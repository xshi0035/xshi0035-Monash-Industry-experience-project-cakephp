<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 */
class CustomersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        // By default, CakePHP will (sensibly) default to preventing users from accessing any actions on a controller.
        // These actions, however, are typically required for users who have not yet logged in.
        $this->Authentication->allowUnauthenticated(['add']);
        // CakePHP loads the model with the same name as the controller by default.
        // Since we don't have an Auth model, we'll need to load "Users" model when starting the controller manually.

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $customers = $this->Customers->find()
            ->all()
            ->toArray();

        $this->set(compact('customers'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customer = $this->Customers->find()
            ->where(['Customers.id' => $id])
            ->leftJoinWith('DiscoverySources')
            ->leftJoinWith('Bookings')
            ->select($this->Customers)
            ->select(['DiscoverySources.name']) // Select only the necessary fields from DiscoverySources
            ->contain(['Bookings'  => [
                'Services',
                'Locations',
                'Statuses',
                'Users'
            ]])
            ->firstOrFail();

        $bookingServices = $this->fetchTable('BookingsServices')->find()
            ->contain([
                'Bookings',
                'Services.Categories'
            ])
            ->all()
            ->toArray();

        $controller = $this->getRequest()->getQuery('controller');
        $action = $this->getRequest()->getQuery('action');
        $id = $this->getRequest()->getQuery('id');

        if ($controller === null || $action === null) {
            $controller = 'Customers';
            $action = 'index';
        }

        $backUrl = ['controller' => $controller, 'action' => $action];

        if ($id !== null) {
            $backUrl = ['controller' => $controller, 'action' => $action, $id];
        }

        $this->set(compact('customer', 'bookingServices', 'backUrl'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // Step 4 of Booking Process: Enter customer details
        $currentStep = 4;

        // Fetch tables that aren't explicitly associated with Customers
        $locationsTable = $this->fetchTable('Locations');

        // Retrieve location, services, total cost, and drop off time/date data from session
        $locationId = $this->request->getSession()->read('Booking.location_id');
        $location = $locationsTable->get($locationId);
        $totalCost = $this->request->getSession()->read('Booking.total_cost');
        $grouped_services = $this->request->getSession()->read('Booking.grouped_services');
        $products_array = $this->request->getSession()->read('Booking.products_array');
        $selectedDropoffDate = $this->request->getSession()->read('Booking.dropoff_date');
        $selectedDropoffTime = $this->request->getSession()->read('Booking.dropoff_time');
        $formattedDate = date('d/m/Y', strtotime($selectedDropoffDate));
        $formattedTime = date('h:i A', strtotime($selectedDropoffTime));

        // Load previously inputted values from session, if any
        $inputFirstName = $this->request->getSession()->read('Customer.first_name') ?? null;
        $inputLastName = $this->request->getSession()->read('Customer.last_name') ?? null;
        $inputEmail = $this->request->getSession()->read('Customer.email') ?? null;
        $inputPhone = $this->request->getSession()->read('Customer.phone_no') ?? null;
        $inputDiscSrc = $this->request->getSession()->read('Customer.discovery_source_id') ?? null;

        $customer = $this->Customers->newEmptyEntity();

        if ($this->request->is('post')) {
            // Get user input from the form
            $firstName = $this->request->getData('first_name');
            $lastName = $this->request->getData('last_name');
            $email = $this->request->getData('email');
            $phone = $this->request->getData('phone_no');
            $discoverySourceId = $this->request->getData('discovery_source_id');

            // Store user input in session
            $this->request->getSession()->write('Customer.first_name', $firstName);
            $this->request->getSession()->write('Customer.last_name', $lastName);
            $this->request->getSession()->write('Customer.email', $email);
            $this->request->getSession()->write('Customer.phone_no', $phone);
            $this->request->getSession()->write('Customer.discovery_source_id', $discoverySourceId);

            // Redirect back to the booking flow
            return $this->redirect(['controller' => 'Bookings', 'action' => 'confirm']);
        }

        $discoverySources = $this->Customers->DiscoverySources->find('list', limit: 200)->all();
        $this->set(compact('customer', 'discoverySources', 'currentStep', 'location', 'totalCost', 'grouped_services', 'formattedDate', 'formattedTime', 'inputFirstName', 'inputLastName', 'inputEmail', 'inputPhone', 'inputDiscSrc', 'products_array'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customer = $this->Customers->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__("{0}'s details have been successfully updated.", $customer->first_name . ' ' . $customer->last_name), ['escape' => false]);

                return $this->redirect(['action' => 'view', $customer->id]);
            }
            $this->Flash->error(__(__("{0}'s details could not be updated. Please try again.", $customer->first_name . ' ' . $customer->last_name), ['escape' => false]));
        }
        $discoverySources = $this->Customers->DiscoverySources->find('list', limit: 200)->all();
        $this->set(compact('customer', 'discoverySources'));
    }

    /**
     * Add Comments method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function addComments($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => [
                'Bookings' => [
                    'Services',
                    'Locations',
                    'Statuses'
                ]
            ]
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('Your comments about {0} has been saved.', h($customer->first_name) . ' ' . h($customer->last_name)), ['escape' => false]);

                return $this->redirect(['action' => 'view', $customer->id]);
            }
            $this->Flash->error(__('Your comments about {0} could not been saved. Please try again.', h($customer->first_name) . ' ' . h($customer->last_name)), ['escape' => false]);
        }

        $discoverySourceId = $customer->discovery_source_id;
        if ($discoverySourceId) {
            $discoverySource = $this->Customers->DiscoverySources->get($discoverySourceId)->name;
        } else {
            $discoverySource = null;
        }

        $this->set(compact('customer', 'discoverySource'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customer = $this->Customers->get($id);
        if ($this->Customers->delete($customer)) {
            $this->Flash->success(__('The customer has been deleted.'));
        } else {
            $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function disallowEntry(): bool
    {
        $authRoleId = $this->request->getAttribute('identity')->role_id;

        //Role: Inactive aren't allowed access to anything.
        $disallowed = [3];

        return in_array($authRoleId, $disallowed);
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Check if the user is logged in and if their role is disallowed
        if ($this->request->getAttribute('identity') === $this->disallowEntry()) {
            // Flash a message indicating that access is denied
            $this->Flash->error('You do not have access to this system.');

            // Redirect them to Bookings/selectLocation
            return $this->redirect(['controller' => 'Bookings', 'action' => 'indexById']);
        }
    }
}
