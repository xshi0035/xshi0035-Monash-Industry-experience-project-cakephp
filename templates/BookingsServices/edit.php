<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BookingsService $bookingsService
 * @var string[]|\Cake\Collection\CollectionInterface $bookings
 * @var string[]|\Cake\Collection\CollectionInterface $services
 * @var string[]|\Cake\Collection\CollectionInterface $photos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $bookingsService->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $bookingsService->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Bookings Services'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bookingsServices form content">
            <?= $this->Form->create($bookingsService) ?>
            <fieldset>
                <legend><?= __('Edit Bookings Service') ?></legend>
                <?php
                    echo $this->Form->control('service_qty');
                    echo $this->Form->control('booking_id', ['options' => $bookings]);
                    echo $this->Form->control('service_id', ['options' => $services]);
                    echo $this->Form->control('photos._ids', ['options' => $photos]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
