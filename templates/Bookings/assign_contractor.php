<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 */

$this->layout = 'manager_view';
$this->assign('title', "View Booking");
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    'javascript:history.back()',
    ['escape' => false, 'class' => 'btn btn-link']
) ?>
<div class="row">
    <div class="col-sm-6">
        <h3>Assign Contractor</h3>
        <?php echo $this->Form->create($booking, ['url' => ['action' => 'assignContractor', $booking->id]]); ?>
        <table class="table table-sm">
            <tr>
                <th><?= __('Booking ID') ?></th>
                <td><?= h($booking->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Customer') ?></th>
                <td><?= h($booking->customer->first_name . ' ' . $booking->customer->last_name) ?></td>
            </tr>
            <tr>
                <th><?= __('Location') ?></th>
                <td>
                    <b><?= h($booking->location->name) ?> branch</b>
                    <br>
                    <?= h($booking->location->st_address) . ', ' . h($booking->location->suburb) . ', ' . h($booking->location->state->abbr) . ' ' . h($booking->location->postcode) ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Drop-off Date and Time') ?></th>
                <td><?= h($booking->dropoff_date) . ' at ' . h($booking->dropoff_time) ?></td>
            </tr>
            <tr>
                <th><?= __('Contractor') ?></th>
                <td>
                    <div class="row">
                        <?php if (!empty($users)): ?>
                            <div class="col-sm-8">
                                <?php echo $this->Form->control('user_id', [
                                    'type' => 'select',
                                    'options' => $users,
                                    'label' => false,
                                    'class' => 'form-control'
                                ]); ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $this->Form->button(__('Save'), ['class' => 'btn btn-primary mt-2 mt-sm-0']) ?>
                            </div>
                        <?php else: ?>
                            <div class="col-sm-12">
                                No contractors currently assigned to this location.
                            </div>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        </table>
        <br>
        <?= $this->Form->end() ?>

        <br>
    </div>
    <div class="col-sm-6">
        <div class="card card-body">
            <?php if (!empty($booking->services)) : ?>
                <h4><?= __('Required Services') ?></h4>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tr>
                            <th><?= __('Service') ?></th>
                            <th><?= __('Quantity') ?></th>
                        </tr>
                        <?php foreach ($booking->services as $service) : ?>
                            <tr>
                                <td><?= h($service->name) . ' (' . h($service->category->name) . ')' ?></td>
                                <td><?= h($service->_joinData->service_qty) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
            <?php if (!empty($booking->products)) : ?>
                <h4><?= __('Products Purchased') ?></h4>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tr>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Quantity') ?></th>
                        </tr>
                        <?php foreach ($booking->products as $product) : ?>
                            <tr>
                                <td><?= h($product->name) ?></td>
                                <td><?= h($product->_joinData->product_qty) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>