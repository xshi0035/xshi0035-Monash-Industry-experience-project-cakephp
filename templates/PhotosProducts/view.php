<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PhotosProduct $photosProduct
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Photos Product'), ['action' => 'edit', $photosProduct->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Photos Product'), ['action' => 'delete', $photosProduct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $photosProduct->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Photos Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Photos Product'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="photosProducts view content">
            <h3><?= h($photosProduct->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Photo') ?></th>
                    <td><?= $photosProduct->hasValue('photo') ? $this->Html->link($photosProduct->photo->description, ['controller' => 'Photos', 'action' => 'view', $photosProduct->photo->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $photosProduct->hasValue('product') ? $this->Html->link($photosProduct->product->name, ['controller' => 'Products', 'action' => 'view', $photosProduct->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($photosProduct->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
