<?php

$this->layout = 'pages';
$this->assign('title', 'Booking Confirmed');

$formattedDate = date('d/m/Y', strtotime($dropoffDate));
$formattedTime = date('h:i A', strtotime($dropoffTime));
?>
<div class="container-fluid">
    <div class="bookings confirm">
        <h1 class="text-center">Thanks for your payment</h1>
        <p class="text-center">Your booking has been successfully confirmed. A detailed confirmation email and payment receipt have been sent to your inbox.</p>


        <h2>Your booking details summary</h2>

        <hr>
        <div class="row">
            <div class="col-sm-5">
                <h3>Customer details</h3>
                <p><strong><?= __('Name:') ?></strong> <?= h($customer->first_name) . ' ' . h($customer->last_name) ?></p>
                <p><strong><?= __('Email:') ?></strong> <?= h($customer->email) ?></p>
                <p><strong><?= __('Phone number:') ?></strong> <?= h($customer->phone_no) ?></p>
                <h3>Drop off details</h3>
                <p><strong><?= __('Location:') ?></strong> <?= h($location->name) ?></p>
                <p><strong><?= __('Address:') ?></strong> <?= h($location->st_address) . ', ' . h($location->suburb) . ' ' . h($location->state->abbr) . ' ' . h($location->postcode) ?></p>
                <p><strong><?= __('Date and time:') ?></strong> <?= h($formattedDate) . ' at ' . h($formattedTime) ?></p>
            </div>
            <div class="col-sm-7">
                <h3>Selected services</h3>
                <ul>
                    <?php foreach ($services as $service): ?>
                        <li><?= h($service->quantity) ?>x <b><?= h($service->name) ?></b> ($<?= h($service->service_cost) ?> each)</li>
                    <?php endforeach; ?>
                </ul>
                <?php if (!empty($products)) : ?>
                    <h3>Selected products</h3>
                    <ul>
                        <?php foreach ($products as $product): ?>
                            <li><?= h($product->quantity) ?>x <b><?= h($product->name) ?></b> ($<?= h($product->product_cost) ?> each)</li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <h3>Cost details</h3>
                <p><strong><?= __('Total Cost:') ?></strong> $<?= h($totalCost) ?></p>
                <?php if ($discount_amount > 0): ?>
                    <p><strong><?= __('Discount Applied:') ?></strong> -$<?= h(number_format($discount_amount, 2, '.', '')) ?></p>
                <?php endif; ?>
                <p><strong><?= __('GST (included):') ?></strong> $<?= h(number_format($tax_amount, 2, '.', '')) ?></p>
                <p><strong><?= __('Final Amount Paid:') ?> $<?= h(number_format($amount_paid, 2, '.', '')) ?></strong></p>
            </div>
        </div>

        <hr>
        <div class="form-group">
            <div class="p-3 bg-light rounded">
                <strong><a href="<?= $this->ContentBlock->text('main-website-link'); ?>" target="_blank">CONTACT US</a></strong>
                <p class="mb-1">
                    <b>Location:</b> <?= $this->ContentBlock->text('location'); ?>
                </p>
                <p class="mb-1">
                    <b>Email:</b> <?= $this->ContentBlock->text('email'); ?>
                </p>
                <p class="mb-3">
                    <b>Phone Number:</b> <?= $this->ContentBlock->text('phone-number'); ?>
                </p>
                <p class="mb-1">
                    If you wish to cancel your booking, please <a href="<?= $this->ContentBlock->text('main-website-link'); ?>" target="_blank">contact us</a> within 24 hours before your scheduled drop off to avoid any cancellation fees.
                </p>
            </div>
        </div>
        <br>
        <?= $this->Html->link('Back to Home', 'https://pramspa.com.au/', ['class' => 'btn btn-primary']) ?>
        <br>
        <br>

    </div>
</div>