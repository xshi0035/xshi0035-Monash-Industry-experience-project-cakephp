<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Availability> $availabilities
 */

$this->layout = 'manager_view';
$this->assign('title', 'All availabilities');

?>
<div class="availabilities index content">
    <?= $this->Html->link(__('New Availability'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Availabilities') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('start_time') ?></th>
                    <th><?= $this->Paginator->sort('end_time') ?></th>
                    <th><?= $this->Paginator->sort('day_of_week') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($availabilities as $availability): ?>
                <tr>
                    <td><?= $this->Number->format($availability->id) ?></td>
                    <td><?= h($availability->start_time) ?></td>
                    <td><?= h($availability->end_time) ?></td>
                    <td><?= $this->Number->format($availability->day_of_week) ?></td>
                    <td><?= $availability->hasValue('location') ? $this->Html->link($availability->location->st_address, ['controller' => 'Locations', 'action' => 'view', $availability->location->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $availability->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $availability->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $availability->id], ['confirm' => __('Are you sure you want to delete # {0}?', $availability->id)]) ?>
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
