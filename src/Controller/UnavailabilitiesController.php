<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Unavailabilities Controller
 *
 * @property \App\Model\Table\UnavailabilitiesTable $Unavailabilities
 */
class UnavailabilitiesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Unavailabilities->find()
            ->contain(['Locations']);
        $unavailabilities = $this->paginate($query);

        $this->set(compact('unavailabilities'));
    }

    /**
     * View method
     *
     * @param string|null $id Unavailability id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $unavailability = $this->Unavailabilities->get($id, contain: ['Locations']);
        $this->set(compact('unavailability'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $unavailability = $this->Unavailabilities->newEmptyEntity();

        if ($this->request->is('post')) {
            $unavailability = $this->Unavailabilities->patchEntity($unavailability, $this->request->getData());
            if ($this->Unavailabilities->save($unavailability)) {
                $this->Flash->success(__(
                    'The unavailability has been saved. <br />PLEASE NOTE THAT: This unavailability only affects new bookings, and not existing bookings. You will need to manually check and manage any existing bookings within this date range.'
                ), ['escape' => false]);

                return $this->redirect(['controller' => 'Locations', 'action' => 'view', $unavailability->location_id]);
            }
            $this->Flash->error(__('The unavailability could not be saved. Please try again.'));
        } else {
            // Set the location_id from the query parameter
            $location_id = $this->request->getQuery('location_id');
            if ($location_id) {
                $unavailability->location_id = $location_id;
            }
        }
        $locations = $this->Unavailabilities->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'limit' => 200,
        ])->toArray();

        $this->set(compact('unavailability', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Unavailability id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $unavailability = $this->Unavailabilities->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $unavailability = $this->Unavailabilities->patchEntity($unavailability, $this->request->getData());
            if ($this->Unavailabilities->save($unavailability)) {
                $this->Flash->success(__('The unavailability has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The unavailability could not be saved. Please, try again.'));
        }
        // Fetch the list of locations
        $locations = $this->Unavailabilities->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'limit' => 200,
        ])->toArray();
        $this->set(compact('unavailability', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Unavailability id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $unavailability = $this->Unavailabilities->get($id);
        $locationId = $this->request->getQuery('location_id');
        
        if ($this->Unavailabilities->delete($unavailability)) {
            $this->Flash->success(__('The unavailability has been deleted.'));
        } else {
            $this->Flash->error(__('The unavailability could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Locations', 'action' => 'view', $locationId]);
    }
}
