<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Category> $categories
 */
$this->layout = 'manager_view';
$this->assign('title', 'Archived Categories');
?>
<div class="d-sm-flex align-items-center justify-content-between flex-wrap mb-2">
    <h2>Archived Categories</h2>
    <?= $this->Html->link(__('Return to List of Categories'), ['action' => 'index'], ['class' => 'd-sm-inline-block btn btn-secondary']) ?>
    <div class="d-block d-sm-none mb-3"></div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="categoriesTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><?= __('Name') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= h($category->name) ?></td>
                            <td class="actions">
                                <?= $this->Form->postLink(__('Unarchive'), ['action' => 'unarchive', $category->id], [
                                    'confirm' => __('Please confirm that you would like to unarchive this record of {0}', $category->name)
                                ]) ?>
                                <!-- <?= $this->Form->postLink(__('Permanently Delete'), ['action' => 'delete', $category->id], [
                                    'confirm' => __('Are you sure you want to permanently delete the {0} category? All services under this category will also be deleted.', $category->name),
                                    'class' => 'text-danger'
                                ]) ?> -->
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
        var table = $('#categoriesTable').DataTable({
            lengthChange: false,
            columnDefs: [{
                targets: -1, // Last column (Actions)
                orderable: false
            }]
        });
    });
</script>