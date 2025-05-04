<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\BookingsService> $bookingsServices
 */
?>
<div class="bookingsServices index content">
    <?= $this->Html->link(__('New Bookings Service'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Bookings Services') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('service_qty') ?></th>
                    <th><?= $this->Paginator->sort('booking_id') ?></th>
                    <th><?= $this->Paginator->sort('service_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookingsServices as $bookingsService): ?>
                <tr>
                    <td><?= $this->Number->format($bookingsService->id) ?></td>
                    <td><?= $this->Number->format($bookingsService->service_qty) ?></td>
                    <td><?= $bookingsService->hasValue('booking') ? $this->Html->link($bookingsService->booking->id, ['controller' => 'Bookings', 'action' => 'view', $bookingsService->booking->id]) : '' ?></td>
                    <td><?= $bookingsService->hasValue('service') ? $this->Html->link($bookingsService->service->name, ['controller' => 'Services', 'action' => 'view', $bookingsService->service->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $bookingsService->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bookingsService->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bookingsService->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bookingsService->id)]) ?>
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
