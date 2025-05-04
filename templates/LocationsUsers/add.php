<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationsUser $locationsUser
 * @var \Cake\Collection\CollectionInterface|string[] $locations
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Locations Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="locationsUsers form content">
            <?= $this->Form->create($locationsUser) ?>
            <fieldset>
                <legend><?= __('Add Locations User') ?></legend>
                <?php
                    echo $this->Form->control('location_id', ['options' => $locations]);
                    echo $this->Form->control('user_id', ['options' => $users]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
