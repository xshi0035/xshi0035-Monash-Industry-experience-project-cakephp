<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DiscoverySource $discoverySource
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Discovery Source'), ['action' => 'edit', $discoverySource->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Discovery Source'), ['action' => 'delete', $discoverySource->id], ['confirm' => __('Are you sure you want to delete # {0}?', $discoverySource->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Discovery Sources'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Discovery Source'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="discoverySources view content">
            <h3><?= h($discoverySource->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($discoverySource->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($discoverySource->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Customers') ?></h4>
                <?php if (!empty($discoverySource->customers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Phone No') ?></th>
                            <th><?= __('Terms Cond') ?></th>
                            <th><?= __('Priv Policy') ?></th>
                            <th><?= __('Cancel Policy') ?></th>
                            <th><?= __('Email Sub') ?></th>
                            <th><?= __('Discovery Source Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($discoverySource->customers as $customer) : ?>
                        <tr>
                            <td><?= h($customer->id) ?></td>
                            <td><?= h($customer->email) ?></td>
                            <td><?= h($customer->first_name) ?></td>
                            <td><?= h($customer->last_name) ?></td>
                            <td><?= h($customer->phone_no) ?></td>
                            <td><?= h($customer->terms_cond) ?></td>
                            <td><?= h($customer->priv_policy) ?></td>
                            <td><?= h($customer->cancel_policy) ?></td>
                            <td><?= h($customer->discovery_source_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Customers', 'action' => 'view', $customer->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Customers', 'action' => 'edit', $customer->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Customers', 'action' => 'delete', $customer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customer->id)]) ?>
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
