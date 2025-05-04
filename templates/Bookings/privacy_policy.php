<?php

$this->layout = 'pages';

$this->assign("title", "Privacy Policy");
?>
<div class="container-fluid">
    <!-- <?= $this->Html->link(__('Back'), ['controller' => 'Customers', 'action' => 'add'], ['class' => 'btn btn-primary']) ?> -->
    <h2>Privacy Policy</h2>
    <?= $this->ContentBlock->html('privacy-policy'); ?>
</div>
