<?php


use Cake\Core\Configure;

$appLocale = Configure::read('App.defaultLocale');

$cakeDescription = $this->ContentBlock->text('website-title') . " Booking";
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

    <header class="bg-primary text-white text-center py-4">
        <h1>Book with Pram Spa</h1>
        <p>Step <?= $currentStep ?> of 5</p>
    </header>
    <br>

    <main class="container flex-fill">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>

    <footer class="panel-footer mt-auto">
        <?=$this->ContentBlock->text('copyright-message')?>
    </footer>

    <?= $this->fetch('script') ?>
</body>

</html>
