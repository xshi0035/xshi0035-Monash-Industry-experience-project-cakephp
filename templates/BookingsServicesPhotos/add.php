<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BookingsServicesPhoto $bookingsServicesPhoto
 * @var \Cake\Collection\CollectionInterface|string[] $bookingsServices
 * @var \Cake\Collection\CollectionInterface|string[] $photos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Bookings Services Photos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bookingsServicesPhotos form content">
            <?= $this->Form->create($bookingsServicesPhoto) ?>
            <fieldset>
                <legend><?= __('Add Bookings Services Photo') ?></legend>
                <?php
                    echo $this->Form->control('photo_type');
                    echo $this->Form->control('comments');
                    echo $this->Form->control('booking_service_id', ['options' => $bookingsServices]);
                    echo $this->Form->control('photo_id', ['options' => $photos, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
