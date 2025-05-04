<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Availability $availability
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Availability'), ['action' => 'edit', $availability->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Availability'), ['action' => 'delete', $availability->id], ['confirm' => __('Are you sure you want to delete # {0}?', $availability->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Availabilities'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Availability'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="availabilities view content">
            <h3><?= h($availability->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $availability->hasValue('location') ? $this->Html->link($availability->location->st_address, ['controller' => 'Locations', 'action' => 'view', $availability->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($availability->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Day Of Week') ?></th>
                    <td><?= $this->Number->format($availability->day_of_week) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Time') ?></th>
                    <td><?= h($availability->start_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Time') ?></th>
                    <td><?= h($availability->end_time) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
