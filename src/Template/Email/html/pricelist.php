<?php
/**
 * Price list access request email (CakePHP 3.10).
 * View vars: name, email, type, url
 */
?>
<p>A user has requested access to the Price List.</p>
<p><strong>Name:</strong> <?= h($name ?? '') ?></p>
<p><strong>Email:</strong> <?= h($email ?? '') ?></p>
<p><strong>Request type:</strong> <?= h($type ?? 'pricelist') ?></p>
<p>To grant access, click the link below:</p>
<p><a href="<?= h($url ?? '') ?>"><?= h($url ?? '') ?></a></p>
