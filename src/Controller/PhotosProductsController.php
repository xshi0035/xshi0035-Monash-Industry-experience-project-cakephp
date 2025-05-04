<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Filesystem\File;

/**
 * PhotosProducts Controller
 *
 * @property \App\Model\Table\PhotosProductsTable $PhotosProducts
 */
class PhotosProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->PhotosProducts->find()
            ->contain(['Products', 'Photos']);
        $photosProducts = $this->paginate($query);

        $this->set(compact('photosProducts'));
    }

    /**
     * View method
     *
     * @param string|null $id Photos Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $photosProduct = $this->PhotosProducts->get($id, [
            'contain' => ['Products', 'Photos'],
        ]);

        $this->set(compact('photosProduct'));
    }

    /**
     * Add method
     *
     * @param string|null $productId Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($productId = null)
    {
        $photoTable = $this->fetchTable('Photos');

        if ($this->request->is('post')) {
            $uploadedFiles = $this->request->getData('photo'); // Get array of uploaded files
            $comment = $this->request->getData('comment');

            // Fetch the current number of photos associated with the product
            $existingPhotosCount = $this->PhotosProducts->find()
                ->where(['product_id' => $productId])
                ->matching('Photos', function ($q) {
                    return $q->where(['Photos.in_bin' => false]);
                })
                ->count();

            $maxPhotos = 3; // Set your maximum number of photos here
            $remainingUploads = $maxPhotos - $existingPhotosCount;

            if ($remainingUploads <= 0) {
                $this->Flash->error(__('You have reached the maximum number of photos for this product.'));
                return $this->redirect(['controller' => 'Products', 'action' => 'view', $productId]);
            }

            // Limit the number of uploaded files
            if (count($uploadedFiles) > $remainingUploads) {
                $this->Flash->error(__('You can upload a maximum of {0} photo(s).', $remainingUploads));
                return $this->redirect(['controller' => 'Products', 'action' => 'view', $productId]);
            }

            // Ensure the directory exists and is writable
            $directoryPath = WWW_ROOT . 'img' . DS . 'product_photos';
            if (!file_exists($directoryPath)) {
                if (!mkdir($directoryPath, 0755, true)) {
                    $this->Flash->error(__('Failed to create directory for product photos.'));
                    return $this->redirect(['controller' => 'Products', 'action' => 'view', $productId]);
                }
            }

            // Validate and process each file
            $allowedMimeTypes = ['image/jpg', 'image/jpeg', 'image/png']; 
            $successes = 0;

            foreach ($uploadedFiles as $uploadedFile) {
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
                        $photo->path = '/img/product_photos/' . $uniqueFileName;
                        $photo->in_bin = false;

                        if ($photoTable->save($photo)) {
                            // Save the photo to `PhotosProducts`
                            $photosProduct = $this->PhotosProducts->newEmptyEntity();
                            $photosProduct->comments = $comment;
                            $photosProduct->product_id = $productId;
                            $photosProduct->photo_id = $photo->id;

                            if ($this->PhotosProducts->save($photosProduct)) {
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
            }

            // Display results
            if ($successes > 0) {
                $this->Flash->success(__('{0} photo(s) uploaded successfully.', $successes));
            }

            return $this->redirect(['controller' => 'Products', 'action' => 'view', $productId]);
        }

        $this->set(compact('productId'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Photos Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $photosProduct = $this->PhotosProducts->get($id, [
            'contain' => ['Photos', 'Products'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $photosProduct = $this->PhotosProducts->patchEntity($photosProduct, $this->request->getData());
            if ($this->PhotosProducts->save($photosProduct)) {
                $this->Flash->success(__('The photo association has been updated.'));

                return $this->redirect(['action' => 'view', $photosProduct->id]);
            }
            $this->Flash->error(__('The photo association could not be updated. Please, try again.'));
        }
        $photos = $this->PhotosProducts->Photos->find('list', ['limit' => 200])->all();
        $products = $this->PhotosProducts->Products->find('list', ['limit' => 200])->all();
        $this->set(compact('photosProduct', 'photos', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Photos Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $photosProduct = $this->PhotosProducts->get($id);
        if ($this->PhotosProducts->delete($photosProduct)) {
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
