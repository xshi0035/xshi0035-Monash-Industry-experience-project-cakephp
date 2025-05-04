<div class="content">
    <!-- START MAIN CONTENT AREA -->

    <header style="background-color: #215D39; color: #fff; text-align: center; padding-top: 1rem; padding-bottom: 1rem;">
        <h1>New Pram Spa Booking Assigned to You!</h1>
    </header>

    <p>Hi <?= h($first_name) ?>, </p>
    <p>You have been assigned a new booking by one of the Pram Spa managers.</p>
    <p>Please log in to the <a href="https://booking.pramspa.au/admin" target="_blank">Pram Spa Admin Portal</a> to view the new booking.</p>
    <p>You can search for <strong>Booking ID: <?= h($booking_id) ?></strong> in the Portal to see more details.</p>
    <div style="background-color: #f8f9fa; width:80%; padding:1rem;">
        <h2>Booking details</h2>
        <strong>Booking ID: </strong><?= ' ' . h($booking_id) ?><br><br>
        <strong>Location: </strong><?= ' ' . h($dropoff_loc) ?><br>
        <strong>Address:</strong> <?= h($dropoff_address) ?><br>
        <strong>Drop-off: </strong><?= ' ' . h($dropoff_date) . ' at ' . h($dropoff_time) ?>
        <br><br>
        <h3>Services</h3>
        <table style="width: 40%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 0.3rem; border-bottom: 1px solid #000000; text-align: left;">Item</th>
                    <th style="padding: 0.3rem; border-bottom: 1px solid #000000; text-align: left;">Service</th>
                    <th style="padding: 0.3rem; border-bottom: 1px solid #000000; text-align: left;">Qty</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <th style="padding: 0.3rem; border: none; text-align: left;" scope="row"><?= h($service->category->name) ?></th>
                        <td style="padding: 0.3rem; border: none; text-align: left;"><?= h($service->name) ?></td>
                        <td style="padding: 0.3rem; border: none; text-align: left;"><?= h($bookingsServices[$service->id]->service_qty) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (!empty($products)): ?>
            <br>
            <h3>Products</h3>
            <table style="width: 40%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 0.3rem; border-bottom: 1px solid #000000; text-align: left;">Product</th>
                        <th style="padding: 0.3rem; border-bottom: 1px solid #000000; text-align: left;">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td style="padding: 0.3rem; border: none; text-align: left;" scope="row"><?= h($product->name) ?></td>
                            <th style="padding: 0.3rem; border: none; text-align: left;"><?= h($product->_joinData->product_qty) ?></th>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <br>
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