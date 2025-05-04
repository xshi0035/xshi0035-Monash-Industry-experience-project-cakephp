<?php

/**
 * Reset Password HTML email template
 *
 * @var \App\View\AppView $this
 * @var string $first_name email recipient's first name
 * @var string $last_name email recipient's last name
 * @var string $email email recipient's email address
 * @var string $nonce nonce used to reset the password
 */
?>
<div>
    <h3>Reset your account password</h3>
    <p>Hi <?= h($first_name) ?>, </p>
    <p>Thank you for your request to reset the password of your account on <b><?= $this->ContentBlock->text('website-title'); ?></b>. </p>
    <p></p>
    <p>To reset your account password, use the button below to access the reset password page: </p>
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
        ">Reset account password</button>
    </a>
    <p>or use the following link: <br>
        <?= $this->Html->link($this->Url->build(['controller' => 'Auth', 'action' => 'resetPassword', $nonce], ['fullBase' => true]), ['controller' => 'Users', 'action' => 'resetPassword', $nonce], ['fullBase' => true, 'style' => 'word-break:break-all']) ?></p>
    <br>
    <br>
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