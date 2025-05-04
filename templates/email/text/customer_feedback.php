<?php

/**
 * Customer Feedback TEXT Email content
 *
 */
?>

Hi <?= h($first_name) ?>,

Thank you for trusting Pram Spa with your baby gear! We hope you're delighted with the results.

We'd love to hear about your experience.
Leave us a review, and you'll have a chance to receive a FREE gift on your next booking with us!

Leave us a review here: https://g.page/pramspa/review?id

We appreciate your support and look forward to welcoming you back soon!


Warm regards,
The Pram Spa Team


---

This email is addressed to <<?= h($email) ?>>.
Please discard this email if it's not meant for you.

Copyright © <?= date('Y'); ?> <?= $this->ContentBlock->text('website-title'); ?>