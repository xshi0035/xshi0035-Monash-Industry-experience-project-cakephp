<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Photos Controller
 *
 * @property \App\Model\Table\PhotosTable $Photos
 */
class PhotosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Photos->find();
        $photos = $this->paginate($query);

        $this->set(compact('photos'));
    }

    /**
     * View method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $photo = $this->Photos->get($id, contain: []);
        $this->set(compact('photo'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $photo = $this->Photos->newEmptyEntity();
        if ($this->request->is('post')) {
            $photo = $this->Photos->patchEntity($photo, $this->request->getData());
            if ($this->Photos->save($photo)) {
                $this->Flash->success(__('The photo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The photo could not be saved. Please, try again.'));
        }
        $this->set(compact('photo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $photo = $this->Photos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $photo = $this->Photos->patchEntity($photo, $this->request->getData());
            if ($this->Photos->save($photo)) {
                $this->Flash->success(__('The photo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The photo could not be saved. Please, try again.'));
        }
        $this->set(compact('photo'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $photo = $this->Photos->get($id);

        if ($this->Photos->delete($photo)) {
            $filePath = WWW_ROOT . ltrim($photo->path, '/'); 

            if (file_exists($filePath)){
                unlink($filePath);
            }
            $this->Flash->success(__('The photo has been deleted.'));
            
        } else {
            $this->Flash->error(__('The photo could not be deleted. Please, try again.'));
        }

        // Redirect back to the same page (referer)
        return $this->redirect($this->request->referer());
    }

    /**
     * Recover method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function restore($id = null)
    {
        $photo = $this->Photos->get($id);
        $photo->in_bin = false;

        if ($this->Photos->save($photo)) {
            $this->Flash->success(__('The photo has been restored.'));
        } else {
            $this->Flash->error(__('The photo could not be restored. Please, try again.'));
        }

        // Redirect back to the same page (referer)
        return $this->redirect($this->request->referer());
    }

    /**
     * Add to bin method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function moveToBin($id = null)
    {
        if ($id != null) {
            $photo = $this->Photos->get($id, contain: []);
            $photo->in_bin = true;
            if ($this->Photos->save($photo)) {
                $this->Flash->success(__('The photo has been moved to bin.'));
            } else {
                $this->Flash->error(__('The photo could not be moved to bin. Please, try again.'));
            }
            return $this->redirect($this->request->referer());
        } else {
            $query = $this->Photos->find()
                ->where(['in_bin ' => 1]);
            // ->all();

            $photos = $this->paginate($query);
            $this->set(compact('photos'));
            return $this->render('bin');
        }
    }


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
}
