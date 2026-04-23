<?php
use Cake\Routing\Router;

$name = $name ?? '';
$address = $address ?? '';
$company = $company ?? '';
$specification = $specification ?? '';
$email = $email ?? '';
$date = $date ?? '';
$pdf_attachment = $pdf_attachment ?? '';

$downloadUrl = !empty($pdf_attachment)
    ? Router::url('/' . ltrim($pdf_attachment, '/'), true)
    : '';
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
<p><strong>Download PDF:</strong> 
<a href="<?= h($downloadUrl) ?>">Click here to download your PDF</a></p>
<?php endif; ?>

<p>Regards,<br><?= defined('SITENAME') ? h(SITENAME) : 'Durotech Industries' ?></p>