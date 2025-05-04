<?php


use Cake\Core\Configure;

$appLocale = Configure::read('App.defaultLocale');

$cakeDescription = $this->ContentBlock->text('website-title');
?>

<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->Html->meta('icon') ?>

    <!-- Include Bootstrap CSS from the webroot folder -->
    <?= $this->Html->css('bootstrap.min.css') ?>

    <script src="https://kit.fontawesome.com/dc286b156c.js" crossorigin="anonymous"></script>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <title>
        <?= $cakeDescription . ": ",
        $this->fetch('title') ?>
    </title>
</head>

<body class="d-flex flex-column min-vh-100">

<br>

<main class="container flex-fill">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>

    <?= $this->Html->link(__('Return to make a booking'), ['controller' => 'Bookings', 'action' => 'selectLocation']) ?>
    <br><b>or</b><br>
    <?= $this->Html->link('Return to Pram Spa home page', 'https://pramspa.com.au/') ?>


</main>

<?= $this->fetch('script') ?>
</body>

</html>
