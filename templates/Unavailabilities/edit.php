<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Unavailability $unavailability
 * @var string[]|\Cake\Collection\CollectionInterface $locations
 */
$this->layout = 'manager_view';
$this->assign('title', "Edit Unavailability");
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    'javascript:history.back()',
    ['escape' => false, 'class' => 'btn btn-link']
) ?>
<h3><?= __('Edit Unavailability') ?></h3>
<hr>
<div class="row">
    <div class="col-sm-3">
        <?= $this->Form->create($unavailability) ?>
        <?php
        echo $this->Form->control('location_id', [
            'type' => 'select',
            'class' => 'form-group form-control',
            'options' => $locations,
            'empty' => 'Select a location',
            'label' => 'Location*',
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
        ?>
    </div>
</div>
<?= $this->Html->link(__('Cancel'), 'javascript:history.back()', ['class' => 'btn btn-secondary']) ?>
<?= $this->Form->button(__('Save Changes'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>