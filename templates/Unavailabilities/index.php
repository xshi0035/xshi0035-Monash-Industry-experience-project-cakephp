<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Unavailability> $unavailabilities
 */
$this->layout = 'manager_view';
$this->assign('title', 'Unavailabilities');
?>

<div class="d-sm-flex align-items-center justify-content-between flex-wrap">
    <h2>Unavailabilities</h2>
    <?= $this->Html->link(__('New Unavailability'), ['action' => 'add'], ['class' => 'd-sm-inline-block btn btn-primary']) ?>
    <div class="d-block d-sm-none mb-3"></div>
</div>

<!-- Search Form -->
<div class="mb-3">
    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline', 'id' => 'unavailabilitySearchForm']) ?>
    <label for="searchInput" class="mr-2">Search:</label>
    <?= $this->Form->control('search', [
        'type' => 'text',
        'value' => $this->request->getQuery('search'),
        'label' => false,
        'class' => 'form-control',
        'id' => 'searchInput',
        'placeholder' => 'Enter location or date'
    ]) ?>
    <?= $this->Form->end() ?>
</div>

<!-- DataTables Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="unavailabilitiesTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th><?= __('Start Date') ?></th>
                        <th><?= __('End Date') ?></th>
                        <th><?= __('Location') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($unavailabilities as $unavailability): ?>
                    <tr>
                        <td>
                            <?= $this->Html->link(
                                '<i class="fa fa-eye" aria-hidden="true"></i>',
                                ['action' => 'view', $unavailability->id],
                                ['escape' => false]
                            ) ?>
                        </td>
                        <td><?= h($unavailability->start_date->format('Y-m-d')) ?></td>
                        <td><?= h($unavailability->end_date->format('Y-m-d')) ?></td>
                        <td>
                            <?= $unavailability->has('location') ? 
                                $this->Html->link(
                                    h($unavailability->location->name),
                                    ['controller' => 'Locations', 'action' => 'view', $unavailability->location->id]
                                ) : 'N/A' ?>
                        </td>
                        <td class="actions">
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $unavailability->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $unavailability->id], ['confirm' => __('Are you sure you want to delete # {0}?', $unavailability->id)]) ?>
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
        var table = $('#unavailabilitiesTable').DataTable({
            lengthChange: false,
            columnDefs: [
                {
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

        // Handle search input
        $('#searchInput').on('keyup', function() {
            table.search(this.value).draw();
        });
    });
</script>
