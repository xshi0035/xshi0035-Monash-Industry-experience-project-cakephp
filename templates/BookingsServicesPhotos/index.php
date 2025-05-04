<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\BookingsServicesPhoto> $bookingsServicesPhotos
 */
?>
<div class="bookingsServicesPhotos index content">
    <?= $this->Html->link(__('New Bookings Services Photo'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Bookings Services Photos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('photo_type') ?></th>
                    <th><?= $this->Paginator->sort('booking_service_id') ?></th>
                    <th><?= $this->Paginator->sort('photo_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookingsServicesPhotos as $bookingsServicesPhoto): ?>
                <tr>
                    <td><?= $this->Number->format($bookingsServicesPhoto->id) ?></td>
                    <td><?= h($bookingsServicesPhoto->photo_type) ?></td>
                    <td><?= $bookingsServicesPhoto->hasValue('bookings_service') ? $this->Html->link($bookingsServicesPhoto->bookings_service->id, ['controller' => 'BookingsServices', 'action' => 'view', $bookingsServicesPhoto->bookings_service->id]) : '' ?></td>
                    <td><?= $bookingsServicesPhoto->hasValue('photo') ? $this->Html->link($bookingsServicesPhoto->photo->description, ['controller' => 'Photos', 'action' => 'view', $bookingsServicesPhoto->photo->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $bookingsServicesPhoto->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bookingsServicesPhoto->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bookingsServicesPhoto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bookingsServicesPhoto->id)]) ?>
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
