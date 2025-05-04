<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */
$this->layout = 'manager_view';
$this->assign('title', "Bookings Summary");

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
    <h2>Booking Summary</h2>
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
                    'value' => $locationId,
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
                    'value' => $statusId,
                    'label' => false,
                    'class' => 'form-control'
                ]) ?>
            </div>

            <!-- Date Range Filter -->
            <div class="form-group col-md-6">
                <div class="d-flex flex-column flex-md-row">
                    <label for="dateRange" class="mb-0 mr-md-2 mb-1 mb-md-0">Date Range</label>
                    <!-- <small class="text-muted mb-0">(These dates filter the drop-off date of bookings.)</small> -->
                    <small class="text-muted mb-0">(These dates filter the bookings when they are booked.)</small>
                </div>
                <div class="form-row">

                    <!-- Start Date -->
                    <div class="form-group col-md-6">
                        <?= $this->Form->control('start_date', [
                            'type' => 'date',
                            'placeholder' => 'dd/mm/yyyy',
                            'value' => $start_date,
                            'label' => false,
                            'class' => 'form-control',
                            'aria-label' => 'Start Date'
                        ]) ?>
                        <small class="form-text text-muted">Start Date (Date Booked)</small>
                    </div>

                    <!-- End Date -->
                    <div class="form-group col-md-6">
                        <?= $this->Form->control('end_date', [
                            'type' => 'date',
                            'placeholder' => 'dd/mm/yyyy',
                            'value' => $end_date,
                            'label' => false,
                            'class' => 'form-control',
                            'aria-label' => 'End Date'
                        ]) ?>
                        <small class="form-text text-muted">End Date (Date Booked)</small>
                    </div>

                </div>
            </div>

        </div>

        <div class="form-row justify-content-end">
            <!-- Filter Button -->
            <div class="form-group mr-2">
                <?= $this->Form->button(__('Filter'), ['class' => 'btn btn-primary', 'style' => 'color: white']) ?>
            </div>

            <!-- Clear Filter Button -->
            <div class="form-group">
                <?= $this->Html->link(
                    __('Clear Filter'),
                    ['action' => 'bookingsSummary', '?' => ['clear' => 1]],
                    ['class' => 'btn btn-secondary']
                ) ?>
            </div>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<!-- Booking Summary Content -->
<div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Drop-off Date & Time</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Assigned Contractor</th>
                    <th>Services</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td>
                            <?= h($booking->date_booked->format('d/m/Y')) . ' ' . h($booking->date_booked->format('g:i A'))  ?
                                $this->Html->link(
                                    $booking->date_booked->format('d/m/Y') . ' ' . $booking->date_booked->format('g:i A'),
                                    ['controller' => 'Bookings', 'action' => 'view', $booking->id, '?' => ['controller' => 'Bookings', 'action' => 'bookingsSummary']]
                                ) : ''
                            ?>

                        </td>
                        <td>
                            <?= $booking->hasValue('customer') ?
                                $this->Html->link(
                                    $booking->customer->first_name . ' ' . $booking->customer->last_name,
                                    ['controller' => 'Customers', 'action' => 'view', $booking->customer->id, '?' => ['controller' => 'Bookings', 'action' => 'bookingsSummary']]
                                )
                                : ''
                            ?>
                        </td>
                        <td>
                            <?= $booking->hasValue('customer') ?
                                h($booking->customer->email) : ''
                            ?>
                        </td>
                        <td>
                            <?= $booking->hasValue('customer') ?
                                h($booking->customer->phone_no) : ''
                            ?>
                        </td>
                        <td><?= h($booking->location->name) ?></td>
                        <td><?= h($booking->status->name) ?></td>

                        <?php if ($booking->user_id == null) : ?>
                            <td><em>Unassigned</em></td>
                        <?php else: ?>
                            <td><?= h($users[$booking->user_id]->first_name) . ' ' . h($users[$booking->user_id]->last_name) ?></td>
                        <?php endif; ?>

                        <td>
                            <?php foreach ($booking->services as $service) : ?>
                                <ul class="pl-4">
                                    <li><strong><?= h($service->name) ?></strong><br>
                                        (<?= h($service->category->name) ?>)<br>
                                        Quantity: <?= h($service->_joinData->service_qty) ?></li>
                                    Cost per service: $<?= h($service->service_cost) ?><br><br>
                                </ul>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>