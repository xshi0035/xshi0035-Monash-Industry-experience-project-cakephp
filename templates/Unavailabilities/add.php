<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Unavailability $unavailability
 * @var \Cake\Collection\CollectionInterface|string[] $locations
 */
$this->layout = 'manager_view';
$this->assign('title', "Add Unavailability");
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    'javascript:history.back()',
    ['escape' => false, 'class' => 'btn btn-link']
) ?>
<h3><?= __('Add Unavailability') ?></h3>
<hr>
<div class="row">
    <div class="col-sm-4">
        <?= $this->Form->create($unavailability) ?>
        <?php
        echo $this->Form->control('location_id', [
            'type' => 'select',
            'class' => 'form-group form-control',
            'label' => 'Location*',
            // 'value' => $location_id,
            'required' => true,
            'disabled' => true
        ]);
        echo $this->Form->control('start_date', [
            'type' => 'date',
            'class' => 'form-group form-control',
            'label' => 'Start Date*',
            'required' => true,
            'placeholder' => 'Select start date',
        ]);
        echo $this->Form->control('end_date', [
            'type' => 'date',
            'class' => 'form-group form-control',
            'label' => 'End Date*',
            'required' => true,
            'placeholder' => 'Select end date',
        ]);
        echo $this->Form->control('location_id', ['type' => 'hidden']);
        ?>
        <div class="mt-3">
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>