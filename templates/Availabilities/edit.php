<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Availability $availability
 * @var \Cake\Collection\CollectionInterface|string[] $locations
 */
if ($this->request->getSession()->read('Auth.role_id') == 2) {
    $this->layout = 'manager_view';
}

if ($this->request->getSession()->read('Auth.role_id') == 1) {
    $this->layout = 'admin_view';
}

$this->assign('title', "Edit Availability Block");
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    'javascript:history.back()',
    ['escape' => false, 'class' => 'btn btn-link']
) ?>
<h3><?= __('Edit Availability Block') ?></h3>
<hr>
<div class="row">
    <div class="col-sm-4">
        <?= $this->Form->create($availability) ?>
        <?php
        echo $this->Form->control('day_of_week', [
            'type' => 'select',
            'class' => 'form-group form-control',
            'label' => 'Day of the Week*',
            'options' => [
                0 => 'Sunday',
                1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
                6 => 'Saturday',
            ],
            'required' => true
        ]);
        echo $this->Form->control('start_time', [
            'type' => 'select',
            'class' => 'form-group form-control',
            'label' => 'Start Time*',
            'required' => true,
            'options' => $options,
            'value' => $selectedStartTime
        ]);
        echo $this->Form->control('end_time', [
            'type' => 'select',
            'required' => true,
            'class' => 'form-group form-control',
            'label' => 'End Time*',
            'options' => $options,
            'value' => $selectedEndTime
        ]); ?>
    </div>
</div>
<?= $this->Html->link(__('Cancel'), 'javascript:history.back()', ['class' => 'btn btn-secondary']) ?>
<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>