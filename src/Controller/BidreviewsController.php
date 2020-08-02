<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Bidreviews Controller
 *
 * @property \App\Model\Table\BidreviewsTable $Bidreviews
 *
 * @method \App\Model\Entity\Bidreview[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BidreviewsController extends AuctionBaseController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ReviewUsers', 'Users'],
        ];
        $bidreviews = $this->paginate($this->Bidreviews);

        $this->set(compact('bidreviews'));
    }

    /**
     * View method
     *
     * @param string|null $id Bidreview id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bidreview = $this->Bidreviews->get($id, [
            'contain' => ['ReviewUsers', 'Users'],
        ]);

        $this->set('bidreview', $bidreview);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bidreview = $this->Bidreviews->newEmptyEntity();
        if ($this->request->is('post')) {
            $bidreview = $this->Bidreviews->patchEntity($bidreview, $this->request->getData());
            if ($this->Bidreviews->save($bidreview)) {
                $this->Flash->success(__('The bidreview has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bidreview could not be saved. Please, try again.'));
        }
        $reviewUsers = $this->Bidreviews->ReviewUsers->find('list', ['limit' => 200]);
        $users = $this->Bidreviews->Users->find('list', ['limit' => 200]);
        $this->set(compact('bidreview', 'reviewUsers', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bidreview id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bidreview = $this->Bidreviews->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bidreview = $this->Bidreviews->patchEntity($bidreview, $this->request->getData());
            if ($this->Bidreviews->save($bidreview)) {
                $this->Flash->success(__('The bidreview has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bidreview could not be saved. Please, try again.'));
        }
        $reviewUsers = $this->Bidreviews->ReviewUsers->find('list', ['limit' => 200]);
        $users = $this->Bidreviews->Users->find('list', ['limit' => 200]);
        $this->set(compact('bidreview', 'reviewUsers', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bidreview id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bidreview = $this->Bidreviews->get($id);
        if ($this->Bidreviews->delete($bidreview)) {
            $this->Flash->success(__('The bidreview has been deleted.'));
        } else {
            $this->Flash->error(__('The bidreview could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
