<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
if ($this->request->getSession()->read('Auth.role_id') == 3) {
    $this->layout = 'contractor_view';
}

if ($this->request->getSession()->read('Auth.role_id') == 2) {
    $this->layout = 'manager_view';
}

if ($this->request->getSession()->read('Auth.role_id') == 1) {
    $this->layout = 'admin_view';
}
$this->assign('title', "Customer: Add Comments");
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    'javascript:history.back()',
    ['escape' => false, 'class' => 'btn btn-link']
) ?>
<h3>Add Comments</h3>
<?= $this->Form->create($customer) ?>
<div class="row">
    <div class="col-sm-3">
        <table class="table table-borderless table-sm">
            <tr>
                <th><?= __('Full name') ?></th>
                <td><?= h($customer->first_name) . ' ' . h($customer->last_name) ?></td>
            </tr>
            <tr>
                <th><?= __('Email') ?></th>
                <td><?= h($customer->email) ?></td>
            </tr>
        </table>
    </div>
    <div class="col-sm-3">
        <table class="table table-borderless table-sm">
            <tr>
                <th><?= __('Phone No') ?></th>
                <td><?= h($customer->phone_no) ?></td>
            </tr>
            <tr>
                <th><?= __('Discovery Source') ?></th>
                <?php if ($discoverySource): ?>
                    <td><?= h($discoverySource) ?></td>
                <?php else: ?>
                    <td><i>No discovery source selected</i></td> 
                <?php endif; ?>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="alert alert-secondary" role="alert">
            <b>NOTE:</b> Please add your comments to any existing comments. Try not to delete others' comments already entered. These comments are anonymous. Please sign your name if you wish to keep a record.
        </div>
        <table class="table table-borderless table-sm">
            <thead>
                <tr>
                    <th><?= __('Admin Comments') ?></th>
                </tr>
            </thead>
            <tbody>
                <td>
                    <?= $this->Form->control('admin_comments', [
                        'type' => 'textarea',
                        'escape' => false,
                        'label' => false,
                        'class' => 'form-control',
                        'rows' => 3,
                        'placeholder' => 'Enter your comments here'
                    ]) ?>
                </td>
            </tbody>
        </table>
    </div>
</div>
<?= $this->Html->link(__('Cancel'), 'javascript:history.back()', ['class' => 'btn btn-secondary']) ?>
<?= $this->Form->button(__('Save'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>