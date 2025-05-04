<?php
/**
 * @var \App\View\AppView $this
 * @var string $message
 * @var string $url
 */
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';
$this->assign('title', 'Error 500 Encountered');


if (Configure::read('debug')) :
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.php');

    $this->start('file');
    ?>
    <?php if ($error instanceof Error) : ?>
    <?php $file = $error->getFile() ?>
    <?php $line = $error->getLine() ?>
    <strong>Error in: </strong>
    <?= $this->Html->link(sprintf('%s, line %s', Debugger::trimPath($file), $line), Debugger::editorUrl($file, $line)); ?>
<?php endif; ?>
    <?php
    echo $this->element('auto_table_warning');

    $this->end();
endif;
?>
<h1>Error 500: Internal Server Error</h1>

<div class="row">
    <div class="col-sm-8">
        <div>
            <h2>What does this mean?</h2>
            <p> It looks like <b>we</b> had an issue while you were trying to load the page. Our team is working on solving this issue as soon as possible.</p>
        </div>

        <div class="card">
            <div class='card-body'>
                <h3 class="card-title"> What can you do?</h3>
                <p>Unfortunately, not much. However, you can:
                    <br>1) Try refreshing the page.
                    <br>2) Come back later if it's still not working.
                </p>
            </div>
        </div>


        <div class="card">
            <div class='card-body'>
                <h3 class="card-title"> What now?</h3>
                <p>If you still need to get in touch with us, you can try contacting us.
                </p>
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
</div>

<p class="error">
    <strong><?= __d('cake', 'Error') ?>: </strong>
    <?= h($message) ?>
</p>
