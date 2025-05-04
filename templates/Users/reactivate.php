<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var string[]|\Cake\Collection\CollectionInterface $roles
 * @var string[]|\Cake\Collection\CollectionInterface $locations
 */

if ($this->request->getSession()->read('Auth.role_id') == 2) {
    $this->layout = 'manager_view';
}

if ($this->request->getSession()->read('Auth.role_id') == 1) {
    $this->layout = 'admin_view';
}
$this->assign('title', "Reactivate Staff Account");
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    'javascript:history.back()',
    ['escape' => false, 'class' => 'btn btn-link']
) ?>

<h2><?= __('Reactivate Staff Account') ?></h2>
<hr>
<div class="row">
    <div class="col-sm-5">
        <?= $this->Form->create($user) ?>
        <div class="form-group row">
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('first_name', [
                    'label' => 'First Name*',
                    'required' => true,
                    'class' => 'form-control form-group',
                    'readonly' => true
                ]); ?>
            </div>
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('last_name', [
                    'label' => 'Last Name*',
                    'required' => true,
                    'class' => 'form-control form-group',
                    'readonly' => true
                ]);
                // if ($this->Form->isFieldError('last_name')) {
                //     echo $this->Form->error('last_name', null, ['class' => 'text-danger']);
                // }
                ?>
            </div>
        </div>
        <?php
        echo $this->Form->control('email', [
            'class' => 'form-control form-group'
        ]); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('phone_no', [
                    'class' => 'form-control form-group'
                ]); ?>
            </div>
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('role_id', [
                    'options' => $roles,
                    'class' => 'form-control form-group',
                    'value' => $user->role_id ? $user->role_id : 3
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <?php echo '<div class="form-group">';
        echo '<label>' . __('Locations') . '</label>';
        foreach ($locations as $id => $name) {
            echo '<div class="form-check">';
            echo $this->Form->checkbox('locations._ids[]', [
                'class' => 'form-check-input',
                'value' => $id,
                'hiddenField' => false,
                'checked' => in_array($id, collection($user->locations)->extract('id')->toArray())
            ]);
            echo '<label class="form-check-label" for="locations-ids-' . $id . '">' . h($name) . '</label>';
            echo '</div>';
        }
        echo '</div>'; ?>
    </div>
</div>
<?= $this->Html->link(__('Cancel'), 'javascript:history.back()', ['class' => 'btn btn-secondary']) ?>
<?= $this->Form->button(__('Reactivate Account'), ['class' => 'btn btn-primary']) ?> <br><br>
<?= $this->Form->end() ?>

<br><br>
