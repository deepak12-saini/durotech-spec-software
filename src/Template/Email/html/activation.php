<?php
/**
 * Account activation email template.
 * Expected vars: name, email, password (base64 encoded email), type
 */
$name = trim((string)($name ?? ''));
$email = trim((string)($email ?? ''));
$code = (string)($password ?? '');
$siteName = defined('SITENAME') ? SITENAME : 'Durotech Industries';
$baseUrl = defined('SITEURL') ? rtrim((string)SITEURL, '/') : '';
$activationUrl = $baseUrl !== '' ? ($baseUrl . '/users/activateaccount/' . rawurlencode($code)) : '';
?>
<p>Hi <?= h($name !== '' ? $name : 'there') ?>,</p>
<p>Welcome to <?= h($siteName) ?>.</p>
<p>Please activate your account by clicking the link below:</p>
<?php if ($activationUrl !== ''): ?>
<p>
    <a href="<?= h($activationUrl) ?>" style="display:inline-block;padding:10px 18px;background:#1f7dc2;color:#ffffff;text-decoration:none;border-radius:4px;">
        Activate Account
    </a>
</p>
<p>If the button does not work, copy this URL into your browser:</p>
<p><?= h($activationUrl) ?></p>
<?php else: ?>
<p>Activation link could not be generated. Please contact support.</p>
<?php endif; ?>
<p>Regards,<br><?= h($siteName) ?></p>
