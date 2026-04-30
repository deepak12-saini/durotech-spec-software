<?php
/**
 * Password reset link email template.
 * Vars: url, name, email
 */
$name = trim((string)($name ?? ''));
$resetUrl = trim((string)($url ?? ''));
$siteName = defined('SITENAME') ? SITENAME : 'Durotech Industries';
?>
<p>Hi <?= h($name !== '' ? $name : 'there') ?>,</p>

<p>You requested to reset your password for <?= h($siteName) ?>.</p>

<?php if ($resetUrl !== ''): ?>
<p>
    <a href="<?= h($resetUrl) ?>" style="display:inline-block;padding:10px 18px;background:#1f7dc2;color:#ffffff;text-decoration:none;border-radius:4px;">
        Reset Password
    </a>
</p>
<p>If the button does not work, copy this URL into your browser:</p>
<p><?= h($resetUrl) ?></p>
<?php else: ?>
<p>Reset link is not available. Please request a new reset email.</p>
<?php endif; ?>

<p>If you did not request this, you can ignore this email.</p>
<p>Regards,<br><?= h($siteName) ?></p>
