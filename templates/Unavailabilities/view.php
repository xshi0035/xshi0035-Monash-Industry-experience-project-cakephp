<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Unavailability $unavailability
 */
$this->layout = 'manager_view';
$this->assign('title', 'View Unavailability');
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    ['controller' => 'Unavailabilities', 'action' => 'index'],
    ['escape' => false, 'class' => 'btn btn-link']
) ?>

<div class="d-sm-flex align-items-center justify-content-between flex-wrap">
    <h3>Unavailability Details</h3>
    <?= $this->Html->link(
        __('Edit Unavailability'),
        ['action' => 'edit', $unavailability->id],
        ['class' => 'd-sm-inline-block btn btn-primary']
    ) ?>
    <div class="d-block d-sm-none mb-3"></div>
</div>

<table class="table table-sm">
    <tr>
        <th><?= __('Location') ?></th>
        <td>
            <?= $unavailability->has('location') ? 
                $this->Html->link(
                    h($unavailability->location->name),
                    ['controller' => 'Locations', 'action' => 'view', $unavailability->location->id]
                ) : 'N/A' ?>
        </td>
    </tr>
    <tr>
        <th><?= __('Start Date') ?></th>
        <td><?= $unavailability->start_date ? h($unavailability->start_date->format('Y-m-d')) : 'N/A' ?></td>
    </tr>
    <tr>
        <th><?= __('End Date') ?></th>
        <td><?= $unavailability->end_date ? h($unavailability->end_date->format('Y-m-d')) : 'N/A' ?></td>
    </tr>
    <!-- <tr>
        <th><?= __('ID') ?></th>
        <td><?= $this->Number->format($unavailability->id) ?></td>
    </tr> -->
</table>
