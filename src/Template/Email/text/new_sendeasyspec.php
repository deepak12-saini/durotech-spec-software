<?php
$name = $name ?? '';
$address = $address ?? '';
$company = $company ?? '';
$specification = $specification ?? '';
$email = $email ?? '';
$date = $date ?? '';
$pdfname = $pdfname ?? '';
$downloadUrl = defined('SITEURL') ? (rtrim(SITEURL, '/') . '/mailers/download/' . $pdfname) : '';
?>
Hello <?= h($name) ?>,

Please find your specification details below.

<?php if ($company): ?>Project: <?= h($company) ?>

<?php endif; ?>
<?php if ($address): ?>Address: <?= h($address) ?>

<?php endif; ?>
<?php if ($specification): ?>Specification:
<?= $specification ?>

<?php endif; ?>
<?php if ($date): ?>Date: <?= h($date) ?>

<?php endif; ?>
<?php if ($downloadUrl): ?>Download PDF: <?= $downloadUrl ?>

<?php endif; ?>
Regards,
<?= defined('SITENAME') ? h(SITENAME) : 'Durotech' ?>
