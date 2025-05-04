<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->layout = 'login';
$this->assign('title', 'Reset Password');
?>
<div class="container login">
    <div class="row">
        <div class="column column-50 column-offset-25">

            <div class="users form content">

                <?= $this->Form->create($user) ?>

                <fieldset>

                    <legend>Reset Your Password</legend>

                    <?= $this->Flash->render() ?>

                    <p>Please enter your new password below: </p>

                    <?php
                    echo $this->Form->control('password', [
                        'type' => 'password',
                        'label' => 'New Password',
                        'required' => true,
                        'autofocus' => true,
                        'class' => 'form-control',
                        'style' => 'width:25%'
                    ]);
                    echo $this->Form->control('password_confirm', [
                        'type' => 'password',
                        'label' => 'Repeat New Password',
                        'required' => true,
                        'class' => 'form-control',
                        'style' => 'width:25%'
                    ]);
                    ?>

                </fieldset>

                <?= $this->Form->button('Reset Password',  ['class' => 'btn btn-primary']) ?>
                <?= $this->Form->end() ?>

                <hr class="hr-between-buttons">

                <?= $this->Html->link('Back to login', ['controller' => 'Auth', 'action' => 'login'], ['class' => 'button button-outline']) ?>

            </div>
        </div>
    </div>
</div>
