<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
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
?>
<div class="d-sm-flex align-items-center justify-content-between flex-wrap">
    <h2>Pram Spa Staff</h2>
    <?php if ($this->request->getSession()->read('Auth.role_id') == 1): ?>
        <div class="ml-auto">
            <?= $this->Html->link(__('View Deactivated Staff'), ['action' => 'indexArchived'], ['class' => 'btn btn-secondary mr-2 mb-2 mb-sm-0']) ?>
            <?= $this->Html->link(__('Add New Staff Account'), ['plugin' => null, 'controller' => 'Auth', 'action' => 'register'], ['class' => 'btn btn-primary']) ?>
        </div>
    <?php endif; ?>
    <div class="d-block d-sm-none mb-3"></div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone No</th>
                        <th>Role</th>
<!--                        --><?php //if ($this->request->getSession()->read('Auth.role_id') != 2): ?>
<!--                            <th>Actions</th>-->
<!--                        --><?php //endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <?= $this->Html->link(
                                    '<i class="fa fa-eye" aria-hidden="true"></i>',
                                    ['action' => 'view', $user->id],
                                    ['escape' => false]
                                ) ?>
                            </td>
                            <td><?= h($user->first_name) . ' ' . h($user->last_name) ?></td>
                            <td><?= h($user->email) ?></td>
                            <td><?= h($user->phone_no) ?></td>
                            <td><?= h($user->role->name) ?></td>
<!--                            --><?php //if ($this->request->getSession()->read('Auth.role_id') != 2): ?>
<!--                                <td class="actions">-->
<!--                                    --><?php //= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
<!--                                </td>-->
<!--                            --><?php //endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Include DataTables Scripts -->
<?= $this->Html->script('/vendor/jquery/jquery.min.js') ?>
<?= $this->Html->script('/vendor/datatables/jquery.dataTables.min.js') ?>
<?= $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js') ?>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#usersTable').DataTable({
            lengthChange: false,
            columnDefs: [{
                    targets: 0, // First column (View icon)
                    orderable: false,
                    width: "1%"
                },
                {
                    targets: 2,
                    orderable: false,
                },
                {
                    targets: 3,
                    orderable: false,
                },
                {
                    targets: -1, // Last column (Actions)
                    orderable: false
                }
            ],
            order: [
                [1, 'asc']
            ]
        });
    });
</script>
