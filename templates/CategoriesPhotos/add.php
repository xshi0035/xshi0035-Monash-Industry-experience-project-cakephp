<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategoriesPhoto $categoriesPhoto
 * @var \Cake\Collection\CollectionInterface|string[] $categories
 * @var \Cake\Collection\CollectionInterface|string[] $photos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Categories Photos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="categoriesPhotos form content">
            <?= $this->Form->create($categoriesPhoto) ?>
            <fieldset>
                <legend><?= __('Add Categories Photo') ?></legend>
                <?php
                    echo $this->Form->control('cat_id', ['options' => $categories]);
                    echo $this->Form->control('photo_id', ['options' => $photos]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
