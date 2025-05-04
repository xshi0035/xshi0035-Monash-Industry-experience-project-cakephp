<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategoriesPhoto $categoriesPhoto
 * @var string[]|\Cake\Collection\CollectionInterface $categories
 * @var string[]|\Cake\Collection\CollectionInterface $photos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $categoriesPhoto->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $categoriesPhoto->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Categories Photos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="categoriesPhotos form content">
            <?= $this->Form->create($categoriesPhoto) ?>
            <fieldset>
                <legend><?= __('Edit Categories Photo') ?></legend>
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
