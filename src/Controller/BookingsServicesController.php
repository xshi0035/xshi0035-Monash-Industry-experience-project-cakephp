<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * BookingsServices Controller
 *
 * @property \App\Model\Table\BookingsServicesTable $BookingsServices
 */
class BookingsServicesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->BookingsServices->find()
            ->contain(['Bookings', 'Services']);
        $bookingsServices = $this->paginate($query);

        $this->set(compact('bookingsServices'));
    }

    /**
     * View method
     *
     * @param string|null $id Bookings Service id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bookingsService = $this->BookingsServices->get($id, contain: ['Bookings', 'Services', 'Photos']);

        $bookingsServiceCat = $this->fetchTable('Categories')->find()
            ->where(['id' => $bookingsService->service->cat_id])
            ->first();

        $roleId = $this->request->getSession()->read('Auth.role_id');

        $this->set(compact('bookingsService', 'bookingsServiceCat', 'roleId'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bookingsService = $this->BookingsServices->newEmptyEntity();
        if ($this->request->is('post')) {
            $bookingsService = $this->BookingsServices->patchEntity($bookingsService, $this->request->getData());
            if ($this->BookingsServices->save($bookingsService)) {
                $this->Flash->success(__('The bookings service has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bookings service could not be saved. Please, try again.'));
        }
        $bookings = $this->BookingsServices->Bookings->find('list', limit: 200)->all();
        $services = $this->BookingsServices->Services->find('list', limit: 200)->all();
        $photos = $this->BookingsServices->Photos->find('list', limit: 200)->all();
        $this->set(compact('bookingsService', 'bookings', 'services', 'photos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bookings Service id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bookingsService = $this->BookingsServices->get($id, contain: ['Photos']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bookingsService = $this->BookingsServices->patchEntity($bookingsService, $this->request->getData());
            if ($this->BookingsServices->save($bookingsService)) {
                $this->Flash->success(__('The bookings service has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bookings service could not be saved. Please, try again.'));
        }
        $bookings = $this->BookingsServices->Bookings->find('list', limit: 200)->all();
        $services = $this->BookingsServices->Services->find('list', limit: 200)->all();
        $photos = $this->BookingsServices->Photos->find('list', limit: 200)->all();
        $this->set(compact('bookingsService', 'bookings', 'services', 'photos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bookings Service id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bookingsService = $this->BookingsServices->get($id);
        if ($this->BookingsServices->delete($bookingsService)) {
            $this->Flash->success(__('The bookings service has been deleted.'));
        } else {
            $this->Flash->error(__('The bookings service could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
