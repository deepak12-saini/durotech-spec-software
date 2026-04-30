<?php
/**
 * Generic message template.
 * Used by forgot_password() confirmation mail.
 * Vars: name, email, password, type
 */
$name = trim((string)($name ?? ''));
$password = (string)($password ?? '');
$type = trim((string)($type ?? ''));
$siteName = defined('SITENAME') ? SITENAME : 'Durotech Industries';
?>
<p>Hi <?= h($name !== '' ? $name : 'there') ?>,</p>

<?php if ($type === 'forgot'): ?>
<p>Your password has been changed successfully.</p>
<?php else: ?>
<p>Your request has been processed successfully.</p>
<?php endif; ?>

<?php if ($password !== ''): ?>
<p><strong>Temporary/New Password:</strong> <?= h($password) ?></p>
<?php endif; ?>

<p>Regards,<br><?= h($siteName) ?></p>
