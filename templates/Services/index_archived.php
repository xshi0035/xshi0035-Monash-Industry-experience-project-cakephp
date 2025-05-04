<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Service> $services
 */
$this->layout = 'manager_view';
$this->assign('title', "Archived Services");
?>

<div class="d-sm-flex align-items-center justify-content-between flex-wrap">
    <h2>Archived Services</h2>
    <?= $this->Html->link(__('Return to List of Services'), ['action' => 'index'], ['class' => 'd-sm-inline-block btn btn-secondary']) ?>
    <div class="d-block d-sm-none mb-3"></div>
</div>
<div class="mb-3">
    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline', 'id' => 'categoryFilterForm']) ?>
    <label for="categorySelect" class="mr-2">Category:</label>
    <?= $this->Form->control('category', [
        'type' => 'select',
        'options' => ['all' => 'All'] + $categories->toArray(),
        'empty' => false,
        'value' => $selectedCategoryId,
        'label' => false,
        'class' => 'form-control',
        'id' => 'categorySelect'
    ]) ?>
    <?= $this->Form->end() ?>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="servicesTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Cost</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td>
                                <?= $this->Html->link(
                                    '<i class="fa fa-eye" aria-hidden="true"></i>',
                                    ['action' => 'view', $service->id],
                                    [
                                        'escape' => false,
                                    ]
                                ) ?>
                            </td>
                            <td><?= h($service->name) ?></td>
                            <td><?= h($service->category->name) ?></td>
                            <td>$<?= $this->Number->format($service->service_cost) ?></td>
                            <td class="actions">
                                <?= $this->Form->postLink(__('Unarchive'), ['action' => 'unarchive', $service->id], [
                                    'confirm' => __('Please confirm that you would like to unarchive this record of {0}', $service->name)
                                ]) ?>
                                <?= $this->Form->postLink(__('Permanently Delete'), ['action' => 'delete', $service->id], [
                                    'confirm' => __('Are you sure you want to permanently delete this record of {0}?', $service->name),
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
    document.getElementById('categorySelect').addEventListener('change', function() {
        document.getElementById('categoryFilterForm').submit();
    });

    $(document).ready(function() {
        $('#servicesTable').DataTable({
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