<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Products->find('all', [
            'conditions' => ['archived' => 0]
        ]);
        $products = $this->paginate($query);

        $this->set(compact('products'));
    }

    /**
     * Archived Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function indexArchived()
    {
        $query = $this->Products->find('all', [
            'conditions' => ['archived' => 1]
        ]);
        $products = $this->paginate($query);

        $this->set(compact('products'));
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => ['Photos'],
        ]);

        $this->set(compact('product'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEmptyEntity();
        if ($this->request->is('post')) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__("New product <b>{0}</b> has been saved.", $product->name), ['escape' => false]);

                return $this->redirect(['action' => 'view', $product->id]);
            }
            $this->Flash->error(__("New product <b>{0}</b> could not be saved.. Please, try again.", $product->name), ['escape' => false]);
        }
        $bookings = $this->Products->Bookings->find('list', limit: 200)->all();
        $this->set(compact('product', 'bookings'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, contain: ['Bookings']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__("Changes to <b>{0}</b> has been saved.", $product->name), ['escape' => false]);

                return $this->redirect(['action' => 'view', $product->id]);
            }
            $this->Flash->error(__("Changes to <b>{0}</b> could not be saved.. Please, try again.", $product->name), ['escape' => false]);
        }
        $bookings = $this->Products->Bookings->find('list', limit: 200)->all();
        $this->set(compact('product', 'bookings'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product <b>{0}</b> has been deleted.', $product->name), ['escape' => false]);
        } else {
            $this->Flash->error(__('The product <b>{0}</b> could not be deleted. Please, try again.', $product->name), ['escape' => false]);
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
        $product = $this->Products->get($id);
        $this->Products->patchEntity($product, ['archived' => true]);
        if ($this->Products->save($product)) {
            $this->Flash->success(__('The product <b>{0}</b> has been archived. It will now be hidden from customers when they make a booking', $product->name), ['escape' => false]);
        } else {
            $this->Flash->error(__('The product <b>{0}</b> could not be archived. Please, try again.', $product->name), ['escape' => false]);
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
        $product = $this->Products->get($id);
        $this->Products->patchEntity($product, ['archived' => false]);
        if ($this->Products->save($product)) {
            $this->Flash->success(__('The product <b>{0}</b> has been restored. It will now show when customers make a booking.', $product->name), ['escape' => false]);
        } else {
            $this->Flash->error(__('The product <b>{0}</b> could not be restored. Please, try again.', $product->name), ['escape' => false]);
        }
        return $this->redirect(['action' => 'index']);
    }
}
