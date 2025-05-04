<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PhotosProduct> $photosProducts
 */
?>
<div class="photosProducts index content">
    <?= $this->Html->link(__('New Photos Product'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Photos Products') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('photo_id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($photosProducts as $photosProduct): ?>
                <tr>
                    <td><?= $this->Number->format($photosProduct->id) ?></td>
                    <td><?= $photosProduct->hasValue('photo') ? $this->Html->link($photosProduct->photo->description, ['controller' => 'Photos', 'action' => 'view', $photosProduct->photo->id]) : '' ?></td>
                    <td><?= $photosProduct->hasValue('product') ? $this->Html->link($photosProduct->product->name, ['controller' => 'Products', 'action' => 'view', $photosProduct->product->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $photosProduct->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $photosProduct->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $photosProduct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $photosProduct->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
