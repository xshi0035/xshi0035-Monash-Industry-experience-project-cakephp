<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * DiscoverySources Controller
 *
 * @property \App\Model\Table\DiscoverySourcesTable $DiscoverySources
 */
class DiscoverySourcesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->DiscoverySources->find();
        $discoverySources = $this->paginate($query);

        $this->set(compact('discoverySources'));
    }

    /**
     * View method
     *
     * @param string|null $id Discovery Source id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $discoverySource = $this->DiscoverySources->get($id, contain: ['Customers']);
        $this->set(compact('discoverySource'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $discoverySource = $this->DiscoverySources->newEmptyEntity();
        if ($this->request->is('post')) {
            $discoverySource = $this->DiscoverySources->patchEntity($discoverySource, $this->request->getData());
            if ($this->DiscoverySources->save($discoverySource)) {
                $this->Flash->success(__('The discovery source has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The discovery source could not be saved. Please, try again.'));
        }
        $this->set(compact('discoverySource'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Discovery Source id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $discoverySource = $this->DiscoverySources->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $discoverySource = $this->DiscoverySources->patchEntity($discoverySource, $this->request->getData());
            if ($this->DiscoverySources->save($discoverySource)) {
                $this->Flash->success(__('The discovery source has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The discovery source could not be saved. Please, try again.'));
        }
        $this->set(compact('discoverySource'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Discovery Source id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $discoverySource = $this->DiscoverySources->get($id);
        if ($this->DiscoverySources->delete($discoverySource)) {
            $this->Flash->success(__('The discovery source has been deleted.'));
        } else {
            $this->Flash->error(__('The discovery source could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Define the allowed roles (1 for Admin, 2 for Manager)
        $AllowedRoles = [1, 2];

        // Check if the user's role is in the allowed roles array
        if (!in_array($this->request->getAttribute('identity')->role_id, $AllowedRoles)) {
            // $this->Flash->error(__('You are not authorized to access this area.'));
            return $this->redirect(['controller' => 'Auth', 'action' => 'login']); //change this later when home page is made
        }
    }
}
