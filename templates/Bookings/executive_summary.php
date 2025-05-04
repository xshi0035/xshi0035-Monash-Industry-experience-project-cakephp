<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */
$this->layout = 'manager_view';
$this->assign('title', "Executive Summary");

// Determine if any filters are active based on query parameters
$activeFilters = false;
$query = $this->request->getQuery();
if (
    !empty($query['location']) ||
    !empty($query['status']) ||
    !empty($query['month'])
) {
    $activeFilters = true;
}
?>

<!-- Toggle Button for Filter Form -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Executive Summary</h2>
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
            <div class="form-group col-md-4">
                <?= $this->Form->label('location', 'Location') ?>
                <?= $this->Form->control('location', [
                    'type' => 'select',
                    'options' => $locationOptions,
                    'empty' => 'All Locations',
                    'value' => $selectedLocationId,
                    'label' => false,
                    'class' => 'form-control'
                ]) ?>
            </div>

            <!-- Date Range Filter -->
            <div class="form-group offset-md-2 col-md-6">
                <div class="d-flex flex-column flex-md-row">
                    <label for="dateRange" class="mb-0 mr-md-2 mb-1 mb-md-0">Date Range</label>
                    <small class="text-muted mb-0">(These dates filter the drop-off date of bookings.)</small>
                </div>
                <div class="form-row">

                    <!-- Start Date Filter -->
                    <div class="form-group col-md-4">
                        <?= $this->Form->control('start_date', [
                            'type' => 'date',
                            'placeholder' => 'dd/mm/yyyy',
                            'value' => $selectedStartDate,
                            'label' => false,
                            'class' => 'form-control',
                        ]) ?>
                        <small class="form-text text-muted">Start Date (Date Paid)</small>
                    </div>

                    <!-- End Date Filter -->
                    <div class="form-group col-md-4">
                        <?= $this->Form->control('end_date', [
                            'type' => 'date',
                            'placeholder' => 'dd/mm/yyyy',
                            'value' => $selectedEndDate,
                            'label' => false,
                            'class' => 'form-control'
                        ]) ?>
                        <small class="form-text text-muted">End Date (Date Paid)</small>
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
                <?= $this->Html->link(__('Clear Filter'), ['action' => 'executiveSummary'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<!-- Information Summary -->
<div class="mb-4">
    <p><strong>Date Range:</strong> <?= date('d/m/Y', strtotime($selectedStartDate)) . '  to  ' . h(date('d/m/Y', strtotime($selectedEndDate))) ?></p>
    <p><strong>Location:</strong> <?= h($selectedLocation) ?></p>
    <p><strong>Staff:</strong> All staff</p>
    <p><strong>Booking Status:</strong> Completed </p>
</div>

<!-- Executive Summary Table -->
<h4>Location Peformance</h4>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Location Name</th>
                    <th>Total Customers</th>
                    <th>Total Bookings</th>
                    <th>Services Booked</th>
                    <th>Bookings Average Invoice ($AUD)</th>
                    <th>Total Discount Given ($AUD)</th>
                    <th>Invoice Total ($AUD)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($summary as $locationSummary): ?>
                    <tr>
                        <td>
                            <?= h($locationSummary['locationName'])  ?
                                $this->Html->link(
                                    h($locationSummary['locationName']),
                                    ['controller' => 'Bookings', 'action' => 'index', 'LOCATION', $locationSummary['locationId']]
                                )
                                : ''
                            ?>
                        </td>
                        <td><?= h($locationSummary['totalCustomers']) ?></td>
                        <td><?= h($locationSummary['totalBookings']) ?></td>
                        <td><?= h($locationSummary['totalServices']) ?></td>
                        <td><?=number_format((float)$locationSummary['avgInvoice'], 2, '.', '');?></td>
                        <td><?=number_format((float)$locationSummary['discountTotal'], 2, '.', '');?></td>
                        <td><?=number_format((float)$locationSummary['invoiceTotal'], 2, '.', '');?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>