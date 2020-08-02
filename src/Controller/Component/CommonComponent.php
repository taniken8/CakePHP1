<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

/**
 * Common component
 */
class CommonComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];



    public function initialize(array $config): void
    {
        $this->controller = $this->_registry->getController();
        $this->controller->loadModel('Auction');
    }

    //連絡先を送っているかどうか
    public function isContact($id)
    {
        $bidinfo = $this->controller->Bidinfo->get($id, [
            'contain' => ['Bidcontacts']]);

        //連絡先を送っていればfalse
        if ($bidinfo->bidcontact) {
            return false;
        }
        return true;
    }

    //発送ボタンを押したかどうか
    public function isShipping($id)
    {
        $bidinfo = $this->controller->Bidinfo->get($id, [
            'contain' => ['Bidcontacts']]);

        //連絡先を送っていなければfalse
        if (!$bidinfo->bidcontact) {
            return false;
        }
        //発送ボタンが押されていればfalse
        if ($bidinfo->bidcontact->send) {
            return false;
        }
        return true;
    }

    //受取ボタンを押したかどうか
    public function isReceipt($id)
    {
        $bidinfo = $this->controller->Bidinfo->get($id, [
            'contain' => ['Bidcontacts']]);

        $bidcontact = $bidinfo->bidcontact;

        //連絡先を送っていなければfalse
        if (!$bidcontact) {
            return false;
        }
        //発送ボタンが押されていなければfalse
        if (!$bidcontact->send) {
            return false;
        }
        //受取ボタンが押されていればfalse
        if ($bidcontact->receipt) {
            return false;
        }
        return true;
    }

    //評価をしているかどうか
    public function isReview($id)
    {
        $bidinfo = $this->controller->Bidinfo->get($id, [
            'contain' => ['Bidcontacts']]);
        $bidreview = $this->controller->Bidreviews->find()
            ->where([
                'bidinfo_id' => $id,
                'user_id' => $this->controller->Auth->user('id')
            ])
            ->count();

        $bidcontact = $bidinfo->bidcontact;

        //連絡先を送っていなければfalse
        if (!$bidcontact) {
            return false;
        }
        //発送ボタンが押されていなければfalse
        if (!$bidcontact->send) {
            return false;
        }
        //受取ボタンを押されていなければfalse
        if (!$bidcontact->receipt) {
            return false;
        }
        //ログインユーザーが評価していればfalse
        if ($bidreview === 1) {
            return false;
        }
        return true;
    }

    //取引が完了しているかどうか
    public function isFinish($id)
    {
        $bidinfo = $this->controller->Bidinfo->get($id, [
            'contain' => ['Bidcontacts']]);
        $bidreview = $this->controller->Bidreviews->find()
            ->where([
                'bidinfo_id' => $id,
                'user_id' => $this->controller->Auth->user('id')
            ])
            ->count();

        $bidcontact = $bidinfo->bidcontact;

        //連絡先を送っていなければfalse
        if (!$bidcontact) {
            return false;
        }
        //発送ボタンが押されていなければfalse
        if (!$bidcontact->send) {
            return false;
        }
        //受取ボタンを押されていなければfalse
        if (!$bidcontact->receipt) {
            return false;
        }
        //ログインユーザーが評価されていなければfalse
        if (!$bidreview === 1) {
            return false;
        }
        return true;
    }
}
