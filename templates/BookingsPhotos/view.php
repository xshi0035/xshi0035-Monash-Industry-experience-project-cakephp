<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BookingsPhoto $bookingsPhoto
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Bookings Photo'), ['action' => 'edit', $bookingsPhoto->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Bookings Photo'), ['action' => 'delete', $bookingsPhoto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bookingsPhoto->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Bookings Photos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Bookings Photo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bookingsPhotos view content">
            <h3><?= h($bookingsPhoto->photo_type) ?></h3>
            <table>
                <tr>
                    <th><?= __('Photo Type') ?></th>
                    <td><?= h($bookingsPhoto->photo_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Booking') ?></th>
                    <td><?= $bookingsPhoto->hasValue('booking') ? $this->Html->link($bookingsPhoto->booking->id, ['controller' => 'Bookings', 'action' => 'view', $bookingsPhoto->booking->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Photo') ?></th>
                    <td><?= $bookingsPhoto->hasValue('photo') ? $this->Html->link($bookingsPhoto->photo->description, ['controller' => 'Photos', 'action' => 'view', $bookingsPhoto->photo->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($bookingsPhoto->id) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Comments') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($bookingsPhoto->comments)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
