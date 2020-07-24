<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Bidcontacts Controller
 *
 * @property \App\Model\Table\BidcontactsTable $Bidcontacts
 *
 * @method \App\Model\Entity\Bidcontact[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BidcontactsController extends AuctionBaseController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Bidinfos', 'Users'],
        ];
        $bidcontacts = $this->paginate($this->Bidcontacts);

        $this->set(compact('bidcontacts'));
    }

    /**
     * View method
     *
     * @param string|null $id Bidcontact id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bidcontact = $this->Bidcontacts->get($id, [
            'contain' => ['Bidinfos', 'Users'],
        ]);

        $this->set('bidcontact', $bidcontact);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function create()
    {
        $bidcontact = $this->Bidcontacts->newEmptyEntity();
        if ($this->request->is('post')) {
            $bidcontact = $this->Bidcontacts->patchEntity($bidcontact, $this->request->getData());
            if ($this->Bidcontacts->save($bidcontact)) {
                $this->Flash->success(__('The bidcontact has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bidcontact could not be saved. Please, try again.'));
        }
        $bidinfos = $this->Bidcontacts->Bidinfos->find('list', ['limit' => 200]);
        $users = $this->Bidcontacts->Users->find('list', ['limit' => 200]);
        $this->set(compact('bidcontact', 'bidinfos', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bidcontact id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bidcontact = $this->Bidcontacts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bidcontact = $this->Bidcontacts->patchEntity($bidcontact, $this->request->getData());
            if ($this->Bidcontacts->save($bidcontact)) {
                $this->Flash->success(__('The bidcontact has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The bidcontact could not be saved. Please, try again.'));
            }
        }
        $bidinfos = $this->Bidcontacts->Bidinfos->find('list', ['limit' => 200]);
        $users = $this->Bidcontacts->Users->find('list', ['limit' => 200]);
        $this->set(compact('bidcontact', 'bidinfos', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bidcontact id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bidcontact = $this->Bidcontacts->get($id);
        if ($this->Bidcontacts->delete($bidcontact)) {
            $this->Flash->success(__('The bidcontact has been deleted.'));
        } else {
            $this->Flash->error(__('The bidcontact could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
