<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 * @var \Cake\Collection\CollectionInterface|string[] $bookings
 */
$this->layout = 'manager_view';
$this->assign('title', "Add Product");
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    'javascript:history.back()',
    ['escape' => false, 'class' => 'btn btn-link']
) ?>
<h3><?= __('Add Product') ?></h3>
<hr>
<div class="row">
    <div class="col-sm-3">
        <?= $this->Form->create($product) ?>
        <?php
        echo $this->Form->control('name', [
            'class' => 'form-group form-control',
            'label' => 'Name*',
            'required' => true,
            'placeholder' => 'Enter name',
            'pattern' => '[a-zA-Z\s -]+',
            'title' => 'Product name should only contain letters, hyphens and spaces.'
        ]); ?>
        <label for="product_cost">Cost*</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">$</span>
            </div>
            <?php
            echo $this->Form->input('product_cost', [
                'class' => 'form-control',
                'type' => 'number',
                'step' => '0.01',
                'min' => '0',
                'max' => '500',
                'pattern' => '^-?\d{1,8}(\.\d{2})?$',
                'required' => true,
                'label' => false,
                'placeholder' => '00.00'
            ]);
            ?>
        </div>
    </div>
    <div class="col-sm-5">
        <?php
        echo $this->Form->control('description', [
            'class' => 'form-group form-control',
            'type' => 'textarea',
            'label' => 'Description',
            'placeholder' => 'Enter description',
        ]);
        ?>
    </div>
</div>
<?= $this->Html->link(__('Cancel'), 'javascript:history.back()', ['class' => 'btn btn-secondary']) ?>
<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>