<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var string[]|\Cake\Collection\CollectionInterface $roles
 * @var string[]|\Cake\Collection\CollectionInterface $locations
 */

// Get the logged-in user's ID
$loggedInUserId = $this->request->getSession()->read('Auth.id');
$loggedInUserRoleId = $this->request->getSession()->read('Auth.role_id');

// Set the layout based on the role
if ($loggedInUserRoleId == 2) {
    $this->layout = 'manager_view';
}

if ($loggedInUserRoleId == 1) {
    $this->layout = 'admin_view';
}

$this->assign('title', "Edit Staff Details");

?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    'javascript:history.back()',
    ['escape' => false, 'class' => 'btn btn-link']
) ?>

<h2><?= __('Edit Staff Details') ?></h2>
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
                    'class' => 'form-control form-group'
                ]); ?>
            </div>
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('last_name', [
                    'label' => 'Last Name*',
                    'required' => true,
                    'class' => 'form-control form-group'
                ]); ?>
            </div>
        </div>
        <?php
        echo $this->Form->control('email', [
            'label' => 'Email*',
            'required' => true,
            'class' => 'form-control form-group'
        ]); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('phone_no', [
                    'label' => 'Phone Number*',
                    'required' => true,
                    'class' => 'form-control form-group'
                ]); ?>
            </div>
            <div class="col-sm-6">
                <?php
                // Only allow editing the role if the user is not editing their own account
                if ($loggedInUserId != $user->id) {
                    echo $this->Form->control('role_id', [
                        'options' => $roles,
                        'label' => 'Role*',
                        'required' => true,
                        'class' => 'form-control form-group'
                    ]);
                } else {
                    // Display the user's current role but disable the input
                    echo $this->Form->control('role_id', [
                        'options' => $roles,
                        'label' => 'Role*',
                        'disabled' => true, // Disable the field for the current user
                        'class' => 'form-control form-group'
                    ]);
                }
                ?>
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
<?= $this->Form->button(__('Save Changes'), ['class' => 'btn btn-primary']) ?> <br><br>
<?= $this->Form->end() ?>

<br><br>
