<?php
/**
 * Staff “start new job” link email (MeetsController::sendurl).
 * View vars: url (string, full URL to meets/autologin/…)
 */
$jobUrl = $url ?? '';
?>
<p>Hello,</p>
<p>Please use the link below to open your staff session and <strong>start a new job</strong> (staff in/out).</p>
<p><a href="<?= h($jobUrl) ?>" style="display:inline-block;padding:10px 18px;background:#337ab7;color:#fff;text-decoration:none;border-radius:4px;">Open job link</a></p>
<p>If the button does not work, copy and paste this address into your browser:</p>
<p style="word-break:break-all;font-size:12px;"><?= h($jobUrl) ?></p>
<p>Thank you,<br><?= h(defined('SITENAME') ? SITENAME : 'Durotech Industries') ?></p>
