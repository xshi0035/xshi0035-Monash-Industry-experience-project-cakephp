<div>
    <!-- START MAIN CONTENT AREA -->

    <header style="background-color: #215D39; color: #fff; text-align: center; padding-top: 1rem; padding-bottom: 1rem;">
        <h1>Your Items are Ready for Pick Up</h1>
    </header>

    <p>Hi <?= h($first_name) ?>, </p>
    <p>Our staff have finished cleaning your items and they are now ready for pick up!</p>
    <p>Our customer service manager will get in touch with you shortly to confirm the time of your pick up.</p>

    <p>Please pick up your items from the following location:<br>
        <strong>Location: </strong><?= ' ' . h($dropoff_loc) ?><br>
        <strong>Address:</strong> <?= h($dropoff_address) ?>
    </p>

    <p>For your reference, your <strong>Booking ID: <?= h($booking_id) ?></strong></p>

    <p>Thank you for choosing Pram Spa.</p>
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