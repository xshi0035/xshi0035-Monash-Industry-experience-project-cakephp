<?php

$this->layout = 'pages';
$this->assign("title","Booking Confirmed");
?>

<h2>Your booking has been confirmed</h2>
<?= $this->Html->link('Back to Home', 'https://pramspa.com.au/', ['class' => 'btn btn-primary']) ?>
