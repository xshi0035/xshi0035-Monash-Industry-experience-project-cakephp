<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BookingsProduct $bookingsProduct
 * @var \Cake\Collection\CollectionInterface|string[] $bookings
 * @var \Cake\Collection\CollectionInterface|string[] $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Bookings Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bookingsProducts form content">
            <?= $this->Form->create($bookingsProduct) ?>
            <fieldset>
                <legend><?= __('Add Bookings Product') ?></legend>
                <?php
                    echo $this->Form->control('product_qty');
                    echo $this->Form->control('booking_id', ['options' => $bookings]);
                    echo $this->Form->control('product_id', ['options' => $products]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
