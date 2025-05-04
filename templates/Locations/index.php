<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Location> $locations
 */
$this->layout = 'manager_view';
$this->assign('title', 'Locations');
?>

<div class="d-sm-flex align-items-center justify-content-between flex-wrap">
    <h2>Locations</h2>
    <div class="ml-auto">
        <?= $this->Html->link(__('View Archived'), ['action' => 'indexArchived'], ['class' => 'btn btn-secondary mr-2']) ?>
        <?= $this->Html->link(__('New Location'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="d-block d-sm-none mb-3"></div>
</div>

<!-- Location Filter -->
<div class="mb-3">
    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline', 'id' => 'stateFilterForm']) ?>
    <!-- <label for="stateSelect" class="mr-2">State:</label> -->
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
                        <th><?= __('Status') ?></th>
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
                            <td><?php switch ($location->status):
                                    case 'OPERATIONAL': ?>
                                        In Operation
                                    <?php break;
                                    case 'TEMPCLOSED': ?>
                                        Temporarily Closed
                                    <?php break;
                                    case 'ARCHIVED': ?>
                                        Archived
                                    <?php break;
                                    default: ?>
                                        Unknown
                                <?php endswitch; ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $location->id]) ?>
                                <?= $this->Form->postLink(__('Archive'), ['action' => 'archive', $location->id], [
                                    'confirm' => __('Are you sure you want to archive this record of {0}?', $location->name),
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
            ],
            order: [
                [1, 'asc']
            ]
        });
    });
</script>