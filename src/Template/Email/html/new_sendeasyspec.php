<?php

use Cake\Routing\Router;

$name = $name ?? '';
$address = $address ?? '';
$company = $company ?? '';
$specification = $specification ?? '';
$tracknumber = $tracknumber ?? '';
$revision = $revision ?? '';
$created_by = $created_by ?? '';
$email = $email ?? '';
$date = $date ?? '';
$pdf_attachment = $pdf_attachment ?? '';

$downloadUrl = !empty($pdf_attachment)
    ? Router::url('/' . ltrim($pdf_attachment, '/'), true)
    : '';

$logoUrl = Router::url('/customdurotech/images/durotech_logo.png', true);
?>

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:20px;font-family:Arial, sans-serif;">
    <tr>
        <td align="center">
            
            <!-- Main Container -->
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;">
                
                <!-- Header -->
                <tr>
                    <td style="background:#e4edf4;padding:20px;text-align:center;">
                        <img src="<?= $logoUrl ?>" alt="Durotech" style="max-width:180px;">
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:25px;color:#333;">
                        
                        <p style="font-size:16px;">Hello <strong><?= h($name) ?></strong>,</p>
                        
                        <p style="font-size:14px;color:#555;">
                            Please find your specification details below:
                        </p>

                        <?php if (!empty($created_by)): ?>
                        <p style="font-size:14px;color:#555;margin:0 0 14px 0;">
                            A new specification has been created by <strong><?= h($created_by) ?></strong>.
                        </p>
                        <?php endif; ?>

                        <table width="100%" cellpadding="8" cellspacing="0" style="margin-top:15px;border-collapse:collapse;">
                            
                            <?php if ($company): ?>
                            <tr>
                                <td style="background:#f1f1f1;"><strong>Company</strong></td>
                                <td><?= h($company) ?></td>
                            </tr>
                            <?php endif; ?>

                            <?php if ($tracknumber): ?>
                            <tr>
                                <td style="background:#f1f1f1;"><strong>Track No</strong></td>
                                <td><?= h($tracknumber) ?></td>
                            </tr>
                            <?php endif; ?>

                            <?php if (!empty($created_by)): ?>
                            <tr>
                                <td style="background:#f1f1f1;"><strong>Created By</strong></td>
                                <td><?= h($created_by) ?></td>
                            </tr>
                            <?php endif; ?>

                            <?php if ($address): ?>
                            <tr>
                                <td style="background:#f1f1f1;"><strong>Address</strong></td>
                                <td><?= h($address) ?></td>
                            </tr>
                            <?php endif; ?>

                            <?php if ($specification): ?>
                            <tr>
                                <td style="background:#f1f1f1;"><strong>Specification</strong></td>
                                <td><?= nl2br(h($specification)) ?></td>
                            </tr>
                            <?php endif; ?>

                            <?php if ($date): ?>
                            <tr>
                                <td style="background:#f1f1f1;"><strong>Date</strong></td>
                                <td><?= h($date) ?></td>
                            </tr>
                            <?php endif; ?>

                            <?php if ($revision !== ''): ?>
                            <tr>
                                <td style="background:#f1f1f1;"><strong>Revision</strong></td>
                                <td><?= h((string)$revision) ?></td>
                            </tr>
                            <?php endif; ?>

                        </table>

                        <?php if ($downloadUrl): ?>
                        <div style="text-align:center;margin:30px 0;">
                            <a href="<?= h($downloadUrl) ?>" 
                               style="background:#007bff;color:#ffffff;padding:12px 25px;
                                      text-decoration:none;border-radius:5px;font-size:14px;display:inline-block;">
                                Download PDF
                            </a>
                        </div>
                        <?php endif; ?>

                        <p style="font-size:14px;color:#555;">
                            If you have any questions, feel free to contact us.
                        </p>

                        <p style="margin-top:20px;">
                            Regards,<br>
                            <strong><?= defined('SITENAME') ? h(SITENAME) : 'Durotech Industries' ?></strong>
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f1f1f1;text-align:center;padding:15px;font-size:12px;color:#777;">
                        © <?= date('Y') ?> Durotech Industries. All rights reserved.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>