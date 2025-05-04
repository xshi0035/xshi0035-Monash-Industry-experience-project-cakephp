<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BookingsServicesPhoto $bookingsServicesPhoto
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Bookings Services Photo'), ['action' => 'edit', $bookingsServicesPhoto->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Bookings Services Photo'), ['action' => 'delete', $bookingsServicesPhoto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bookingsServicesPhoto->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Bookings Services Photos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Bookings Services Photo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bookingsServicesPhotos view content">
            <h3><?= h($bookingsServicesPhoto->photo_type) ?></h3>
            <table>
                <tr>
                    <th><?= __('Photo Type') ?></th>
                    <td><?= h($bookingsServicesPhoto->photo_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bookings Service') ?></th>
                    <td><?= $bookingsServicesPhoto->hasValue('bookings_service') ? $this->Html->link($bookingsServicesPhoto->bookings_service->id, ['controller' => 'BookingsServices', 'action' => 'view', $bookingsServicesPhoto->bookings_service->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Photo') ?></th>
                    <td><?= $bookingsServicesPhoto->hasValue('photo') ? $this->Html->link($bookingsServicesPhoto->photo->description, ['controller' => 'Photos', 'action' => 'view', $bookingsServicesPhoto->photo->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($bookingsServicesPhoto->id) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Comments') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($bookingsServicesPhoto->comments)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
