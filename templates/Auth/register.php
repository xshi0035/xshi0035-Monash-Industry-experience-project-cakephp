<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\Role $roles
 */

$this->layout = 'login';
$this->layout = 'admin_view';
$this->assign('title', 'Add New Staff Account');
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    'javascript:history.back()',
    ['escape' => false, 'class' => 'btn btn-link']
) ?>

<h2><?= __('Add New Staff Account') ?></h2>
<hr>

<div class="row">
    <div class="col-sm-6">
        <?= $this->Form->create($user) ?>
        <?= $this->Flash->render() ?>
        <div class="form-group row">
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('first_name', [
                    'label' => 'First Name*',
                    'required' => true,
                    'class' => 'form-group form-control',
                ]); ?>
            </div>
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('last_name', [
                    'label' => 'Last Name*',
                    'required' => true,
                    'class' => 'form-group form-control',
                ]); ?>
            </div>
        </div>
        <?php
        echo $this->Form->control('email', [
            'label' => 'Email*',
            'required' => true,
            'class' => 'form-group form-control',
        ]); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('phone_no', [
                    'label' => 'Phone Number*',
                    'required' => true,
                    'class' => 'form-group form-control',
                ]); ?>
            </div>
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('role_id', [
                    'options' => $roles,
                    'label' => 'Role*',
                    'required' => true,
                    'class' => 'form-group form-control',
                ]); ?>
            </div>
        </div>
        <?php
        //        // Password confirmation field with error handling
        //        echo $this->Form->control('password_confirm', [
        //            'type' => 'password',
        //            'value' => '',  // Ensure password is not sending back to the client side
        //            'label' => 'Retype Password*',
        //            'error' => [
        //                'password_confirm' => 'Passwords do not match'
        //            ],
        //            'class' => 'form-group form-control',
        //        ]);
        //
        //        // Password field with error handling
        //        echo $this->Form->control('password', [
        //            'value' => '',  // Ensure password is not sending back to the client side
        //            'type' => 'password',
        //            'label' => 'Password*',
        //            'error' => [
        //                'password' => 'Please provide a valid password'
        //            ],
        //            'class' => 'form-group form-control',
        //        ]);
        //        
        ?>

    </div>
</div>

<div class="mt-3">

    <?= $this->Form->button('Register', ['class' => 'btn btn-primary']) ?>
    <!--<?= $this->Html->link('Back to login', ['controller' => 'Auth', 'action' => 'login'], ['class' => 'btn btn-secondary']) ?>-->
    <?= $this->Form->end() ?>

</div>