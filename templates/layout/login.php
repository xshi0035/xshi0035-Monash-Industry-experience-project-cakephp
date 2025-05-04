<?php

/**
 * Login layout
 *
 * This layout comes with no navigation bar and Flash renderer placeholder. Usually used for login page or similar.
 *
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

$appLocale = Configure::read('App.defaultLocale');

$cakeDescription = $this->ContentBlock->text('website-title');
?>
<!DOCTYPE html>
<html lang="<?= $appLocale ?>">

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription . ": ",
        $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <?= $this->Html->css(['bootstrap.min.css']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body class="bg-light text-dark">
    <main class="d-flex align-items-center justify-content-center vh-100">
        <div class="container">
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
        <?= $this->element('footer_copyright', [], ['ignoreMissing' => true]); ?>

        <?= $this->fetch('footer_script') ?>
    </footer>
</body>

</html>