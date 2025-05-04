<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PhotosProduct $photosProduct
 * @var string[]|\Cake\Collection\CollectionInterface $photos
 * @var string[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $photosProduct->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $photosProduct->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Photos Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="photosProducts form content">
            <?= $this->Form->create($photosProduct) ?>
            <fieldset>
                <legend><?= __('Edit Photos Product') ?></legend>
                <?php
                    echo $this->Form->control('photo_id', ['options' => $photos]);
                    echo $this->Form->control('product_id', ['options' => $products]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
