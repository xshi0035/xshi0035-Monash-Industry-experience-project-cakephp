<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Product> $products
 */
$this->layout = 'manager_view';
$this->assign('title', "Archived Products");
?>

<div class="d-sm-flex align-items-center justify-content-between flex-wrap mb-2">
    <h2>Archived Products</h2>
    <?= $this->Html->link(__('Return to List of Products'), ['action' => 'index'], ['class' => 'd-sm-inline-block btn btn-secondary']) ?>
    <div class="d-block d-sm-none mb-3"></div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="productsTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Cost</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <?= $this->Html->link(
                                    '<i class="fa fa-eye" aria-hidden="true"></i>',
                                    ['action' => 'view', $product->id],
                                    [
                                        'escape' => false,
                                    ]
                                ) ?>
                            </td>
                            <td><?= h($product->name) ?></td>
                            <td>$<?= $this->Number->format($product->product_cost) ?></td>
                            <?php if ($product->hasValue('description')): ?>
                                <td>
                                    <?= h(strlen($product->description) > 50 ? substr($product->description, 0, 50) . '...' : $product->description) ?>
                                </td>
                            <?php else: ?>
                                <td>
                                    <i>No description</i>
                                </td>
                            <?php endif; ?>
                            <td class="actions">
                                <?= $this->Form->postLink(__('Unarchive'), ['action' => 'unarchive', $product->id], [
                                    'confirm' => __('Please confirm that you would like to unarchive this record of {0}', $product->name)
                                ]) ?>
                                <?= $this->Form->postLink(__('Permanently Delete'), ['action' => 'delete', $product->id], [
                                    'confirm' => __('Are you sure you want to permanently delete this record of {0}?', $product->name),
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

<?= $this->Html->script('/vendor/jquery/jquery.min.js') ?>
<?= $this->Html->script("/vendor/datatables/jquery.dataTables.min.js") ?>
<?= $this->Html->script("/vendor/datatables/dataTables.bootstrap4.min.js") ?>

<script>
    $(document).ready(function() {
        $('#productsTable').DataTable({
            lengthChange: false, // Disable the length change menu
            columnDefs: [{
                    targets: 0, // Index of first column (View)
                    orderable: false, // Disable sorting for first column
                    width: "1%" // Set width fixed to content
                },
                {
                    targets: -1, // Index of last column (Actions)
                    orderable: false // Disable sorting for this column
                }
            ]
        });
    });
</script>