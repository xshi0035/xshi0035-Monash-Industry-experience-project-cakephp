<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

//$debug = Configure::read('debug');

$this->layout = 'login';
$this->assign('title', 'Login');
?>

<?= $this->Form->create(null, ['url' => ['controller' => 'Auth', 'action' => 'login']]) ?>



<div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
            <div class="card-body p-3 p-md-4 p-xl-5">
                <div class="text-center mb-3">
                    <h1>Pram Spa Portal</h1>
                    <a href="#!">
                        <!-- Pram Spa image logo here? -->
                    </a>
                </div>
                <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Sign in to your account</h2>
                <?= $this->Flash->render() ?>
                <form action="#!">
                    <div class="row gy-2 overflow-hidden">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <!-- <input type="email" class="form-control" name="email" id="email" value="" placeholder="name@example.com" required>
                                        <label for="email" class="form-label">Email</label> -->
                                <?php
                                echo $this->Form->control('email', [
                                    'type' => 'email',
                                    'required' => true,
                                    'class' => 'form-control',
                                    'placeholder' => 'name@example.com',
                                    'label' => false, // Disable the default label generation
                                    'templates' => [
                                        'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}>',
                                        'inputContainer' => '{{content}}<label for="{{name}}" class="form-label">Email</label>',
                                    ]
                                ]); ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <!-- <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                                        <label for="password" class="form-label">Password</label> -->
                                <?php echo $this->Form->control('password', [
                                    'type' => 'password',
                                    'required' => true,
                                    'class' => 'form-control',
                                    'placeholder' => 'Password',
                                    'label' => false,
                                    'templates' => [
                                        'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}>',
                                        'inputContainer' => '{{content}}<label for="{{name}}" class="form-label">Password</label>',
                                    ]
                                ]); ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-grid my-3">
                                <?= $this->Form->button(__('Log In'), ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) ?>
                                <?= $this->Form->end() ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-between">
                                <?= $this->Html->link(
                                    'Forgot password?',
                                    ['controller' => 'Auth', 'action' => 'forgetPassword'],
                                    ['class' => 'link-primary text-decoration-none']
                                ) ?>
                            </div>
                        </div>
                        <!-- <div class="col-12">
                            <p class="m-0 text-secondary text-center">Don't have an account? <a href="#!" class="link-primary text-decoration-none">Sign up</a></p>
                        </div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>