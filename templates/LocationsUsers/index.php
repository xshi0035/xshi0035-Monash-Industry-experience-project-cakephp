<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LocationsUser> $locationsUsers
 */
$this->layout = 'manager_view';
$this->assign('title', "View Location");
?>
<div class="locationsUsers index content">
    <?= $this->Html->link(__('New Locations User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Manage Contractor Availabilities') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id', 'Contractor') ?></th>
                    <th class="actions"><?= __('Manage Availability') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locationsUsers as $locationsUser): ?>
                    <tr>
                        <td><?= $this->Number->format($locationsUser->id) ?></td>
                        <td><?= $locationsUser->hasValue('location') ? $this->Html->link($locationsUser->location->suburb, ['controller' => 'Locations', 'action' => 'view', $locationsUser->location->id]) : '' ?></td>
                        <td>
                            <?= $locationsUser->hasValue('user') ? $this->Html->link(
                                $locationsUser->user->first_name . ' ' . $locationsUser->user->last_name,
                                ['controller' => 'Users', 'action' => 'view', $locationsUser->user->id]
                            ) : '' ?>
                        </td>
                        <td class="actions">
                            <?= $this->Html->link(__('Add Availability'), ['controller' => 'Availabilities', 'action' => 'add', $locationsUser->id]) ?>
                        </td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $locationsUser->id]) ?>
                            <!-- <?= $this->Html->link(__('Edit'), ['action' => 'edit', $locationsUser->id]) ?> -->
                            <!-- <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $locationsUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationsUser->id)]) ?> -->
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
