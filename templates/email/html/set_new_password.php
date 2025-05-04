<div class="content">
    <!-- START CENTERED WHITE CONTAINER -->

    <!-- START MAIN CONTENT AREA -->
    <h3>Set your account password</h3>
    <p>Hi <?= h($first_name) ?>, </p>
    <p>You manager has created a new <b><?= $this->ContentBlock->text('website-title'); ?></b> Staff Account for you. </p>
    <p></p>
    <p>To set your account password, use the button below to access the reset password page: </p>
    <a href="<?= $this->Url->build(['controller' => 'Auth', 'action' => 'resetPassword', $nonce], ['fullBase' => true]) ?>" target="_blank">
        <button style="
            display: inline-block;
            font-weight: 400;
            color: #1A181B;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: #78B090;
            border: 1px solid #78B090;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .35rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            margin-right: 0.5rem;
            margin-bottom: 1.5rem;
            cursor: pointer;
        ">Set account password</button>
    </a>
    <p>or use the following link:
        <?= $this->Html->link($this->Url->build(['controller' => 'Auth', 'action' => 'resetPassword', $nonce], ['fullBase' => true]), ['controller' => 'Users', 'action' => 'resetPassword', $nonce], ['fullBase' => true, 'style' => 'word-break:break-all']) ?>
    </p>
    <br>
    <br>
    <!-- END MAIN CONTENT AREA -->

    <!-- START FOOTER -->
    <div style="padding: 10px 15px; background-color: #f5f5f5; border-top: 1px solid #ddd; text-align: center; font-size: 0.75rem;">
        <p>This email is addressed to &lt;<?= $email ?>&gt;<br>
            Please discard this email if it's not meant for you.
            <br>
            <br>
            Copyright &copy; <?= date("Y"); ?> <?= $this->ContentBlock->text('website-title'); ?>
        </p>
    </div>
    <!-- END FOOTER -->
</div>