<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location $location
 * @var string[]|\Cake\Collection\CollectionInterface $states
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
$this->layout = 'manager_view';
$this->assign('title', "Edit Location");
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    'javascript:history.back()',
    ['escape' => false, 'class' => 'btn btn-link']
) ?>

<h2><?= __('Add Location') ?></h2>
<hr>
<div class="row">
    <div class="col-sm-12">
        <h3><?= __('Location Details') ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-5">
        <div class="locations form content">
            <?= $this->Form->create($location) ?>
            <?= $this->Form->hidden('form_type', ['value' => 'location']) ?>
            <!-- <h3><?= __('Location Details') ?></h3> -->
            <?php
            echo $this->Form->control('name', [
                'class' => 'form-group form-control',
                'type' => 'text',
                'label' => 'Name*',
                'required' => true,
                'placeholder' => 'Enter location name',
                'pattern' => '[a-zA-Z\s -]+',
                'title' => 'Location name should only contain letters, spaces and hyphens.'
            ]);
            ?>
            <?php
            echo $this->Form->control('st_address', [
                'class' => 'form-group form-control',
                'label' => 'Street Address*',
                'required' => true,
                'placeholder' => 'Enter street address'
            ]);
            ?>
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    echo $this->Form->control('suburb', [
                        'class' => 'form-group form-control',
                        'label' => 'Suburb*',
                        'required' => true,
                        'placeholder' => 'Enter suburb'
                    ]);
                    ?>
                </div>
                <div class="col-sm-3">
                    <?php
                    echo $this->Form->control('state_id', [
                        'class' => 'form-group form-control',
                        'label' => 'State*',
                        'options' => $states,
                        'required' => true
                    ]);
                    ?>
                </div>
                <div class="col-sm-3">
                    <?php
                    echo $this->Form->control('postcode', [
                        'class' => 'form-group form-control',
                        'label' => 'Postcode*',
                        'required' => true,
                        'pattern' => '[0-9]{4}',
                        'title' => 'Please enter a valid 4-digit postcode.',
                        'placeholder' => 'Enter postcode'
                    ]);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="turnaround">Turnaround Time*</label>
                        <div class="input-group">
                            <?php
                            echo $this->Form->input('turnaround', [
                                'class' => 'form-control',
                                'type' => 'number',
                                'label' => false,
                                'placeholder' => '0',
                                'min' => '1',
                                'required' => true
                            ]);
                            ?>
                            <div class="input-group-append">
                                <span class="input-group-text">days</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <?= $this->Form->control('status', [
                            'class' => 'form-control',
                            'label' => 'Status*',
                            'required' => true,
                            'options' => [
                                'OPERATIONAL' => 'In Operation',
                                'TEMPCLOSED' => 'Temporarily Closed'
                            ]
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <p><b>For map view on Customer Bookings page:</b></p>
        <div class="row mt-3">
                <div class="col-sm-12">
                    <?= $this->Html->link(
                        'Open Google Maps',
                        'https://www.google.com/maps',
                        ['class' => 'btn btn-info', 'target' => '_blank']
                    ) ?>
                </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('latitude', [
                    'class' => 'form-group form-control',
                    'label' => 'Latitude*',
                    'required' => true,
                    'pattern' => '-?\d{1,3}\.\d+',
                    'title' => 'Please enter a valid latitude between -90 and 90.',
                    'placeholder' => 'Enter latitude',
                    'min' => '-90',
                    'max' => '90',
                    'step' => 'any'
                ]);
                ?>
            </div>
            <div class="col-sm-6">
                <?php
                echo $this->Form->control('longitude', [
                    'class' => 'form-group form-control',
                    'label' => 'Longitude*',
                    'required' => true,
                    'pattern' => '-?\d{1,3}\.\d+',
                    'title' => 'Please enter a valid longitude between -180 and 180.',
                    'placeholder' => 'Enter longitude',
                    'min' => '-180',
                    'max' => '180',
                    'step' => 'any'
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->link(__('Cancel'), 'javascript:history.back()', ['class' => 'btn btn-secondary']) ?>
<?= $this->Form->button(__('Save Changes'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>
<br><br>