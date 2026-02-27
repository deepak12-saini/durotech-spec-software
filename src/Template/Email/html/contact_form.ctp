<?php
/**
 * Contact form email template (CakePHP 3.10).
 * View vars: name, email, phone, message
 */
?>
<p><strong>Name:</strong> <?= h($name ?? '') ?></p>
<p><strong>Email:</strong> <?= h($email ?? '') ?></p>
<p><strong>Phone:</strong> <?= h($phone ?? '') ?></p>
<p><strong>Message:</strong></p>
<p><?= nl2br(h($message ?? '')) ?></p>
