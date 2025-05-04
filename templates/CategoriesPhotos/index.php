<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\CategoriesPhoto> $categoriesPhotos
 */
?>
<div class="categoriesPhotos index content">
    <?= $this->Html->link(__('New Categories Photo'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Categories Photos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('cat_id') ?></th>
                    <th><?= $this->Paginator->sort('photo_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categoriesPhotos as $categoriesPhoto): ?>
                <tr>
                    <td><?= $this->Number->format($categoriesPhoto->id) ?></td>
                    <td><?= $categoriesPhoto->hasValue('category') ? $this->Html->link($categoriesPhoto->category->name, ['controller' => 'Categories', 'action' => 'view', $categoriesPhoto->category->id]) : '' ?></td>
                    <td><?= $categoriesPhoto->hasValue('photo') ? $this->Html->link($categoriesPhoto->photo->description, ['controller' => 'Photos', 'action' => 'view', $categoriesPhoto->photo->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $categoriesPhoto->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $categoriesPhoto->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $categoriesPhoto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categoriesPhoto->id)]) ?>
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
