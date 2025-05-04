<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Category> $categories
 */
$this->layout = 'manager_view';
$this->assign('title', 'Categories');
?>
<div class="d-sm-flex align-items-center justify-content-between flex-wrap mb-2">
    <h2>Categories</h2>
    <div class="ml-auto">
        <?= $this->Html->link(__('View Archived'), ['action' => 'indexArchived'], ['class' => 'btn btn-secondary mr-2']) ?>
        <?= $this->Html->link(__('New Category'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="d-block d-sm-none mb-3"></div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="categoriesTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th><?= __('Name') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td>
                                <?= $this->Html->link(
                                    '<i class="fa fa-eye" aria-hidden="true"></i>',
                                    ['action' => 'view', $category->id],
                                    ['escape' => false]
                                ) ?>
                            </td>
                            <td><?= h($category->name) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id]) ?>
                                <?= $this->Form->postLink(__('Archive'), ['action' => 'archive', $category->id], [
                                    'confirm' => __('Are you sure you want to archive this record of "{0}"?', $category->name),
                                    'class' => 'text-danger'
                                ]) ?>
                            </td>
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
        $('#categoriesTable').DataTable({
            lengthChange: false,
            columnDefs: [
                {
                    targets: 0, // First column (View icon)
                    orderable: false,
                    width: "1%" // Adjust width as needed
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
