<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Customer> $customers
 */
$this->layout = 'manager_view';
$this->assign('title', "Customers");
?>

<div class="d-sm-flex align-items-center justify-content-between flex-wrap">
    <h2>Customers</h2>
    <!-- <?= $this->Html->link(__('New Customer'), ['action' => 'add'], ['class' => 'd-sm-inline-block btn btn-primary']) ?> -->
    <div class="d-block d-sm-none mb-3"></div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="customersTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="sorting_disabled"></th>
                        <th>Full Name</th>
                        <th>Phone No</th>
                        <th>Email</th>
                        <th>Admin Comments</th>
                        <th>ID</th><!-- Hidden Column -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td>
                                <?= $this->Html->link(
                                    '<i class="fa fa-eye" aria-hidden="true"></i>',
                                    ['action' => 'view', $customer->id],
                                    [
                                        'escape' => false,
                                    ]
                                ) ?>
                            </td>
                            <td><?= h($customer->first_name) . ' ' . h($customer->last_name) ?></td>
                            <td><?= h($customer->phone_no) ?></td>
                            <td><?= h($customer->email) ?></td>
                            <td><?= $customer->hasValue('admin_comments') ? 'Yes' : '---' ?></td>
                            <td><?= h($customer->id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $customer->id]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->Html->script('/vendor/jquery/jquery.min.js') ?>
<?= $this->Html->script("/vendor/datatables/jquery.dataTables.min.js") ?>
<?= $this->Html->script("/vendor/datatables/dataTables.bootstrap4.min.js") ?>

<script>
    $(document).ready(function() {
        $('#customersTable').DataTable({
            columnDefs: [{
                    targets: 0, // Index of first column (View)
                    orderable: false, // Disable sorting for first column
                    width: "1%" // Set width fixed to content
                },
                {
                    targets: 2,
                    orderable: false
                },
                {
                    targets: 3,
                    orderable: false
                },
                {
                    targets: 4,
                    orderable: false
                },
                {
                    targets: 5,
                    visible: false
                },
                {
                    targets: -1, // Index of last column (Actions)
                    orderable: false // Disable sorting for this column
                }
            ],
            order: [
                [5, 'desc']
            ]
        });
    });
</script>