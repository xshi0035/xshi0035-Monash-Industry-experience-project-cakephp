<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Locations Controller
 *
 * @property \App\Model\Table\LocationsTable $Locations
 */
class LocationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $states = $this->Locations->States->find('list', ['keyField' => 'id', 'valueField' => 'abbr']);

        $selectedStateId = $this->request->getQuery('state');

        $query = $this->Locations->find('all', [
            'conditions' => [
                'status !=' => 'ARCHIVED'
            ]
        ])
            ->contain(['States']);

        if ($selectedStateId && $selectedStateId !== 'all') {
            $query->where(['Locations.state_id' => $selectedStateId]);
        };

        $locations = $this->paginate($query);

        $this->set(compact('locations', 'states', 'selectedStateId'));
    }

    /**
     * Archived Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function indexArchived()
    {
        $states = $this->Locations->States->find('list', ['keyField' => 'id', 'valueField' => 'abbr']);

        $selectedStateId = $this->request->getQuery('state');

        // Start the query for archived locations
        $query = $this->Locations->find()
            ->where(['status' => 'ARCHIVED'])
            ->contain(['States']);

        // Apply state filtering if a state is selected
        if ($selectedStateId && $selectedStateId !== 'all') {
            $query->where(['state_id' => $selectedStateId]); // Filter by state_id
        }

        $locations = $query->all()->toArray();

        $this->set(compact('locations', 'states', 'selectedStateId'));
    }

    /**
     * View method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $location = $this->Locations->get($id, contain: [
            'States',
            'Users' => ['Roles'],
            'Bookings',
            'Unavailabilities' => [
                'sort' => ['Unavailabilities.start_date' => 'ASC']
            ]
        ]);

        // Directly use the Availabilities table class
        $availabilitiesTable = $this->fetchTable('Availabilities');
        $availabilities = $availabilitiesTable->find('all', [
            'conditions' => ['Availabilities.location_id' => $id],
            'order' => ['Availabilities.day_of_week' => 'ASC']
        ])->toArray();

        $this->set(compact('location', 'availabilities'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $location = $this->Locations->newEmptyEntity();
        $availabilitiesTable = $this->fetchTable('Availabilities'); // Load the Availabilities model
        $availability = $availabilitiesTable->newEmptyEntity(); // Create a new Availability entity

        // Initialize location_id as null
        $locationId = null;

        // Handle location form submission
        if ($this->request->is('post') && $this->request->getData('form_type') === 'location') {
            $location = $this->Locations->patchEntity($location, $this->request->getData());

            if ($this->Locations->save($location)) {
                $this->Flash->success(__('The location has been saved.'));
                $locationId = $location->id; // Get the location ID after saving

                return $this->redirect(['action' => 'view', $location->id]);
            } else {
                $this->Flash->error(__('The location could not be saved. Please, try again.'));
            }
        }

        // If location is already submitted and we have location_id, use it for availabilities
        if (!empty($this->request->getData('form_type')) && $this->request->getData('form_type') === 'availability') {
            $locationId = $this->request->getData('location_id');


            // Handle availability form submission
            if ($locationId && $this->request->is('post')) {
                $availabilityData = $this->request->getData();
                $availabilityData['location_id'] = $locationId; // Assign location_id to the availability

                $availability = $availabilitiesTable->patchEntity($availability, $availabilityData);
                if ($availabilitiesTable->save($availability)) {
                    $this->Flash->success(__('The availability has been saved.'));
                } else {
                    $this->Flash->error(__('The availability could not be saved. Please, try again.'));
                }
            }
        }

        // Fetch data for dropdowns
        $states = $this->Locations->States->find('list', [
            'keyField' => 'id',
            'valueField' => 'abbr'
        ])->all();
        $users = $this->Locations->Users->find('list')->all();

        // Time options for availability (customize as needed)
        $options = [
            '09:00' => '9:00 AM',
            '10:00' => '10:00 AM',
            '11:00' => '11:00 AM',
            '12:00' => '12:00 PM',
            '01:00' => '1:00 PM',
            '02:00' => '2:00 PM',
            '03:00' => '3:00 PM',
            '04:00' => '4:00 PM',
            '05:00' => '5:00 PM',
        ];

        // Pass the data to the view, including locationId
        $this->set(compact('location', 'availability', 'states', 'users', 'options', 'locationId'));
    }



    /**
     * Edit method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $location = $this->Locations->get($id, contain: ['Users']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $location = $this->Locations->patchEntity($location, $this->request->getData());
            if ($this->Locations->save($location)) {
                $this->Flash->success(__('The location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        $states = $this->Locations->States->find('list', limit: 200)->all();
        $users = $this->Locations->Users->find('list', limit: 200)->all();
        $this->set(compact('location', 'states', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $location = $this->Locations->get($id);
        if ($this->Locations->delete($location)) {
            $this->Flash->success(__('The location has been deleted.'));
        } else {
            $this->Flash->error(__('The location could not be deleted. Please, try again.'));
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

    /**
     * Archive method
     *
     */
    public function archive($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $location = $this->Locations->get($id);
        $this->Locations->patchEntity($location, ['status' => 'ARCHIVED']);
        if ($this->Locations->save($location)) {
            $this->Flash->success(__('The location <i>{0}</i> has been archived.', $location->name), ['escape' => false]);
        } else {
            $this->Flash->error(__('The location <i>{0}</i> could not be archived. Please, try again.', $location->name), ['escape' => false]);
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
        $location = $this->Locations->get($id);
        $this->Locations->patchEntity($location, ['status' => 'OPERATIONAL']);
        if ($this->Locations->save($location)) {
            $this->Flash->success(__('The location <i>{0}</i> has been restored.', $location->name), ['escape' => false]);
        } else {
            $this->Flash->error(__('The location <i>{0}</i> could not be restored. Please, try again.', $location->name), ['escape' => false]);
        }
        return $this->redirect(['action' => 'index']);
    }
}
