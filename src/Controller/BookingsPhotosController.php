<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * BookingsPhotos Controller
 *
 * @property \App\Model\Table\BookingsPhotosTable $BookingsPhotos
 */
class BookingsPhotosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->BookingsPhotos->find()
            ->contain(['Bookings', 'Photos']);
        $bookingsPhotos = $this->paginate($query);

        $this->set(compact('bookingsPhotos'));
    }

    /**
     * View method
     *
     * @param string|null $id Bookings Photo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bookingsPhoto = $this->BookingsPhotos->get($id, contain: ['Bookings', 'Photos']);
        $this->set(compact('bookingsPhoto'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($type = null, $bookingId = null)
    {
        $photoTable = $this->fetchTable('Photos');

        if ($this->request->is('post')) {
            $uploadedFiles = $this->request->getData('photo'); // Get array of uploaded files
            $comment = $this->request->getData('comment');

            // Validate and process each file
            $allowedMimeTypes = ['image/jpg', 'image/jpeg', 'image/png'];
            $successes = 0;

            $photoQuantity = $this->BookingsPhotos->find()
                ->where([
                    'photo_type' => $type,
                    'booking_id' => $bookingId,
                ])
                ->count();

            if (($photoQuantity + count($uploadedFiles)) <= 30) {
                foreach ($uploadedFiles as $uploadedFile) {
                    $mimeType = $uploadedFile->getClientMediaType();
                    $fileName = $this->sanitizeFileName($uploadedFile->getClientFilename());

                    // Check MIME type and file size (<= 5MB)
                    if (in_array($mimeType, $allowedMimeTypes) && $uploadedFile->getSize() <= 5 * 1024 * 1024) {
                        $targetPath = WWW_ROOT . 'img' . DS . 'booking_photos' . DS . $fileName;

                        // Save file to the filesystem
                        $uploadedFile->moveTo($targetPath);

                        // Save the photo to the `Photos` table
                        $photo = $photoTable->newEmptyEntity();
                        $photo->name = $fileName;
                        $photo->path = '/img/booking_photos/' . $fileName;

                        if ($photoTable->save($photo)) {
                            // Save the photo to `BookingsPhotos`
                            $bookingPhoto = $this->BookingsPhotos->newEmptyEntity();
                            $bookingPhoto->photo_type = $type;
                            $bookingPhoto->comments = $comment;
                            $bookingPhoto->booking_id = $bookingId;
                            $bookingPhoto->photo_id = $photo->id;

                            if ($this->BookingsPhotos->save($bookingPhoto)) {
                                $successes++;
                            } else {
                                $this->Flash->error(__('Unable to save photo: {0}', $fileName));
                            }
                        } else {
                            $this->Flash->error(__('Unable to save photo: {0}', $fileName));
                        }
                    } else {
                        $this->Flash->error(__(
                            'Invalid file type or size exceeded for: {0}',
                            h($uploadedFile->getClientFilename()) .
                                '<br /><i style="font-size: small;">Maximum image size is 5MB. File types allowed: .jpg, .jpeg, .png</i>'
                        ), ['escape' => false]);
                    }
                }
            } else {
                $this->Flash->error(__('Maximum number of {0} photos allowed is 30.', $type));
            }

            // Display results
            if ($successes > 0) {
                $this->Flash->success(__('{0} photos uploaded successfully.', $successes));
            }
        }

        return $this->redirect(['controller' => 'Bookings', 'action' => 'view', $bookingId]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Bookings Photo id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bookingsPhoto = $this->BookingsPhotos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bookingsPhoto = $this->BookingsPhotos->patchEntity($bookingsPhoto, $this->request->getData());
            if ($this->BookingsPhotos->save($bookingsPhoto)) {
                $this->Flash->success(__('The bookings photo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bookings photo could not be saved. Please, try again.'));
        }
        $bookings = $this->BookingsPhotos->Bookings->find('list', limit: 200)->all();
        $photos = $this->BookingsPhotos->Photos->find('list', limit: 200)->all();
        $this->set(compact('bookingsPhoto', 'bookings', 'photos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bookings Photo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bookingsPhoto = $this->BookingsPhotos->get($id);
        if ($this->BookingsPhotos->delete($bookingsPhoto)) {
            $this->Flash->success(__('The bookings photo has been deleted.'));
        } else {
            $this->Flash->error(__('The bookings photo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    private function sanitizeFileName(string $fileName): string
    {
        // Replace spaces and risky characters with underscores, allow only alphanumeric, hyphens, underscores, and dots
        return preg_replace('/[^a-zA-Z0-9\-\_\.]/', '_', $fileName);
    }
}
