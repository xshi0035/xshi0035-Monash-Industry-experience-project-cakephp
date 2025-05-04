<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\BookingsProduct> $bookingsProducts
 */
?>
<div class="bookingsProducts index content">
    <?= $this->Html->link(__('New Bookings Product'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Bookings Products') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('product_qty') ?></th>
                    <th><?= $this->Paginator->sort('booking_id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookingsProducts as $bookingsProduct): ?>
                <tr>
                    <td><?= $this->Number->format($bookingsProduct->id) ?></td>
                    <td><?= $this->Number->format($bookingsProduct->product_qty) ?></td>
                    <td><?= $bookingsProduct->hasValue('booking') ? $this->Html->link($bookingsProduct->booking->id, ['controller' => 'Bookings', 'action' => 'view', $bookingsProduct->booking->id]) : '' ?></td>
                    <td><?= $bookingsProduct->hasValue('product') ? $this->Html->link($bookingsProduct->product->name, ['controller' => 'Products', 'action' => 'view', $bookingsProduct->product->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $bookingsProduct->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bookingsProduct->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bookingsProduct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bookingsProduct->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
