<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BookingsService $bookingsService
 */

if ($roleId == 3) {
    $this->layout = 'contractor_view';
} else {
    $this->layout = 'manager_view';
}
$this->assign('title', 'Services Details');
?>
<div class="row">
    <div class="column column-80">
        <?php if ($roleId == 3) : ?>
            <?= $this->Html->link(__('< Back'), ['controller' => 'Bookings', 'action' => 'contractorView', $bookingsService->booking->id]) ?>
        <?php else: ?>
            <?= $this->Html->link(__('< Back'), ['controller' => 'Bookings', 'action' => 'view', $bookingsService->booking->id]) ?>
        <?php endif; ?>
        <br><br>

        <div class="bookingsServices view content">
            <h3>Service Details</h3>
            <table>
                <tr>
                    <th><?= __('Service') ?></th>
                    <td><?= h($bookingsService->service->name) ?></td>


                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($bookingsServiceCat->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Booking ID') ?></th>
                    <td><?= h($bookingsService->booking->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Service Qty') ?></th>
                    <td><?= $this->Number->format($bookingsService->service_qty) ?></td>
                </tr>
            </table>

            <!-- Photo Upload  -->
            <div class="related">
                <!-- Before Photos  -->
                <div style="background-color: #f0f5f2; border-style: solid; border-color: green; padding: 20px;">
                    <h4 style="text-align: center;"><?= __('Before Photo(s)') ?></h4>
                    <h5>Upload New Photo</h5>
                    <?= $this->Form->create(null, ['type' => 'file', 'url' => ['controller' => 'BookingsServicesPhotos', 'action' => 'add', 'BEFORE', $bookingsService->id]]) ?>
                    <?= $this->Form->control('photo[]', [
                        'type' => 'file',
                        'multiple' => true,
                        'label' => 'Photo(s)',
                    ]) ?>
                    <i style="font-size: small;">Maximum image size is 5MB. File types allowed: .jpg, .jpeg, .png</i>
                    <?= $this->Form->control('comment', ['type' => 'text', 'placeholder' => 'Comments']) ?>
                    <?= $this->Form->button(__('Save and Upload Photo'), ['class' => 'btn btn-primary']) ?>
                    <?= $this->Form->end() ?>

                    <?php
                    // Filter for 'BEFORE' photos
                    $beforePhotos = array_filter($bookingsService->photos, function ($photo) {
                        return $photo['_joinData']->photo_type === 'BEFORE';
                    });
                    ?>

                    <?php if (!empty($beforePhotos)) : ?>
                        <div class="table-responsive">
                            <table>
                                <tr>
                                    <th><?= __('File') ?></th>
                                    <th><?= __('Comments') ?></th>
                                    <th class="actions"><?= __('Actions') ?></th>
                                </tr>
                                <?php foreach ($beforePhotos as $photo) : ?>
                                    <tr>
                                        <td>
                                            <?= h($photo->name) ?>
                                            <br>
                                            <?= $this->Html->image($photo->path, ['width' => 100, 'height' => 100]) ?>
                                        </td>
                                        <td><?= h($photo['_joinData']->comments) ?></td>
                                        <td class="actions">
                                            <?= $this->Form->postButton('Delete', ['controller' => 'Photos', 'action' => 'delete', $photo->id, $bookingsService->id], ['confirm' => __('Are you sure you want to delete this photo?')]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php else : ?>
                        <p style="text-align: center;"><b>No photos uploaded yet.</b></p>
                    <?php endif; ?>
                </div>
                <div style="padding-bottom: 20px;">

                </div>
                <div style="background-color: #f0f5f2; border-style: solid; border-color: green; padding: 20px;">
                    <!-- After Photos  -->
                    <h4 style="text-align: center;"><?= __('After Photo(s)') ?></h4>

                    <h5>Upload New Photo</h5>
                    <?= $this->Form->create(null, ['type' => 'file', 'url' => ['controller' => 'BookingsServicesPhotos', 'action' => 'add', 'AFTER', $bookingsService->id]]) ?>
                    <?= $this->Form->control('photo', ['type' => 'file']) ?>
                    <i style="font-size: small;">Maximum image size is 5MB. File types allowed: .jpg, .jpeg, .png</i>
                    <?= $this->Form->control('comment', ['type' => 'text', 'placeholder' => 'Comments']) ?>
                    <?= $this->Form->button(__('Save and Upload Photo'), ['class' => 'btn btn-primary']) ?>
                    <?= $this->Form->end() ?>

                    <?php
                    // Filter for 'BEFORE' photos
                    $afterPhotos = array_filter($bookingsService->photos, function ($photo) {
                        return $photo['_joinData']->photo_type === 'AFTER';
                    });
                    ?>

                    <?php if (!empty($afterPhotos)) : ?>
                        <div class="table-responsive">
                            <table>
                                <tr>
                                    <th><?= __('File') ?></th>
                                    <th><?= __('Comments') ?></th>
                                    <th class="actions"><?= __('Actions') ?></th>
                                </tr>
                                <?php foreach ($afterPhotos as $photo) : ?>
                                    <tr>
                                        <td>
                                            <?= h($photo->name) ?>
                                            <br>
                                            <?= $this->Html->image($photo->path, ['width' => 100, 'height' => 100]) ?>
                                        </td>
                                        <td><?= h($photo['_joinData']->comments) ?></td>
                                        <td class="actions">
                                            <?= $this->Form->postButton(__('Delete'), ['controller' => 'Photos', 'action' => 'delete', $photo->id, $bookingsService->id], ['confirm' => __('Are you sure you want to delete this photo?')]) ?>
                                        </td>
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
    </div>