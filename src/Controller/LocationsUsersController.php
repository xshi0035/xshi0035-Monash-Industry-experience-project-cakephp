<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LocationsUsers Controller
 *
 * @property \App\Model\Table\LocationsUsersTable $LocationsUsers
 */
class LocationsUsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LocationsUsers->find()
            ->contain(['Locations', 'Users']);
        $locationsUsers = $this->paginate($query);

        $this->set(compact('locationsUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Locations User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locationsUser = $this->LocationsUsers->get($id, contain: ['Locations', 'Users']);
        $this->set(compact('locationsUser'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $locationsUser = $this->LocationsUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $locationsUser = $this->LocationsUsers->patchEntity($locationsUser, $this->request->getData());
            if ($this->LocationsUsers->save($locationsUser)) {
                $this->Flash->success(__('The locations user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The locations user could not be saved. Please, try again.'));
        }
        $locations = $this->LocationsUsers->Locations->find('list', limit: 200)->all();
        $users = $this->LocationsUsers->Users->find('list', limit: 200)->all();
        $this->set(compact('locationsUser', 'locations', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Locations User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationsUser = $this->LocationsUsers->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locationsUser = $this->LocationsUsers->patchEntity($locationsUser, $this->request->getData());
            if ($this->LocationsUsers->save($locationsUser)) {
                $this->Flash->success(__('The locations user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The locations user could not be saved. Please, try again.'));
        }
        $locations = $this->LocationsUsers->Locations->find('list', limit: 200)->all();
        $users = $this->LocationsUsers->Users->find('list', limit: 200)->all();
        $this->set(compact('locationsUser', 'locations', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Locations User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locationsUser = $this->LocationsUsers->get($id);
        if ($this->LocationsUsers->delete($locationsUser)) {
            $this->Flash->success(__('The locations user has been deleted.'));
        } else {
            $this->Flash->error(__('The locations user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
