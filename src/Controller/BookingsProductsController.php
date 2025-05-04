<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * BookingsProducts Controller
 *
 * @property \App\Model\Table\BookingsProductsTable $BookingsProducts
 */
class BookingsProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->BookingsProducts->find()
            ->contain(['Bookings', 'Products']);
        $bookingsProducts = $this->paginate($query);

        $this->set(compact('bookingsProducts'));
    }

    /**
     * View method
     *
     * @param string|null $id Bookings Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bookingsProduct = $this->BookingsProducts->get($id, contain: ['Bookings', 'Products']);
        $this->set(compact('bookingsProduct'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bookingsProduct = $this->BookingsProducts->newEmptyEntity();
        if ($this->request->is('post')) {
            $bookingsProduct = $this->BookingsProducts->patchEntity($bookingsProduct, $this->request->getData());
            if ($this->BookingsProducts->save($bookingsProduct)) {
                $this->Flash->success(__('The bookings product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bookings product could not be saved. Please, try again.'));
        }
        $bookings = $this->BookingsProducts->Bookings->find('list', limit: 200)->all();
        $products = $this->BookingsProducts->Products->find('list', limit: 200)->all();
        $this->set(compact('bookingsProduct', 'bookings', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bookings Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bookingsProduct = $this->BookingsProducts->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bookingsProduct = $this->BookingsProducts->patchEntity($bookingsProduct, $this->request->getData());
            if ($this->BookingsProducts->save($bookingsProduct)) {
                $this->Flash->success(__('The bookings product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bookings product could not be saved. Please, try again.'));
        }
        $bookings = $this->BookingsProducts->Bookings->find('list', limit: 200)->all();
        $products = $this->BookingsProducts->Products->find('list', limit: 200)->all();
        $this->set(compact('bookingsProduct', 'bookings', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bookings Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bookingsProduct = $this->BookingsProducts->get($id);
        if ($this->BookingsProducts->delete($bookingsProduct)) {
            $this->Flash->success(__('The bookings product has been deleted.'));
        } else {
            $this->Flash->error(__('The bookings product could not be deleted. Please, try again.'));
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
