<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategoriesPhoto $categoriesPhoto
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Categories Photo'), ['action' => 'edit', $categoriesPhoto->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Categories Photo'), ['action' => 'delete', $categoriesPhoto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categoriesPhoto->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Categories Photos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Categories Photo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="categoriesPhotos view content">
            <h3><?= h($categoriesPhoto->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= $categoriesPhoto->hasValue('category') ? $this->Html->link($categoriesPhoto->category->name, ['controller' => 'Categories', 'action' => 'view', $categoriesPhoto->category->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Photo') ?></th>
                    <td><?= $categoriesPhoto->hasValue('photo') ? $this->Html->link($categoriesPhoto->photo->description, ['controller' => 'Photos', 'action' => 'view', $categoriesPhoto->photo->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($categoriesPhoto->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
