<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;
use Exception;

class AuctionController extends AuctionBaseController {

    //デフォルトテーブルを使わない
    public $useTable = false;


    //初期化処理
    public function initialize():void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Common');
        //必要なモデルをすべてロード
        $this->loadModel('Users');
        $this->loadModel('Biditems');
        $this->loadModel('Bidrequests');
        $this->loadModel('Bidinfo');
        $this->loadModel('Bidmessages');
        $this->loadModel('Bidcontacts');
        $this->loadModel('Bidreviews');

        //ログインしているユーザー情報をauthuserに設定
        $this->set('authuser', $this->Auth->user());
        //レイアウトをauctionに変更
        $this->viewBuilder()->setLayout('auction');
    }

    //トップページ
    public function index()
    {
        //ページネーションでBiditemsを取得
        $auction = $this->paginate('Biditems', [
            'order' => ['endtime'=>'desc'],
            'limit' => 5]);

        $bidreviews = $this->Bidreviews
            ->find('all',['conditions' => ['review_user_id' => $this->Auth->user('id')]])
            ->contain(['Users']);

        $bidreviewsAvg = $this->Bidreviews
            ->find()
            ->where(['review_user_id' => $this->Auth->user('id')])->avg('rate');

        $this->set(compact('auction', 'bidreviews', 'bidreviewsAvg'));
    }

    //商品情報の表示
    public function view($id = null)
    {
        //$idのBiditemを取得
        $biditem = $this->Biditems->get($id, [
            'contain' => ['Users', 'Bidinfo', 'Bidinfo.Users']
            //Bidinfoに組み込まれているUsersも取り出せるようにしてある。
        ]);
        //オークション終了時の処理
        if ($biditem->endtime < new \DateTime('now') and $biditem->finished == 0) {
            //finishedを1に変更して保存
            $biditem->finished = 1;
            $this->Biditems->save($biditem);
            //Bidinfo（落札情報）を作成する
            $bidinfo = $this->Bidinfo->newEmptyEntity();
            //Bidinfoのbiditem_idに$idを設定
            $bidinfo->biditem_id = $id;
            //最高金額のBidrequest（入札情報）を検索
            $bidrequest = $this->Bidrequests
                ->find('all', [
                    'conditions' => ['biditem_id' => $id],
                    'contain' => ['Users'],
                    'order' => ['price' => 'desc']
                    ])
                ->first();
            //Bidrequestが得られた時の処理
            if (!empty($bidrequest)) {
                //Bidinfo（落札情報）の各種プロパティを設定して保存
                $bidinfo->user_id = $bidrequest->user->id;
                //$bidinfo->user = $bidrequest->user; //教科書には書いてあるが、上でuser_idを代入していていらないのでコメントアウト
                $bidinfo->price = $bidrequest->price;
                $this->log($bidinfo);
                $this->Bidinfo->save($bidinfo);
            }
            //Biditemのbidinfoに$bidinfoを設定
            $biditem->bidinfo = $bidinfo;
        }
        //BIdrequestsからbiditem_idが$idのものを取得
        $bidrequests = $this->Bidrequests
            ->find('all', [
                'conditions' => ['biditem_id'=>$id],
                'contain' => ['Users'],
                'order' => ['price'=>'desc']])
            ->toArray();
        //オブジェクト類をテンプレート用に設定
        $this->set(compact('biditem', 'bidrequests'));
    }

    //出品する処理
    public function add()
    {
        //Biditemインスタンスを用意
        $biditem = $this->Biditems->newEmptyEntity();
        //POST送信時の処理
        if ($this->request->is('post')) {
            //$biditemにフォームの送信内容を反映
            $biditem = $this->Biditems->patchEntity($biditem, $this->request->getData());
            //$biditemを保存する

            //↓↓↓↓↓↓↓↓【機能追加】画像のアップロード処理↓↓↓↓↓↓↓↓
            if(!$biditem->getErrors()){
                $image = $this->request->getData('image_file');
                //ファイル名を取得
                $name = $image->getClientFilename();
                //ファイルの移動先を$filePathに代入
                $filePath = '../webroot/img/' .date("YmdHis") . $name;
                //webrootのimgフォルダに移動
                $image->moveTo($filePath);
                //DBにファイル名を保存
                $biditem->image = date("YmdHis") . $name;
            }
            //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
                if ($this->Biditems->save($biditem)) {
                    //成功時のメッセージ
                    $this->Flash->success(__('保存しました。'));
                    //トップページ(index)に移動
                    return $this->redirect(['action' => 'index']);
                }
            //失敗時のメッセージ
            $this->Flash->error(__('保存に失敗しました。もう一度入力ください。'));
        }
        //値を保管
        $this->set(compact('biditem'));
    }

    //入札の処理
    public function bid($biditem_id = null)
    {
        //入札用のBidrequestインスタンスを用意
        $bidrequest = $this->Bidrequests->newEmptyEntity();
        //$bidrequestにbiditem_idとuser_idを設定
        $bidrequest->biditem_id = $biditem_id;
        $bidrequest->user_id = $this->Auth->user('id');
        //POST送信時の処理
        if ($this->request->is('post')) {
            //$bidrequestに送信フォームの内容を反映する
            $bidrequest = $this->Bidrequests->patchEntity($bidrequest, $this->request->getData());
            //Bidrequestを保存
            if ($this->Bidrequests->save($bidrequest)) {
                //成功時のメッセージ
                $this->Flash->success(__('入札を送信しました。'));
                //トップページにリダイレクト
                return $this->redirect(['action'=>'view', $biditem_id]);
            }
            //失敗時のメッセージ
            $this->Flash->error(__('入札に失敗しました。もう一度入力ください。'));
        }
        //$biditem_idの$biditemを取得する
        $biditem = $this->Biditems->get($biditem_id);
        $this->set(compact('bidrequest', 'biditem'));
    }

    //落札者とのメッセージ
    public function msg($bidinfo_id = null)
    {
        //Bidmessageを新たに用意
        $bidmsg = $this->Bidmessages->newEmptyEntity();
        //POST送信時の処理
        if ($this->request->is('post')) {
            //送信されたフォームで$bidmsgを更新
            $bidmsg = $this->Bidmessages->patchEntity($bidmsg, $this->request->getData());
            //Bidmessageを保存
            if ($this->Bidmessages->save($bidmsg)) {
                $this->Flash->success(__('保存しました。'));
            } else {
                $this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
            }
        }
        try { //$bidinfo_idからBidinfoを取得する
            $bidinfo = $this->Bidinfo->get($bidinfo_id, [
                'contain' => ['Biditems']]);
        } catch(Exception $e) {
            $bidinfo = null;
        }
        //Bidmessageをbidinfo_idとuser_idで検索
        $bidmsgs = $this->Bidmessages
            ->find('all', [
                'conditions' => ['bidinfo_id'=>$bidinfo_id],
                'contain' => ['Users'],
                'order' => ['created'=>'desc']
                ]);
        $this->set(compact('bidmsgs', 'bidinfo', 'bidmsg'));
    }

    //落札情報の表示
    public function home()
    {
        //自分が落札したBidinfoをページネーションで取得
        $bidinfo = $this->Paginate('Bidinfo', [
            'conditions'=>['Bidinfo.user_id'=>$this->Auth->user('id')],
            'contain' => ['Users', 'Biditems'],
            'order' => ['created'=>'desc'],
            'limit' => 10])->toArray();
        $this->set(compact('bidinfo'));
    }

    //出品情報の表示
    public function home2()
    {
        //自分が出品したBiditemをページネーションで取得
        $biditems = $this->Paginate('Biditems', [
            'conditions' => ['Biditems.user_id'=>$this->Auth->user('id')],
            'contain' => ['Users', 'Bidinfo'],
            'order' => ['created' => 'desc'],
            'limit' => 10])->toArray();
        $this->set(compact('biditems'));
    }

    //取引画面の表示
    public function contact($id = null)
    {
        //Bidinfo(落札商品)の$idを取得
        $bidinfo = $this->Bidinfo->get($id, [
            'contain' => ['Users', 'Biditems', 'Bidcontacts', 'Bidreviews']
        ]);

        //CommonComponentで共通化した関数の呼び出し
        $isContact = $this->Common->isContact($id);
        $isShipping = $this->Common->isShipping($id);
        $isReceipt = $this->Common->isReceipt($id);
        $isReview = $this->Common->isReview($id);
        $isFinish = $this->Common->isFinish($id);

        //BidContactsを新たに用意
        $bidcontact = $this->Bidcontacts->newEmptyEntity();
        //連絡先送信時の処理
        if ($this->request->is('post')) {
            //送信されたフォームで$bidcontactを更新
            $bidcontact = $this->Bidcontacts->patchEntity($bidcontact, $this->request->getData());
            //Bidcontactsに保存
            if ($this->Bidcontacts->save($bidcontact)) {
                $this->Flash->success(__('保存しました。'));
            } else {
                $this->Flash->error(__('保存に失敗しました。もう一度入力下さい。')	);
            }
            return $this->redirect(['action' => 'contact', $id]);
        }
        $this->set(compact('bidcontact', 'bidinfo', 'isContact', 'isShipping', 'isReceipt', 'isReview', 'isFinish'));
    }

    public function shipping()
    {
        //contactで発送ボタンが押された時の処理
        if ($this->request->is('post')) {
            $id = $this->request->getData('id');
            $bidinfo_id = $this->request->getData('bidinfo_id');
            $bidcontact = $this->Bidcontacts->get($id);
            $bidcontact->send = 1;
            $this->Bidcontacts->save($bidcontact);
            return $this->redirect(['action' => 'contact', $bidinfo_id]);
        } else {
            //失敗時のメッセージ
            $this->Flash->error(__('保存に失敗しました。もう一度お試しください。'));
        }
    }

    public function receipt()
    {
        //contactで受取ボタンが押された時の処理
        if ($this->request->is('post')) {
            $id = $this->request->getData('id');
            $bidinfo_id = $this->request->getData('bidinfo_id');
            $bidcontact = $this->Bidcontacts->get($id);
            $bidcontact->receipt = 1;
            $this->Bidcontacts->save($bidcontact);
            return $this->redirect(['action' => 'contact', $bidinfo_id]);
        } else {
            //失敗時のメッセージ
            $this->Flash->error(__('保存に失敗しました。もう一度お試しください。'));
        }
    }

    public function review()
    {
        //評価送信時の処理
        if ($this->request->is('post')) {
            //Bidreviewsを新たに用意
            $bidreview = $this->Bidreviews->newEmptyEntity();
            //送信されたフォームで$bidreviewを更新
            $bidreview = $this->Bidreviews->patchEntity($bidreview, $this->request->getData());
            $bidinfo_id = $this->request->getData('bidinfo_id');
            //Bidreviewsに保存
            if ($this->Bidreviews->save($bidreview)) {
                $this->Flash->success(__('保存しました。'));
            } else {
                $this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
            }
            return $this->redirect(['action' => 'contact', $bidinfo_id]);
        }
    }
}