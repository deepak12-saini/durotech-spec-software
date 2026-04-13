<?php
/**
 * Welcome mailer template.
 * Vars: name, message, tracknumber, price_url, label
 */
$name = trim((string)($name ?? ''));
$message = (string)($message ?? '');
$tracknumber = trim((string)($tracknumber ?? ''));
$priceUrl = trim((string)($price_url ?? ''));
$label = trim((string)($label ?? ''));
?>
<p>Hello <?= h($name !== '' ? $name : 'Customer') ?>,</p>
<?php if ($tracknumber !== ''): ?>
<p>Reference: <strong><?= h($tracknumber) ?></strong></p>
<?php endif; ?>

<?php if ($message !== ''): ?>
<div><?= $message ?></div>
<?php endif; ?>

<?php if ($priceUrl !== ''): ?>
<p>
    Price list<?= $label !== '' ? ' (' . h($label) . ')' : '' ?>:
    <a href="<?= h($priceUrl) ?>"><?= h($priceUrl) ?></a>
</p>
<?php endif; ?>

<p>Regards,<br><?= h(defined('SITENAME') ? SITENAME : 'Durotech Industries') ?></p>
