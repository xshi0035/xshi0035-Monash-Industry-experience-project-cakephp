<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 */

$this->layout = 'new_contractor_view';
$this->assign('title', 'View Booking');
?>

<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    ['Controller' => 'Locations', 'action' => 'index'],
    ['escape' => false, 'class' => 'btn btn-link']
) ?>
<div class="d-sm-flex align-items-center justify-content-between flex-wrap">
    <h3>Booking Details</h3>
    <div class="d-block d-sm-none mb-3"></div>
</div>
<hr>
<div class="row">
    <div class="col-sm-5">
        <?php echo $this->Form->create($booking, ['url' => ['action' => 'contractorView', $booking->id]]); ?>
        <table class="table table-borderless table-sm">
            <tr>
                <th><?= __('Booking ID') ?></th>
                <td><?= h($booking->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Customer') ?></th>
                <td><?= h($booking->customer->first_name . ' ' . $booking->customer->last_name) ?></td>
            </tr>
            <tr>
                <th><?= __('Location') ?></th>
                <td>
                    <b><?= h($booking->location->name) ?></b>
                    <br>
                    <?= h($booking->location->st_address) . ', ' . h($booking->location->suburb) . ', ' . h($booking->location->state->abbr) . ' ' . h($booking->location->postcode) ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Drop-off Date and Time') ?></th>
                <td><?= h($booking->dropoff_date) . ' at ' . h($booking->dropoff_time) ?></td>
            </tr>
        </table>
    </div>
    <div class="col-sm-5">
        <table class="table table-borderless table-sm">
            <tr>
                <th><?= __('Due Date') ?></th>
                <td><?= h($booking->due_date) ?></td>
            </tr>
            <tr>
                <th><?= __('Status') ?></th>
                <td>
                    <div class="d-flex align-items-center">
                        <?php echo $this->Form->control('status_id', [
                            'type' => 'select',
                            'options' => [
                                1 => 'Booked',
                                2 => 'In Progress',
                                3 => 'Cleaning Done'
                            ],
                            'label' => false,
                            'default' => $booking->status->name,
                            'class' => 'form-control'
                        ]); ?>
                        <?= $this->Form->button(__('Save'), ['class' => 'btn btn-secondary ml-2']) ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <?= $this->Form->end() ?>
</div>
<hr>
<div class="row">
    <div class="col-sm-5">
        <?php if (!empty($booking->services)) : ?>
            <h4><?= __('Required Services') ?></h4>
            <div class="table-responsive">
                <table class="table table-sm">
                    <tr>
                        <th><?= __('Service') ?></th>
                        <th><?= __('Item') ?></th>
                        <th><?= __('Quantity') ?></th>
                    </tr>
                    <?php foreach ($booking->services as $service) : ?>
                        <tr>
                            <td><?= h($service->name) ?></td>
                            <td><?= h($service->category->name) ?></td>
                            <td><?= h($bookingsServices[$service->id]->service_qty) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-sm-5">
        <?php if (!empty($booking->products)) : ?>
            <h4><?= __('Products Purchased') ?></h4>
            <div class="table-responsive">
                <table class="table table-sm">
                    <tr>
                        <th><?= __('Product') ?></th>
                        <th><?= __('Quantity') ?></th>
                        <!-- <th><?= __('Cost (AUD)') ?></th> -->
                    </tr>
                    <?php foreach ($booking->products as $product) : ?>
                        <tr>
                            <td><?= h($product->name) ?></td>
                            <td><?= h($product->_joinData->product_qty) ?></td>
                            <!-- <td>$<?= h($product->product_cost) ?></td> -->
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<hr>
<!-- Photo Uploads  -->
<div class="row">
    <div class="col-sm-5">
        <!-- Before Photos  -->
        <div style="background-color: #f0f5f2; border-style: solid; border-color: green;" class="card card-body">
            <h4 style="text-align: center;"><?= __('Before Photo(s)') ?></h4>
            <i style="font-size: small; text-align: center;">Maximum 30 images</i>

            <h5>Upload Photo</h5>
            <div>
                <?= $this->Form->create(null, ['type' => 'file', 'url' => ['controller' => 'BookingsPhotos', 'action' => 'add', 'BEFORE', $booking->id]]) ?>
            </div>
            <div style="margin-bottom: 15px;">
                <?= $this->Form->control('photo[]', [
                    'type' => 'file',
                    'multiple' => true,
                    'label' => false,
                    'accept' => 'image/jpg, image/jpeg, image/png',
                    'style' => 'display: block;',
                ]) ?>
                <i style="font-size: small;">Maximum image size is 5MB. File types allowed: .jpg, .jpeg, .png</i>
            </div>
            <div style="margin-bottom: 15px;">
                <?= $this->Form->control('comment', [
                    'label' => 'Comments (optional)',
                    'class' => 'form-group form-control',
                    'type' => 'text',
                    'placeholder' => 'Comments'
                ]) ?>
            </div>
            <?= $this->Form->button(__('Save and Upload Photo'), ['class' => 'btn btn-primary', 'style' => 'margin-bottom: 10px;']) ?>
            <!-- <br> -->
            <?= $this->Form->end() ?>
            <?php
            // Filter for 'BEFORE' photos
            $beforePhotos = array_filter($booking->photos, function ($photo) {
                return $photo['_joinData']->photo_type === 'BEFORE' && !$photo->in_bin;
            });
            ?>
            <?php if (!empty($beforePhotos)) : ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tr>
                            <th><?= __('File') ?></th>
                            <th><?= __('Comments') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($beforePhotos as $photo) : ?>
                            <tr>
                                <td>
                                    <?= $this->Html->image($photo->path, ['width' => 100, 'height' => 100]) ?>
                                    <br>
                                    <?= h($photo->name) ?>
                                </td>
                                <td><?= h($photo['_joinData']->comments) ?></td>
                                <td class="actions">
                                    <!-- <?= $this->Form->postButton('Move to bin', ['controller' => 'Photos', 'action' => 'moveToBin', $photo->id], ['class' => 'btn btn-primary', 'style' => 'margin-top: 30px;', 'confirm' => __('Are you sure you want to move this photo to bin?')]) ?> -->
                                    <?= $this->Form->postButton(
                                        '<i class="fa fa-trash" aria-hidden="true"></i>',
                                        ['controller' => 'Photos', 'action' => 'moveToBin', $photo->id],
                                        [
                                            'class' => 'btn btn-primary btn-center',
                                            'escapeTitle' => false,
                                            'confirm' => __('Are you sure you want to move this photo to bin?')
                                        ]
                                    ) ?>
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
    <div class="col-sm-5">
        <!-- After Photos  -->
        <div style="background-color: #f0f5f2; border-style: solid; border-color: green;" class="card card-body mt-3 mt-sm-0">
            <h4 style="text-align: center;"><?= __('After Photo(s)') ?></h4>
            <i style="font-size: small; text-align: center;">Maximum 30 images</i>
            <h5>Upload Photo</h5>
            <div>
                <?= $this->Form->create(null, ['type' => 'file', 'url' => ['controller' => 'BookingsPhotos', 'action' => 'add', 'AFTER', $booking->id]]) ?>
            </div>
            <div style="margin-bottom: 15px;">
                <?= $this->Form->control('photo[]', [
                    'type' => 'file',
                    'multiple' => true,
                    'label' => false,
                    'accept' => 'image/jpg, image/jpeg, image/png',
                    'style' => 'display: block;',
                ]) ?>
                <i style="font-size: small;">Maximum image size is 5MB. File types allowed: .jpg, .jpeg, .png</i>
            </div>
            <div style="margin-bottom: 15px;">
                <?= $this->Form->control('comment', [
                    'label' => 'Comments (optional)',
                    'class' => 'form-group form-control',
                    'type' => 'text',
                    'placeholder' => 'Comments'
                ]) ?>
            </div>
            <?= $this->Form->button(__('Save and Upload Photo'), ['class' => 'btn btn-primary', 'style' => 'margin-bottom: 10px;']) ?>
            <?= $this->Form->end() ?>
            <?php
            // Filter for 'BEFORE' photos
            $afterPhotos = array_filter($booking->photos, function ($photo) {
                return $photo['_joinData']->photo_type === 'AFTER' && !$photo->in_bin;
            });
            ?>
            <?php if (!empty($afterPhotos)) : ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tr>
                            <th><?= __('File') ?></th>
                            <th><?= __('Comments') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($afterPhotos as $photo) : ?>
                            <tr>
                                <td>
                                    <?= $this->Html->image($photo->path, ['width' => 100, 'height' => 100]) ?>
                                    <br>
                                    <?= h($photo->name) ?>
                                </td>
                                <td><?= h($photo['_joinData']->comments) ?></td>
                                <td class="actions">
                                    <!-- <?= $this->Form->postButton('Move to bin', ['controller' => 'Photos', 'action' => 'moveToBin', $photo->id], ['class' => 'btn btn-primary', 'style' => 'margin-top: 30px;', 'confirm' => __('Are you sure you want to move this photo to bin?')]) ?> -->
                                    <?= $this->Form->postButton(
                                        '<i class="fa fa-trash" aria-hidden="true"></i>',
                                        ['controller' => 'Photos', 'action' => 'moveToBin', $photo->id],
                                        [
                                            'class' => 'btn btn-primary btn-center',
                                            'escapeTitle' => false,
                                            'confirm' => __('Are you sure you want to move this photo to bin?')
                                        ]
                                    ) ?>
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
<br>

<script src="https://kit.fontawesome.com/dc286b156c.js" crossorigin="anonymous"></script>