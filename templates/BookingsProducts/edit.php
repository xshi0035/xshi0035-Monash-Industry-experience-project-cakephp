<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BookingsProduct $bookingsProduct
 * @var string[]|\Cake\Collection\CollectionInterface $bookings
 * @var string[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $bookingsProduct->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $bookingsProduct->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Bookings Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bookingsProducts form content">
            <?= $this->Form->create($bookingsProduct) ?>
            <fieldset>
                <legend><?= __('Edit Bookings Product') ?></legend>
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
