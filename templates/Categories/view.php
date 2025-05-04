<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
$this->layout = 'manager_view';
$this->assign('title', "View Category");
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    ['controller' => 'Categories', 'action' => 'index'],
    ['escape' => false, 'class' => 'btn btn-link']
) ?>

<div class="d-sm-flex align-items-center justify-content-between flex-wrap">
    <h3><?= h($category->name) . ' Details' ?></h3>
    <?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id], ['class' => 'd-sm-inline-block btn btn-primary']) ?>
    <div class="d-block d-sm-none mb-3"></div>
</div>

<table class="table table-sm">
    <tr>
        <th><?= __('Name') ?></th>
        <td><?= h($category->name) ?></td>
    </tr>
</table>

<!-- Photo Uploads  -->
<div class="related">
    <div style="background-color: #f0f5f2; border: solid 1px green; padding: 20px;">
        <h4 style="text-align: center;"><?= __('Category Photo') ?></h4>

        <?php
        // Fetch associated photos for the category
        $categoryPhotos = array_filter($category->photos, function ($photo) {
            return !$photo->in_bin;
        });
        $maxPhotos = 1; // Set maximum number of photos to 1
        $currentPhotoCount = count($categoryPhotos);
        ?>

        <?php if ($currentPhotoCount < $maxPhotos): ?>
            <h5>Upload New Photo</h5>

            <div>
                <?= $this->Form->create(null, ['type' => 'file', 'url' => ['controller' => 'CategoriesPhotos', 'action' => 'add', $category->id]]) ?>
            </div>

            <div style="margin-bottom: 15px;">
                <?= $this->Form->control('photo', [
                    'type' => 'file',
                    'label' => 'Photo',
                    'style' => 'display: block;',
                    'accept' => 'image/jpg, image/jpeg, image/png',
                    'required' => true,
                ]) ?>
                <i style="font-size: small;">Maximum image size is 5MB. File types allowed: .jpg, .jpeg, .png</i>
                <br>
                <i style="font-size: small;">You only can upload one photo for each category.</i>
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
            <p style="color: red; text-align: center;"><b>You have already uploaded a photo for this category.</b></p>
        <?php endif; ?>

        <?php if (!empty($categoryPhotos)) : ?>
            <div class="table-responsive">
                <table class="table table-sm">
                    <tr>
                        <th><?= __('File') ?></th>
                        <th><?= __('Comments') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($categoryPhotos as $photo) : ?>
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
            <p style="text-align: center;"><b>No photo uploaded yet.</b></p>
        <?php endif; ?>
    </div>
</div>