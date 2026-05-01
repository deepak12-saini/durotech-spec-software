<?php
/**
 * Generic OTP email (CPD / presentation flows).
 * Vars: name, email, otp
 */
$name = trim((string)($name ?? ''));
$otp = (string)($otp ?? '');
$siteName = defined('SITENAME') ? SITENAME : 'Durotech Industries';
?>
<p>Hi <?= h($name !== '' ? $name : 'there') ?>,</p>
<p>Your one-time password (OTP) is:</p>
<p style="font-size:24px;font-weight:bold;letter-spacing:2px;"><?= h($otp) ?></p>
<p>Enter this code on the website to continue.</p>
<p>Regards,<br><?= h($siteName) ?></p>
