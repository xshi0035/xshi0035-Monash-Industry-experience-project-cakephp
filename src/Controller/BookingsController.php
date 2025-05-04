<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;
use Cake\Mailer\Mailer;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;
use Cake\Routing\Router;
use Cake\I18n\DateTime;
use Cake\I18n\Date;

/**
 * Bookings Controller
 *
 * @property \App\Model\Table\BookingsTable $Bookings
 * @property \App\Model\Table\UsersTable $Users
 */
class BookingsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        // By default, CakePHP will (sensibly) default to preventing users from accessing any actions on a controller.
        // These actions, however, are typically required for users who have not yet logged in.
        $this->Authentication->allowUnauthenticated([
            'selectLocation',
            'selectServices',
            'collectCustomerDetails',
            'selectDropoffTime',
            'confirm',
            'privacyPolicy',
            'checkout',
            'successPage'
        ]);
        // CakePHP loads the model with the same name as the controller by default.
        // Since we don't have an Auth model, we'll need to load "Users" model when starting the controller manually.

    }
    /**
     * Index method (Shows all bookings)
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($filterCriteria = null, $filterCondition = null)
    {
        // Get role of user
        $roleId = $this->request->getSession()->read('Auth.role_id');

        // If the user is a contractor (role 3), redirect them to their own bookings page
        if ($roleId == 3) {
            return $this->redirect(['controller' => 'Bookings', 'action' => 'indexById']);
        }

        if ($this->request->getQuery('clear') == 1) {
            $this->request->getSession()->delete('BookingsIndex');
        }

        // Fetch all unique locations for the filter dropdown
        $locations = $this->Bookings->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['name' => 'ASC'],
        ])
            ->where(['status !=' => 'ARCHIVED'])
            ->toArray();

        // Fetch all unique statuses for the filter dropdown
        $statuses = $this->Bookings->Statuses->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['name' => 'ASC'],
        ])->toArray();

        // Get the filter location and status from the query string
        $locationId = $this->request->getQuery('location');
        $statusId = $this->request->getQuery('status');

        // Filter date range
        $start_date = $this->request->getQuery('start_date');
        $end_date = $this->request->getQuery('end_date');

        // Base query for bookings
        $query = $this->Bookings->find()->contain(['Statuses', 'Customers', 'Locations', 'Services' => [
            'Categories'
        ]]);

        // Apply the location filter if a location is selected
        if ($filterCriteria === 'LOCATION') {
            $query->where(['Bookings.location_id' => $filterCondition]);
            $locationId = $filterCondition;
        } else {
            $locationId = $this->locationFilter($locationId, 'BookingsIndex');
            if (!empty($locationId)) {
                $query->where(['Bookings.location_id' => $locationId]);
            }
        }

        // Apply the status filter if a status is selected
        $statusId = $this->statusFilter($statusId, 'BookingsIndex');
        if (!empty($statusId)) {
            $query->where(['Bookings.status_id' => $statusId]);
        }

        // Apply date range filter
        $dates = $this->dateRangeFilter($start_date, $end_date, 'BookingsIndex');
        $start_date = $dates[0];
        $end_date = $dates[1];

        if ($filterCriteria === 'DATE') {
            $query->where(['MONTH(Bookings.dropoff_date)' => $filterCondition]);
        } else {
            if (!empty($start_date) && !empty($end_date)) {
                $query->where(['Bookings.date_booked >= ' => $start_date, 'Bookings.date_booked <=' => $end_date]);
            } elseif (!empty($start_date) && empty($end_date)) {
                $query->where(['Bookings.date_booked >= ' => $start_date]);
            } elseif (empty($start_date) && !empty($end_date)) {
                $query->where(['Bookings.date_booked <= ' => $end_date]);
            }
        }

        $query = $query->limit(300);

        $bookingIds = $query->all()->extract('id')->toList();

        $users = $this->fetchTable('Users')->find()
            ->all()
            ->indexBy('id')
            ->toArray();

        $this->paginate = [
            'limit' => 300,
            'maxLimit' => 500,
            'order' => ['Bookings.dropoff_date' => 'desc']
        ];

        $bookings = $this->paginate($query);

        // Pass data to the view
        $this->set(compact('bookings', 'locations', 'statuses', 'locationId', 'statusId', 'users', 'start_date', 'end_date'));
    }

    /**
     * Upcoming Index method (Shows all bookings from today onwards)
     *
     */
    public function upcomingIndex($filterCriteria = null, $filterCondition = null)
    {
        // Get role of user
        $roleId = $this->request->getSession()->read('Auth.role_id');

        // If the user is a contractor (role 3), redirect them to their own bookings page
        if ($roleId == 3) {
            return $this->redirect(['controller' => 'Bookings', 'action' => 'indexById']);
        }

        if ($this->request->getQuery('clear') == 1) {
            $this->request->getSession()->delete('UpcomingIndex');
        }

        // Fetch all unique locations for the filter dropdown
        $locations = $this->Bookings->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['name' => 'ASC'],
        ])
            ->where(['status !=' => 'ARCHIVED'])
            ->toArray();

        // Fetch all unique statuses for the filter dropdown
        $statuses = $this->Bookings->Statuses->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['name' => 'ASC'],
        ])->toArray();

        // Get the filter location and status from the query string
        $locationId = $this->request->getQuery('location');
        $statusId = $this->request->getQuery('status');

        // Filter date range
        $start_date = $this->request->getQuery('start_date');
        $end_date = $this->request->getQuery('end_date');

        // Base query for bookings
        $query = $this->Bookings->find()
            ->contain([
                'Statuses',
                'Customers',
                'Locations',
                'Services' => [
                    'Categories'
                ]
            ])
            ->where(['dropoff_date >=' => Date::today()]);

        // Apply the location filter if a location is selected
        if ($filterCriteria === 'LOCATION') {
            $query->where(['Bookings.location_id' => $filterCondition]);
            $locationId = $filterCondition;
        } else {
            $locationId = $this->locationFilter($locationId, 'UpcomingIndex');
            if (!empty($locationId)) {
                $query->where(['Bookings.location_id' => $locationId]);
            }
        }

        // Apply the status filter if a status is selected
        if (!empty($statusId)) {
            $query->where(['Bookings.status_id' => $statusId]);
        }

        // Apply date range filter
        if (!empty($start_date) && !empty($end_date)) {
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
            $query->where(['Bookings.dropoff_date >= ' => $start_date, 'Bookings.dropoff_date <=' => $end_date]);
        } elseif ($filterCriteria === 'DATE') {
            $query->where(['MONTH(Bookings.dropoff_date)' => $filterCondition]);
        }

        $query = $query->limit(300);

        $bookingIds = $query->all()->extract('id')->toList();

        $users = $this->fetchTable('Users')->find()
            ->all()
            ->indexBy('id')
            ->toArray();

        $this->paginate = [
            'limit' => 300,
            'maxLimit' => 500,
            'order' => ['Bookings.dropoff_date' => 'desc']
        ];

        $bookings = $this->paginate($query);

        // Pass data to the view
        $this->set(compact('bookings', 'locations', 'statuses', 'locationId', 'statusId', 'users', 'start_date', 'end_date'));
    }


    /**
     * Index method for Users that want to view their own bookings (Contractors)
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function indexById()
    {
        // Get role of user
        $roleId = $this->request->getSession()->read('Auth.role_id');

        // Get id of the current user
        $userId = $this->request->getSession()->read('Auth.id');

        // If the user is not a contractor (role 1 or 2), redirect to the full bookings page
        if ($roleId == 1 || $roleId == 2) {
            return $this->redirect(['action' => 'index']);
        }

        // Fetch all unique locations for the filter dropdown
        $locations = $this->Bookings->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['name' => 'ASC'],
        ])
            ->where(['status !=' => 'ARCHIVED'])
            ->matching('Users', function ($q) use ($userId) {
                return $q->where(['Users.id' => $userId]);
            })
            ->toArray();

        // Fetch all unique statuses for the filter dropdown
        $statuses = $this->Bookings->Statuses->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['id' => 'ASC'],
        ])
            ->where(['id NOT IN' => [6]])
            ->toArray();

        // Get the filter location and status from the query string
        $locationId = $this->request->getQuery('location');
        $statusId = $this->request->getQuery('status');

        // Filter date range
        $start_date = $this->request->getQuery('start_date');
        $end_date = $this->request->getQuery('end_date');

        // Base query for contractor bookings (filtered by user_id)
        $query = $this->Bookings->find()
            ->where(['Bookings.user_id' => $userId])
            ->contain(['Statuses', 'Customers', 'Locations', 'Services' => [
                'Categories'
            ]]);

        // Apply the location filter if a location is selected
        if (!empty($locationId)) {
            $query->where(['Bookings.location_id' => $locationId]);
        }

        // Apply the status filter if a status is selected
        if (!empty($statusId)) {
            $query->where(['Bookings.status_id' => $statusId]);
        }

        // Apply date range filter
        if (!empty($start_date) && !empty($end_date)) {
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
            $query->where(['Bookings.dropoff_date >= ' => $start_date, 'Bookings.dropoff_date <=' => $end_date]);
        }

        // Paginate the filtered query
        $bookings = $this->paginate($query);

        // Pass data to the view and render the contractor-specific template
        $this->set(compact('bookings', 'locations', 'statuses', 'locationId', 'statusId', 'start_date', 'end_date'));
        $this->render('contractorIndex');
    }

    /**
     * Unassigned Bookings Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function unassignedIndex()
    {
        // Get role of user
        $roleId = $this->request->getSession()->read('Auth.role_id');

        // If the user is a contractor (role 3), redirect them to their own bookings page
        if ($roleId == 3) {
            return $this->redirect(['controller' => 'Bookings', 'action' => 'indexById']);
        }

        // Fetch all unique locations for the filter dropdown
        $locations = $this->Bookings->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['name' => 'ASC'],
        ])
            ->where(['status !=' => 'ARCHIVED'])
            ->toArray();

        // Fetch all unique statuses for the filter dropdown
        $statuses = $this->Bookings->Statuses->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['name' => 'ASC'],
        ])->toArray();

        // Get the filter location and status from the query string
        $locationId = $this->request->getQuery('location');

        // Base query for bookings
        $query = $this->Bookings->find()
            ->where(['Bookings.user_id IS' => null, 'Bookings.status_id IS' => 1])
            ->contain(['Statuses', 'Customers', 'Locations', 'Services' => [
                'Categories'
            ]]);

        // Apply the location filter if a location is selected
        $locationId = $this->locationFilter($locationId, 'UnassignedIndex');
        if (!empty($locationId)) {
            $query->where(['Bookings.location_id' => $locationId]);
        }

        $query = $query->limit(300);

        $this->paginate = [
            'limit' => 300,
            'maxLimit' => 500,
            'order' => ['Bookings.dropoff_date' => 'desc']
        ];

        // Paginate the filtered query
        $bookings = $this->paginate($query);

        // Pass data to the view
        $this->set(compact('bookings', 'locations', 'statuses', 'locationId'));
        $this->render('unassignedIndex');
    }

    /**
     * Assign Contractor method
     *
     * @param string|null $id Booking id.
     */
    public function assignContractor($id = null)
    {
        $booking = $this->Bookings->get($id, [
            'contain' => [
                'Statuses',
                'Customers',
                'Locations' => ['States'],
                'Products',
                'Services' => ['Categories'],
                'Users'
            ]
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            // Only patch the 'user_id' field for contractor assignment
            $data = ['user_id' => $this->request->getData('user_id')];
            $booking = $this->Bookings->patchEntity($booking, $data);

            if ($this->Bookings->save($booking)) {
                $this->Flash->success(__('The contractor has been assigned.'));

                if ($booking->user_id !== null) {
                    $contractor = $this->Bookings->Users->find()
                        ->where(['Users.id' => $booking->user_id])
                        ->first();

                    $location = $booking->location;

                    // Fetch the quantities from BookingsServices based on the booking_id
                    $bookingsServices = $this->Bookings->BookingsServices->find()
                        ->where(['booking_id' => $id])
                        ->all()
                        ->indexBy('service_id')
                        ->toArray();

                    // Send Assign Booking Notification to Contractor
                    $mailer = new Mailer('default');

                    // email basic config
                    $mailer
                        ->setFrom(['info@pramspa.com.au' => 'Pram Spa'])
                        ->setEmailFormat('both')
                        ->setTo($contractor->email)
                        ->setSubject('New Booking Assigned to You | Booking #' . $booking->id);

                    // select email template
                    $mailer
                        ->viewBuilder()->setHelpers(['ContentBlocks.ContentBlock'])->setLayout('default')
                        ->setTemplate('assign_contractor');

                    // transfer required view variables to email template
                    $mailer
                        ->setViewVars([
                            'first_name' => $contractor->first_name,
                            'last_name' => $contractor->last_name,
                            'email' => $contractor->email,
                            'booking_id' => $booking->id,
                            'dropoff_loc' => $location->name,
                            'dropoff_address' => h($location->st_address) . ', ' . h($location->suburb) . ' ' . h($location->state->abbr) . ' ' . h($location->postcode),
                            'dropoff_date' => date('d/m/Y', $booking->dropoffDate),
                            'dropoff_time' => date('h:i A', $booking->dropoffTime),
                            'services' => $booking->services,
                            'products' => $booking->products,
                            'bookingsServices' => $bookingsServices
                        ]);

                    //Send email
                    if (!$mailer->deliver()) {
                        // Just in case something goes wrong when sending emails

                        return $this->render(); // Skip the rest of the controller and render the view
                    }
                }

                return $this->redirect(['action' => 'assignContractor', $booking->id]);
            } else {
                $this->Flash->error(__('The contractor could not be assigned. Please, try again.'));
            }
        }

        // Fetch related data
        $statuses = $this->Bookings->Statuses->find('list', limit: 200)->all();
        $locations = $this->Bookings->Locations->find('list', limit: 200)->all();
        $products = $this->Bookings->Products->find('list', limit: 200)->all();
        $services = $this->Bookings->Services->find('list', limit: 200)->all();
        $customers = $this->Bookings->Customers->find('list', limit: 200)->all();

        // Fetch users for the location
        $locationUsers = $this->fetchTable('LocationsUsers')->find()
            ->where(['location_id' => $booking->location_id])
            ->all();

        // Extract user IDs from the locationUsers collection
        $userIds = $locationUsers->extract('user_id')->toList();

        // Fetch the user details (user_id as the key, email as the value)
        if (count($userIds) > 0) {
            $users = $this->fetchTable('Users')->find()
                ->where(['id IN' => $userIds])
                ->all()
                ->combine('id', function ($user) {
                    return $user->first_name . ' ' . $user->last_name;
                })
                ->toArray();
        }

        $this->set(compact('booking', 'statuses', 'customers', 'locations', 'products', 'services', 'users'));
    }

    /**
     * View method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if ($this->allowEntry() === false) {
            return $this->redirect(['action' => 'contractorView', $id]);
        }
        $booking = $this->Bookings->get($id, contain: [
            'Statuses',
            'Customers',
            'Locations' => ['States'],
            'Products',
            'Photos',
            'Services' => [
                'Categories'
            ],
            'Photos'
        ]);

        // Recalculate the due date if dropoff_date or turnaround has changed
        $dropoffDate = $booking->dropoff_date;
        $turnaround = $booking->location->turnaround; // Ensure you have access to turnaround time
        $dueDate = $this->calculateDueDate($dropoffDate, $turnaround);
        $booking->due_date = $dueDate;

        // Fetch contractor
        if ($booking->user_id != null) {
            $contractor = $this->fetchTable('Users')->find()
                ->where(['id IN' => $booking->user_id])
                ->first();
        } else {
            $contractor = null;
        }

        $controller = $this->getRequest()->getQuery('controller');
        $action = $this->getRequest()->getQuery('action');
        $id = $this->getRequest()->getQuery('id');

        if ($controller === null || $action === null) {
            $controller = 'Bookings';
            $action = 'index'; 
        }
        
        $backUrl = ['controller' => $controller, 'action' => $action];

        if ($id !== null) {
            $backUrl = ['controller' => $controller, 'action' => $action, $id];
        }
    
        $this->set(compact('booking', 'contractor', 'backUrl'));
    }

    /**
     * View method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function contractorView($id = null)
    {
        $booking = $this->Bookings->get($id, contain: [
            'Statuses',
            'Customers',
            'Locations' => ['States'],
            'Products',
            'Photos',
            'Services' => ['Categories']
        ]);

        // Fetch the quantities from BookingsServices based on the booking_id
        $bookingsServices = $this->Bookings->BookingsServices->find()
            ->where(['booking_id' => $id])
            ->all()
            ->indexBy('service_id')
            ->toArray();

        $bookingsProducts = $this->Bookings->BookingsProducts->find()
            ->where(['booking_id' => $id])
            ->all()
            ->indexBy('product_id')
            ->toArray();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $booking = $this->Bookings->patchEntity($booking, $data);

            if ($this->Bookings->save($booking)) {
                $this->Flash->success(__('The booking has been saved.'));
            } else {
                $this->Flash->error(__('The booking could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('booking', 'bookingsServices', 'bookingsProducts'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $booking = $this->Bookings->newEmptyEntity();

        if ($this->request->is('post')) {

            $data = $this->request->getData();

            $selectedServiceIds = $data['services']['_ids'] ?? [];

            // Store the selected service IDs in the session
            $this->request->getSession()->write('Booking.service_ids', $selectedServiceIds);

            return $this->redirect(['action' => 'selectLocations']);
        }
        $statuses = $this->Bookings->Statuses->find('list', limit: 200)->all();
        $customers = $this->Bookings->Customers->find('list', limit: 200)->all();
        $products = $this->Bookings->Products->find('list', limit: 200)->all();
        $services = $this->Bookings->Services->find('list', limit: 200)->all();
        $this->set(compact('booking', 'statuses', 'customers', 'products', 'services', 'serviceIds'));
    }

    // Booking Step 1: Select a Drop Off Location
    public function selectLocation()
    {
        $currentStep = 1;

        // Get selectLocation stored in the session
        $selectedLocation = $this->request->getSession()->read('Booking.location_id');

        $booking = $this->Bookings->newEmptyEntity();
        if ($this->request->is('post')) {
            $locationId = $this->request->getData('location_id');

            // Store the selected location in the session
            $this->request->getSession()->write('Booking.location_id', $locationId);

            return $this->redirect(['controller' => 'Bookings', 'action' => 'selectServices']);
        }

        // Fetch locations with full address details, including the state name
        $locations = $this->Bookings->Locations->find()
            ->contain(['States'])
            ->select([
                'Locations.id',
                'Locations.name',
                'Locations.st_address',
                'Locations.suburb',
                'Locations.postcode',
                'Locations.latitude',
                'Locations.longitude',
                'States.name'
            ])
            ->order([
                'States.name' => 'ASC',
                'Locations.suburb' => 'ASC'
            ]) // Order by state and suburb
            ->where(['Locations.status' => 'OPERATIONAL']) // Adding condition for status not archived
            ->all()
            ->groupBy('state.name') // Group by state name
            ->toArray();

        $this->set(compact('booking', 'currentStep', 'locations', 'selectedLocation'));
    }

    // Booking Step 2: Select service(s) & product(s)
    public function selectServices()
    {
        $currentStep = 2;

        // Load the Services and Products table
        $servicesTable = $this->fetchTable('Services');
        $productsTable = $this->fetchTable('Products');

        // Read location and services data from session
        $locationId = $this->request->getSession()->read('Booking.location_id');
        $location = $this->Bookings->Locations->get($locationId);
        $selectedServiceIds = $this->request->getSession()->read('Booking.service_ids') ?? [];

        $services_array = $this->request->getSession()->read('Booking.selected_services') ?? []; // not needed?
        $grouped_services = $this->request->getSession()->read('Booking.grouped_services') ?? [];

        $products_array = $this->request->getSession()->read('Booking.products_array') ?? [];

        if ($this->request->is('post')) {
            // Fetch total cost from the session
            $totalCost = $this->request->getData('total_cost');

            // Retrieve and decode JSON data from grouped_services and services_array
            $groupedServicesJson = $this->request->getData('grouped_services');
            $selectedServicesJson = $this->request->getData('services_array');

            $selectedProductsJson = $this->request->getData('products_array');

            // Decode JSON to PHP array
            $groupedServices = json_decode($groupedServicesJson, true);
            $selectedServices = json_decode($selectedServicesJson, true);

            $selectedProducts = json_decode($selectedProductsJson, true);

            // Check for JSON decoding errors
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->Flash->error(__('Invalid data format for selected services.'));
                return $this->redirect(['action' => 'selectServices']);
            }

            // Extract service/product IDs from the JSON array
            $serviceIdsArray = array_column($selectedServices, 'id');
            $productIdsArray = array_column($selectedProducts, 'id');

            // Store selected services/products & total_cost in the session
            $this->request->getSession()->write('Booking.service_ids', $serviceIdsArray);
            $this->request->getSession()->write('Booking.product_ids', $productIdsArray);
            $this->request->getSession()->write('Booking.total_cost', $totalCost);
            $this->request->getSession()->write('Booking.selected_services', $selectedServices);
            $this->request->getSession()->write('Booking.grouped_services', $groupedServices);
            $this->request->getSession()->write('Booking.products_array', $selectedProducts);

            return $this->redirect(['action' => 'selectDropoffTime']);
        }

        // Subquery to find service_ids associated with the specific location_id
        $subquery = $servicesTable->Locations->junction()->find()
            ->select(['service_id'])
            ->where(['location_id' => $locationId]);

        $services = $servicesTable->find()
            ->contain([
                'Categories' => ['Photos']
            ])
            ->where([
                'Categories.archived' => 0,
                'Services.archived' => 0,
                'Services.id NOT IN' => $subquery

            ])
            ->order(['Categories.id' => 'ASC'])
            ->all()
            ->groupBy(function ($item) {
                return $item->category->name; // Group by category name
            });

        // Fetch products and group them under the "Products" category
        $products = $productsTable
            ->find()
            ->where(['Products.archived' => 0])
            ->toArray();
        $grouped_products = ['Products' => $products];

        $this->set(compact('currentStep', 'services', 'selectedServiceIds', 'services_array', 'grouped_services', 'location', 'grouped_products', 'products_array'));
    }

    // Booking Step 3: Select Drop off date and time
    public function selectDropoffTime()
    {
        $currentStep = 3;

        // Retrieve location, services and total cost data from session
        $locationId = $this->request->getSession()->read('Booking.location_id');
        $location = $this->Bookings->Locations->get($locationId);
        $totalCost = $this->request->getSession()->read('Booking.total_cost');
        $selectedServiceIds = $this->request->getSession()->read('Booking.service_ids');

        $grouped_services = $this->request->getSession()->read('Booking.grouped_services');

        $products_array = $this->request->getSession()->read('Booking.products_array');

        // Load previously selected date and time from session, if any
        $selectedDropoffDate = $this->request->getSession()->read('Booking.dropoff_date') ?? date('Y-m-d', strtotime("+1 day"));
        $selectedDropoffTime = $this->request->getSession()->read('Booking.dropoff_time') ?? null;

        if ($this->request->is('post')) {
            // Get drop-off date and time from the form submission
            $dropoffDate = $this->request->getData('dropoff_date');
            $dropoffDate = date('Y-m-d', strtotime($dropoffDate));
            $dropoffTime = $this->request->getData('dropoff_time');

            // Store selected date and time in session
            $this->request->getSession()->write('Booking.dropoff_date', $dropoffDate);
            $this->request->getSession()->write('Booking.dropoff_time', $dropoffTime);

            return $this->redirect(['controller' => 'Customers', 'action' => 'add']);
        }

        // Get start and end times based on the drop-off date
        $dayOfWeek = date('w', strtotime($selectedDropoffDate)); // Get the current day of the week (0 = Sunday, 6 = Saturday)

        // Fetch availabilities for the location
        $availabilities = $this->fetchTable('Availabilities')->find()
            ->where(['location_id' => $locationId])
            ->all()
            ->map(function ($availability) {
                // Remove seconds from start_time and end_time
                $availability->start_time = $availability->start_time->i18nFormat('HH:mm');
                $availability->end_time = $availability->end_time->i18nFormat('HH:mm');
                return $availability;
            })
            ->toList();

        // Initialize default times (fallback if no availability is found)
        $startTime = null;
        $endTime = null;

        $options = [
            'morning' => [],
            'afternoon' => []
        ];

        // Check if there's availability for the current day of the week
        foreach ($availabilities as $availability) {
            if ($availability->day_of_week == $dayOfWeek) {
                $startTime = strtotime($availability->start_time); // Use the available start time
                $endTime = strtotime($availability->end_time); // Use the available end time

                // Check if current datetime is still available
                if ($selectedDropoffDate == date('Y-m-d')) {
                    $current = time();
                    if (date('i') != 15) {
                        $interval = 15 * 60;
                        $last = $current - $current % $interval;
                        $next = $last + $interval;
                    } else {
                        $next = $current;
                    }

                    // Check if current time is still before the end time
                    if ($next < $endTime) {
                        // If current time is beyond start time, update the start time to current time
                        $startTime = max($next, $startTime);
                        $options = $this->generateTimeOptions($options, $startTime, $endTime);
                    }
                } else {
                    // If it's not today, generate options normally
                    $options = $this->generateTimeOptions($options, $startTime, $endTime);
                }
            }
        }

        // Sort time options
        uasort($options['morning'], function ($a, $b) {
            return strtotime($a) < strtotime($b) ? -1 : 1;
        });

        uasort($options['afternoon'], function ($a, $b) {
            return strtotime($a) < strtotime($b) ? -1 : 1;
        });

        // Fetch unavailabilities for the location
        $unavailabilities = $this->fetchTable('Unavailabilities')->find()
            ->where(['location_id' => $locationId])
            ->all()
            ->toList();

        $unavailableDays = [];
        $count = 0;
        foreach ($unavailabilities as $unavailability) {
            $start = $unavailability->start_date->format('Y-m-d');
            $end = $unavailability->end_date->format('Y-m-d');

            // Create a DatePeriod instance to iterate over each day between start and end
            $period = new \DatePeriod(
                new DateTime($start), // Start date
                new \DateInterval('P1D'), // Interval of 1 day
                (new DateTime($end))->modify('+1 day') // End date inclusive
            );

            // Add each day in the period to the $unavailableDays array
            foreach ($period as $date) {
                $unavailableDays[] = $date->format('Y-m-d');
            }
        }

        $allDaysOfWeek = range(0, 6);

        // Extract available days of the week from availabilities
        $availableDOW = array_map(function ($availability) {
            return $availability->day_of_week;
        }, $availabilities);

        // Find days that are not in the availableDays array
        $unavailableDOW = array_diff($allDaysOfWeek, $availableDOW);

        $this->set(compact('currentStep', 'selectedDropoffDate', 'selectedDropoffTime', 'location', 'totalCost', 'grouped_services', 'options', 'availabilities', 'unavailableDays', 'products_array', 'unavailableDOW'));
    }

    /**
     * Generate time options for availability periods
     */
    public function generateTimeOptions($options = [], $startTime = null, $endTime = null)
    {
        // Calculate time range for the current availability period
        $timeRange = ($endTime - $startTime) / 60;

        // Generate time slots for this availability period
        for ($i = 0; $i <= $timeRange; $i += 15) {  // 15-minute intervals
            $time = strtotime('+' . $i . ' minutes', $startTime);
            $formattedTime = date('H:i', $time);  // Convert to 24-hour format

            // Extract hour from the time
            $hour = date('H', $time);

            // Categorize into morning or afternoon based on hour
            if ($hour < 12) {
                $options['morning'][$formattedTime] = $formattedTime;
            } else {
                $options['afternoon'][$formattedTime] = $formattedTime;
            }
        }

        // Ensure the last element (endTime) is included
        $formattedEndTime = date('H:i', $endTime);
        $endHour = date('H', $endTime);
        if ($endHour < 12) {
            $options['morning'][$formattedEndTime] = $formattedEndTime;
        } else {
            $options['afternoon'][$formattedEndTime] = $formattedEndTime;
        }

        return $options;
    }

    // Booking Step 4: save the customer id in to the booking form
    public function collectCustomerDetails()
    {
        // Check if customer Data is already in session
        $customerData = $this->request->getSession()->read('Customer');

        if (!$customerData) {
            // Redirect to the customer add page if customer ID is not found
            return $this->redirect(['controller' => 'Customers', 'action' => 'add']);
        }

        // If customer ID exists, proceed to the next step in the booking process
        return $this->redirect(['action' => 'confirm']);
    }

    // Booking Step 5: Confirm Booking
    public function confirm()
    {
        $currentStep = 5;

        // Retrieve customer data from the session
        $customerData = $this->request->getSession()->read('Customer');
        if (!$customerData) {
            return $this->redirect(['action' => 'collectCustomerDetails']);
        }

        // Convert the array back into a Customer entity object
        $customer = $this->Bookings->Customers->newEmptyEntity();
        $customer = $this->Bookings->Customers->patchEntity($customer, $customerData);

        // Retrieve other necessary data from the session
        $selectedServiceIds = $this->request->getSession()->read('Booking.service_ids');
        $selectedProductIds = $this->request->getSession()->read('Booking.product_ids');
        $grouped_services = $this->request->getSession()->read('Booking.grouped_services');
        $products_array = $this->request->getSession()->read('Booking.products_array');
        $dropoffDate = $this->request->getSession()->read('Booking.dropoff_date');
        $dropoffTime = $this->request->getSession()->read('Booking.dropoff_time');
        $totalCost = $this->request->getSession()->read('Booking.total_cost');
        $locationId = $this->request->getSession()->read('Booking.location_id');
        $location = $this->Bookings->Locations->get($locationId, [
            'contain' => ['States']
        ]);

        // Calculate booking due date
        $dueDate = $this->calculateDueDate($dropoffDate, $location->turnaround);

        // Calculate quantities of each service
        $serviceQuantities = array_count_values($selectedServiceIds);
        $productQuantities = array_count_values($selectedProductIds);

        // Fetch selected services
        $services = $this->Bookings->Services->find()
            ->contain(['Categories'])
            ->where(['Services.id IN' => array_keys($serviceQuantities)])
            ->all()
            ->indexBy('id')
            ->toArray();

        // Add quantities to products array
        foreach ($services as $id => $service) {
            $services[$id]->quantity = $serviceQuantities[$id];
        }

        if (count($productQuantities) > 0) {
            $products = $this->Bookings->Products->find()
                ->where(['Products.id IN' => array_keys($productQuantities)])
                ->all()
                ->indexBy('id')
                ->toArray();

            // Add quantities to products array
            foreach ($products as $id => $product) {
                $products[$id]->quantity = $productQuantities[$id];
            }
        } else {
            $products = [];
        }

        if ($this->request->is('post')) {
            return $this->redirect(['action' => 'checkout']);
        }

        // Set the booking data for the confirmation page
        $this->set(compact('currentStep', 'booking', 'selectedServiceIds', 'dropoffDate', 'dropoffTime', 'totalCost', 'customerId', 'customer', 'services', 'grouped_services', 'location', 'products'));
    }

    public function privacyPolicy() {}

    public function editView($id = null)
    {
        if ($this->request->getAttribute('identity')->role_id == 3) {
            $this->redirect(['action' => 'contractorView', $id]);
        }

        $booking = $this->Bookings->get($id, contain: [
            'Statuses',
            'Customers',
            'Locations' => ['States'],
            'Products',
            'Services' => ['Categories']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $booking = $this->Bookings->patchEntity($booking, $data);

            if ($this->Bookings->save($booking)) {
                $this->Flash->success(__('The booking has been saved.'));

                // fetch required data
                $status = $this->Bookings->Statuses->get($booking->status_id);
                $customer = $this->Bookings->Customers->get($booking->cust_id);
                $location = $this->Bookings->Locations->get($booking->location_id, [
                    'contain' => ['States']
                ]);

                if ($status->name === 'Approved') {
                    $mailerApproved = new Mailer('default');

                    $mailerApproved
                        ->setFrom(['info@pramspa.com.au' => 'Pram Spa'])
                        ->setEmailFormat('both')
                        ->setTo($customer->email)
                        ->setSubject('Pram Spa: Items Ready for Pick Up | Booking #' . $booking->id);

                    $mailerApproved
                        ->viewBuilder()->setHelpers(['ContentBlocks.ContentBlock'])->setLayout('default')
                        ->setTemplate('pickup_notification');

                    $mailerApproved
                        ->setViewVars([
                            'first_name' => $customer->first_name,
                            'last_name' => $customer->last_name,
                            'email' => $customer->email,
                            'booking_id' => $booking->id,
                            'dropoff_loc' => $location->name,
                            'dropoff_address' => h($location->st_address) . ', ' . h($location->suburb) . ' ' . h($location->state->abbr) . ' ' . h($location->postcode),
                        ]);

                    if (!$mailerApproved->deliver()) {
                        // Just in case something goes wrong when sending emails

                        return $this->render(); // Skip the rest of the controller and render the view
                    }

                    return $this->redirect(['action' => 'view', $booking->id]);
                }

                // Send Customer Feedback email
                if ($status->name === 'Completed') {
                    $mailerCompleted = new Mailer('default');

                    $mailerCompleted
                        ->setFrom(['info@pramspa.com.au' => 'Pram Spa'])
                        ->setEmailFormat('both')
                        ->setTo($customer->email)
                        ->setSubject('Pram Spa: We\'d love to hear your feedback | Booking #' . $booking->id);

                    $mailerCompleted
                        ->viewBuilder()->setHelpers(['ContentBlocks.ContentBlock'])->setLayout('default')
                        ->setTemplate('customer_feedback');

                    $mailerCompleted
                        ->setViewVars([
                            'first_name' => $customer->first_name,
                            'last_name' => $customer->last_name,
                            'email' => $customer->email
                        ]);

                    if (!$mailerCompleted->deliver()) {
                        // Just in case something goes wrong when sending emails

                        return $this->render(); // Skip the rest of the controller and render the view
                    }

                    return $this->redirect(['action' => 'view', $booking->id]);
                }
            } else {
                $this->Flash->error(__('The booking could not be saved. Please, try again.'));
            }
            return $this->redirect(['action' => 'view', $booking->id]);
        }
        $statuses = $this->Bookings->Statuses->find('list', limit: 200)->all();
        $locations = $this->Bookings->Locations->find('list', limit: 200)->all();
        $products = $this->Bookings->Products->find('list', limit: 200)->all();
        $services = $this->Bookings->Services->find('list', limit: 200)->all();
        $customers = $this->Bookings->Customers->find('list', limit: 200)->all();

        // Fetch users for the location
        $locationUsers = $this->fetchTable('LocationsUsers')->find()
            ->where(['location_id' => $booking->location_id])
            ->all();

        // Extract user IDs from the locationUsers collection
        $userIds = $locationUsers->extract('user_id')->toList();

        // Fetch the user details (user_id as the key, email as the value)
        $users = $this->fetchTable('Users')->find()
            ->where(['id IN' => $userIds])
            ->all()
            ->combine('id', function ($user) {
                return $user->first_name . ' ' . $user->last_name;
            })
            ->toArray();

        if ($booking->user_id != null) {
            $defaultContractor =  $this->fetchTable('Users')->find()
                ->where(['id IN' => $booking->user_id])
                ->all()
                ->extract('email')
                ->toList();
        } else {
            $defaultContractor = null;
        };

        // Availabilities
        $availabilities = $this->fetchTable('Availabilities')->find()
            ->where([
                'location_id' => $booking->location_id,
            ])
            ->all()
            ->map(function ($availability) {
                // Remove seconds from start_time and end_time
                $availability->start_time = $availability->start_time->i18nFormat('HH:mm');
                $availability->end_time = $availability->end_time->i18nFormat('HH:mm');
                return $availability;
            })
            ->toList();

        $selectedDropoffDate = $booking->get('dropoff_date')->format('Y-m-d');

        $dayOfWeek = date('w', strtotime($selectedDropoffDate));

        // Fetch availabilities for the location
        $selectedAvailabilities = $this->fetchTable('Availabilities')->find()
            ->where([
                'location_id' => $booking->location_id,
                'day_of_week' => $dayOfWeek,
            ])
            ->all()
            ->map(function ($availability) {
                // Remove seconds from start_time and end_time
                $availability->start_time = $availability->start_time->i18nFormat('HH:mm');
                $availability->end_time = $availability->end_time->i18nFormat('HH:mm');
                return $availability;
            })
            ->toList();

        $options = array();

        foreach ($selectedAvailabilities as $availability) {
            $startTime = strtotime($availability->start_time);
            $endTime = strtotime($availability->end_time);

            $timeRange = ($endTime - $startTime) / 60;

            for ($i = 0; $i <= $timeRange; $i += 15) {
                $options[date('H:i', ($startTime + $i * 60))] = date('H:i', ($startTime + $i * 60));
            }

            $options[date('H:i', $endTime)] = date('H:i', $endTime);
        }

        // Sort time options
        uasort($options, function ($a, $b) {
            return strtotime($a) < strtotime($b) ? -1 : 1;
        });

        $selectedDropoffTime = $booking->get('dropoff_time')->format('H:i');

        // Unavailabilities
        // Fetch unavailabilities for the location
        $unavailabilities = $this->fetchTable('Unavailabilities')->find()
            ->where(['location_id' => $booking->location_id])
            ->all()
            ->toList();

        $unavailableDays = [];
        $count = 0;
        foreach ($unavailabilities as $unavailability) {
            $start = $unavailability->start_date->format('Y-m-d');
            $end = $unavailability->end_date->format('Y-m-d');

            // Create a DatePeriod instance to iterate over each day between start and end
            $period = new \DatePeriod(
                new DateTime($start), // Start date
                new \DateInterval('P1D'), // Interval of 1 day
                (new DateTime($end))->modify('+1 day') // End date inclusive
            );

            // Add each day in the period to the $unavailableDays array
            foreach ($period as $date) {
                $unavailableDays[] = $date->format('Y-m-d');
            }
        }

        $this->set(compact('availabilities', 'booking', 'statuses', 'customers', 'locations', 'products', 'services', 'options', 'selectedDropoffTime', 'users', 'defaultContractor', 'selectedDropoffDate', 'unavailableDays'));
    }
    /**
     * Edit method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if ($this->request->getAttribute('identity')->role_id == 3) {
            $this->redirect(['action' => 'contractorView', $id]);
        }
        // $booking = $this->Bookings->get($id, contain: ['Products', 'Services']);
        $booking = $this->Bookings->get($id, contain: [
            'Statuses',
            'Customers',
            'Locations' => ['States'],
            'Products',
            'Services' => ['Categories']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if (array_key_exists('dropoff_date', $data)) {
                $data['dropoff_date'] = date('Y-m-d', strtotime($data['dropoff_date']));
            }
            $booking = $this->Bookings->patchEntity($booking, $data);

            if (isset($data['dropoff_time'])) {
                if ($this->Bookings->save($booking)) {
                    $this->Flash->success(__('The booking has been saved.'));

                    // fetch required data
                    $status = $this->Bookings->Statuses->get($booking->status_id);
                    $customer = $this->Bookings->Customers->get($booking->cust_id);
                    $location = $this->Bookings->Locations->get($booking->location_id, [
                        'contain' => ['States']
                    ]);

                    if ($status->name === 'Approved') {
                        $mailerApproved = new Mailer('default');

                        $mailerApproved
                            ->setFrom(['info@pramspa.com.au' => 'Pram Spa'])
                            ->setEmailFormat('both')
                            ->setTo($customer->email)
                            ->setSubject('Pram Spa: Items Ready for Pick Up | Booking #' . $booking->id);

                        $mailerApproved
                            ->viewBuilder()->setHelpers(['ContentBlocks.ContentBlock'])->setLayout('default')
                            ->setTemplate('pickup_notification');

                        $mailerApproved
                            ->setViewVars([
                                'first_name' => $customer->first_name,
                                'last_name' => $customer->last_name,
                                'email' => $customer->email,
                                'booking_id' => $booking->id,
                                'dropoff_loc' => $location->name,
                                'dropoff_address' => h($location->st_address) . ', ' . h($location->suburb) . ' ' . h($location->state->abbr) . ' ' . h($location->postcode),
                            ]);

                        if (!$mailerApproved->deliver()) {
                            // Just in case something goes wrong when sending emails

                            return $this->render(); // Skip the rest of the controller and render the view
                        }

                        return $this->redirect(['action' => 'view', $booking->id]);
                    }

                    if ($status->name === 'Completed') {
                        $mailer = new Mailer('default');

                        // email basic config
                        $mailer
                            ->setFrom(['info@pramspa.com.au' => 'Pram Spa'])
                            ->setEmailFormat('both')
                            ->setTo($customer->email)
                            ->setSubject('Pram Spa: We\'d love to hear your feedback | Booking #' . $booking->id);

                        // select email template
                        $mailer
                            ->viewBuilder()->setHelpers(['ContentBlocks.ContentBlock'])->setLayout('default')
                            ->setTemplate('customer_feedback');

                        // transfer required view variables to email template
                        $mailer
                            ->setViewVars([
                                'first_name' => $customer->first_name,
                                'last_name' => $customer->last_name,
                                'email' => $customer->email
                            ]);

                        //Send email
                        if (!$mailer->deliver()) {
                            // Just in case something goes wrong when sending emails

                            return $this->render(); // Skip the rest of the controller and render the view
                        }

                        return $this->redirect(['action' => 'view', $booking->id]);
                    } else {
                        return $this->redirect(['action' => 'view', $booking->id]);
                    }
                } else {
                    $this->Flash->error(__('The booking could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('Please make sure sure you have selected a valid date and time.'));
            }
        }
        $statuses = $this->Bookings->Statuses->find('list', limit: 200)->all();
        $products = $this->Bookings->Products->find('list', limit: 200)->all();
        $services = $this->Bookings->Services->find('list', limit: 200)->all();
        $customers = $this->Bookings->Customers->find('list', limit: 200)->all();

        $locations = $this->Bookings->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['name' => 'ASC'],
        ])
            ->where(['status' => 'OPERATIONAL'])
            ->toArray();

        // Fetch users for the location
        $locationUsers = $this->fetchTable('LocationsUsers')->find()
            ->where(['location_id' => $booking->location_id])
            ->all();

        // Extract user IDs from the locationUsers collection
        $userIds = $locationUsers->extract('user_id')->toList();

        // Fetch the user details (user_id as the key, email as the value)
        $users = [];
        if ($userIds) {
            // Fetch the user details (user_id as the key, email as the value)
            $users = $this->fetchTable('Users')->find()
                ->where(['id IN' => $userIds])
                ->all()
                ->combine('id', function ($user) {
                    return $user->first_name . ' ' . $user->last_name;
                })
                ->toArray();
        }

        if ($booking->user_id != null) {
            $defaultContractor =  $this->fetchTable('Users')->find()
                ->where(['id IN' => $booking->user_id])
                ->all()
                ->extract('email')
                ->toList();
        } else {
            $defaultContractor = null;
        };

        // Availabilities
        $availabilities = $this->fetchTable('Availabilities')->find()
            ->where([
                'location_id' => $booking->location_id,
            ])
            ->all()
            ->map(function ($availability) {
                // Remove seconds from start_time and end_time
                $availability->start_time = $availability->start_time->i18nFormat('HH:mm');
                $availability->end_time = $availability->end_time->i18nFormat('HH:mm');
                return $availability;
            })
            ->toList();

        $selectedDropoffDate = $booking->get('dropoff_date')->format('Y-m-d');

        $dayOfWeek = date('w', strtotime($selectedDropoffDate));

        // Fetch availabilities for the location
        $selectedAvailabilities = $this->fetchTable('Availabilities')->find()
            ->where([
                'location_id' => $booking->location_id,
                'day_of_week' => $dayOfWeek,
            ])
            ->all()
            ->map(function ($availability) {
                // Remove seconds from start_time and end_time
                $availability->start_time = $availability->start_time->i18nFormat('HH:mm');
                $availability->end_time = $availability->end_time->i18nFormat('HH:mm');
                return $availability;
            })
            ->toList();

        $options = array();

        foreach ($selectedAvailabilities as $availability) {
            $startTime = strtotime($availability->start_time);
            $endTime = strtotime($availability->end_time);

            $timeRange = ($endTime - $startTime) / 60;

            for ($i = 0; $i <= $timeRange; $i += 15) {
                $options[date('H:i', ($startTime + $i * 60))] = date('H:i', ($startTime + $i * 60));
            }

            $options[date('H:i', $endTime)] = date('H:i', $endTime);
        }

        // Sort time options
        uasort($options, function ($a, $b) {
            return strtotime($a) < strtotime($b) ? -1 : 1;
        });

        $selectedDropoffTime = $booking->get('dropoff_time')->format('H:i');

        // Unavailabilities
        // Fetch unavailabilities for the location
        $unavailabilities = $this->fetchTable('Unavailabilities')->find()
            ->where(['location_id' => $booking->location_id])
            ->all()
            ->toList();

        $unavailableDays = [];
        $count = 0;
        foreach ($unavailabilities as $unavailability) {
            $start = $unavailability->start_date->format('Y-m-d');
            $end = $unavailability->end_date->format('Y-m-d');

            // Create a DatePeriod instance to iterate over each day between start and end
            $period = new \DatePeriod(
                new DateTime($start), // Start date
                new \DateInterval('P1D'), // Interval of 1 day
                (new DateTime($end))->modify('+1 day') // End date inclusive
            );

            // Add each day in the period to the $unavailableDays array
            foreach ($period as $date) {
                $unavailableDays[] = $date->format('Y-m-d');
            }
        }

        $this->set(compact('availabilities', 'booking', 'statuses', 'customers', 'locations', 'products', 'services', 'options', 'selectedDropoffTime', 'users', 'defaultContractor', 'selectedDropoffDate', 'unavailableDays'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $booking = $this->Bookings->get($id);
        if ($this->Bookings->delete($booking)) {
            $this->Flash->success(__('The booking has been deleted.'));
        } else {
            $this->Flash->error(__('The booking could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Checkout method
     *
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function checkout()
    {
        // Set the Stripe secret key from configuration
        $stripe_secret_key = Configure::read('Stripe.secret_key');
        $stripe_tax_rate = Configure::read('Stripe.tax_rate');

        // Set the Stripe API key
        Stripe::setApiKey($stripe_secret_key);

        // Success URL
        $successUrl = Router::url('/bookings/success-page', true);

        // Load drop-off location to prepopulate in Stripe
        $locationId = $this->request->getSession()->read('Booking.location_id');
        $location = $this->Bookings->Locations->get($locationId, [
            'contain' => ['States']
        ]);

        // Get customer email to send receipt
        $customerData = $this->request->getSession()->read('Customer');
        if (!$customerData) {
            $this->Flash->error(__('Customer data not found. Please, try again.'));
            return $this->redirect(['action' => 'collectCustomerDetails']);
        }

        // Retrieve all services and products
        $services = $this->request->getSession()->read('Booking.selected_services');
        $products = $this->request->getSession()->read('Booking.products_array'); // Make sure you have this in the session
        $lineItems = [];
        $count = 0;
        $serviceNames = [];
        $productNames = [];

        // Add services to line items
        foreach ($services as $service) {
            if (!array_key_exists($service['name'], $serviceNames)) {
                $lineItems[$count]['price_data']['currency'] = "AUD";
                $lineItems[$count]['price_data']['unit_amount'] = $service['cost'] * 100;
                $lineItems[$count]['price_data']['product_data']['name'] = $service['category'] . ' ' . $service['name'];
                $lineItems[$count]['quantity'] = 1;
                $lineItems[$count]['tax_rates'] = [$stripe_tax_rate];
                $serviceNames[$service['category'] . ' ' . $service['name']] = $count;
                $count++;
            } else {
                $lineItems[$serviceNames[$service['name']]]['quantity']++;
            }
        }

        foreach ($products as $product) {
            if (!array_key_exists($product['name'], $productNames)) {
                $lineItems[$count]['price_data']['currency'] = "AUD";
                $lineItems[$count]['price_data']['unit_amount'] = $product['cost'] * 100;
                $lineItems[$count]['price_data']['product_data']['name'] = $product['name'];
                $lineItems[$count]['quantity'] = 1;
                $lineItems[$count]['tax_rates'] = [$stripe_tax_rate];

                $productNames[$product['name']] = $count;
                $count++;
            } else {
                $lineItems[$productNames[$product['name']]]['quantity']++;
            }
        }

        // Promotion code handling
        $promotionCode = $this->request->getData('promotion_code');
        $this->request->getSession()->write('PromotionCode', $promotionCode);

        try {
            // Create a Stripe checkout session
            $checkout_session = \Stripe\Checkout\Session::create([
                "line_items" => $lineItems,
                "mode" => "payment",
                "payment_method_types" => ["card", "afterpay_clearpay", "au_becs_debit"],
                'allow_promotion_codes' => true,
                "payment_intent_data" => [
                    "shipping" => [
                        "name" => "Dropoff Location",
                        "address" => [
                            "line1" => $location->st_address,
                            "city" => $location->suburb,
                            "state" => $location->state->abbr,
                            "postal_code" => $location->postcode,
                            "country" => "AU",
                        ],
                    ],
                ],
                "success_url" => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
            ]);

            // Redirect to the Stripe checkout session URL
            return $this->redirect($checkout_session->url);
        } catch (ApiErrorException $e) {
            // Handle Stripe API errors
            throw new NotFoundException('Stripe API Error: ' . $e->getMessage());
        }
    }


    public function successPage()
    {
        // Retrieve information from Stripe paymentIntent
        // Set Stripe API key
        \Stripe\Stripe::setApiKey(Configure::read('Stripe.secret_key'));

        // Retrieve session ID from the query parameter
        $session_id = $this->request->getQuery('session_id');

        if (!$session_id) {
            throw new NotFoundException('Session ID not found.');
        }

        try {
            // Retrieve the checkout session
            $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);

            // Retrieve the Payment Intent ID from the Checkout session
            $payment_intent_id = $checkout_session->payment_intent;

            // Retrieve the Payment Intent using the ID
            $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);

            $payment_method = $payment_intent->payment_method_types[0];

            $amount_paid = $checkout_session->amount_total / 100;
            $discount_amount = $checkout_session->total_details->amount_discount / 100;
            $tax_amount = $checkout_session->total_details->amount_tax / 100;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            throw new NotFoundException('Stripe API Error: ' . $e->getMessage());
        }

        // Retrieve customer data from the session
        $customerData = $this->request->getSession()->read('Customer');
        if (!$customerData) {
            $this->Flash->error(__('Customer data not found. Please, try again.'));
            return $this->redirect(['action' => 'selectLocation']);
        }

        // Extract customer fields from the session data
        $firstName = $customerData['first_name'];
        $lastName = $customerData['last_name'];
        $email = $customerData['email'];
        $phone = $customerData['phone_no'];
        $discoverySourceId = $customerData['discovery_source_id'];

        // Check if customer already exists based on these fields
        $existingCustomer = $this->Bookings->Customers->find()
            ->where([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone_no' => $phone,
            ])
            ->first();

        if ($existingCustomer) {
            // Customer already exists, use their ID for the booking
            $customerId = $existingCustomer->id;
            $customer = $existingCustomer;
        } else {
            // Create new customer entity
            $customer = $this->Bookings->Customers->newEmptyEntity();
            $customerData = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone_no' => $phone,
                'discovery_source_id' => $discoverySourceId
            ];

            $customer = $this->Bookings->Customers->patchEntity($customer, $customerData);

            if ($this->Bookings->Customers->save($customer)) {
                $customerId = $customer->id;
            } else {
                // Handle save error
                $this->Flash->error(__('The customer could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'collectCustomerDetails']);
            }
        }

        // Store the customer ID in the session
        $this->request->getSession()->write('Booking.customer_id', $customerId);

        // Retrieve all necessary data from the session
        $customerId = $this->request->getSession()->read('Booking.customer_id');
        $selectedServiceIds = $this->request->getSession()->read('Booking.service_ids');
        $selectedProductIds = $this->request->getSession()->read('Booking.product_ids');
        $dropoffDate = $this->request->getSession()->read('Booking.dropoff_date');
        $dropoffTime = $this->request->getSession()->read('Booking.dropoff_time');
        $totalCost = $this->request->getSession()->read('Booking.total_cost');
        $locationId = $this->request->getSession()->read('Booking.location_id');
        $location = $this->Bookings->Locations->get($locationId, [
            'contain' => ['States']
        ]);

        // Calculate quantities of each service
        $serviceQuantities = array_count_values($selectedServiceIds);
        $productQuantities = array_count_values($selectedProductIds);

        // Fetch selected services
        $services = $this->Bookings->Services->find()
            ->contain('Categories')
            ->where(['Services.id IN' => array_keys($serviceQuantities)])
            ->all()
            ->indexBy('id')
            ->toArray();

        // Add quantities to services array
        foreach ($services as $id => $service) {
            $services[$id]->quantity = $serviceQuantities[$id];
        }

        if (count($productQuantities) > 0) {
            $products = $this->Bookings->Products->find()
                ->where(['Products.id IN' => array_keys($productQuantities)])
                ->all()
                ->indexBy('id')
                ->toArray();

            // Add quantities to services array
            foreach ($products as $id => $product) {
                $products[$id]->quantity = $productQuantities[$id];
            }
        } else {
            $products = [];
        }

        // Generate booking ID
        $custChar = null;
        $randNum = '';
        $bookingId = '';

        do {
            // Generate random number
            $randNum = '';
            for ($x = 0; $x < 6; $x++) {
                $randNum .= rand(0, 9);
            }

            $custChar = str_pad(substr($customer->first_name, 0, 3), 3, '_');
            $custChar .= str_pad(substr($customer->last_name, 0, 3), 3, '_');

            $bookingId = strtoupper($custChar) . $randNum;

            // Check if the bookingId already exists in the database
            $existingBooking = $this->Bookings->find()
                ->where(['id' => $bookingId])
                ->first();
        } while (!empty($existingBooking)); // Repeat if bookingId is found

        // Create and save the booking
        $booking = $this->Bookings->newEmptyEntity();
        $booking->id = $bookingId;
        $bookingData = [
            'cust_id' => $customerId,
            'location_id' => $locationId,
            'dropoff_date' => $dropoffDate,
            'dropoff_time' => $dropoffTime,
            'total_cost' => $amount_paid,
            'discount_amount' => $discount_amount,
            'initial_amount' => $totalCost,
            'due_date' => $this->calculateDueDate($dropoffDate, $location->turnaround),
            'status_id' => 1,
            'date_paid' => date('Y-m-d H:i:s'),
            'date_booked' => date('Y-m-d H:i:s')
        ];
        $booking = $this->Bookings->patchEntity($booking, $bookingData);

        if ($this->Bookings->save($booking)) {
            // Save associated services
            foreach ($services as $serviceId => $service) {
                $bookingsService = $this->Bookings->BookingsServices->newEmptyEntity();
                $bookingsService->booking_id = $bookingId;
                $bookingsService->service_id = $serviceId;
                $bookingsService->service_qty = $service->quantity;
                $this->Bookings->BookingsServices->save($bookingsService);
            }

            // Save associated products
            foreach ($products as $productId => $product) {
                $bookingsProduct = $this->Bookings->BookingsProducts->newEmptyEntity();
                $bookingsProduct->booking_id = $bookingId;
                $bookingsProduct->product_id = $productId;
                $bookingsProduct->product_qty = $product->quantity;
                $this->Bookings->BookingsProducts->save($bookingsProduct);
            }
        } else {
            $this->Flash->error(__('The booking could not be saved. Please, try again.'));
        }

        // Send Booking Confirmation to Customer
        $mailerToCustomer = new Mailer('default');

        // email basic config
        $mailerToCustomer
            ->setFrom(['info@pramspa.com.au' => 'Pram Spa'])
            ->setEmailFormat('both')
            ->setTo($customer->email)
            ->setSubject('Booking Confirmation with Pram Spa | Booking #' . $booking->id);

        // select email template
        $mailerToCustomer
            ->viewBuilder()->setHelpers(['ContentBlocks.ContentBlock'])->setLayout('new_booking')
            ->setTemplate('customer_confirm');

        // transfer required view variables to email template
        $mailerToCustomer
            ->setViewVars([
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'phone_no' => $customer->phone_no,
                'email' => $customer->email,
                'dropoff_loc' => $location->name,
                'dropoff_address' => h($location->st_address) . ', ' . h($location->suburb) . ' ' . h($location->state->abbr) . ' ' . h($location->postcode),
                'dropoff_date' => date('d/m/Y', strtotime($dropoffDate)),
                'dropoff_time' => date('h:i A', strtotime($dropoffTime)),
                'total_cost' => $totalCost,
                'discount_amt' => $discount_amount,
                'amount_paid' => $amount_paid,
                'tax_amt' => $tax_amount,
                'pmt_method' => $payment_method,
                'services' => $services,
                'products' => $products,
                'booking_id' => $bookingId
            ]);

        //Send email
        if (!$mailerToCustomer->deliver()) {
            // Handle email sending failure if necessary
            $this->Flash->error(__("We unfortunately couldn't send you the booking confirmation email. Please contact Pram Spa to confirm that your booking went through."));
        }

        // Clone existing mailer for New Booking Notification to Admin
        $mailerToAdmin = clone $mailerToCustomer;

        // email basic config
        $mailerToAdmin
            ->setFrom(['booking.no-reply@pramspa.au' => 'Pram Spa Bookings'])
            ->setEmailFormat('both')
            ->setTo('info@pramspa.com.au')
            ->setSubject('New Pram Spa Booking for ' . $customer->first_name . ' ' . $customer->last_name . ' | Booking #' . $booking->id);

        // select email template
        $mailerToAdmin
            ->viewBuilder()->setHelpers(['ContentBlocks.ContentBlock'])->setLayout('new_booking')
            ->setTemplate('booking_notification');

        // Send the cloned email
        if (!$mailerToAdmin->deliver()) {
            return $this->render();
        }

        // Clear the session data
        $this->request->getSession()->delete('Booking');
        $this->request->getSession()->delete('Customer');

        $this->set(compact('booking', 'selectedServiceIds', 'dropoffDate', 'dropoffTime', 'totalCost', 'customerId', 'customer', 'services', 'location', 'amount_paid', 'discount_amount', 'tax_amount', 'products'));
    }

    /**
     * Boookings Summary Report method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function bookingsSummary()
    {
        // Get role of user
        $roleId = $this->request->getSession()->read('Auth.role_id');

        // If the user is a contractor (role 3), redirect them to their own bookings page
        if ($roleId == 3) {
            return $this->redirect(['controller' => 'Bookings', 'action' => 'indexById']);
        }

        if ($this->request->getQuery('clear') == 1) {
            $this->request->getSession()->delete('BookingsSummary');
        }

        // Fetch all unique locations for the filter dropdown
        $locations = $this->Bookings->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['name' => 'ASC'],
        ])
            ->where(['status !=' => 'ARCHIVED'])
            ->toArray();

        // Fetch all unique statuses for the filter dropdown
        $statuses = $this->Bookings->Statuses->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['name' => 'ASC'],
        ])->toArray();

        // Get the filter location and status from the query string
        $locationId = $this->request->getQuery('location');
        $statusId = $this->request->getQuery('status');

        // Filter date range
        $start_date = $this->request->getQuery('start_date');
        $end_date = $this->request->getQuery('end_date');

        // Base query for bookings
        $query = $this->Bookings->find()->contain(['Statuses', 'Customers', 'Locations', 'Services' => [
            'Categories'
        ]]);

        // Apply the location filter if a location is selected
        $locationId = $this->locationFilter($locationId, 'BookingsSummary');
        if (!empty($locationId)) {
            $query->where(['Bookings.location_id' => $locationId]);
        }

        // Apply the status filter if a status is selected
        $statusId = $this->statusFilter($statusId, 'BookingsSummary');
        if (!empty($statusId)) {
            $query->where(['Bookings.status_id' => $statusId]);
        }

        // Apply date range filter
        $dates = $this->dateRangeFilter($start_date, $end_date, 'BookingsSummary');
        $start_date = $dates[0];
        $end_date = $dates[1];

        if (!empty($start_date) && !empty($end_date)) {
            $query->where(['Bookings.date_booked >= ' => $start_date, 'Bookings.date_booked <=' => $end_date]);
        } elseif (!empty($start_date) && empty($end_date)) {
            $query->where(['Bookings.date_booked >= ' => $start_date]);
        } elseif (empty($start_date) && !empty($end_date)) {
            $query->where(['Bookings.date_booked <= ' => $end_date]);
        }

        $query = $query->limit(300);

        $bookingIds = $query->all()->extract('id')->toList();

        $users = $this->fetchTable('Users')->find()
            ->all()
            ->indexBy('id')
            ->toArray();

        $location = null;
        if ($locationId != null) {
            $location = $this->Bookings->Locations->get($locationId);
        }

        // Paginate the filtered query
        $this->paginate = [
            'limit' => 300,
            'maxLimit' => 500,
            'order' => ['Bookings.dropoff_date' => 'desc']
        ];

        $bookings = $this->paginate($query);

        // Pass data to the view
        $this->set(compact('bookings', 'locations', 'statuses', 'locationId', 'statusId', 'users', 'start_date', 'end_date', 'location'));
    }

    /**
     * Monthly Summary Report method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function monthlySummary()
    {
        // Get role of user
        $roleId = $this->request->getSession()->read('Auth.role_id');

        // If the user is a contractor (role 3), redirect them to their own bookings page
        if ($roleId == 3) {
            return $this->redirect(['controller' => 'Bookings', 'action' => 'indexById']);
        }

        // Fetch all unique locations for the filter dropdown
        $locations = $this->Bookings->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['name' => 'ASC'],
        ])
            ->where(['status !=' => 'ARCHIVED'])
            ->toArray();

        // Fetch all unique statuses for the filter dropdown
        $statuses = $this->Bookings->Statuses->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['name' => 'ASC'],
        ])->toArray();

        // Generate the list of years for the filter dropdown
        $years = [];
        for ($year = date('Y') - 5; $year <= date('Y'); $year++) {
            $years[$year] = $year;
        }

        // Get the selected filter values from the query string
        $locationId = $this->request->getQuery('location');
        if ($locationId != null) {
            $selectedLocation = $this->fetchTable('Locations')->find()
                ->where(['id' => $locationId])
                ->first()
                ->suburb; // Use 'suburb' to match the location name field
        } else {
            $selectedLocation = 'All locations';
        }

        $financialYear = $this->request->getQuery('financial_year');
        if ($financialYear != null) {
            $financialYearVal = $financialYear . '/07 - ' . ($financialYear + 1) . '/06';
        } else {
            $financialYear = date('Y'); // Set the financial year to the current year if not provided
            $financialYearVal = $financialYear . '/07 - ' . ($financialYear + 1) . '/06';
        }

        $months = [];
        // Add months from July to December of the selected financial year
        for ($month = 7; $month <= 12; $month++) {
            $months[] = [$month, date('F Y', strtotime("$financialYear-$month-01"))];
        }

        // Add months from January to June of the next year
        for ($month = 1; $month <= 6; $month++) {
            $nextYear = $financialYear + 1;
            $months[] = [$month, date('F Y', strtotime("$nextYear-$month-01"))];
        }

        $summary = [];

        $statusId = $this->fetchTable('Statuses')->find()
            ->where(['name' => 'Cancelled'])
            ->first()
            ->id;

        foreach ($months as $month) {
            $startOfMonth = date('Y-m-01 00:00:00', strtotime($month[1]));
            $endOfMonth = date('Y-m-t 23:59:59', strtotime($month[1]));

            // Count total bookings for this month
            $query = $this->Bookings->find()
                ->where([
                    'date_paid >=' => $startOfMonth,
                    'date_paid <=' => $endOfMonth,
                    'status_id NOT IN' => $statusId
                ]);

            if ($locationId) {
                $query->andWhere(['location_id' => $locationId]);
            }

            $totalBookings = $query->count();

            // Count total services for this month by summing service_qty from BookingsServices
            $totalServicesQuery = $this->fetchTable('BookingsServices')->find()
                ->contain(['Bookings'])
                ->where([
                    'Bookings.date_paid >=' => $startOfMonth,
                    'Bookings.date_paid <=' => $endOfMonth,
                    'Bookings.status_id NOT IN' => $statusId
                ]);

            if ($locationId) {
                $totalServicesQuery->andWhere(['Bookings.location_id' => $locationId]);
            }

            $totalServices = $totalServicesQuery
                ->select(['total_service_qty' => 'SUM(BookingsServices.service_qty)'])
                ->first()
                ->total_service_qty ?? 0;

            $invoiceTotalQuery = $totalCostSum = $this->Bookings->find()
                ->where([
                    'date_paid >=' => $startOfMonth,
                    'date_paid <=' => $endOfMonth,
                    'status_id NOT IN' => $statusId
                ]);

            if ($locationId) {
                $invoiceTotalQuery->andWhere(['location_id' => $locationId]);
            }

            $invoiceTotal = $invoiceTotalQuery->all()
                ->sumOf('total_cost');

            $avgInvoice = $totalBookings != 0 ? $invoiceTotal / $totalBookings : 0;

            // Add the results to the summary
            $summary[] = [
                'month' => $month,
                'totalBookings' => $totalBookings,
                'totalServices' => $totalServices,
                'avgInvoice' => $avgInvoice,
                'invoiceTotal' => $invoiceTotal,
            ];
        }

        // Pass data to the view
        $this->set(compact('summary', 'locations', 'locationId', 'selectedLocation', 'statuses', 'financialYear', 'financialYearVal', 'years', 'months', 'invoiceTotal', 'avgInvoice'));
    }

    /**
     * Boookings Summary Report method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function executiveSummary()
    {
        // Get role of user
        $roleId = $this->request->getSession()->read('Auth.role_id');

        // If the user is a contractor (role 3), redirect them to their own bookings page
        if ($roleId == 3) {
            return $this->redirect(['controller' => 'Bookings', 'action' => 'indexById']);
        }

        // Fetch all unique locations for the filter dropdown
        $locationOptions = $this->Bookings->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['name' => 'ASC'],
        ])
            ->where(['status !=' => 'ARCHIVED'])
            ->toArray();

        // Fetch all unique statuses for the filter dropdown
        $statuses = $this->Bookings->Statuses->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['name' => 'ASC'],
        ])->toArray();

        $selectedLocationId = $this->request->getQuery('location');
        if ($selectedLocationId != null) {
            $locations = $this->fetchTable('Locations')->find()
                ->where(['id' => $selectedLocationId])->toArray();
            $selectedLocation = $this->fetchTable('Locations')->find()
                ->where(['id' => $selectedLocationId])
                ->first()
                ->suburb;
        } else {
            $locations = $this->fetchTable('Locations')->find()->where(['status !=' => 'ARCHIVED'])->toArray();
            $selectedLocation = 'All Locations';
        }

        foreach ($locations as $location) {
            $locationId = $location->id;
            $locationName = $location->name;

            // Filter date range
            $start = $this->request->getQuery('start_date');
            $selectedStartDate = $start != '' ? $start : date('Y/m/d');
            $end = $this->request->getQuery('end_date');
            $selectedEndDate = $end != '' ? $end : date('Y/m/d', strtotime($selectedStartDate . ' +1 month -1 day'));

            $statusId = $this->fetchTable('Statuses')->find()
                ->where(['name' => 'Completed'])
                ->first()
                ->id;

            $query = $this->Bookings->find()
                ->where([
                    'location_id' => $location->id,
                    'date_paid >=' => $selectedStartDate,
                    'date_paid <=' => $selectedEndDate,
                    'status_id' => $statusId,
                ]);

            $totalBookings = $query->count();

            $totalServicesQuery = $this->fetchTable('BookingsServices')->find()
                ->contain(['Bookings'])
                ->where([
                    'Bookings.date_paid >=' => $selectedStartDate,
                    'Bookings.date_paid <=' => $selectedEndDate,
                    'Bookings.status_id' => $statusId,
                    'Bookings.location_id' => $location->id
                ]);

            $totalServices = $totalServicesQuery
                ->select(['total_service_qty' => 'SUM(BookingsServices.service_qty)'])
                ->first()
                ->total_service_qty ?? 0;

            $invoiceTotal = $query->all()
                ->sumOf('total_cost');

            $discountTotal = $query->all()
                ->sumOf('discount_amount');

            $avgInvoice = $totalBookings != 0 ? $invoiceTotal / $totalBookings : 0;

            $customerList = $query->all()->extract('cust_id')->toList();

            if (count($customerList) != 0) {
                $totalCustomer = $this->fetchTable('Customers')->find()
                    ->where([
                        'id IN' => $customerList
                    ])
                    ->count();
            } else {
                $totalCustomer = 0;
            }

            $summary[] = [
                'locationId' => $locationId,
                'locationName' => $locationName,
                'totalCustomers' => $totalCustomer,
                'totalBookings' => $totalBookings,
                'totalServices' => $totalServices,
                'avgInvoice' => $avgInvoice,
                'discountTotal' => $discountTotal,
                'invoiceTotal' => $invoiceTotal,
            ];
        }

        // Pass data to the view
        $this->set(compact('locationOptions', 'selectedLocationId', 'statuses', 'statusId', 'summary', 'selectedStartDate', 'selectedEndDate', 'selectedLocation'));
    }


    private function calculateDueDate($dropoffDate, $turnaround)
    {
        // Convert dropoffDate to Date object
        if (!($dropoffDate instanceof \Cake\I18n\Date)) {
            $dropoffDate = new \Cake\I18n\Date($dropoffDate);
        }

        // If dropoffDate is on a weekend, move to next Monday
        $dayOfWeek = $dropoffDate->format('N'); // 1 (Monday) to 7 (Sunday)
        if ($dayOfWeek >= 6) { // Saturday or Sunday
            $dropoffDate = $dropoffDate->modify('next Monday');
        }

        $currentDate = clone $dropoffDate;
        $daysAdded = 1; // Include dropoffDate as Day 1

        while ($daysAdded < $turnaround) {
            $currentDate = $currentDate->modify('+1 day');
            $dayOfWeek = $currentDate->format('N');
            if ($dayOfWeek < 6) { // Weekday
                $daysAdded++;
            }
        }

        return $currentDate; // Due date
    }

    public function locationFilter($locationId = null, $object = null)
    {
        $session_object = $object . '.' . 'locationFilter';
        if ($locationId === null) {
            $locationId = $this->request->getSession()->read($session_object);
        }
        if (!empty($locationId)) {
            $this->request->getSession()->write($session_object, $locationId);
        } else {
            $this->request->getSession()->write($session_object, null);
        }
        return $locationId;
    }

    public function statusFilter($statusId = null, $object = null)
    {
        $session_object = $object . '.' . 'statusFilter';
        if ($statusId === null) { // NOTES: from back/clear filter
            $statusId = $this->request->getSession()->read($session_object);
        }
        if (!empty($statusId)) { // NOTES: from filter
            $this->request->getSession()->write($session_object, $statusId);
        } else { // NOTES: select all statuses
            $this->request->getSession()->write($session_object, null);
        }
        return $statusId;
    }

    public function dateRangeFilter($start_date = null, $end_date = null, $object = null)
    {
        $session_object_start = $object . '.' . 'startDateFilter';
        $session_object_end = $object . '.' . 'endDateFilter';
        if (!empty($start_date) && !empty($end_date)) {
            $this->request->getSession()->write($session_object_start, $start_date);
            $this->request->getSession()->write($session_object_end, $end_date);
        } elseif (!empty($start_date) && empty($end_date)) {
            $this->request->getSession()->write($session_object_start, $start_date);
        } elseif (empty($start_date) && !empty($end_date)) {
            $this->request->getSession()->write($session_object_end, $end_date);
        } else {
            $start_date = $this->request->getSession()->read($session_object_start);
            $end_date = $this->request->getSession()->read($session_object_end);
        }
        return [$start_date, $end_date];
    }

    public function allowEntry(): bool
    {
        $authRoleId = $this->request->getAttribute('identity')->role_id;

        $admin_manager = [1, 2];

        return in_array($authRoleId, $admin_manager);
    }
}
