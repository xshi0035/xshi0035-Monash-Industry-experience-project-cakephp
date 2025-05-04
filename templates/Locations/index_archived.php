<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Location> $locations
 */
$this->layout = 'manager_view';
$this->assign('title', 'Archived Locations');
?>

<div class="d-sm-flex align-items-center justify-content-between flex-wrap">
    <h2>Archived Locations</h2>
    <?= $this->Html->link(__('Return to List of Locations'), ['action' => 'index'], ['class' => 'd-sm-inline-block btn btn-secondary']) ?>
    <div class="d-block d-sm-none mb-3"></div>
</div>

<!-- Location Filter -->
<div class="mb-3">
    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline', 'id' => 'stateFilterForm']) ?>
    <?= $this->Form->control('state', [
        'type' => 'select',
        'options' => ['all' => 'All states'] + $states->toArray(),
        'value' => $selectedStateId,
        'empty' => false,
        'label' => false,
        'class' => 'form-control',
        'id' => 'stateSelect'
    ]) ?>
    <?= $this->Form->end() ?>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="locationsTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th><?= __('Name') ?></th>
                        <th><?= __('Street Address') ?></th>
                        <th><?= __('Suburb') ?></th>
                        <th><?= __('Postcode') ?></th>
                        <th><?= __('State') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($locations as $location): ?>
                        <tr>
                            <td>
                                <?= $this->Html->link(
                                    '<i class="fa fa-eye" aria-hidden="true"></i>',
                                    ['action' => 'view', $location->id],
                                    ['escape' => false]
                                ) ?>
                            </td>
                            <td><?= h($location->name) ?></td>
                            <td><?= h($location->st_address) ?></td>
                            <td><?= h($location->suburb) ?></td>
                            <td><?= h($location->postcode) ?></td>
                            <td><?= $location->has('state') ? h($location->state->abbr) : '' ?></td>
                            <td class="actions">
                                <?= $this->Form->postLink(__('Unarchive'), ['action' => 'unarchive', $location->id], [
                                    'confirm' => __('Please confirm that you would like to unarchive this record of {0}', $location->name)
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
    document.getElementById('stateSelect').addEventListener('change', function() {
        document.getElementById('stateFilterForm').submit();
    });

    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#locationsTable').DataTable({
            lengthChange: false,
            columnDefs: [{
                    targets: 0, // First column (View icon)
                    orderable: false,
                    width: "1%"
                },
                {
                    targets: -1, // Last column (Actions)
                    orderable: false
                }
            ]
        });
    });
</script>