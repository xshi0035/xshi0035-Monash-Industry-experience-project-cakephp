<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PhotosProduct $photosProduct
 * @var \Cake\Collection\CollectionInterface|string[] $photos
 * @var \Cake\Collection\CollectionInterface|string[] $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Photos Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="photosProducts form content">
            <?= $this->Form->create($photosProduct) ?>
            <fieldset>
                <legend><?= __('Add Photos Product') ?></legend>
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
