<?php
/**
 * Specification / EasySpec email (CakePHP 3.10).
 * View vars: subject, pdfname, name, address, company, specification, email, date
 */
$name = $name ?? '';
$address = $address ?? '';
$company = $company ?? '';
$specification = $specification ?? '';
$email = $email ?? '';
$date = $date ?? '';
$pdfname = $pdfname ?? '';
$downloadUrl = defined('SITEURL') ? (rtrim(SITEURL, '/') . '/mailers/download/' . $pdfname) : '';
?>
<p>Hello <?= h($name) ?>,</p>
<p>Please find your specification details below.</p>
<?php if ($company): ?>
<p><strong>Company:</strong> <?= h($company) ?></p>
<?php endif; ?>
<?php if ($address): ?>
<p><strong>Address:</strong> <?= h($address) ?></p>
<?php endif; ?>
<?php if ($specification): ?>
<p><strong>Specification:</strong><br><?= nl2br(h($specification)) ?></p>
<?php endif; ?>
<?php if ($date): ?>
<p><strong>Date:</strong> <?= h($date) ?></p>
<?php endif; ?>
<?php if ($downloadUrl): ?>
<p><strong>Download PDF:</strong> <a href="<?= h($downloadUrl) ?>">Click here to download your PDF</a></p>
<?php endif; ?>
<p>Regards,<br><?= defined('SITENAME') ? h(SITENAME) : 'Durotech' ?></p>
