<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Service $service
 * @var \Cake\Collection\CollectionInterface|string[] $categories
 * @var \Cake\Collection\CollectionInterface|string[] $bookings
 */
$this->layout = 'manager_view';
$this->assign('title', "Add Service");
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    'javascript:history.back()',
    ['escape' => false, 'class' => 'btn btn-link']
) ?>
<h3><?= __('Add Service') ?></h3>
<hr>
<div class="row">
    <div class="col-sm-5">
        <?= $this->Form->create($service) ?>
        <?php
        echo $this->Form->control('name', [
            'class' => 'form-group form-control',
            'label' => 'Name*',
            'required' => true,
            'placeholder' => 'Enter name',
            'pattern' => '[a-zA-Z\s -]+',
            'title' => 'Service name should only contain letters, hyphens and spaces.'
        ]);
        ?>
        <div class="row">
            <div class="col-sm-8">
                <?php
                echo $this->Form->control('cat_id', [
                    'class' => 'form-group form-control',
                    'options' => $categories,
                    'label' => 'Category*',
                    'required' => true,
                ]); ?>
            </div>
            <div class="col-sm-4">
                <label for="product_cost">Cost*</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <?php
                    echo $this->Form->input('service_cost', [
                        'class' => 'form-control',
                        'type' => 'number',
                        'step' => '0.01',
                        'min' => '0',
                        'max' => '500',
                        'required' => true,
                        'label' => false,
                        'placeholder' => '00.00'
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-secondary mt-3 mt-sm-0" role="alert">
                    If a service is not available at a certain location, you can specify that below. This will make sure customers cannot book this service at these locations.
                </div>
                <?php echo '<div class="form-group">';
                echo '<label>' . __('Unavailable at the following locations:') . '</label>'; ?>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="select-all-checkbox">
                    <b><label class="form-check-label" for="select-all-checkbox">Select All</label></b>
                </div>
                <?php
                foreach ($locations as $id => $name) {
                    echo '<div class="form-check">';
                    echo $this->Form->checkbox('locations._ids[]', [
                        'class' => 'form-check-input location-checkbox',
                        'value' => $id,
                        'hiddenField' => false,
                        // 'checked' => in_array($id, collection($service->locations)->extract('id')->toArray())
                    ]);
                    echo '<label class="form-check-label" for="locations-ids-' . $id . '">' . h($name) . '</label>';
                    echo '</div>';
                }
                echo '</div>'; ?>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
        <?php
        echo $this->Form->control('description', [
            'class' => 'form-group form-control',
            'type' => 'textarea',
            'label' => 'Description',
            'placeholder' => 'Enter description',
        ]);
        ?>
    </div>
</div>
<?= $this->Html->link(__('Cancel'), 'javascript:history.back()', ['class' => 'btn btn-secondary']) ?>
<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.location-checkbox');
        const selectAllCheckbox = document.getElementById('select-all-checkbox');

        // Function to handle Select All checkbox
        selectAllCheckbox.addEventListener('change', function() {
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        // Uncheck Select All if any location checkbox is unchecked
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (!checkbox.checked) {
                    selectAllCheckbox.checked = false; // Uncheck Select All
                } else {
                    // Check if all checkboxes are checked
                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked; // Check Select All if all are checked
                }
            });
        });

    });
</script>