<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
$this->layout = 'manager_view';
$this->assign('title', "Add Category");
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    ['controller' => 'Categories', 'action' => 'index'],
    ['escape' => false, 'class' => 'btn btn-link']
) ?>
<h3><?= __('Add Category') ?></h3>
<hr>
<div class="row">
    <div class="col-sm-6">
        <?= $this->Form->create($category) ?>
        <?php
        echo $this->Form->control('name', [
            'class' => 'form-group form-control',
            'label' => 'Name*',
            'required' => true,
            'placeholder' => 'Enter category name',
            'pattern' => '[a-zA-Z\s -]+',
            'title' => 'Category name should only contain letters, hyphens, and spaces.'
        ]);
        ?>
        <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
