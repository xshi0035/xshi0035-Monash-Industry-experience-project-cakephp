<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Service $service
 */
$this->layout = 'manager_view';
$this->assign('title', "View Service");
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    ['Controller' => 'Services', 'action' => 'index'],
    ['escape' => false, 'class' => 'btn btn-link']
) ?>

<div class="d-sm-flex align-items-center justify-content-between flex-wrap">
    <h3>Service Details</h3>
    <?= $this->Html->link(__('Edit Service'), ['action' => 'edit', $service->id], ['class' => 'd-sm-inline-block btn btn-primary']) ?>
    <div class="d-block d-sm-none mb-3"></div>
</div>
<div class="row">
    <div class="col-sm-5">
        <table class="table table-borderless table-sm">
            <tr>
                <th><?= __('Name') ?></th>
                <td><?= h($service->name) ?></td>
            </tr>
            <tr>
                <th><?= __('Category') ?></th>
                <td><?= h($service->category->name) ?></td>
            </tr>
            <tr>
                <th><?= __('Cost') ?></th>
                <td>$<?= $this->Number->format($service->service_cost) ?></td>
            </tr>
            <tr>
                <th><?= __('Description') ?></th>
                <td>
                    <?php if ($service->hasValue('description')): ?>
                        <?= $this->Text->autoParagraph(h($service->description)); ?>
                    <?php else: ?>
                        <i>No description</i>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-sm-4">
        <b>Unavailable at:</b>
        <?php if (!empty($service->locations)) : ?>
            <ul>
                <?php foreach ($service->locations as $location) : ?>
                    <li>
                        <?= h($location->name) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p><i>This service is made available at all locations.</i></p>
        <?php endif; ?>
    </div>
</div>