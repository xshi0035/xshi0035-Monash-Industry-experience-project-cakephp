<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * CategoriesPhotos Controller
 *
 * @property \App\Model\Table\CategoriesPhotosTable $CategoriesPhotos
 */
class CategoriesPhotosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->CategoriesPhotos->find()
            ->contain(['Categories', 'Photos']);
        $categoriesPhotos = $this->paginate($query);

        $this->set(compact('categoriesPhotos'));
    }

    /**
     * View method
     *
     * @param string|null $id Categories Photo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $categoriesPhoto = $this->CategoriesPhotos->get($id, [
            'contain' => ['Categories', 'Photos'],
        ]);

        $this->set(compact('categoriesPhoto'));
    }

    /**
     * Add method
     *
     * @param string|null $categoryId Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($categoryId = null)
    {
        $photoTable = $this->fetchTable('Photos');

        if ($this->request->is('post')) {
            $uploadedFile = $this->request->getData('photo'); // Single uploaded file
            $comment = $this->request->getData('comment');

            // Fetch the current number of photos associated with the category
            $existingPhotosCount = $this->CategoriesPhotos->find()
                ->where(['cat_id' => $categoryId])
                ->matching('Photos', function ($q) {
                    return $q->where(['Photos.in_bin' => false]);
                })
                ->count();

            $maxPhotos = 1; // Maximum allowed photos

            if ($existingPhotosCount >= $maxPhotos) {
                $this->Flash->error(__('You have already uploaded a photo for this category.'));
                return $this->redirect(['controller' => 'Categories', 'action' => 'view', $categoryId]);
            }

            // Ensure the directory exists and is writable
            $directoryPath = WWW_ROOT . 'img' . DS . 'category_photos';
            if (!file_exists($directoryPath)) {
                if (!mkdir($directoryPath, 0755, true)) {
                    $this->Flash->error(__('Failed to create directory for category photos.'));
                    return $this->redirect(['controller' => 'Categories', 'action' => 'view', $categoryId]);
                }
            }

            // Validate and process the file
            $allowedMimeTypes = ['image/jpg', 'image/jpeg', 'image/png']; 
            $successes = 0;

            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $mimeType = $uploadedFile->getClientMediaType();
                $fileName = $this->sanitizeFileName($uploadedFile->getClientFilename());

                // Check MIME type and file size (<= 5MB)
                if (in_array($mimeType, $allowedMimeTypes) && $uploadedFile->getSize() <= 5 * 1024 * 1024) {
                    $uniqueFileName = uniqid() . '-' . $fileName;
                    $targetPath = $directoryPath . DS . $uniqueFileName;

                    // Save file to the filesystem
                    $uploadedFile->moveTo($targetPath);

                    // Save the photo to the `Photos` table
                    $photo = $photoTable->newEmptyEntity();
                    $photo->name = $uniqueFileName;
                    $photo->path = '/img/category_photos/' . $uniqueFileName;
                    $photo->in_bin = false;

                    if ($photoTable->save($photo)) {
                        // Save the photo to `CategoriesPhotos`
                        $categoriesPhoto = $this->CategoriesPhotos->newEmptyEntity();
                        $categoriesPhoto->comments = $comment;
                        $categoriesPhoto->cat_id = $categoryId;
                        $categoriesPhoto->photo_id = $photo->id;

                        if ($this->CategoriesPhotos->save($categoriesPhoto)) {
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
            } else {
                $this->Flash->error(__('Error uploading file: {0}', $uploadedFile->getClientFilename()));
            }

            // Display results
            if ($successes > 0) {
                $this->Flash->success(__('Photo uploaded successfully.'));
            }

            return $this->redirect(['controller' => 'Categories', 'action' => 'view', $categoryId]);
        }

        $this->set(compact('categoryId'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Categories Photo id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categoriesPhoto = $this->CategoriesPhotos->get($id, [
            'contain' => ['Photos', 'Categories'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $categoriesPhoto = $this->CategoriesPhotos->patchEntity($categoriesPhoto, $this->request->getData());
            if ($this->CategoriesPhotos->save($categoriesPhoto)) {
                $this->Flash->success(__('The photo association has been updated.'));

                return $this->redirect(['action' => 'view', $categoriesPhoto->id]);
            }
            $this->Flash->error(__('The photo association could not be updated. Please, try again.'));
        }
        $photos = $this->CategoriesPhotos->Photos->find('list', ['limit' => 200])->all();
        $categories = $this->CategoriesPhotos->Categories->find('list', ['limit' => 200])->all();
        $this->set(compact('categoriesPhoto', 'photos', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Categories Photo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categoriesPhoto = $this->CategoriesPhotos->get($id);
        if ($this->CategoriesPhotos->delete($categoriesPhoto)) {
            $this->Flash->success(__('The photo association has been deleted.'));
        } else {
            $this->Flash->error(__('The photo association could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Sanitize the file name to prevent security issues.
     *
     * @param string $fileName Original file name.
     * @return string Sanitized file name.
     */
    private function sanitizeFileName(string $fileName): string
    {
        // Replace spaces and risky characters with underscores, allow only alphanumeric, hyphens, underscores, and dots
        return preg_replace('/[^a-zA-Z0-9\-\_\.]/', '_', $fileName);
    }
}
