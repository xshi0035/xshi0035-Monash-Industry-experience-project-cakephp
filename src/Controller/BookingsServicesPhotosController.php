<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Photo;

/**
 * BookingsServicesPhotos Controller
 *
 * @property \App\Model\Table\BookingsServicesPhotosTable $BookingsServicesPhotos
 */
class BookingsServicesPhotosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->BookingsServicesPhotos->find()
            ->contain(['BookingsServices', 'Photos']);
        $bookingsServicesPhotos = $this->paginate($query);

        $this->set(compact('bookingsServicesPhotos'));
    }

    /**
     * View method
     *
     * @param string|null $id Bookings Services Photo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bookingsServicesPhoto = $this->BookingsServicesPhotos->get($id, contain: ['BookingsServices', 'Photos']);
        $this->set(compact('bookingsServicesPhoto'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($type = null, $bookingServiceId = null)
    {
        $photoTable = $this->fetchTable('Photos');
    
        if ($this->request->is('post')) {
            $uploadedFiles = $this->request->getData('photo'); // Get array of uploaded files
            $comment = $this->request->getData('comment');  

            // Validate and process each file
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $errors = [];
            $successes = 0;
    
            foreach ($uploadedFiles as $uploadedFile) {
                $fileInfo = pathinfo($uploadedFile->getClientFilename());
                $fileExtension = strtolower($fileInfo['extension']);
    
                // Check if the uploaded photo has a valid file type AND is <= 5MB in size
                if (in_array($fileExtension, $allowedExtensions) && $uploadedFile->getSize() <= 5 * 1024 * 1024) {
                    $fileName = $uploadedFile->getClientFilename();
                    $targetPath = WWW_ROOT . 'img' . DS . 'service_photos' . DS . $fileName;
                    $uploadedFile->moveTo($targetPath);
    
                    // Save photo to the `Photos` table
                    $photo = $photoTable->newEmptyEntity();
                    $photo->name = $fileName;
                    $photo->path = '/img/service_photos/' . $fileName;
    
                    if ($photoTable->save($photo)) {
                        // Save the photo to `BookingsServicesPhotos`
                        $bookingServicesPhoto = $this->BookingsServicesPhotos->newEmptyEntity();
                        $bookingServicesPhoto->photo_type = $type;
                        $bookingServicesPhoto->comments = $comment;
                        $bookingServicesPhoto->bookings_service_id = $bookingServiceId;
                        $bookingServicesPhoto->photo_id = $photo->id;
    
                        if ($this->BookingsServicesPhotos->save($bookingServicesPhoto)) {
                            $successes++;
                        } else {
                            $errors[] = __('Unable to save the association for photo: {0}', $fileName);
                        }
                    } else {
                        $errors[] = __('Unable to save photo: {0}', $fileName);
                    }
                } else {
                    $errors[] = __('Invalid file type or size exceeded for: {0}', $uploadedFile->getClientFilename());
                }
            }
    
            // Display results
            if ($successes > 0) {
                $this->Flash->success(__('{0} photos uploaded successfully.', $successes));
            }
    
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $this->Flash->error($error);
                }
            }
        }
    
        return $this->redirect(['controller' => 'BookingsServices', 'action' => 'view', $bookingServiceId]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Bookings Services Photo id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bookingsServicesPhoto = $this->BookingsServicesPhotos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bookingsServicesPhoto = $this->BookingsServicesPhotos->patchEntity($bookingsServicesPhoto, $this->request->getData());
            if ($this->BookingsServicesPhotos->save($bookingsServicesPhoto)) {
                $this->Flash->success(__('The bookings services photo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bookings services photo could not be saved. Please, try again.'));
        }
        $bookingsServices = $this->BookingsServicesPhotos->BookingsServices->find('list', limit: 200)->all();
        $photos = $this->BookingsServicesPhotos->Photos->find('list', limit: 200)->all();
        $this->set(compact('bookingsServicesPhoto', 'bookingsServices', 'photos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bookings Services Photo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bookingsServicesPhoto = $this->BookingsServicesPhotos->get($id);
        if ($this->BookingsServicesPhotos->delete($bookingsServicesPhoto)) {
            $this->Flash->success(__('The bookings services photo has been deleted.'));
        } else {
            $this->Flash->error(__('The bookings services photo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
