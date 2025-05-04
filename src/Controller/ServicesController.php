<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Services Controller
 *
 * @property \App\Model\Table\ServicesTable $Services
 */
class ServicesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $categories = $this->Services->Categories->find('list', ['keyField' => 'id', 'valueField' => 'name']);

        $selectedCategoryId = $this->request->getQuery('category');

        $query = $this->Services->find('all', [
            'conditions' => ['Services.archived' => 0]
        ])
            ->contain(['Categories']);

        if ($selectedCategoryId && $selectedCategoryId !== 'all') {
            $query->where(['Services.cat_id' => $selectedCategoryId]);
        }

        $services = $this->paginate($query);

        $this->set(compact('services', 'categories', 'selectedCategoryId'));
    }

    /**
     * Archived Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function indexArchived()
    {
        $categories = $this->Services->Categories->find('list', ['keyField' => 'id', 'valueField' => 'name']);

        $selectedCategoryId = $this->request->getQuery('category');

        $query = $this->Services->find('all', [
            'conditions' => ['Services.archived' => 1]
        ])
            ->contain(['Categories']);

        if ($selectedCategoryId && $selectedCategoryId !== 'all') {
            $query->where(['Services.cat_id' => $selectedCategoryId]);
        }

        $services = $this->paginate($query);

        $this->set(compact('services', 'categories', 'selectedCategoryId'));
    }

    /**
     * View method
     *
     * @param string|null $id Service id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $service = $this->Services->get($id, contain: ['Categories', 'Bookings', 'Locations']);
        $this->set(compact('service'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $service = $this->Services->newEmptyEntity();
        if ($this->request->is('post')) {
            $service = $this->Services->patchEntity($service, $this->request->getData());
            if ($this->Services->save($service)) {
                // Link checked locations
                if (!empty($this->request->getData('locations._ids'))) {
                    $locations = $this->Services->Locations->find()
                        ->where(['Locations.id IN' => $this->request->getData('locations._ids')])
                        ->toArray();
                    $this->Services->Locations->link($service, $locations);
                }

                $this->Flash->success(__('The service has been saved.'));

                return $this->redirect(['action' => 'view', $service->id]);
            }
            $this->Flash->error(__('The service could not be saved. Please, try again.'));
        }
        $categories = $this->Services->Categories->find('list', limit: 200)->all();
        $bookings = $this->Services->Bookings->find('list', limit: 200)->all();
        $locations = $this->Services->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'limit' => 200
        ])
            ->where(['status' => 'OPERATIONAL'])
            ->toArray();
        $this->set(compact('service', 'categories', 'bookings', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Service id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $service = $this->Services->get($id, contain: ['Bookings', 'Locations']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $service = $this->Services->patchEntity($service, $this->request->getData());
            if ($this->Services->save($service)) {
                // Remove existing associations with Locations
                $this->Services->Locations->unlink($service, $service->locations);

                // Link new locations if provided
                if (!empty($this->request->getData('locations._ids'))) {
                    $locations = $this->Services->Locations->find()
                        ->where(['Locations.id IN' => $this->request->getData('locations._ids')])
                        ->toArray();
                    $this->Services->Locations->link($service, $locations);
                }

                $this->Flash->success(__("Changes to <b>{0}</b> has been saved.", $service->name), ['escape' => false]);

                return $this->redirect(['action' => 'view', $service->id]);
            }
            $this->Flash->success(__("Changes to <b>{0}</b> could not be saved. Please try again.", $service->name), ['escape' => false]);
        }
        $categories = $this->Services->Categories->find('list', limit: 200)->all();
        $bookings = $this->Services->Bookings->find('list', limit: 200)->all();
        $locations = $this->Services->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'limit' => 200
        ])
            ->where(['status' => 'OPERATIONAL'])
            ->toArray();
        $this->set(compact('service', 'categories', 'bookings', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Service id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $service = $this->Services->get($id);
        if ($this->Services->delete($service)) {
            $this->Flash->success(__('The service <i>{0}</i> has been deleted.', $service->name), ['escape' => false]);
        } else {
            $this->Flash->error(__('The service <i>{0}</i> could not be deleted. Please, try again.', $service->name), ['escape' => false]);
        }

        return $this->redirect(['action' => 'indexArchived']);
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

    /**
     * Archive method
     *
     */
    public function archive($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $service = $this->Services->get($id);
        $this->Services->patchEntity($service, ['archived' => true]);
        if ($this->Services->save($service)) {
            $this->Flash->success(__('The service <i>{0}</i> has been archived.', $service->name), ['escape' => false]);
        } else {
            $this->Flash->error(__('The service <i>{0}</i> could not be archived. Please, try again.', $service->name), ['escape' => false]);
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Unarchive method
     *
     */
    public function unarchive($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $service = $this->Services->get($id);
        $this->Services->patchEntity($service, ['archived' => false]);
        if ($this->Services->save($service)) {
            $this->Flash->success(__('The service <i>{0}</i> has been restored.', $service->name), ['escape' => false]);
        } else {
            $this->Flash->error(__('The service <i>{0}</i> could not be restored. Please, try again.', $service->name), ['escape' => false]);
        }
        return $this->redirect(['action' => 'index']);
    }
}
