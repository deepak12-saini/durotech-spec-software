<?php
/**
 * Warranty request form email – link for customer to complete the form.
 * View vars: name, email, url, unique_id
 */
$name = $name ?? '';
$url = $url ?? '';
$unique_id = $unique_id ?? '';
?>
<p>Dear <?= h($name) ?>,</p>
<p>Thank you for your warranty request (Reference: <strong><?= h($unique_id) ?></strong>).</p>
<p>Please complete the warranty form using the link below:</p>
<p><a href="<?= h($url) ?>" style="display:inline-block;padding:10px 20px;background:#0066cc;color:#fff;text-decoration:none;border-radius:4px;">Open warranty form</a></p>
<p>Or copy this link into your browser:</p>
<p><?= h($url) ?></p>
<p>If you have any questions, please contact us.</p>
<p>Kind regards,<br><?= defined('SITENAME') ? h(SITENAME) : 'Durotech' ?></p>
