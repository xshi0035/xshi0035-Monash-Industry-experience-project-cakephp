<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
$this->layout = 'manager_view';
$this->assign('title', "View Product");
?>
<div class="d-block w-100 w-md-50">
    <?= $this->Html->link(
        '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back to Products',
        ['Controller' => 'Products', 'action' => 'index'],
        ['escape' => false, 'class' => 'btn btn-link']
    ) ?>
    <div class="d-sm-flex align-items-center justify-content-between flex-wrap">
        <h3><?= h($product->name) . ' details' ?></h3>
        <?= $this->Html->link(__('Edit Product'), ['action' => 'edit', $product->id], ['class' => 'd-sm-inline-block btn btn-primary']) ?>
        <div class="d-block d-sm-none mb-3"></div>
    </div>

    <table class="table table-sm">
        <tr>
            <th style="width: 1%;"><?= __('Name') ?></th>
            <td><?= h($product->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Cost') ?></th>
            <td>$<?= $this->Number->format($product->product_cost) ?></td>
        </tr>
        <?php if ($product->hasValue('description')): ?>
            <tr>
                <th><?= __('Description') ?></th>
                <td><?= $this->Text->autoParagraph(h($product->description)); ?></td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Photo Uploads  -->
    <div class="related">
        <div style="background-color: #f0f5f2; border: solid 1px green; padding: 20px;">
            <h4 style="text-align: center;"><?= __('Product Photo(s)') ?></h4>

            <?php
            // Fetch associated photos for the product
            $productPhotos = array_filter($product->photos, function ($photo) {
                return !$photo->in_bin;
            });
            $maxPhotos = 3; // Set your maximum number of photos here
            $currentPhotoCount = count($productPhotos);
            $remainingUploads = $maxPhotos - $currentPhotoCount;
            ?>

            <?php if ($currentPhotoCount < $maxPhotos): ?>
                <h5>Upload New Photo</h5>

                <div>
                    <?= $this->Form->create(null, ['type' => 'file', 'url' => ['controller' => 'PhotosProducts', 'action' => 'add', $product->id]]) ?>
                </div>

                <div style="margin-bottom: 15px;">
                    <?= $this->Form->control('photo[]', [
                        'type' => 'file',
                        'multiple' => true,
                        'label' => 'Photo(s)',
                        'style' => 'display: block;',
                        'accept' => 'image/jpg, image/jpeg, image/png', // Limit accepted file types
                        'required' => true,
                    ]) ?>
                    <i style="font-size: small;">Maximum image size is 5MB. File types allowed: .jpg, .jpeg, .png</i>
                    <br>
                    <i style="font-size: small;">You can upload up to <?= $remainingUploads ?> more photo(s).</i>
                </div>

                <div style="margin-bottom: 15px;">
                    <?= $this->Form->control('comment', [
                        'type' => 'text',
                        'placeholder' => 'Comments',
                        'style' => 'display: block;',
                    ]) ?>
                </div>

                <?= $this->Form->button(__('Save and Upload Photo'), ['class' => 'btn btn-primary', 'style' => 'margin-bottom: 10px;']) ?>
                <?= $this->Form->end() ?>
            <?php else: ?>
                <p style="color: red; text-align: center;"><b>You have reached the maximum number of photos (<?= $maxPhotos ?>) for this product.</b></p>
            <?php endif; ?>

            <?php if (!empty($productPhotos)) : ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tr>
                            <th><?= __('File') ?></th>
                            <th><?= __('Comments') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($productPhotos as $photo) : ?>
                            <tr>
                                <td>
                                    <?= $this->Html->image($photo->path, ['width' => 100, 'height' => 100]) ?>
                                    <br>
                                    <?= h($photo->name) ?>
                                </td>
                                <td><?= h($photo->_joinData->comments) ?></td>
                                <td class="actions">
                                    <?= $this->Form->postButton(
                                        '<i class="fa fa-trash" aria-hidden="true"></i>',
                                        ['controller' => 'Photos', 'action' => 'moveToBin', $photo->id],
                                        [
                                            'class' => 'btn btn-primary btn-center',
                                            'escapeTitle' => false,
                                            'confirm' => __('Are you sure you want to move this photo to bin?')
                                        ]
                                    ) ?> </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php else : ?>
                <p style="text-align: center;"><b>No photos uploaded yet.</b></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://kit.fontawesome.com/dc286b156c.js" crossorigin="anonymous"></script>