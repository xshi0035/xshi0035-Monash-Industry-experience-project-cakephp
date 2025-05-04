<?php
/**
 * @var \App\View\AppView $this
 * @var string $message
 * @var string $url
 */
use Cake\Core\Configure;

$this->layout = 'error';
$this->assign('title', 'Error 400 Encountered');

if (Configure::read('debug')) :
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.php');

    $this->start('file');
    echo $this->element('auto_table_warning');
    $this->end();
endif;
?>
<h1>Error 400: Bad Request</h1>

<div class="row">
    <div class="col-sm-8">
        <div>
            <h2>What does this mean?</h2>
            <p> It means that for some reason, your computer couldn't reach our website.</p>
        </div>

        <div class="card">
            <div class='card-body'>
                <h3 class="card-title"> There can be a few reasons why this may have happened:</h3>
                <p>1) You may be trying to access a page that might not exist (check the bar at the top).
                    <br>2) The site might be down, or your internet was disconnected.</p>
            </div>
        </div>

        <div class="card">
            <div class='card-body'>
                <h3 class="card-title"> How can you fix it?</h3>
                <p>1) Check the url bar again, maybe you misspelled something
                    <br>2) If you were filling out a form, check if you have filled out everything you need to.
                    <br>3) Try and refresh the page or try coming back later, the site might be down.
                    <br>4) If all else fails, try <?= $this->Html->link('contacting us', 'https://pramspa.com.au/contact-us/') ?>.

                </p>
            </div>
            <div class="form-group">
                <div class="p-3 bg-light rounded">
                    <strong><a href="<?= $this->ContentBlock->text('main-website-link'); ?>" target="_blank">CONTACT US</a></strong>
                    <p class = "mb-1">
                        Location: <?= $this->ContentBlock->text('location'); ?>
                    </p>
                    <p class="mb-1">
                        Email: <?= $this->ContentBlock->text('email'); ?>
                    </p>
                    <p class="mb-3">
                        Phone Number: <?= $this->ContentBlock->text('phone-number'); ?>
                    </p>
                    <p class="mb-1">
                        If you wish to cancel your booking, please <a href="<?= $this->ContentBlock->text('main-website-link'); ?>" target="_blank">contact us</a> within 24 hours before your scheduled drop off to avoid any cancellation fees.
                    </p>
                </div>
            </div>
        </div>


    </div>
</div>
<p class="error">
    <strong><?= __d('cake', 'Error') ?>: </strong>
    <?= __d('cake', 'The requested address {0} was not found on this server.', "<strong>'{$url}'</strong>") ?>
</p>
