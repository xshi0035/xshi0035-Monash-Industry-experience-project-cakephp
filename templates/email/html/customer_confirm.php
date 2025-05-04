<?php

/**
 * Confirm Customer Booking HTML email template
 *@var \App\View\AppView $this
 */
?>
<div>
    <!-- START MAIN CONTENT AREA -->

    <header style="background-color: #215D39; color: #fff; text-align: center; padding-top: 1rem; padding-bottom: 1rem;">
        <h1>Booking Confirmation with Pram Spa</h1>
    </header>

    <p>Hi <?= h($first_name) ?>, </p>
    <p>Thank you for booking with Pram Spa! We're delighted that you've chosen us to care for your baby gear.</p>
    <p>Our customer service agent will be in touch shortly to confirm your booking.</p>
    <div style="background-color: #f8f9fa; width:80%; padding:1rem;">
        <h2>Your details</h2>
        <p>
            <strong>Name: </strong><?= h($first_name) . ' ' . h($last_name) ?><br>
            <strong>Email: </strong><?= h($email) ?><br>
            <strong>Phone: </strong><?= h($phone_no) ?>
        </p>
        <h2>Booking summary</h2>
        <p>
            <strong>Booking ID: </strong><?= ' ' . h($booking_id) ?><br><br>
            <strong>Location: </strong><?= ' ' . h($dropoff_loc) ?><br>
            <strong>Address:</strong> <?= h($dropoff_address) ?><br>
            <strong>Drop-off: </strong><?= ' ' . h($dropoff_date) . ' at ' . h($dropoff_time) ?>
        </p>
        <h3>Services</h3>
        <table style="width: 40%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 0.3rem; border-bottom: 1px solid #000000; text-align: left;">Item</th>
                    <th style="padding: 0.3rem; border-bottom: 1px solid #000000; text-align: left;">Service</th>
                    <th style="padding: 0.3rem; border-bottom: 1px solid #000000; text-align: left;">Qty</th>
                    <th style="padding: 0.3rem; border-bottom: 1px solid #000000; text-align: left;">Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <th style="padding: 0.3rem; border: none; text-align: left;" scope="row"><?= h($service->category->name) ?></th>
                        <td style="padding: 0.3rem; border: none; text-align: left;"><?= h($service->name) ?></td>
                        <td style="padding: 0.3rem; border: none; text-align: left;"><?= h($service->quantity) ?></td>
                        <td style="padding: 0.3rem; border: none; text-align: left;">$<?= h($service->service_cost) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (!empty($products)): ?>
            <h3>Products</h3>
            <table style="width: 40%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 0.3rem; border-bottom: 1px solid #000000; text-align: left;">Product</th>
                        <th style="padding: 0.3rem; border-bottom: 1px solid #000000; text-align: left;">Qty</th>
                        <th style="padding: 0.3rem; border-bottom: 1px solid #000000; text-align: left;">Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td style="padding: 0.3rem; border: none; text-align: left;" scope="row"><?= h($product->name) ?></td>
                            <th style="padding: 0.3rem; border: none; text-align: left;"><?= h($product->quantity) ?></th>
                            <td style="padding: 0.3rem; border: none; text-align: left;">$<?= h($product->product_cost) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <br>
        <div style="width:15rem;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <th style="padding: 0.3rem; border-top: 1px solid #000000; text-align: left;">Subtotal</th>
                    <td style="padding: 0.3rem; border-top: 1px solid #000000; text-align: left;"><?= ' $' . h($total_cost) ?></td>
                </tr>
                <?php if ($discount_amt > 0): ?>
                    <tr>
                        <th style="padding: 0.3rem; border: none; text-align: left;">Discount</th>
                        <td style="padding: 0.3rem; border: none; text-align: left;"><?= ' -$' . h(number_format($discount_amt, 2, '.', '')) ?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th style="padding: 0.3rem; border: none; text-align: left;">GST (included)</th>
                    <td style="padding: 0.3rem; border: none; text-align: left;"><?= ' $' . h(number_format($tax_amt, 2, '.', '')) ?></td>
                </tr>
                <tr>
                    <th style="padding: 0.3rem; border: none; text-align: left;">Total paid</th>
                    <td style="padding: 0.3rem; border: none; text-align: left;"><b><?= ' $' . h(number_format($amount_paid, 2, '.', '')) ?></b></td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <hr>
    <p><b>NOTE:</b> <?= $this->ContentBlock->text('turnaround-time'); ?>
    </p>
    <p>Payment is due prior to the pick up of your baby gear.<br>
    <p><b>Name:</b> <?= $this->ContentBlock->text('website-title'); ?><br>
        <b>BSB:</b> <?= $this->ContentBlock->text('bsb-number'); ?><br>
        <b>Acc No:</b> <?= $this->ContentBlock->text('account-number'); ?>
    </p>
    <p>Thank you again for your booking.</p>
    <!-- END MAIN CONTENT AREA -->

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