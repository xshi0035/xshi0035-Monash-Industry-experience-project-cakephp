<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */
$this->layout = 'manager_view';
$this->assign('title', "Monthly Summary");

// Determine if any filters are active based on query parameters
$activeFilters = false;
$query = $this->request->getQuery();
if (
    !empty($query['location']) ||
    !empty($query['financial_year'])
) {
    $activeFilters = true;
}
?>

<!-- Toggle Button for Filter Form -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Monthly Summary</h2>
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
                    'options' => $locations,
                    'empty' => 'All Locations',
                    'value' => $locationId,
                    'label' => false,
                    'class' => 'form-control'
                ]) ?>
            </div>

            <!-- Financial Year Filter -->
            <div class="form-group offset-md-2 col-md-4">
                <?= $this->Form->label('financial_year', 'Financial Year') ?>
                <?= $this->Form->control('financial_year', [
                    'type' => 'select',
                    'options' => $years,
                    'empty' => 'Select a year',
                    'value' => $financialYear,
                    'label' => false,
                    'class' => 'form-control'
                ]) ?>
            </div>

        </div>

        <div class="form-row justify-content-end">
            <!-- Filter Button -->
            <div class="form-group mr-2">
                <?= $this->Form->button(__('Filter'), ['class' => 'btn btn-primary']) ?>
            </div>

            <!-- Clear Filter Button -->
            <div class="form-group">
                <?= $this->Html->link(__('Clear Filter'), ['action' => 'monthlySummary'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<!-- Information Summary -->
<div class="mb-4">
    <p><strong>Financial Year:</strong> <?= h($financialYearVal) ?></p>
    <p><strong>Location:</strong> <?= h($selectedLocation) ?></p>
    <!-- <p><strong>Staff:</strong> All staff</p> -->
    <p><strong>Booking Status:</strong> All Statuses (except Cancelled Bookings) </p>
</div>

<!-- Monthly Summary Table -->
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Total Bookings</th>
                    <th>Services Booked</th>
                    <th>Bookings Average Invoice ($AUD)</th>
                    <th>Invoice Total ($AUD)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($summary as $monthlySummary): ?>
                    <tr>
                        <td>
                            <?= h($monthlySummary['month'][1])  ?
                            $this->Html->link(
                                h($monthlySummary['month'][1]),
                                    ['controller' => 'Bookings', 'action' => 'index', 'DATE', $monthlySummary['month'][0]]
                                )
                                : ''
                            ?>
                        </td>
                        <td><?= h($monthlySummary['totalBookings']) ?></td>
                        <td><?= h($monthlySummary['totalServices']) ?></td>
                        <td><?=number_format((float)$monthlySummary['avgInvoice'], 2, '.', '');?></td>
                        <td><?=number_format((float)$monthlySummary['invoiceTotal'], 2, '.', '');?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
