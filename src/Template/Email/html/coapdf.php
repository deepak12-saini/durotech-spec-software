<?php
/**
 * COA (Certificate of Analysis) email template.
 * View vars: subject, pdfname, name, product, batch_no, date_of_manu, expiry_date, form_no
 */
$siteName = defined('SITENAME') ? SITENAME : 'Durotech Industries';
$logoUrl = (defined('SITEURL') ? SITEURL : '') . 'durologo.png';
$product = $product ?? '';
$batchNo = $batch_no ?? '';
$dateOfManu = $date_of_manu ?? '';
$expiryDate = $expiry_date ?? '';
$formNo = $form_no ?? '';
$recipientName = $name ?? '';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Analysis</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.5; color: #333; background:#f5f7fb; margin:0; padding:0;">
    <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="width:100%; background:#f5f7fb; padding:20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="width:600px; max-width: 100%; background:#ffffff; border-radius:10px; overflow:hidden;">
                    <tr>
                        <td style="background:#0b6bae; padding:18px 22px; text-align:left;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="width:140px;">
                                        <img src="<?= h($logoUrl) ?>" alt="Durotech" style="width:120px; height:auto; display:block;">
                                    </td>
                                    <td style="text-align:right; vertical-align:middle;">
                                        <div style="color:#ffffff; font-weight:700; font-size:16px;"><?= h($siteName) ?></div>
                                        <div style="color:#d6ecff; font-size:12px; margin-top:2px;">Certificate of Analysis</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:22px 22px 10px 22px;">
                            <p style="margin:0 0 10px 0; font-size:14px;">Hello <?= h($recipientName) ?>,</p>
                            <p style="margin:0 0 14px 0; font-size:14px;">Please find below the Certificate of Analysis details.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 22px 18px 22px;">
                            <table style="border-collapse: collapse; width: 100%; margin: 0;">
                                <tr style="background: #e7f5f9;">
                                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size:13px; width: 42%;">Product</th>
                                    <td style="border: 1px solid #ddd; padding: 10px; font-size:13px;"><?= h($product) ?></td>
                                </tr>
                                <tr>
                                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size:13px;">Batch No.</th>
                                    <td style="border: 1px solid #ddd; padding: 10px; font-size:13px;"><?= h($batchNo) ?></td>
                                </tr>
                                <tr style="background: #f9f9f9;">
                                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size:13px;">Date of Manufacture</th>
                                    <td style="border: 1px solid #ddd; padding: 10px; font-size:13px;"><?= h($dateOfManu) ?></td>
                                </tr>
                                <tr>
                                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size:13px;">Expiry Date</th>
                                    <td style="border: 1px solid #ddd; padding: 10px; font-size:13px;"><?= h($expiryDate) ?></td>
                                </tr>
                                <tr style="background: #f9f9f9;">
                                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-size:13px;">Form No.</th>
                                    <td style="border: 1px solid #ddd; padding: 10px; font-size:13px;"><?= h($formNo) ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 22px 22px 22px;">
                            <p style="margin:0 0 12px 0; font-size:13px;">If you require the full COA PDF, please contact us.</p>
                            <p style="margin:0; font-size:13px;">Regards,<br><strong><?= h($siteName) ?></strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f3f6fb; padding:14px 22px; border-top:1px solid #e6ebf2;">
                            <div style="font-size:12px; color:#6b7280;">
                                Thank you for choosing Durotech Industries.
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
