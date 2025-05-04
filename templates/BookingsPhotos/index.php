<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\BookingsPhoto> $bookingsPhotos
 */
?>
<div class="bookingsPhotos index content">
    <?= $this->Html->link(__('New Bookings Photo'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Bookings Photos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('photo_type') ?></th>
                    <th><?= $this->Paginator->sort('booking_id') ?></th>
                    <th><?= $this->Paginator->sort('photo_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookingsPhotos as $bookingsPhoto): ?>
                <tr>
                    <td><?= $this->Number->format($bookingsPhoto->id) ?></td>
                    <td><?= h($bookingsPhoto->photo_type) ?></td>
                    <td><?= $bookingsPhoto->hasValue('booking') ? $this->Html->link($bookingsPhoto->booking->id, ['controller' => 'Bookings', 'action' => 'view', $bookingsPhoto->booking->id]) : '' ?></td>
                    <td><?= $bookingsPhoto->hasValue('photo') ? $this->Html->link($bookingsPhoto->photo->description, ['controller' => 'Photos', 'action' => 'view', $bookingsPhoto->photo->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $bookingsPhoto->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bookingsPhoto->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bookingsPhoto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bookingsPhoto->id)]) ?>
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
