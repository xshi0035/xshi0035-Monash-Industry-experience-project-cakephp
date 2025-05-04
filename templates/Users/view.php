<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user

 */
if ($this->request->getSession()->read('Auth.role_id') == 2) {
    $this->layout = 'manager_view';
}

if ($this->request->getSession()->read('Auth.role_id') == 1) {
    $this->layout = 'admin_view';
}

if ($this->request->getSession()->read('Auth.role_id') == 3) {
    $this->layout = 'new_contractor_view';
}

if ($this->request->getSession()->read('Auth.id') === $user->id) :
    $this->assign('title', 'My Profile');
else:
    $this->assign('title', h($user->first_name) . ' ' . h($user->last_name) . '\'s Profile');
endif;
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    ['controller' => 'Users', 'action' => 'index'],
    ['escape' => false, 'class' => 'btn btn-link']
) ?>
<div class="d-sm-flex align-items-center justify-content-between flex-wrap mb-3">
    <?php if ($this->request->getSession()->read('Auth.id') === $user->id) : ?>
        <h3>My Profile</h3>
    <?php else : ?>
        <h3>Staff Details</h3>
    <?php endif; ?>
    <div class="ml-auto">
        <?php if ($this->request->getAttribute('identity')->role_id != 3) : ?>
            <?= $this->Html->link(__('Edit Details'), ['action' => 'edit', $user->id], ['class' => 'btn btn-primary mb-2 mb-sm-0']) ?>
        <?php endif; ?>

        <div class="d-block d-sm-none mr-2"></div>
        <!-- <?= $this->Form->postLink(
                    __('Force Reset Password'),
                    ['controller' => 'Auth', 'action' => 'forceResetPassword', $user->id],
                    [
                        'confirm' => __('Are you sure you want to force reset password for {0}?', $user->first_name . ' ' . $user->last_name),
                        'class' => 'btn btn-danger',
                    ]
                ) ?> -->
        <div class="d-block d-sm-none mb-3"></div>
    </div>
</div>
<div class="row">
    <div class="col-sm-5">
        <table class="table table-sm">
            <tr>
                <th><?= __('Name') ?></th>
                <td><?= h($user->first_name) . ' ' . h($user->last_name) ?></td>
            </tr>
            <tr>
                <th><?= __('Email') ?></th>
                <td><?= h($user->email) ?></td>
            </tr>
            <tr>
                <th><?= __('Phone No') ?></th>
                <td><?= h($user->phone_no) ?></td>
            </tr>
            <tr>
                <th><?= __('Role') ?></th>
                <td><?= h($user->role->name) ?></td>
            </tr>
            <!-- <tr>
                    <th><?= __('Nonce') ?></th>
                    <td><?= h($user->nonce) ?></td>
                </tr> -->
            <!-- <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr> -->
            <!-- <tr>
                    <th><?= __('Nonce Expiry') ?></th>
                    <td><?= h($user->nonce_expiry) ?></td>
                </tr> -->
            <tr>
                <th><?= __('Created') ?></th>
                <td><?= h($user->created) ?></td>
            </tr>
        </table>
        <h4><?= __('Locations') ?></h4>
        <?php if (!empty($user->locations)) : ?>
            <ol>
                <?php foreach ($user->locations as $location) : ?>
                    <li>
                        <b><?= h($location->name) ?></b><br>
                        <i><?= h($location->st_address) . ', ' . h($location->suburb) . ' ' . h($location->postcode) . ', ' . h($location->state->abbr) ?></i>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php else : ?>
            <p><i>This staff is not assigned to any locations.</i></p>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php if ($this->request->getAttribute('identity')->role_id != 3) : ?>
            <?= $this->Form->postLink(
                __('Force Reset Password'),
                ['controller' => 'Auth', 'action' => 'forceResetPassword', $user->id],
                [
                    'confirm' => __('Are you sure you want to force reset password for {0}?', $user->first_name . ' ' . $user->last_name),
                    'class' => 'btn btn-secondary mb-2',
                ]
            ) ?><br>
            <?php if (!($this->request->getAttribute('identity')->id === $user->id)) : ?>
                <?= $this->Form->postLink(__('Deactivate account'), ['action' => 'archive', $user->id], [
                    'confirm' => __("Are you sure you want to deactivate {0}'s Pram Spa Staff account? They will no longer be able to log in using their details once you confirm.", $user->first_name . ' ' . $user->last_name),
                    'class' => 'btn btn-danger'
                ]) ?>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</div>