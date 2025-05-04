<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Photo> $photos
 */

$this->layout = 'manager_view';
$this->assign('title', "Bin");
?>
<h3 class="text-center"><?= __('Photos Bin') ?></h3>

<div class="table-responsive" style="max-width: 600px; margin: auto;">
    <table class="table" style="width: 100%;">
        <thead>
            <tr>
                <th class="text-center" style="width: 60%;">Photo</th>
                <th class="text-center" style="width: 40%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($photos as $photo): ?>
                <tr>
                    <td class="text-center align-middle">
                        <?= $this->Html->image($photo->path, ['width' => 150, 'height' => 150]) ?>
                        <br>
                        <?= h($photo->name) ?>
                    </td>
                    <td class="text-right align-middle">
                        <div class="btn-group">
                            <?= $this->Form->postButton(__('Delete'), ['action' => 'delete', $photo->id], ['class' => 'btn btn-delete', 'confirm' => __('Are you sure you want to permanently delete this photo?')]) ?>
                            <?= $this->Form->postButton(__('Restore'), ['action' => 'restore', $photo->id], ['class' => 'btn btn-primary', 'confirm' => __('Are you sure you want to restore this photo?')]) ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>