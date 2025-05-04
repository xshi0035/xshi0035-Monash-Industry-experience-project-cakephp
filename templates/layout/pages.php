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

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <title>
        <?= $cakeDescription . ": ",
        $this->fetch('title') ?>
    </title>
</head>

<header>
    <div class="p-5 bg-primary text-white text-center">
        <h1>Book with Pram Spa</h1>
    </div>
</header>

<br>

<body>

    <div class="container">

        <main>
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </main>

        <footer>
            <!-- PUT FOOTER HERE -->
        </footer>
    </div>

</body>

<footer class="panel-footer mt-auto">
    <?= $this->ContentBlock->text('copyright-message') ?>
</footer>

</html>