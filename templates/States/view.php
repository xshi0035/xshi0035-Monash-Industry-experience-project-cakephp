<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\State $state
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit State'), ['action' => 'edit', $state->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete State'), ['action' => 'delete', $state->id], ['confirm' => __('Are you sure you want to delete # {0}?', $state->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List States'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New State'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="states view content">
            <h3><?= h($state->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($state->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Abbr') ?></th>
                    <td><?= h($state->abbr) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($state->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Locations') ?></h4>
                <?php if (!empty($state->locations)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Street No') ?></th>
                            <th><?= __('Street Name') ?></th>
                            <th><?= __('Suburb') ?></th>
                            <th><?= __('Postcode') ?></th>
                            <th><?= __('State Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($state->locations as $location) : ?>
                        <tr>
                            <td><?= h($location->id) ?></td>
                            <td><?= h($location->street_no) ?></td>
                            <td><?= h($location->street_name) ?></td>
                            <td><?= h($location->suburb) ?></td>
                            <td><?= h($location->postcode) ?></td>
                            <td><?= h($location->state_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Locations', 'action' => 'view', $location->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Locations', 'action' => 'edit', $location->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Locations', 'action' => 'delete', $location->id], ['confirm' => __('Are you sure you want to delete # {0}?', $location->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
