<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 * @var string[]|\Cake\Collection\CollectionInterface $discoverySources
 */
$this->layout = 'manager_view';
$this->assign('title', "Edit Customer Details");
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    'javascript:history.back()',
    ['escape' => false, 'class' => 'btn btn-link']
) ?>
<div class="d-sm-flex align-items-center justify-content-between flex-wrap mb-2">
    <h3>Edit Customer Details</h3>
    <div class="d-block d-sm-none mb-3"></div>
</div>
<hr>
<div class="row">
    <div class="col-sm-5">
        <?= $this->Form->create($customer) ?>
        <div class="row">
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('first_name', [
                    'class' => 'form-group form-control',
                ]); ?>
            </div>
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('last_name', [
                    'class' => 'form-group form-control',
                ]);
                ?>
            </div>
        </div>
        <?php
        echo $this->Form->control('email', [
            'class' => 'form-group form-control',
        ]);
        echo $this->Form->control('phone_no', [
            'class' => 'form-group form-control',
            'required' => true
        ]);
        echo $this->Form->control('discovery_source_id', [
            // 'options' => $discoverySources,
            'class' => 'form-group form-control',
            'disabled' => true
        ]);
        ?>

        <?= $this->Html->link(__('Cancel'), 'javascript:history.back()', ['class' => 'btn btn-secondary']) ?>
        <?= $this->Form->button(__('Save Changes'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>

    </div>
</div>