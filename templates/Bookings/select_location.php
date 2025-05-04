<?php

$this->layout = 'bookings';

$this->assign('title', 'Select Drop-Off Location');
// Load the Google Maps API key from the configuration
$googleMapsApiKey = \Cake\Core\Configure::read('App.googleMapsApiKey');
?>
<div class="container-fluid">
    <?php if (!empty($locations)): ?>
        <div class="row">
            <div class="col-sm-5">
                <h2>Select a Drop-Off Location</h2>
                <p>Please choose one of our locations to drop-off your prams and accessories.</p>
                <?= $this->Form->create(null, ['url' => ['action' => 'selectLocation']]) ?>

                <?php
                $isFirstLocation = true;
                foreach ($locations as $stateName => $locationsInState): ?>
                    <h3><?= h($stateName) ?></h3>
                    <?php foreach ($locationsInState as $location): ?>
                        <div class="form-check">
                            <?= $this->Form->input('location_id', [
                                'type' => 'radio',
                                'options' => [
                                    $location->id => h($location->st_address . ', ' . $location->suburb . ', ' . $location->postcode)
                                ],
                                'class' => 'form-check-input',
                                'id' => 'location_' . $location->id,
                                'checked' => ($selectedLocation == $location->id) || (empty($selectedLocation) && $isFirstLocation),
                                'label' => false,
                                'required' => true,
                                'data-lat' => h($location->latitude),
                                'data-lng' => h($location->longitude),
                                'data-address' => h($location->st_address . ', ' . $location->suburb . ', ' . $location->postcode) // Add address
                            ]) ?>
                            <label class="form-check-label" for="location_<?= $location->id ?>">
                                <?= h($location->name) ?>
                            </label>
                            <br>
                            <?= h($location->st_address . ', ' . $location->suburb . ', ' . $location->postcode) ?>
                        </div>
                        <?php $isFirstLocation = false; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>

                <br>
                <?= $this->Form->button(__('Next'), ['class' => 'btn btn-primary']) ?>
                <?= $this->Form->end() ?>
            </div>

            <div class="col-sm-7">
                <?php
                // Find the selected location or default to the first location
                $selectedAddress = '';
                $selectedLocationFound = false;
                foreach ($locations as $stateName => $locationsInState) {
                    foreach ($locationsInState as $location) {
                        if ($selectedLocation == $location->id) {
                            $selectedAddress = h($location->st_address . ', ' . $location->suburb . ', ' . $location->postcode);
                            $selectedLocationFound = true;
                            break 2; // Exit both loops when the selected location is found
                        }
                    }
                }
                // If no location is selected, use the first one
                if (!$selectedLocationFound) {
                    $firstState = array_key_first($locations);
                    $firstLocation = reset($locations[$firstState]);
                    $selectedAddress = h($firstLocation->st_address . ', ' . $firstLocation->suburb . ', ' . $firstLocation->postcode);
                }
                $mapSrc = "https://www.google.com/maps/embed/v1/place?key={$googleMapsApiKey}&q=" . urlencode($selectedAddress) . "&zoom=17";
                ?>
                <iframe id="map" src="<?= $mapSrc ?>" style="height:500px; width:100%;" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
        <br><br>
    <?php else: ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger" role="alert">
                    Sorry! There are no Pram Spa locations in operation at this time. Please check again later.
                </div>
                <?= $this->Html->link('Return Back to Home', 'https://pramspa.com.au/', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- JavaScript to Update Map on Selection Change -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const googleMapsApiKey = '<?= h($googleMapsApiKey) ?>';

        // Update the map when a location is selected
        document.querySelectorAll('input[name="location_id"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                var selectedAddress = this.getAttribute('data-address');
                var newSrc = 'https://www.google.com/maps/embed/v1/place?key=' + googleMapsApiKey + '&q=' + encodeURIComponent(selectedAddress) + '&zoom=17';
                document.getElementById('map').src = newSrc;
            });
        });
    });
</script>
