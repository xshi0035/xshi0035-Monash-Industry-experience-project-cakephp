<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 * @var \Cake\Collection\CollectionInterface|string[] $discoverySources
 */

$this->layout = 'bookings';

$this->assign('title', 'Customer Details');
?>
<div class="container-fluid">

    <div class="row">
        <div class="col-sm-8">
            <div>
                <h2>Enter your details</h2>
                <p>*Fields marked with an asterix are mandatory</p>
            </div>
            <div class="row">
                <div class="col-sm-9">
                    <?= $this->Form->create($customer) ?>
                    <fieldset>
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                echo $this->Form->control('first_name', [
                                    'class' => 'form-control',
                                    'label' => 'First name*',
                                    'value' => $inputFirstName,
                                    'required' => true,
                                    'pattern' => '[a-zA-Z\s -]+',
                                    'title' => 'First name should only contain letters and spaces.'
                                ]); ?>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                echo $this->Form->control('last_name', [
                                    'class' => 'form-control',
                                    'label' => 'Last name*',
                                    'value' => $inputLastName,
                                    'required' => true,
                                    'pattern' => '[a-zA-Z\s -]+',
                                    'title' => 'last name should only contain letters and spaces.'
                                ]); ?>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->control('email', [
                            'class' => 'form-control',
                            'label' => 'Email address*',
                            'value' => $inputEmail,
                            'required' => true,
                            'type' => 'email',
                            'placeholder' => 'test@example.com',
                            'title' => 'Please enter a valid email address.'
                        ]); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                echo $this->Form->control('phone_no', [
                                    'class' => 'form-control',
                                    'label' => 'Phone number*',
                                    'value' => $inputPhone,
                                    'required' => true,
                                    'placeholder' => '0XXXXXXXXX',
                                    'pattern' => '^(0)[0-9]{9}$',
                                    'title' => 'Please enter a valid Australian phone number. It should start with 0 and be followed by 9 digits.'
                                ]); ?>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                echo $this->Form->control('discovery_source_id', [
                                    'options' => $discoverySources,
                                    'label' => 'Where did you first hear about us?*',
                                    'class' => 'form-select',
                                    'required' => true,
                                    'value' => $inputDiscSrc
                                ]); ?>
                            </div>
                        </div>
                        <label for="privacy-policy">Please read and agree to our Privacy Policy:</label>
                        <div class="card">
                            <div class="overflow-auto" style="max-height: 200px;">
                                <p><?= $this->ContentBlock->html('privacy-policy'); ?></p>
                            </div>
                        </div>
                        <div>
                            <input
                                type="checkbox"
                                name="privacy_policy"
                                class="form-check-input"
                                required="true" />
                            <label
                                class="form-check-label">
                                <!-- <p>I have read and agree to Pram Spa's <?= $this->Html->link(__('privacy policy'), ['controller' => 'Bookings', 'action' => 'privacyPolicy'], ['target' => '_blank']) ?>*</p> -->
                                <p>I have read and agree to Pram Spa's privacy policy above*</p>
                            </label>
                        </div>
                        <div class="form-group">
                            <div class="p-3 bg-light rounded">
                                <?= $this->ContentBlock->html('cancellation-policy'); ?>
                                <div class="form-check">
                                    <input
                                        type="hidden"
                                        name="cancellation_policy_id"
                                        value="0" />
                                    <input
                                        type="checkbox"
                                        name="cancellation_policy_id"
                                        class="form-check-input"
                                        value="1"
                                        id="cancellation_policy_id"
                                        required="true" />
                                    <label
                                        class="form-check-label"
                                        for="cancellation_policy_id">
                                        I agree
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="p-3 bg-light rounded">
                                <?= $this->ContentBlock->html('terms-conditions'); ?>

                                <div class="form-check">

                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        required="true" />
                                    <label
                                        class="form-check-label">
                                        I understand this T&Cs disclaimer
                                    </label>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                </div>
                <div class="col-sm-3">
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card bg-light">
                <div class='card-body'>
                    <h3>Booking Summary</h3>
                    <label>Location: </label><?= ' ' . h($location->name) ?><br>
                    <label>Drop-off: </label><?= ' ' . h($formattedDate) . ', ' . h($formattedTime) ?>
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

    <?= $this->Html->link(__('Back'), ['controller' => 'Bookings', 'action' => 'selectDropoffTime'], ['class' => 'btn btn-secondary', 'confirm' => __('Are you sure you want to go back? Going back to previous page will not save your current selection.')]) ?>
    <?= $this->Form->button(__('Next'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>

</div>
<br>

<?= $this->Html->script('/webroot/vendor/jquery/jquery.min.js') ?>
<script>
    $(document).ready(function() {
        let selectedServices = <?= json_encode($grouped_services) ?>;
        let selectedProducts = <?= json_encode($products_array) ?>;

        function loadSummary() {

            selectedServices.forEach((serviceGroup, index) => {
                let servicesHtml = '';

                // Loop through each service within a category instance
                serviceGroup.services.forEach(service => {
                    servicesHtml += `<div>${service.name} - $${service.cost}</div>`;
                    // totalCost += parseFloat(service.cost);
                });

                // Append category instance and services to booking summary
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

        loadSummary();
    });
</script>