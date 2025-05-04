<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Categories->find('all', [
            'conditions' => ['archived' => 0]
        ]);
        $categories = $this->paginate($query);

        $this->set(compact('categories'));
    }

    /**
     * Archived Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function indexArchived()
    {
        $query = $this->Categories->find('all', [
            'conditions' => ['archived' => 1]
        ]);
        $categories = $this->paginate($query);

        $this->set(compact('categories'));
    }

    /**
    * View method
    *
    * @param string|null $id Category id.
    * @return \Cake\Http\Response|null|void Renders view
    * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    */
    public function view($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['Photos'],
        ]);
        $this->set(compact('category'));
    } 


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEmptyEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $this->set(compact('category'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $this->set(compact('category'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
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
        $category = $this->Categories->get($id);
        $this->Categories->patchEntity($category, ['archived' => true]);
        if ($this->Categories->save($category)) {
            $this->Flash->success(__('The category <i>{0}</i> has been archived.', $category->name), ['escape' => false]);
        } else {
            $this->Flash->error(__('The category <i>{0}</i> could not be archived. Please, try again.', $category->name), ['escape' => false]);
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
        $category = $this->Categories->get($id);
        $this->Categories->patchEntity($category, ['archived' => false]);
        if ($this->Categories->save($category)) {
            $this->Flash->success(__('The category <i>{0}</i> has been restored.', $category->name), ['escape' => false]);
        } else {
            $this->Flash->error(__('The category <i>{0}</i> could not be restored. Please, try again.', $category->name), ['escape' => false]);
        }
        return $this->redirect(['action' => 'index']);
    }
}
