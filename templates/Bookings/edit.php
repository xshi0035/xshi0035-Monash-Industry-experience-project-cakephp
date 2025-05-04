<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 * @var string[]|\Cake\Collection\CollectionInterface $statuses
 * @var string[]|\Cake\Collection\CollectionInterface $customers
 * @var string[]|\Cake\Collection\CollectionInterface $locations
 * @var string[]|\Cake\Collection\CollectionInterface $products
 * @var string[]|\Cake\Collection\CollectionInterface $services
 */

if ($this->request->getSession()->read('Auth.role_id') == 2) {
    $this->layout = 'manager_view';
}

if ($this->request->getSession()->read('Auth.role_id') == 1) {
    $this->layout = 'admin_view';
}
$this->assign('title', "Edit Booking Details");
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    'javascript:history.back()',
    ['escape' => false, 'class' => 'btn btn-link']
)
?>


<h3><?= __('Edit Booking Details') ?></h3>
<hr>
<div class="row">
    <div class="col-sm-4">
        <?= $this->Form->create($booking) ?>
        <table class="table table-borderless table-sm">
            <tr>
                <th style="150px"><?= __('Booking ID') ?></th>
                <td><?= h($booking->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Customer') ?></th>
                <td><?= $booking->hasValue('customer') ? h($booking->customer->first_name . ' ' . $booking->customer->last_name) : '' ?></td>
            </tr>
            <tr>
                <th><?= __('Location') ?></th>
                <td>
                    <?php echo $this->Form->control('location_id', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $locations,
                        'label' => false,
                        'value' => $booking->location_id ?? null
                    ]); ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Drop-off Date*') ?></th>
                <td>
                    <i class="fa fa-calendar" id="calendar-icon"></i>
                    <input id="dropoff_date" name="dropoff_date" readonly />
                </td>
            </tr>
            <tr>
                <th><?= __('Drop-off Time*') ?></th>
                <td>
                    <div id="time-options">
                        <?php
                        echo $this->Form->control('dropoff_time', [
                            'type' => 'select',
                            'value' => $selectedDropoffTime,
                            'required' => true,
                            'class' => 'form-control',
                            'default' => false,
                            'options' => $options,
                            'label' => false
                        ]); ?>
                    </div>

                </td>
            </tr>
            <tr>
                <th><?= __('Total Cost') ?></th>
                <td>$<?= h($booking->total_cost) ?></td>
            </tr>
            <tr>
                <th><?= __('Date Paid') ?></th>
                <td><?= h($booking->date_paid) ?></td>
            </tr>
            <tr>
                <th><?= __('Date Booked') ?></th>
                <td><?= h($booking->date_booked) ?></td>
            </tr>
            <tr>
                <th>Assigned Contractor</th>
                <td>
                    <?php echo $this->Form->control('user_id', [
                        'type' => 'select',
                        'class' => 'form-control',
                        'options' => $users,
                        'label' => false,
                        'default' => $defaultContractor ?? null
                    ]); ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Status') ?></th>
                <td>
                    <?php echo $this->Form->control('status_id', [
                        'options' => $statuses,
                        'type' => 'select',
                        'class' => 'form-control',
                        'default' => $booking->status_id,
                        'label' => false
                    ]); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<br>

<?= $this->Html->link(__('Cancel'), 'javascript:history.back()', ['class' => 'btn btn-secondary']) ?>
<?= $this->Form->button(__('Save Changes'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>

<!-- For datepicker -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js">
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.0/themes/hot-sneaks/jquery-ui.min.css" integrity="sha512-oDaiKkgvaEO0CZX1jkpkjkC4XPPztbZ/Q3RBtWSQgrZlC2uFIci+1WpvfstzGpvIXYWRMNDdNDcgvmTiGwq2aA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
    var $j = jQuery.noConflict();

    $j(document).ready(function() {
        let selectedDropoffDate = <?= json_encode($selectedDropoffDate ?? '') ?>;
        let selectedDropOffTime = <?= json_encode($selectedDropoffTime ?? '') ?>;
        let availabilities = <?= json_encode($availabilities) ?>;

        // Match date with availabilities for time option
        // update time options based on availabilities
        $j('#dropoff_date').on('change', function() {
            selectedDropoffDate = $j(this).val();

            if (selectedDropoffDate) {
                let dateParts = selectedDropoffDate.split('-');
                let day = dateParts[0];
                let month = dateParts[1] - 1;
                let year = dateParts[2];

                // Create a new Date object
                let dateObject = new Date(year, month, day);
                let dayOfWeek = dateObject.getDay(); // Get the day of the week (0 = Sunday, ..., 6 = Saturday)

                // Retrieve availability data
                let options = [];

                // Loop to find availability for the selected day of the week
                for (let avail in availabilities) {
                    if (availabilities[avail]['day_of_week'] == dayOfWeek) {
                        let startTime = availabilities[avail]['start_time'].slice(0, 5);
                        let endTime = availabilities[avail]['end_time'].slice(0, 5);

                        // Convert start and end times to Date objects for easier manipulation
                        let startDate = new Date('1970-01-01T' + startTime + ':00');
                        let endDate = new Date('1970-01-01T' + endTime + ':00');

                        // Calculate the time range in minutes
                        let timeRange = (endDate - startDate) / 60000;

                        // Generate time slots in 15-minute intervals
                        for (let i = 0; i <= timeRange; i += 15) {
                            let newTime = new Date(startDate.getTime() + i * 60000);
                            let formattedTime = newTime.toTimeString().slice(0, 5);
                            options.push(formattedTime);
                        }

                        // Add the end time as the last option
                        options.push(endTime);
                    }
                }

                options.sort(function(a, b) {
                    return a > b ? 1 : a < b ? -1 : 0;
                });

                updateTimeOptions(options);
            }
        });

        function updateTimeOptions(options) {
            // Empty the existing time options
            $j('#time-options').empty();

            // Check if no time slots are available
            if (options.length === 0) {

                $j('#time-options').append(`
                <select name="dropoff_time" class="form-control" required disabled>
                    <option>No Time Slots Available</option>
                </select>
            `);
                return;
            }

            // Create a select element
            let selectElement = $('<select/>', {
                name: 'dropoff_time',
                class: 'form-control',
                required: true
            });

            // Loop through the provided options and add them as <option> elements
            options.forEach(function(option) {
                let optionElement = $('<option/>', {
                    value: option,
                    text: option
                });
                selectElement.append(optionElement);
            });

            // Append the select element to the 'time-options' div
            $j('#time-options').append(selectElement);
        }


        // Date picker 
        let today = new Date();
        let initialDate = selectedDropoffDate ? new Date(selectedDropoffDate) : today;

        let disabledDateRanges = <?= json_encode($unavailableDays ?? []) ?>;

        $j('#dropoff_date').datepicker({
            constrainInput: true,
            dateFormat: 'dd-mm-yy',
            beforeShowDay: function(date) {
                var string = $j.datepicker.formatDate('yy-mm-dd', date);
                return [disabledDateRanges.indexOf(string) == -1]
            },
            minDate: "-3m",   
            maxDate: "+3m",
            showOtherMonths: true,
            selectOtherMonths: true
        }).datepicker('setDate', initialDate);

        // When calendar icon is clicked, open datepicker
        $j('#calendar-icon').click(function() {
            $j('#dropoff_date').focus(); // Focus on the date input to open datepicker
        });

    });
</script>