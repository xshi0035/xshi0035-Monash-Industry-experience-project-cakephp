<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
$this->layout = 'manager_view';
$this->assign('title', "View Customer Details");

?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    $backUrl,
    ['escape' => false, 'class' => 'btn btn-link']
) ?>
<div class="d-sm-flex align-items-center justify-content-between flex-wrap">
    <h3>Customer Details</h3>
    <div class="ml-auto">
        <?= $this->Html->link(__('Add Comments'), ['action' => 'addComments', $customer->id], ['class' => 'btn btn-secondary mr-2']) ?>
        <?= $this->Html->link(__('Edit Customer'), ['action' => 'edit', $customer->id], ['class' => 'd-sm-inline-block btn btn-primary']) ?>
    </div>
    <div class="d-block d-sm-none mb-3"></div>
</div>
<div class="row">
    <div class="col-sm-3">
        <b><?= __('Full name') ?></b>
        <p><?= h($customer->first_name) . ' ' . h($customer->last_name) ?></p>
        <b><?= __('Email') ?></b>
        <p><?= h($customer->email) ?></p>
    </div>
    <div class="col-sm-3">
        <b><?= __('Phone No') ?></b>
        <p><?= h($customer->phone_no) ?></p>
        <b><?= __('Discovery Source') ?></b>
        <?php if ($customer->hasValue('discovery_source_id')): ?>
            <p><?= h($customer->_matchingData['DiscoverySources']->name) ?></p>
        <?php else: ?>
            <p><i>No discovery source selected</i></p>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <b><?= __('Admin Comments') ?></b>
        <p>
            <?php if ($customer->admin_comments != null): ?>
                <?= $this->Text->autoParagraph(h($customer->admin_comments)); ?>
            <?php else: ?>
                <i>No comments</i>
            <?php endif; ?>
        </p>
    </div>
</div>

<hr>

<h4>Bookings</h4>
<?php if (!empty($customer->bookings)): ?>
    <div class="card mb-4 d-none d-md-block">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="bookingsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Location</th>
                            <th>Drop-off Date & Time</th>
                            <th>Services</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Assigned Contractor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customer->bookings as $booking): ?>
                            <tr>
                                <td class="text-center">
                                    <?= $this->Html->link(
                                        '<i class="fa fa-eye" aria-hidden="true"></i>',
                                        ['controller' => 'Bookings', 'action' => 'view', $booking->id, '?' => ['controller' => 'Customers', 'action' => 'view', 'id' => h($customer->id)]],
                                        [
                                            'escape' => false,
                                        ]
                                    ) ?>
                                </td>
                                <td><?= h($booking->location->name) ?></td>
                                <td><?= h($booking->dropoff_date->format('d/m/Y')) . ' ' . h($booking->dropoff_time->format('g:i A')) ?></td>
                                <td>
                                    <?php foreach ($bookingServices as $bookingService) : ?>
                                        <?php if ($bookingService->booking_id == $booking->id) : ?>
                                            <strong><?= h($bookingService->service->name) ?></strong><br>
                                            (<?= h($bookingService->service->category->name) ?>)<br>
                                            Quantity: <?= h($bookingService->service_qty) ?><br><br>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <?php if ($booking->due_date !== null): ?>
                                        <?= h($booking->due_date) ?><br>
                                    <?php endif; ?>
                                </td>
                                <td><?= h($booking->status->name) ?></td>

                                <?php if ($booking->user_id == null) : ?>
                                    <td><em>Unassigned</em></td>
                                <?php else: ?>
                                    <td><?= h($booking->user->first_name) . ' ' . h($booking->user->last_name) ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="d-block d-md-none">
        <?php foreach ($customer->bookings as $booking): ?>
            <div class="card mb-2">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h5><i class="fa fa-map-marker" aria-hidden="true"></i> <?= h($booking->location->name) ?><br></h5>
                        <div class="ml-auto">
                            <?= $this->Html->link(
                                '<i class="fa fa-eye" aria-hidden="true"></i>',
                                ['controller' => 'Bookings', 'action' => 'view', $booking->id],
                                ['escape' => false, 'class' => 'btn btn-primary btn-sm']
                            ) ?>
                        </div>
                    </div>
                    <p class="card-text">
                        <i class="fa fa-calendar-o" aria-hidden="true"></i> <?= h($booking->dropoff_date->format('d/m/Y')) . ' ' . h($booking->dropoff_time->format('g:i A')) ?><br>
                        <span class="badge badge-primary"><?= h($booking->status->name) ?></span><br>
                        <hr>
                        <?php foreach ($bookingServices as $bookingService) : ?>
                            <?php if ($bookingService->booking_id == $booking->id) : ?>
                                <?= h($bookingService->service_qty) ?> x <strong><?= h($bookingService->service->name) ?></strong> (<?= h($bookingService->service->category->name) ?>)<br>
                            <?php endif; ?>
                        <?php endforeach; ?><br>
                        <strong>Due Date:</strong>
                        <?php if ($booking->due_date !== null): ?>
                            <?= h($booking->due_date) ?><br>
                        <?php endif; ?>
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
<?php else: ?>
    <p>No bookings found for this customer.</p>
<?php endif; ?>

<?= $this->Html->script('/vendor/jquery/jquery.min.js') ?>
<?= $this->Html->script("/vendor/datatables/jquery.dataTables.min.js") ?>
<?= $this->Html->script("/vendor/datatables/dataTables.bootstrap4.min.js") ?>

<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#bookingsTable').DataTable({
            columnDefs: [{
                    targets: 0,
                    orderable: false
                },
                {
                    targets: -1, // Index of last column (Actions)
                    orderable: false // Disable sorting for this column
                }
            ],
            order: [
                [3, 'asc']
            ]
        });
    });
</script>