<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BookingsProduct $bookingsProduct
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Bookings Product'), ['action' => 'edit', $bookingsProduct->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Bookings Product'), ['action' => 'delete', $bookingsProduct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bookingsProduct->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Bookings Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Bookings Product'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bookingsProducts view content">
            <h3><?= h($bookingsProduct->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Booking') ?></th>
                    <td><?= $bookingsProduct->hasValue('booking') ? $this->Html->link($bookingsProduct->booking->id, ['controller' => 'Bookings', 'action' => 'view', $bookingsProduct->booking->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $bookingsProduct->hasValue('product') ? $this->Html->link($bookingsProduct->product->name, ['controller' => 'Products', 'action' => 'view', $bookingsProduct->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($bookingsProduct->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Product Qty') ?></th>
                    <td><?= $this->Number->format($bookingsProduct->product_qty) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
