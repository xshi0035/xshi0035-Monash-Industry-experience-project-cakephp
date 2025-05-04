Your Items are Ready for Pick Up! | Pram Spa

Hi <?= h($first_name) ?>,

Our staff have finished cleaning your items and they are now ready for pick up!

Please pick up your items from the following location:
Location: </strong><?= ' ' . h($dropoff_loc) ?>

Address: <?= h($dropoff_address) ?>


For your reference, your Booking ID: <?= h($booking_id) ?>.


Thank you for choosing Pram Spa.


---

This email is addressed to <<?= h($email) ?>>.
Please discard this email if it's not meant for you.

Copyright © <?= date('Y'); ?> <?= $this->ContentBlock->text('website-title'); ?>