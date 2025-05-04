<?php

/**
 * Confirm Customer Booking TEXT email template
 * @var \App\View\AppView $this
 */
?>

Hi <?= h($first_name) ?>,

Thank you for booking with Pram Spa! We're delighted that you've chosen us to care for your baby gear.

Our customer service agent will be in touch shortly to confirm your booking.


YOUR DETAILS
Name: <?= h($first_name) . ' ' . h($last_name) ?>

Phone: <?= h($phone_no) ?>

Email: <?= h($email) ?>


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


----------------

NOTE: <?= $this->ContentBlock->text('turnaround-time'); ?>

Payment is due prior to the pick up of your baby gear.
Name: Pram Spa
BSB: <?= $this->ContentBlock->text('bsb-number'); ?>

Acc No: <?= $this->ContentBlock->text('account-number'); ?>


Thank you again for your booking.

---

This email is addressed to <<?= h($email) ?>>.
Please discard this email if it's not meant for you.

Copyright © <?= date('Y'); ?> <?= $this->ContentBlock->text('website-title'); ?>