<?php

/**
 * Customer Feedback HTML Email content
 *
 */
?>
<div class="content">
    <!-- START MAIN CONTENT AREA -->

    <header style="background-color: #215D39; color: #fff; text-align: center; padding-top: 1rem; padding-bottom: 1rem;">
        <h1>Thank you for choosing Pram Spa.</h1>
    </header>

    <p>Hi <?= h($first_name) ?>, </p>
    <p>Thank you for trusting Pram Spa with your baby gear! We hope you're delighted with the results.</p>
    <p>We'd love to hear about your experience.</p>
    <p><b>Leave us a review,</b> and you'll have a chance to <b>receive a FREE gift</b> on your next booking with us!</p>
    <a target="_blank" href="https://g.page/pramspa/review?id">
        <button style="
        display: inline-block;
        font-weight: 400;
        color: #1A181B;
        text-align: center;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: #78B090;
        border: 1px solid #78B090;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: .35rem;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        margin-right: 0.5rem;
        margin-bottom: 1rem;
        cursor: pointer;
    ">Leave us a review</button>
    </a>
    <p>We appreciate your support and look forward to welcoming you back soon!</p>
    <p>Warm regards,<br>
    The Pram Spa Team</p>
    <!-- END MAIN CONTENT AREA -->
    <br>
    <!-- START FOOTER -->
    <div style="padding: 10px 15px; background-color: #f5f5f5; border-top: 1px solid #ddd; text-align: center; font-size: 0.75rem;">
        <p>This email is addressed to &lt;<?= $email ?>&gt;<br>
            Please discard this email if it's not meant for you.
            <br>
            <br>
            Copyright &copy; <?= date("Y"); ?> <?= $this->ContentBlock->text('website-title'); ?>
        </p>
    </div>
    <!-- END FOOTER -->
</div>