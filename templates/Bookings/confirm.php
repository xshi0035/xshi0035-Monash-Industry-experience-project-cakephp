<?php

$this->layout = 'bookings';
$this->assign("title", "Confirm Details");
$formattedDate = date('d/m/Y', strtotime($dropoffDate));
$formattedTime = date('h:i A', strtotime($dropoffTime));

?>
<div class="container-fluid">
    <div class="bookings confirm">
        <h2>Confirm your booking details</h2>

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

                <p><strong><?= __('Total Cost:') ?></strong> $<?= h($totalCost) ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-secondary" role="alert">
                    NOTE: If you have a discount code, please enter it in the next step after choosing 'Proceed to Payment'.
                </div>
                <?= $this->Form->create($booking) ?>
                <?= $this->Html->link(__('Go Back and Edit'), ['controller' => 'Customers', 'action' => 'add'], ['class' => 'btn btn-secondary']) ?>
                <?= $this->Form->button(__('Proceed to Payment'), ['class' => 'btn btn-primary']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
        <br>
    </div>
</div>