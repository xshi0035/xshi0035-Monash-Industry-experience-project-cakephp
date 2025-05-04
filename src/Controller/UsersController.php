<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

    public function index()
    {
        $query = $this->Users->find()
            ->contain(['Roles'])
            ->where(['Users.role_id !=' => 4]); // Exclude users with role_id 4
        $users = $this->paginate($query);

        $authRoleId = $this->request->getSession()->read('Auth.role_id');

        // Handle the redirect logic here
        if ($authRoleId !== 1 && $authRoleId !== 2) {
            return $this->redirect(['controller' => 'Bookings', 'action' => 'indexById']);
        }

        if ($authRoleId == 2) {
            $users = $this->paginate($query->where(['role_id' => 3]));
        }

        $this->set(compact('users'));
    }

    /**
     * Archived Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function indexArchived()
    {
        $query = $this->Users->find('all', [
            'conditions' => ['role_id' => 4]
        ]);
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {

        $user = $this->Users->get($id, contain: [
            'Roles',
            'Locations' => ['States'],
        ]);

        $authUserId = $this->request->getSession()->read('Auth.id');
        $authRoleId = $this->request->getSession()->read('Auth.role_id');

        // Handle the redirect logic here
        if ($authUserId != $user->id && $authRoleId !== 1 && $authRoleId !== 2) {
            return $this->redirect(['controller' => 'Bookings', 'action' => 'indexById']);
        }

        $this->set(compact('user'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if ($this->allowEntry() === False) {
            $this->Flash->error('You do not have access to this page.');
            $this->redirect(['action' => 'selectLocation']);
        }

        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The new staff has been added.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The new staff could not be added. Please, try again.'));
        }

        $roles = $this->Users->Roles->find('list', limit: 200)->all();
        $locations = $this->Users->Locations->find('list', limit: 200)->all();
        $this->set(compact('user', 'roles', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $authRoleId = $this->request->getSession()->read('Auth.role_id');


        if ($this->request->getAttribute('identity')->role_id == 3) {
            $this->redirect(['action' => 'view', $id]);
        }

        $user = $this->Users->get($id, ['contain' => ['Locations']]);

        $authUserId = $this->request->getSession()->read('Auth.id');
        $authRoleId = $this->request->getSession()->read('Auth.role_id');

        // Handle the redirect logic here
        if ($authUserId != $user->id && !($this->allowEntry())) {
            return $this->redirect(['controller' => 'Bookings', 'action' => 'indexById']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {

                // Remove existing associations with Locations
                $this->Users->Locations->unlink($user, $user->locations);

                // Link new locations if provided
                if (!empty($this->request->getData('locations._ids'))) {
                    $locations = $this->Users->Locations->find()
                        ->where(['Locations.id IN' => $this->request->getData('locations._ids')])
                        ->toArray();
                    $this->Users->Locations->link($user, $locations);
                }

                $this->Flash->success(__("<i>{0}</i>'s details have been updated.", $user->first_name . ' ' . $user->last_name), ['escape' => false]);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("<i>{0}</i>'s details could not be saved. Please, try again.", $user->first_name . ' ' . $user->last_name), ['escape' => false]);
        }

        // $roles = $this->Users->Roles->find('list', limit: 200)->all();
        $roles = $this->Users->Roles->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'conditions' => ['Roles.id >=' => $authRoleId, 'Roles.id != ' => 4],
            'limit' => 200
        ])->toArray();
        $locations = $this->Users->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'limit' => 200
        ])->where([
            'status' => 'OPERATIONAL'
        ])->toArray();
        $this->set(compact('user', 'roles', 'locations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function delete(?string $id = null)
    // {
    //     if ($this->allowEntry() === False) {
    //         $this->Flash->error('You do not have access to this page.');
    //         $this->redirect(['action' => 'selectLocation']);
    //     }

    //     $this->request->allowMethod(['post', 'delete']);
    //     $user = $this->Users->get($id);
    //     if ($this->Users->delete($user)) {
    //         $this->Flash->success(__('The user has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The user could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Define the allowed roles (1 for Admin, 2 for Manager)
        $AllowedRoles = [1, 2, 3];

        // Check if the user's role is in the allowed roles array
        if (!in_array($this->request->getAttribute('identity')->role_id, $AllowedRoles)) {
            // $this->Flash->error(__('You are not authorized to access this area.'));
            return $this->redirect(['controller' => 'Auth', 'action' => 'login']); //change this later when home page is made
        }
    }

    public function allowEntry(): bool
    {
        $authRoleId = $this->request->getAttribute('identity')->role_id;

        $admin_manager = [1, 2];

        return in_array($authRoleId, $admin_manager);
    }

    /**
     * Archive method (deactivate)
     *
     */
    public function archive(?string $id = null)
    {

        if ($this->request->getAttribute('identity')->role_id != 1) {
            $this->Flash->error('You do not have access to this action.');
            //            return $this->redirect(['controller' => 'bookings', 'action' => 'selectLocation']);
        } else {
            $user = $this->Users->get($id);

            $user->role_id = 4;

            if ($this->Users->save($user)) {
                $this->Flash->success(__("<i>{0}</i>'s staff profile has been deactivated.", $user->first_name . ' ' . $user->last_name), ['escape' => false]);
            } else {
                $this->Flash->error(__("<i>{0}</i>'s staff profile could not be deactivated. Please try again.", $user->first_name . ' ' . $user->last_name), ['escape' => false]);
            }
        }
        // Redirect to the index action
        return $this->redirect(['action' => 'index']);
    }

    public function reactivate(?string $id = null)
    {
        $user = $this->Users->get($id, ['contain' => ['Locations']]);

        $authUserId = $this->request->getSession()->read('Auth.id');
        $authRoleId = $this->request->getSession()->read('Auth.role_id');

        // Handle the redirect logic here
        if ($authUserId != $user->id && $authRoleId !== 1 && $authRoleId !== 2) {
            return $this->redirect(['controller' => 'Bookings', 'action' => 'indexById']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                // $this->Users->Locations->unlinkAll($user); // Remove existing associations with Locations
                // if (!empty($this->request->getData('locations._ids'))) {
                //     $locations = $this->Users->Locations->find()
                //         ->where(['Locations.id IN' => $this->request->getData('locations._ids')])
                //         ->toArray();
                //     $this->Users->Locations->link($user, $locations);
                // }

                // Remove existing associations with Locations
                $this->Users->Locations->unlink($user, $user->locations);

                // Link new locations if provided
                if (!empty($this->request->getData('locations._ids'))) {
                    $locations = $this->Users->Locations->find()
                        ->where(['Locations.id IN' => $this->request->getData('locations._ids')])
                        ->toArray();
                    $this->Users->Locations->link($user, $locations);
                }
                $this->redirect(['controller' => 'Auth', 'action' => 'forceResetPassword', $user->id]);

                $this->Flash->success(__("<i>{0}</i>'s details have been updated.", $user->first_name . ' ' . $user->last_name), ['escape' => false]);

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("<i>{0}</i>'s details could not be saved. Please, try again.", $user->first_name . ' ' . $user->last_name), ['escape' => false]);
            }
        }

        // $roles = $this->Users->Roles->find('list', limit: 200)->all();
        $roles = $this->Users->Roles->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'conditions' => ['Roles.id IN' => [1, 2, 3]],
            'limit' => 200
        ])->toArray();
        $locations = $this->Users->Locations->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'limit' => 200
        ])->toArray();
        $this->set(compact('user', 'roles', 'locations'));
    }
}
