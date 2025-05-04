
Notification: New Pram Spa Booking Assigned to You!

Hi <?= h($first_name) ?>,

You have been assigned a new booking by one of the Pram Spa managers.

Please log in to the Pram Spa Admin Portal (https://booking.pramspa.au/admin) to view the new booking.
You can search for Booking ID: <?= h($booking_id) ?> in the Portal to see more details.


BOOKING DETAILS:
Booking ID: <?= h($booking_id) ?>

Location: <?= h($dropoff_loc) ?>

Address: <?= h($dropoff_address) ?>

Drop-off: <?= h($dropoff_date) . ' at ' . h($dropoff_time) ?>


CUSTOMER INFORMATION:
Name: <?= h($first_name) . ' ' . h($last_name) ?>



Services:
<?php foreach ($services as $service) : ?>
    - <?= h($service->category->name) ?>: <?= h($service->name) ?> (Qty: <?= h($bookingsServices[$service->id]->service_qty) ?>) - $<?= h($service->service_cost) ?> each
<?php endforeach; ?>

<?php if (!empty($products)): ?>
Products:
<?php foreach ($products as $product) : ?>
    - <?= h($product->name) ?> (Qty: <?= h($product->_joinData->product_qty) ?>) - $<?= h($product->product_cost) ?> each
    <?php endforeach; ?>
<?php endif; ?>


---

This email is addressed to <<?= h($email) ?>>.
Please discard this email if it's not meant for you.

Copyright © <?= date('Y'); ?> <?= $this->ContentBlock->text('website-title'); ?>