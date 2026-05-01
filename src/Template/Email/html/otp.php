<?php
/**
 * Price list / label PDF OTP email.
 * Vars: name, otp
 */
$name = trim((string)($name ?? ''));
$otp = (string)($otp ?? '');
$siteName = defined('SITENAME') ? SITENAME : 'Durotech Industries';
?>
<p>Hi <?= h($name !== '' ? $name : 'there') ?>,</p>
<p>Your one-time password (OTP) for price list access is:</p>
<p style="font-size:24px;font-weight:bold;letter-spacing:2px;"><?= h($otp) ?></p>
<p>Enter this code on the website to open your price PDF.</p>
<p>Regards,<br><?= h($siteName) ?></p>
