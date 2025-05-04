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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $discoverySource->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $discoverySource->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Discovery Sources'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="discoverySources form content">
            <?= $this->Form->create($discoverySource) ?>
            <fieldset>
                <legend><?= __('Edit Discovery Source') ?></legend>
                <?php
                    echo $this->Form->control('name');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
