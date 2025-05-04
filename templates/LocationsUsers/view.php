<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationsUser $locationsUser
 */
$this->layout = 'manager_view';
$this->assign('title', "View Availabilities");
?>
<div class="row">
    <!-- <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Locations User'), ['action' => 'edit', $locationsUser->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Locations User'), ['action' => 'delete', $locationsUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationsUser->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Locations Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Locations User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside> -->
    <div class="column column-80">
        <div class="locationsUsers view content">
            <h3>Contractor and Branch info</h3>
            <table>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td>
                        <b><?= h($locationsUser->location->suburb) ?> branch</b>
                        <br>
                        <?= h($locationsUser->location->street_no) . ' ' . h($locationsUser->location->street_name) . '<br>' . h($locationsUser->location->suburb) . '<br>' . h($locationsUser->location->postcode) . '<br>' . h($locationsUser->location->state) ?>
                    </td>
                </tr>
                <!-- <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $locationsUser->hasValue('location') ? $this->Html->link($locationsUser->location->street_no, ['controller' => 'Locations', 'action' => 'view', $locationsUser->location->id]) : '' ?></td>
                </tr> -->
                <!-- <tr>
                    <th><?= __('Contractor') ?></th>
                    <td><?= $locationsUser->hasValue('user') ? $this->Html->link($locationsUser->user->email, ['controller' => 'Users', 'action' => 'view', $locationsUser->user->id]) : '' ?></td>
                </tr> -->
                <tr>
                    <th><?= __('Contractor') ?></th>
                    <td><?= $locationsUser->hasValue('user') ? h($locationsUser->user->email) : '' ?></td>
                </tr>
                <!-- <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($locationsUser->id) ?></td>
                </tr> -->
            </table>
        </div>
    </div>
</div>
