New Customer Booking Received

A new Pram Spa booking was made by: <?= h($first_name) . ' ' . h($last_name) ?>.

Please log in to the Pram Spa Admin Portal (https://booking.pramspa.au/admin) to view the new booking.
You can search for <strong>Booking ID: <?= h($booking_id) ?></strong> in the Portal to see more details.

CUSTOMER INFORMATION
To contact the customer, please see their details below:
- Name: <?= h($first_name) . ' ' . h($last_name) ?>

- Email: <?= h($email) ?>

- Phone: <?= h($phone_no) ?>


BOOKING SUMMARY:
Location: <?= h($dropoff_loc) ?>

Address: <?= h($dropoff_address) ?>

Drop-off: <?= h($dropoff_date) ?> at <?= h($dropoff_time) ?>


Services:
<?php foreach ($services as $service) : ?>
    - <?= h($service->category->name) ?>: <?= h($service->name) ?> (Qty: <?= h($service->quantity) ?>) - $<?= h($service->service_cost) ?> each
<?php endforeach; ?>

<?php if (!empty($products)): ?>
Products:
<?php foreach ($products as $product) : ?>
    - <?= h($product->name) ?> (Qty: <?= h($product->quantity) ?>) - $<?= h($product->product_cost) ?> each
    <?php endforeach; ?>

<?php endif; ?>
Subtotal: $<?= h($total_cost) ?>

<?php if ($discount_amt > 0): ?>
Discount: -$<?= h(number_format($discount_amt, 2, '.', '')) ?>

<?php endif; ?>
GST (included): $<?= h(number_format($tax_amt, 2, '.', '')) ?>

Total paid: $<?= h(number_format($amount_paid, 2, '.', '')) ?>


---

This email is addressed to <info@pramspa.com.au>.
Please discard this email if it's not meant for you.

Copyright © <?= date('Y'); ?> <?= $this->ContentBlock->text('website-title'); ?>