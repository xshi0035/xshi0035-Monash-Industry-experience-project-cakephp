<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Photo> $photos
 */
?>
<div class="photos index content">
    <?= $this->Html->link(__('New Photo'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Photos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('path') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($photos as $photo): ?>
                <tr>
                    <td><?= $this->Number->format($photo->id) ?></td>
                    <td><?= h($photo->name) ?></td>
                    <td><?= h($photo->path) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $photo->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $photo->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $photo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $photo->id)]) ?>
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
