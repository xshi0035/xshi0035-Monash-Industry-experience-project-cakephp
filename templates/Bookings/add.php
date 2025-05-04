<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 * @var \Cake\Collection\CollectionInterface|string[] $statuses
 * @var \Cake\Collection\CollectionInterface|string[] $customers
 * @var \Cake\Collection\CollectionInterface|string[] $locations
 * @var \Cake\Collection\CollectionInterface|string[] $products
 * @var \Cake\Collection\CollectionInterface|string[] $services
 */

$this->layout = 'manager_view';
$this->assign('title', "Create Booking");

?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Bookings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bookings form content">
            <?= $this->Form->create($booking) ?>
            <fieldset>
                <legend><?= __('Add Booking') ?></legend>
                <?php
                echo $this->Form->control('total_cost');
                echo $this->Form->control('dropoff_time');
                echo $this->Form->control('dropoff_date');
                echo $this->Form->control('status_id', ['options' => $statuses]);
                echo $this->Form->control('date_paid');
                echo $this->Form->control('date_booked');
                echo $this->Form->control('cust_id', ['options' => $customers]);
                echo $this->Form->control('products._ids', ['options' => $products]);
                echo $this->Form->control('services._ids', ['options' => $services]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
