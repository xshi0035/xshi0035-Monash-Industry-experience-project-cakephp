<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location $location
 * @var \App\Model\Entity\Availability[] $availabilities
 */
$this->layout = 'manager_view';
$this->assign('title', "View Location");

$daysOfWeek = [
    0 => 'Sunday',
    1 => 'Monday',
    2 => 'Tuesday',
    3 => 'Wednesday',
    4 => 'Thursday',
    5 => 'Friday',
    6 => 'Saturday'
];

$groupedAvailabilities = [];
foreach ($availabilities as $availability) {
    $day = $availability->day_of_week;
    if (!isset($groupedAvailabilities[$day])) {
        $groupedAvailabilities[$day] = [];
    }
    $groupedAvailabilities[$day][] = $availability;
}
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    ['controller' => 'Locations', 'action' => 'index'],
    ['escape' => false, 'class' => 'btn btn-link']
) ?>
<div class="d-sm-flex align-items-center justify-content-between flex-wrap">
    <h3><?= h($location->name) . ' branch' ?></h3>
    <?php if ($location->status !== 'ARCHIVED'): ?>
        <?= $this->Html->link(__('Edit Location'), ['action' => 'edit', $location->id], ['class' => 'd-sm-inline-block btn btn-primary']) ?>
    <?php else: ?>
        <?= $this->Form->postLink(__('Unarchive'), ['action' => 'unarchive', $location->id], [
            'confirm' => __('Please confirm that you would like to unarchive this record of {0}', $location->name),
            'class' => 'd-sm-inline-block btn btn-info'
        ]) ?>
    <?php endif; ?>
    <div class="d-block d-sm-none mb-3"></div>
</div>
<div class="row">
    <div class="col-sm-5">
        <table class="table table-sm">
            <tr>
                <th><?= __('Address') ?></th>
                <td><?= h($location->st_address) . ', ' . h($location->suburb) . ', ' . h($location->state->abbr) . ' ' . h($location->postcode) ?></td>
            </tr>
            <tr>
                <th><?= __('Turnaround Time') ?></th>
                <td><?= h($location->turnaround) ?> days</td>
            </tr>
            <tr>
                <th><?= __('Status') ?></th>
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
            </tr>
        </table>
        <br>
        <h4><?= __('Contractors') ?></h4>
        <?php if (!empty($location->users)) : ?>
            <div class="table-responsive">
                <table class="table table-sm">
                    <tr>
                        <th><?= __('Name') ?></th>
                        <th><?= __('Email') ?></th>
                        <th><?= __('Phone No') ?></th>
                        <th><?= __('Role') ?></th>
                    </tr>
                    <?php foreach ($location->users as $user) : ?>
                        <tr>
                            <td><?= h($user->first_name) . ' ' . h($user->last_name) ?></td>
                            <td><?= h($user->email) ?></td>
                            <td><?= h($user->phone_no) ?></td>
                            <td><?= h($user->role->name) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php else : ?>
            <p><i>There are no staff currently assigned to this location.</i></p>
        <?php endif; ?>
        <br><br>
        <?php if ($location->status !== 'ARCHIVED'): ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0"><?= __('Rostered Unavailable Dates') ?></h4>
                <?= $this->Html->link('+ Add Unavailability', [
                    'controller' => 'Unavailabilities',
                    'action' => 'add',
                    '?' => ['location_id' => $location->id]
                ], ['class' => 'btn-link']) ?>
            </div>
            <?php if (!empty($location->unavailabilities)): ?>
                <table class="table table-sm">
                    <tr>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($location->unavailabilities as $unavailability): ?>
                        <tr>
                            <td><?= h($unavailability->start_date->format('d/m/Y')) ?></td>
                            <td><?= h($unavailability->end_date->format('d/m/Y')) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Unavailabilities', 'action' => 'edit', $unavailability->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), [
                                    'controller' => 'Unavailabilities',
                                    'action' => 'delete',
                                    $unavailability->id,
                                    '?' => ['location_id' => $location->id]
                                ], [
                                    'confirm' => __('Are you sure you want to delete this unavailability starting from {0} to {1}?', $unavailability->start_date->format('d/m/Y'), $unavailability->end_date->format('d/m/Y')),
                                    'escape' => false,
                                    'class' => 'text-danger'
                                ]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p><i>No rostered unavailabilities added for this location.</i></p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php if ($location->status !== 'ARCHIVED'): ?>
        <div class="col-sm-7">
            <div class="card mb-5">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="d-sm-flex align-items-center justify-content-between flex-wrap">
                            <h4>Operating Hours</h4>
                            <?= $this->Html->link(__('+ Add Availability Block'), ['controller' => 'Availabilities', 'action' => 'add', '?' => ['location_id' => $location->id]], ['class' => 'btn-link']) ?>
                            <div class="d-block d-sm-none mb-3"></div>
                        </div>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th><?= __('Day of Week') ?></th>
                                    <th><?= __('Start Time') ?></th>
                                    <th><?= __('End Time') ?></th>
                                    <th><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($availabilities)) : ?>
                                    <?php foreach ($availabilities as $availability) : ?>
                                        <tr>
                                            <!-- <td><?= h($availability->day_of_week) ?></td> -->
                                            <td><?= h($daysOfWeek[$availability->day_of_week]) ?></td>
                                            <td><?= h($availability->start_time) ?></td>
                                            <td><?= h($availability->end_time) ?></td>
                                            <td>
                                                <?= $this->Html->link(__('Edit'), ['controller' => 'Availabilities', 'action' => 'edit', $availability->id], ['class' => 'btn btn-sm btn-primary']) ?>
                                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Availabilities', 'action' => 'delete', $availability->id], ['confirm' => __('Are you sure you want to delete this availability?'), 'class' => 'btn btn-sm btn-danger']) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- <?php foreach ($groupedAvailabilities as $dayOfWeek => $dayAvailabilities): ?>
                                    <tr>
                                        <td><?= $daysOfWeek[$dayOfWeek] ?></td>
                                        <?php foreach ($dayAvailabilities as $availability): ?>
                                            <td><?= h($availability->start_time) ?></td>
                                            <td><?= h($availability->end_time) ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?> -->
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4"><i>There are currently no operating hours set for this location.</i></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>