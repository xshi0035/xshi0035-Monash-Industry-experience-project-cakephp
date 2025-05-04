<?php

$this->layout = 'bookings';

$this->assign('title', 'Select Services');
?>
<div class="container-fluid">
    <div class="bookings form content">
        <?= $this->Form->create(null, ['url' => ['action' => 'selectServices']]) ?>

        <!-- Hidden field for total cost, serviceIds, and array of selected services -->
        <?= $this->Form->hidden('total_cost', ['id' => 'total-cost-input']) ?>
        <?= $this->Form->hidden('services_array', ['id' => 'services-array']) ?>
        <?= $this->Form->hidden('grouped_services', ['id' => 'services-grouped-by-cat']) ?>
        <?= $this->Form->hidden('products_array', ['id' => 'products-array']) ?>

        <div class="row">
            <div class="col-sm-8">
                <div class="d-flex align-items-center justify-content-between">
                    <h2>Select Services</h2>
                    <!-- <button class="btn btn-primary btn-filter" type="button" data-bs-toggle="collapse" data-bs-target="#filterForm" aria-controls="filterForm">
                        <i class="fa fa-filter" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline">&nbsp;Filter</span>
                    </button> -->
                </div>
                <p>Please choose your desired cleaning services depending on the type of pram or accessory you have.</p>

                <!-- <div class="collapsed mb-4" id="filterForm">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            // Convert Collection to array
                            $servicesArray = $services->toArray();

                            // Extract unique categories
                            $uniqueCategories = array_unique(array_merge(array_keys($servicesArray), ['Products']));

                            foreach ($uniqueCategories as $category): ?>
                                <div class="form-check me-3">
                                    <input type="checkbox" class="form-check-input category-checkbox" value="<?= h($category) ?>" id="filter_<?= h($category) ?>">
                                    <label class="form-check-label" for="filter_<?= h($category) ?>"><?= h($category) ?></label>
                                </div>
                            <?php endforeach; ?>
                            <button type="button" class="btn btn-primary apply-filter">Apply Filter</button>
                            <button type="button" class="btn btn-secondary clear-filter">Clear Filter</button>
                        </div>
                    </div>
                </div> -->

                <!-- Display Services -->
                <?php foreach ($services as $categoryName => $servicesInCategory): ?>
                    <div class="card">
                        <div class='card-body'>
                            <h3 class="card-title"><?= h($categoryName) ?></h3>
                            <div class="d-flex flex-wrap">
                                <?php foreach ($servicesInCategory as $service): ?>
                                    <div class="me-2 mb-2">
                                        <input
                                            type="checkbox"
                                            name="service_ids[]"
                                            value="<?= h($service->id) ?>"
                                            class="btn-check btn-service"
                                            id="service_<?= h($service->id) ?>"
                                            data-name="<?= h($service->name) ?>"
                                            data-description="<?= h($service->description) ?>"
                                            data-cost="<?= h($service->service_cost) ?>"
                                            data-category="<?= h($categoryName) ?>" />
                                        <label
                                            class="btn btn-outline-primary"
                                            for="service_<?= h($service->id) ?>"
                                            style="cursor: pointer;">
                                            <?= h($service->name) . ' <b>$' . h($service->service_cost) . '</b>' ?>
                                        </label>
                                        <div class="service-description" id="description_<?= h($service->id) ?>" style="display:none; margin-top:10px;">
                                            <!-- Service description will be shown here -->
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="btn btn-primary add-to-booking" style="float:right; display:none;" data-category="<?= h($categoryName) ?>" data-type="service">Add to Booking</button>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- Display Products -->
                <div class="card mb-3">
                    <div class='card-body'>
                        <h3 class="card-title">Products</h3>
                        <p>Purchase any aftercare products with your booking and receive them when you drop off/pick up your items.</p>
                        <div class="d-flex flex-wrap">
                            <?php foreach ($grouped_products['Products'] as $product): ?>
                                <div class="me-2 mb-2">
                                    <input
                                        type="checkbox"
                                        name="product_ids[]"
                                        value="<?= h($product->id) ?>"
                                        class="btn-check btn-product"
                                        id="product_<?= h($product->id) ?>"
                                        data-name="<?= h($product->name) ?>"
                                        data-description="<?= h($product->description) ?>"
                                        data-cost="<?= h($product->product_cost) ?>"
                                        data-category="Products" />
                                    <label
                                        class="btn btn-outline-dark"
                                        for="product_<?= h($product->id) ?>"
                                        style="cursor: pointer;">
                                        <?= h($product->name) . ' <b>$' . h($product->product_cost) . '</b>' ?>
                                    </label>
                                    <div class="product-description" id="prodDescription_<?= h($product->id) ?>" style="display:none; margin-top:10px;">
                                        <!-- Product description will be shown here -->
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-primary add-product" style="float:right; display:none;" data-category="Products" data-type="product">Add</button>
                    </div>
                </div>
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
                        <div id="total-cost" style="float:right">
                            <!-- Total cost printed here -->
                        </div>
                        <br>
                        <button id="remove-all" class="btn btn-outline-danger" style="float:right; margin-top:1rem">Remove All</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->Html->link(__('Back'), ['action' => 'selectLocation'], ['class' => 'btn btn-secondary back-button', 'confirm' => __('Are you sure you want to go back? Going back to previous page will not save your current selection.')]) ?>
    <?= $this->Form->button(__('Next'), ['class' => 'btn btn-primary next-button']) ?>
    <?= $this->Form->end() ?>
</div>

<br>

<?= $this->Html->script('/webroot/vendor/bootstrap.bundle.min.js') ?>
<?= $this->Html->script('/webroot/vendor/jquery/jquery.min.js') ?>

<script>
    $(document).ready(function() {
        // Initially hide all "Add to Booking" buttons
        $('.add-to-booking, .add-product').hide();

        let selectedServices = <?= json_encode($grouped_services) ?>;
        let productsToAdd = <?= json_encode($products_array) ?>;
        let totalCost = 0;

        function updateSummary() {
            $('#booking-summary').empty();
            totalCost = 0;

            if (selectedServices.length > 0) {

                selectedServices.forEach((serviceGroup, index) => {
                    let servicesHtml = '';

                    // Loop through each service within a service group (category instance)
                    serviceGroup.services.forEach(service => {
                        servicesHtml += `<div>${service.name} - $${service.cost}</div>`;
                        totalCost += parseFloat(service.cost);
                    });

                    // Append the category instance and services with a remove button
                    $('#booking-summary').append(`
                        <div class="category-group">
                            <div class="service-item">
                                <div class="service-details">
                                    <label>${serviceGroup.category}</label><br>
                                    ${servicesHtml}
                                </div>
                                <button class="btn btn-secondary remove-category" data-index="${index}">X</button>
                            </div>
                        </div>
                    `);
                });
            };

            // Render products without category
            productsToAdd.forEach((product, index) => {
                $('#booking-summary').append(`
                    <div class="product-item">
                        <div>
                            <label>Product</label><br>
                            ${product.name} - $${product.cost}
                        </div>
                        <button class="btn btn-secondary remove-product" data-index="${index}">X</button>
                    </div>
                `);
                totalCost += parseFloat(product.cost);
            });

            $('#total-cost').text('$' + totalCost.toFixed(2));
            $('#total-cost-input').val(totalCost.toFixed(2)); // Update hidden field with total cost

            // Update the hidden field with selected service IDs
            const serviceIds = selectedServices.flatMap(serviceGroup => serviceGroup.services.map(service => service.id)).join(',');
            $('#service-ids-input').val(serviceIds.replace(/,$/, ''));

            if (selectedServices.length + productsToAdd.length > 1) {
                $('#remove-all').show();
            } else {
                $('#remove-all').hide();
            }

            updateNextButtonState();
        }

        function generateUniqueId() {
            return 'item_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        }

        function updateNextButtonState() {
            if (selectedServices.length > 0) {
                $('.next-button').prop('disabled', false);
            } else {
                $('.next-button').prop('disabled', true);
            }
        }

        $('.add-to-booking').on('click', function() {
            let categoryName = $(this).data('category');
            let servicesToAdd = [];

            // Iterate only over checkboxes within the same category
            $(this).closest('.card-body').find('.btn-service:checked').each(function() {
                let serviceId = $(this).val();
                let serviceName = $(this).data('name');
                let serviceCost = $(this).data('cost');

                servicesToAdd.push({
                    uniqueId: generateUniqueId(),
                    id: serviceId,
                    name: serviceName,
                    cost: serviceCost,
                    category: categoryName
                });

                // Uncheck and trigger change event
                $(this).closest('.card-body').find('.btn-service:checked').each(function() {
                    $(this).prop('checked', false).trigger('change');
                });

                // Uncheck after adding service(s) to booking
                $(this).prop('checked', false);

                // Hide description after unchecking
                $('#description_' + serviceId).slideUp();
            });

            // Add selected services as a new instance for the category
            if (servicesToAdd.length > 0) {
                selectedServices.push({
                    category: categoryName,
                    services: servicesToAdd
                });
            }

            // Reset all buttons to be enabled
            $('.btn-check').prop('disabled', false);

            updateSummary();
        });

        $('.add-product').on('click', function() {
            let productsToAddTemp = [];

            // Iterate only over checkboxes within the same category
            $(this).closest('.card-body').find('.btn-product:checked').each(function() {
                let productId = $(this).val();
                let producteName = $(this).data('name');
                let productCost = $(this).data('cost');

                productsToAdd.push({
                    uniqueId: generateUniqueId(),
                    id: productId,
                    name: producteName,
                    cost: productCost
                });

                console.log(productsToAdd);

                // Uncheck and trigger change event
                $(this).closest('.card-body').find('.btn-product:checked').each(function() {
                    $(this).prop('checked', false).trigger('change');
                });

                // Uncheck after adding service(s) to booking
                $(this).prop('checked', false);

                // Hide description after unchecking
                $('#prodDescription_' + productId).slideUp();
            });

            // Add selected products to the productsToAdd array
            if (productsToAddTemp.length > 0) {
                productsToAdd.push(...productsToAddTemp);
            }

            // Reset all buttons to be enabled
            $('.btn-check').prop('disabled', false);

            updateSummary();
        });

        $('#booking-summary').on('click', '.remove-category', function() {
            let index = $(this).data('index');

            // Remove selected category instance by its index
            selectedServices.splice(index, 1);

            updateSummary();
        });

        $('#booking-summary').on('click', '.remove-product', function() {
            let index = $(this).data('index');

            // Remove selected product by its index
            productsToAdd.splice(index, 1);

            updateSummary();
        });

        $('.next-button, .back-button').on('click', function() {
            // Flatten selectedServices to contain only array of service objects
            const flatServicesArray = selectedServices.flatMap(serviceGroup => serviceGroup.services);

            const flatProductsArray = productsToAdd;

            // Convert flattened array to JSON string and store it in hidden input
            $('#services-array').val(JSON.stringify(flatServicesArray));
            $('#services-grouped-by-cat').val(JSON.stringify(selectedServices));

            $('#products-array').val(JSON.stringify(flatProductsArray));
        });

        $('#remove-all').on('click', function(e) {
            e.preventDefault(); // Makes sure it doesn't trigger POST request
            selectedServices = [];
            productsToAdd = [];

            updateSummary();
        });

        // Show description when service is clicked/checked
        $('.btn-service').on('change', function() {
            let serviceId = $(this).val();
            let serviceDescription = $(this).data('description');
            let serviceName = $(this).data('name').toLowerCase();
            let category = $(this).data('category');
            let isChecked = $(this).is(':checked');

            if (isChecked && serviceDescription.trim() !== '') {
                $('#description_' + serviceId).html(serviceDescription).slideDown();
            } else {
                $('#description_' + serviceId).slideUp();
            }

            // Disable or enable the opposite package in the same category
            if (serviceName.includes('premium')) {
                if (isChecked) {
                    $(`.btn-service[data-category="${category}"]`).each(function() {
                        if ($(this).data('name').toLowerCase().includes('basic')) {
                            $(this).prop('disabled', true);
                        }
                    });
                } else {
                    $(`.btn-service[data-category="${category}"]`).each(function() {
                        if ($(this).data('name').toLowerCase().includes('basic')) {
                            $(this).prop('disabled', false);
                        }
                    });
                }
            } else if (serviceName.includes('basic')) {
                if (isChecked) {
                    $(`.btn-service[data-category="${category}"]`).each(function() {
                        if ($(this).data('name').toLowerCase().includes('premium')) {
                            $(this).prop('disabled', true);
                        }
                    });
                } else {
                    $(`.btn-service[data-category="${category}"]`).each(function() {
                        if ($(this).data('name').toLowerCase().includes('premium')) {
                            $(this).prop('disabled', false);
                        }
                    });
                }
            }

            // Show or hide the "Add to Booking" button based on selection
            let anyChecked = $(`.btn-service[data-category="${category}"]:checked`).length > 0;
            if (anyChecked) {
                $(`.add-to-booking[data-category="${category}"]`).show();
            } else {
                $(`.add-to-booking[data-category="${category}"]`).hide();
            }
        });


        // Show description when service is clicked/checked
        $('.btn-product').on('change', function() {
            let productId = $(this).val();
            let productDescription = $(this).data('description');
            let category = $(this).data('category');
            let isChecked = $(this).is(':checked');

            if (isChecked) {
                $('#prodDescription_' + productId).html(productDescription).slideDown();
            } else {
                $('#prodDescription_' + productId).slideUp();
            }

            // Show or hide the "Add" button based on selection
            let anyChecked = $(`.btn-product[data-category="${category}"]:checked`).length > 0;
            if (anyChecked) {
                $(`.add-product[data-category="${category}"]`).show();
            } else {
                $(`.add-product[data-category="${category}"]`).hide();
            }
        });


        // Initial update of the summary on page load
        updateSummary();
    });
</script>