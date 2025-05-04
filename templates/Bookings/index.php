<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */
$this->layout = 'manager_view';
$this->assign('title', "Bookings");

// Determine if any filters are active based on query parameters
$activeFilters = false;
$query = $this->request->getQuery();
if (
    !empty($query['location']) ||
    !empty($query['status']) ||
    !empty($query['start_date']) ||
    !empty($query['end_date'])
) {
    $activeFilters = true;
}
?>

<!-- Toggle Button for Filter Form -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>All Bookings</h2>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#filterForm" aria-expanded="<?= $activeFilters ? 'true' : 'false' ?>" aria-controls="filterForm">
        <i class="fa fa-filter" aria-hidden="true"></i> Filter
    </button>
</div>


<!-- Collapsible Filter Form -->
<div class="collapse mb-4 <?= $activeFilters ? 'show' : '' ?>" id="filterForm">
    <div class="card card-body">
        <?= $this->Form->create(null, ['type' => 'get', 'class' => '']) ?>

        <div class="form-row">

            <!-- Location Filter -->
            <div class="form-group col-md-3">
                <?= $this->Form->label('location', 'Location') ?>
                <?= $this->Form->control('location', [
                    'type' => 'select',
                    'options' => $locations,
                    'empty' => 'All Locations',
                    'value' => $locationId, // Pre-select the location based on the current filter
                    'label' => false,
                    'class' => 'form-control'
                ]) ?>
            </div>

            <!-- Status Filter -->
            <div class="form-group col-md-3">
                <?= $this->Form->label('status', 'Status') ?>
                <?= $this->Form->control('status', [
                    'type' => 'select',
                    'options' => $statuses,
                    'empty' => 'All Statuses',
                    'value' => $statusId, // Pre-select the status based on the current filter
                    'label' => false,
                    'class' => 'form-control'
                ]) ?>
            </div>

            <!-- Date Range Filter -->
            <div class="form-group col-md-6">
                <div class="d-flex flex-column flex-md-row">
                    <label for="dateRange" class="mb-0 mr-md-2 mb-1 mb-md-0">Drop-off Date Range</label>
                    <small class="text-muted mb-0">(These dates filter the drop-off date of bookings.)</small>
                </div>
                <div class="form-row">

                    <!-- Start Date -->
                    <div class="form-group col-md-6">
                        <?= $this->Form->control('start_date', [
                            'type' => 'date',
                            'placeholder' => 'dd/mm/yyyy',
                            'value' => $start_date, // Pre-select the start_date based on the current filter
                            'label' => false,
                            'class' => 'form-control',
                            'aria-label' => 'Start Date'
                        ]) ?>
                        <small class="form-text text-muted">Start Date (Drop-off Date)</small>
                    </div>

                    <!-- End Date -->
                    <div class="form-group col-md-6">
                        <?= $this->Form->control('end_date', [
                            'type' => 'date',
                            'placeholder' => 'dd/mm/yyyy',
                            'value' => $end_date, // Pre-select the end_date based on the current filter
                            'label' => false,
                            'class' => 'form-control',
                            'aria-label' => 'End Date'
                        ]) ?>
                        <small class="form-text text-muted">End Date (Drop-off Date)</small>
                    </div>

                </div>
            </div>

        </div>

        <div class="form-row justify-content-end">
            <!-- Filter Button -->
            <div class="form-group mr-2">
                <?= $this->Form->button(__('Filter'), ['class' => 'btn btn-primary']) ?>
            </div>

            <!-- Clear Filter Button -->
            <div class="form-group">
                <?= $this->Html->link(
                    __('Clear Filter'),
                    ['action' => 'index', '?' => ['clear' => 1]],
                    ['class' => 'btn btn-secondary']
                ) ?>
            </div>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<!-- DataTables Example -->
<div class="card shadow mb-4 d-none d-md-block">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="bookingsTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th>Customer</th>
                        <th>Location</th>
                        <th>Drop-off Date & Time</th>
                        <th>Services</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Assigned Contractor</th>
                        <th>ID</th><!-- Hidden column  -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td class="text-center">
                                <?= $this->Html->link(
                                    '<i class="fa fa-eye" aria-hidden="true"></i>',
                                    ['action' => 'view', $booking->id],
                                    [
                                        'escape' => false,

                                    ]
                                ) ?>
                            </td>
                            <td><?= h($booking->customer->first_name . ' ' . $booking->customer->last_name) ?></td>
                            <td><?= h($booking->location->name) ?></td>
                            <td><?= h($booking->dropoff_date->format('d/m/Y')) . ' ' . h($booking->dropoff_time->format('g:i A')) ?></td>
                            <td>
                                <?php foreach ($booking->services as $service) : ?>
                                    <ul class="pl-4">
                                        <li><strong><?= h($service->name) ?></strong><br>
                                            (<?= h($service->category->name) ?>)<br>
                                            Quantity: <?= h($service->_joinData->service_qty) ?></li>
                                    </ul>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php if (!empty($booking->due_date)) : ?>
                                    <?= h($booking->due_date->format('d/m/Y')) ?>
                                <?php else : ?>
                                    <em>Not Available</em>
                                <?php endif; ?>
                            </td>
                            <td><?= h($booking->status->name) ?></td>

                            <?php if ($booking->user_id == null) : ?>
                                <td><em>Unassigned</em></td>
                            <?php else: ?>
                                <td><?= h($users[$booking->user_id]->first_name) . ' ' . h($users[$booking->user_id]->last_name) ?></td>
                            <?php endif; ?>
                            <td><?= h($booking->id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $booking->id]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="d-block d-md-none">
    <?php foreach ($bookings as $booking): ?>
        <div class="card mb-2">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0"><?= h($booking->customer->first_name . ' ' . $booking->customer->last_name) ?></h5>
                    <div class="ml-auto">
                        <?= $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i>', ['action' => 'view', $booking->id], ['escape' => false, 'class' => 'btn btn-primary btn-sm']) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $booking->id], ['class' => 'btn btn-secondary btn-sm']) ?>
                    </div>
                </div>
                <p class="card-text">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> <?= h($booking->location->name) ?><br>
                    <i class="fa fa-calendar-o" aria-hidden="true"></i> <?= h($booking->dropoff_date->format('d/m/Y')) . ' ' . h($booking->dropoff_time->format('g:i A')) ?><br>
                    <span class="badge badge-primary"><?= h($booking->status->name) ?></span><br>
                    <hr>
                    <?php foreach ($booking->services as $service) : ?>
                        <?= h($service->_joinData->service_qty) ?> x <strong><?= h($service->name) ?></strong> (<?= h($service->category->name) ?>)<br>
                    <?php endforeach; ?><br>

                    <strong>Due Date:</strong>
                    <td>
                        <?php if (!empty($booking->calculated_due_date)) : ?>
                            <?= h($booking->calculated_due_date->format('d/m/Y')) ?>
                        <?php else : ?>
                            <em>Not Available</em>
                        <?php endif; ?>
                    </td>
                    <br>
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <?php if ($booking->user_id == null) : ?>
                        <em>Unassigned</em>
                    <?php else: ?>
                        <?= h($users[$booking->user_id]->first_name) . ' ' . h($users[$booking->user_id]->last_name) ?>
                    <?php endif; ?><br>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->Html->script('/vendor/jquery/jquery.min.js') ?>
<?= $this->Html->script("/vendor/datatables/jquery.dataTables.min.js") ?>
<?= $this->Html->script("/vendor/datatables/dataTables.bootstrap4.min.js") ?>

<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#bookingsTable').DataTable({
            columnDefs: [{
                    targets: 0, // Index of first column (View)
                    orderable: false, // Disable sorting for first column
                    width: "1%" // Set width fixed to content
                },
                {
                    targets: 8, // Index of Booking ID
                    visible: false // Hide column from table view
                },
                {
                    targets: -1, // Index of last column (Actions)
                    orderable: false // Disable sorting for this column
                }
            ],
            // order: [
            //     [3, 'asc']
            // ]
        });
    });
</script>