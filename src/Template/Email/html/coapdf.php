<?php
/**
 * COA (Certificate of Analysis) email template.
 * View vars: subject, pdfname, name, product, batch_no, date_of_manu, expiry_date, form_no
 */
$siteName = defined('SITENAME') ? SITENAME : 'Durotech Industries';
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
<body style="font-family: Arial, sans-serif; line-height: 1.5; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <p>Hello <?= h($recipientName) ?>,</p>
    <p>Please find below the Certificate of Analysis details.</p>
    <table style="border-collapse: collapse; width: 100%; margin: 20px 0;">
        <tr style="background: #e7f5f9;">
            <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Product</th>
            <td style="border: 1px solid #ddd; padding: 10px;"><?= h($product) ?></td>
        </tr>
        <tr>
            <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Batch No.</th>
            <td style="border: 1px solid #ddd; padding: 10px;"><?= h($batchNo) ?></td>
        </tr>
        <tr style="background: #f9f9f9;">
            <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Date of Manufacture</th>
            <td style="border: 1px solid #ddd; padding: 10px;"><?= h($dateOfManu) ?></td>
        </tr>
        <tr>
            <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Expiry Date</th>
            <td style="border: 1px solid #ddd; padding: 10px;"><?= h($expiryDate) ?></td>
        </tr>
        <tr style="background: #f9f9f9;">
            <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Form No.</th>
            <td style="border: 1px solid #ddd; padding: 10px;"><?= h($formNo) ?></td>
        </tr>
    </table>
    <p>If you require the full COA PDF, please contact us.</p>
    <p>Regards,<br><?= h($siteName) ?></p>
</body>
</html>
