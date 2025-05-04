<?php

$this->layout = 'bookings';

$this->assign('title', 'Select Drop-Off Date/Time');
?>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-8">
            <div>
                <h2>Select a Drop-Off Date and Time</h2>
                <p>Please choose the time and date that suits you best.</p>
                <p>*Fields marked with an asterix are mandatory</p>
            </div>
            <?= $this->Form->create(null) ?>
            <fieldset>
                <!-- Select date  -->
                <div>
                    <i class="fa fa-calendar" id="calendar-icon"></i>
                    <input id="dropoff_date" name="dropoff_date" readonly />
                </div>

                <!-- Select time  -->
                <div>
                    <div class="date-info-box" style="border: 1px solid #ccc; padding: 10px; margin-top: 20px; width: max-content; display: flex; align-items: center;">
                        <i class="fa-regular fa-clock" style="margin-right: 8px;"></i>
                        <h6 id="date-info" style="margin: 0;">Select a time for <span id="selected-date">
                            <?= h($selectedDropoffDate ?? date("Y-m-d", strtotime("+1 day"))) ?>
                            </span></h6>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <p>Morning</p>
                            <div id="morning-options">
                                <?php if (empty($options['morning'])): ?>
                                    <div class="form-check">
                                        <b> No time slots available in the morning</b>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($options['morning'] as $option): ?>
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="dropoff_time"
                                                id="dropoff_time_<?= h($option) ?>"
                                                value="<?= h($option) ?>"
                                                required
                                                <?php if ($selectedDropoffTime === $option): ?>checked<?php endif; ?>>
                                            <label class="form-check-label" for="dropoff_time_<?= h($option) ?>">
                                                <?= h($option) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="col">
                            <p>Afternoon</p>
                            <div id="afternoon-options">
                                <?php if (empty($options['afternoon'])): ?>
                                    <div class="form-check">
                                        <b> No time slots available in the afternoon</b>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($options['afternoon'] as $option): ?>
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="dropoff_time"
                                                id="dropoff_time_<?= h($option) ?>"
                                                value="<?= h($option) ?>"
                                                required
                                                <?php if ($selectedDropoffTime === $option): ?>checked<?php endif; ?>>
                                            <label class="form-check-label" for="dropoff_time_<?= h($option) ?>">
                                                <?= h($option) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>

            </fieldset>
        </div>
        <div class="col-sm-4">
            <div class="card bg-light">
                <div class='card-body'>
                    <h3>Booking Summary</h3>
                    <label>Location: </label><?= ' ' . h($location->name) ?>
                    <hr>
                    <div id="booking-summary">
                        <!-- Summary will show here -->
                    </div>
                    <hr>
                    <label>Total Cost:</label>
                    <span style="float:right">$<?= h($totalCost) ?></span>
                </div>
            </div>
        </div>
    </div>

    <br>

    <?= $this->Html->link(__('Back'), ['action' => 'selectServices'], ['class' => 'btn btn-secondary', 'confirm' => __('Are you sure you want to go back? Going back to previous page will not save your current selection.')]) ?>
    <?= $this->Form->button(__('Next'), ['class' => 'btn btn-primary next-button']) ?>
    <?= $this->Form->end() ?>

</div>
<br>

<!-- For datepicker -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js">
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.0/themes/hot-sneaks/jquery-ui.min.css" integrity="sha512-oDaiKkgvaEO0CZX1jkpkjkC4XPPztbZ/Q3RBtWSQgrZlC2uFIci+1WpvfstzGpvIXYWRMNDdNDcgvmTiGwq2aA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
    $(document).ready(function() {
        let selectedServices = <?= json_encode($grouped_services) ?>;
        let selectedProducts = <?= json_encode($products_array) ?>;
        // Disable if without selection
        let selectedDropoffDate = <?= json_encode($selectedDropoffDate ?? '') ?>;
        let selectedDropOffTime = <?= json_encode($selectedDropoffTime ?? '') ?>;

        function loadSummary() {

            selectedServices.forEach((serviceGroup, index) => {
                let servicesHtml = '';

                // Loop through each service within a category instance
                serviceGroup.services.forEach(service => {
                    servicesHtml += `<div>${service.name} - $${service.cost}</div>`;
                });

                // Append list of category instances and services to summary
                $('#booking-summary').append(`
                    <div class="category-group">
                        <div class="service-item">
                            <div class="service-details">
                                <label>${serviceGroup.category}</label><br>
                                ${servicesHtml}
                            </div>
                        </div>
                    </div>
                `);
            });

            // Render products without category
            selectedProducts.forEach((product, index) => {
                $('#booking-summary').append(`
                    <div class="product-item">
                        <div>
                            <label>Product</label><br>
                            ${product.name} - $${product.cost}
                        </div>
                    </div>
                `);
            });
        }

        // update time options based on availabilities
        $('#dropoff_date').on('change', function() {
            selectedDropoffDate = $(this).val();
            selectedDropOffTime = '';

            if (selectedDropoffDate) {
                $('#date-info').text('Select a time for ' + selectedDropoffDate);

                let dateParts = selectedDropoffDate.split('-');
                let day = dateParts[0];
                let month = dateParts[1] - 1; // JavaScript months are 0-based
                let year = dateParts[2];

                // Create a new Date object
                let dateObject = new Date(year, month, day);
                let dayOfWeek = dateObject.getDay(); // Get the day of the week (0 = Sunday, ..., 6 = Saturday)

                // Retrieve availability data
                let availabilities = <?= json_encode($availabilities) ?>;

                // Initialize default start and end times
                let startEndTimes = [];

                // Get current date in yyyy-mm-dd format for comparison
                let currentDate = new Date();
                let currentDay = String(currentDate.getDate()).padStart(2, '0');
                let currentMonth = String(currentDate.getMonth() + 1).padStart(2, '0'); // JavaScript months are 0-based
                let currentYear = currentDate.getFullYear();
                let formattedCurrentDate = `${currentYear}-${currentMonth}-${currentDay}`;

                // Loop to find availability for the selected day of the week
                for (let avail in availabilities) {
                    if (availabilities[avail]['day_of_week'] == dayOfWeek) {
                        let startTime = availabilities[avail]['start_time'].slice(0, 5); // Removes the seconds
                        let endTime = availabilities[avail]['end_time'].slice(0, 5); // Removes the seconds

                        // Convert selected date to yyyy-mm-dd for comparison
                        let formattedSelectedDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                        // If the selected date is today, check if the current time is before the end time
                        if (formattedSelectedDate === formattedCurrentDate) {
                            let now = new Date(); // Current date and time object
                            let next;
                            let minutes = now.getMinutes();

                            // Calculate the next available 15-minute interval
                            if (minutes % 15 !== 0) {
                                let interval = 15 * 60 * 1000;
                                let last = now.getTime() - (now.getTime() % interval);
                                next = new Date(last + interval);
                            } else {
                                next = now;
                            }
                            next = next.getHours().toString().padStart(2, '0') + ":" + next.getMinutes().toString().padStart(2, '0');

                            if (next < endTime) {
                                // Adjust the start time to be the max between current time and the available start time
                                startTime = next > startTime ? next : startTime;

                                startEndTimes.push({
                                    start_time: startTime,
                                    end_time: endTime
                                });
                            }
                        } else {
                            // If not today, use the available start and end times
                            startEndTimes.push({
                                start_time: startTime,
                                end_time: endTime
                            });
                        }
                    }
                }

                // Generate new time options between start_time and end_time
                let options = {
                    morning: [],
                    afternoon: []
                };

                startEndTimes.forEach(timeRange => {
                    let generatedOptions = generateTimeOptions(timeRange.start_time, timeRange.end_time);
                    options.morning.push(...generatedOptions.morning);
                    options.afternoon.push(...generatedOptions.afternoon);
                });

                options.morning.sort(function(a, b) {
                    return a > b ? 1 : a < b ? -1 : 0;
                });

                options.afternoon.sort(function(a, b) {
                    return a > b ? 1 : a < b ? -1 : 0;
                });

                // Update morning and afternoon time options
                updateTimeOptions(options);
            }
            toggleNextButton();
        });

        // Function to generate time options in 15-minute intervals between startTime and endTime
        function generateTimeOptions(startTime, endTime) {
            let start = new Date('1970-01-01T' + startTime + ':00'); // Time format hh:mm
            let end = new Date('1970-01-01T' + endTime + ':00');

            let options = {
                morning: [],
                afternoon: []
            };

            let timeRange = (end - start) / (1000 * 60); // Time difference in minutes

            for (let i = 0; i <= timeRange; i += 15) { // 15-minute intervals
                let time = new Date(start.getTime() + i * 60000); // Add minutes to start time
                let formattedTime = time.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });

                let hours = time.getHours();
                if (hours < 12) {
                    options.morning.push(formattedTime);
                } else {
                    options.afternoon.push(formattedTime);
                }
            }

            return options;
        }

        function updateTimeOptions(options) {
            // Clear current options
            $('#morning-options').empty();
            $('#afternoon-options').empty();

            // Check if there are no morning or afternoon slots available
            if (options.morning.length === 0 && options.afternoon.length === 0) {
                $('#morning-options').append(`
                <div class="form-check">
                    <b> No time slots available in the morning</b>
                </div>
        `);

                $('#afternoon-options').append(`
                
            <div class="form-check">
                <b> No time slots available in the afternoon</b>
            </div>
        `);
                checkTimeSlotAvailability(); // Call after updating the options
                return;
            }

            // Populate morning options
            options.morning.forEach(function(option) {
                $('#morning-options').append(`
            <div class="form-check">
                <input class="form-check-input" type="radio" name="dropoff_time" id="dropoff_time_${option}" value="${option}">
                <label class="form-check-label" for="dropoff_time_${option}">${option}</label>
            </div>
        `);
            });

            // Populate afternoon options
            options.afternoon.forEach(function(option) {
                $('#afternoon-options').append(`
            <div class="form-check">
                <input class="form-check-input" type="radio" name="dropoff_time" id="dropoff_time_${option}" value="${option}">
                <label class="form-check-label" for="dropoff_time_${option}">${option}</label>
            </div>
        `);
            });
        }

        function checkTimeSlotAvailability() {
            let morningOptions = $('#morning-options input').length > 0;
            let afternoonOptions = $('#afternoon-options input').length > 0;

            if (morningOptions || afternoonOptions) {
                $('.next-button').prop('disabled', false); // Enable the "Next" button
            } else {
                $('.next-button').prop('disabled', true); // Disable the "Next" button
            }
        }

        // Date picker 
        let today = new Date();
        let initialDate = selectedDropoffDate ? new Date(selectedDropoffDate) : today;

        let disabledDateRanges = <?= json_encode($unavailableDays ?? '') ?>;
        let unavailableDays = <?= json_encode(array_values($unavailableDOW ?? [])) ?>;

        $('#dropoff_date').datepicker({
            constrainInput: true,
            dateFormat: 'dd-mm-yy',
            beforeShowDay: function(date) {
                var formattedDate = jQuery.datepicker.formatDate('yy-mm-dd', date);
                var dayOfWeek = date.getDay();

                // Check if the date is in disabledDateRanges or if the day of the week is unavailable
                if (disabledDateRanges.includes(formattedDate) || unavailableDays.includes(dayOfWeek)) {
                    return [false]; // Disable the date
                } else {
                    return [true]; // Enable the date
                }
            },
            minDate: "+1d",
            maxDate: "+3m",
            showOtherMonths: true,
            selectOtherMonths: true
        }).datepicker('setDate', initialDate);

        // When calendar icon is clicked, open datepicker
        $('#calendar-icon').click(function() {
            $('#dropoff_date').focus(); // Focus on the date input to open datepicker
        });

        // Function to toggle the "Next" button
        function toggleNextButton() {
            selectedDropoffDate = $('#dropoff_date').val();

            if (!selectedDropoffDate || !selectedDropOffTime) {
                $('.next-button').prop('disabled', true); // Disable if either is not selected
            } else {
                $('.next-button').prop('disabled', false); // Enable if both are selected
            }
        }

        // Event listener for time selection
        $(document).on('change', 'input[name="dropoff_time"]', function() {
            selectedDropOffTime = $(this).val();
            toggleNextButton();
        });

        toggleNextButton();

        loadSummary();
    });
</script>