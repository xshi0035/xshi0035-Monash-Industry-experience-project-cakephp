<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BookingsPhoto $bookingsPhoto
 * @var string[]|\Cake\Collection\CollectionInterface $bookings
 * @var string[]|\Cake\Collection\CollectionInterface $photos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $bookingsPhoto->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $bookingsPhoto->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Bookings Photos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bookingsPhotos form content">
            <?= $this->Form->create($bookingsPhoto) ?>
            <fieldset>
                <legend><?= __('Edit Bookings Photo') ?></legend>
                <?php
                    echo $this->Form->control('photo_type');
                    echo $this->Form->control('comments');
                    echo $this->Form->control('booking_id', ['options' => $bookings]);
                    echo $this->Form->control('photo_id', ['options' => $photos]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
