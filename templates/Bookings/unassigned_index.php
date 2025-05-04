<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */
$this->layout = 'manager_view';
$this->assign('title', "Unassigned Bookings");
?>
<!-- Page Heading -->
<h2>Unassigned Bookings</h2>

<!-- Filter Form -->
<div class="mb-4">
    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']) ?>

    <!-- Location Filter -->
    <?= $this->Form->control('location', [
        'type' => 'select',
        'options' => $locations,
        'empty' => 'All Locations',
        'value' => $locationId, // Pre-select the location based on the current filter
        'label' => false,
        'class' => 'form-control mr-2'
    ]) ?>

    <!-- Filter Button -->
    <?= $this->Form->button(__('Filter'), ['class' => 'btn btn-primary']) ?>

    <?= $this->Form->end() ?>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4 d-none d-md-block">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="unassignedBookingsTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Location</th>
                        <th>Drop off Date & Time</th>
                        <th>Services</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td>
                                <?= $booking->hasValue('customer') ?
                                    $this->Html->link(
                                        $booking->customer->first_name . ' ' . $booking->customer->last_name,
                                        ['controller' => 'Bookings', 'action' => 'view', $booking->id, '?' => ['controller' => 'Bookings', 'action' => 'unassignedIndex']]
                                    )
                                    : ''
                                ?>
                            </td>
                            <td><?= h($booking->location->name) ?></td>
                            <td><?= h($booking->dropoff_date->format('d/m/y')) . ' ' . h($booking->dropoff_time->format('g:i a')) ?></td>
                            <td>
                            <?php foreach ($booking->services as $service) : ?>
                                    <ul class="pl-4">
                                        <li><strong><?= h($service->name) ?></strong><br>
                                            (<?= h($service->category->name) ?>)<br>
                                            Quantity: <?= h($service->_joinData->service_qty) ?></li>
                                    </ul>
                                <?php endforeach; ?>
                            </td>
                            <td><?= h($booking->status->name) ?></td>
                            <td> <?= $this->Html->link(__('Assign Contractor'), ['action' => 'assignContractor', $booking->id], ['class' => 'btn btn-primary']) ?>
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
                </div>
                <p class="card-text">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> <?= h($booking->location->name) ?><br>
                    <i class="fa fa-calendar-o" aria-hidden="true"></i> <?= h($booking->dropoff_date->format('d/m/Y')) . ' ' . h($booking->dropoff_time->format('g:i A')) ?><br>
                    <span class="badge badge-primary"><?= h($booking->status->name) ?></span><br>
                    <hr>
                    <?php foreach ($booking->services as $service) : ?>
                        <?= h($service->_joinData->service_qty) ?> x <strong><?= h($service->name) ?></strong> (<?= h($service->category->name) ?>)<br>
                    <?php endforeach; ?><br>
                    <br>
                    <td> <?= $this->Html->link(__('Assign Contractor'), ['action' => 'assignContractor', $booking->id], ['class' => 'btn btn-primary']) ?>
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
        $('#unassignedBookingsTable').DataTable({
            columnDefs: [
                
            ],
            order: [
                
            ]
        });
    });
</script>