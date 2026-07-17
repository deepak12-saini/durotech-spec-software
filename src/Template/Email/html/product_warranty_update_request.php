<?php
/**
 * Admin notification: customer requested a warranty update from the portal.
 *
 * View vars: siteName, logoUrl, requestId, product, name, companyName, notes,
 *            customerEmail, customerPhone, adminListUrl, hasAttachment
 */
$siteName = $siteName ?? 'Durotech Industries';
$logoUrl = $logoUrl ?? '';
$requestId = (string)($requestId ?? '');
$product = trim((string)($product ?? ''));
$name = trim((string)($name ?? ''));
$companyName = trim((string)($companyName ?? ''));
$notes = trim((string)($notes ?? ''));
$customerEmail = trim((string)($customerEmail ?? ''));
$customerPhone = trim((string)($customerPhone ?? ''));
$adminListUrl = $adminListUrl ?? '';
$hasAttachment = !empty($hasAttachment);

$detailRows = [
    'Request ID' => $requestId !== '' ? '#' . $requestId : '—',
    'Product' => $product !== '' ? $product : '—',
    'Name' => $name !== '' ? $name : '—',
    'Company' => $companyName !== '' ? $companyName : '—',
    'Customer email' => $customerEmail !== '' ? $customerEmail : '—',
    'Customer phone' => $customerPhone !== '' ? $customerPhone : '—',
    'Supporting PDF' => $hasAttachment ? 'Attached to this email' : 'None',
];
?>
<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin:0;padding:0;background-color:#e8eef2;font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.45;color:#333333;">
    <tr>
        <td align="center" style="padding:24px 12px;">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" style="max-width:600px;width:100%;background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                <?= $this->element('Email/durotech_logo_header', [
                    'siteName' => $siteName,
                    'logoUrl' => $logoUrl,
                    'linkUrl' => $adminListUrl,
                ]) ?>
                <tr>
                    <td style="padding:8px 24px 0 24px;">
                        <p style="margin:0;padding:10px 0 4px 0;font-size:13px;color:#d99612;font-weight:bold;text-transform:uppercase;letter-spacing:0.06em;">Warranty update request</p>
                        <h1 style="margin:0 0 12px 0;font-size:20px;font-weight:bold;color:#1a1a1a;line-height:1.3;">Customer requested a correction</h1>
                        <p style="margin:0 0 20px 0;color:#555555;">A customer submitted an update request from their warranty portal. Please review and follow up within 2 business days.</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 24px 8px 24px;">
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="border:1px solid #e0e6eb;border-radius:6px;overflow:hidden;">
                            <?php
                            $i = 0;
                            foreach ($detailRows as $label => $value):
                                $i++;
                                $bg = ($i % 2 === 1) ? '#f7fafc' : '#ffffff';
                                ?>
                                <tr>
                                    <td valign="top" width="38%" style="padding:12px 14px;background-color:<?= $bg ?>;border-bottom:1px solid #e8eef2;font-weight:bold;color:#1a4a6e;font-size:14px;"><?= h((string)$label) ?></td>
                                    <td valign="top" style="padding:12px 14px;background-color:<?= $bg ?>;border-bottom:1px solid #e8eef2;color:#333333;font-size:14px;"><?= h((string)$value) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:16px 24px 8px 24px;">
                        <p style="margin:0 0 8px 0;font-weight:bold;color:#1a4a6e;font-size:14px;">Notes from customer</p>
                        <div style="padding:14px;background-color:#f7fafc;border:1px solid #e0e6eb;border-radius:6px;color:#333333;font-size:14px;white-space:pre-wrap;"><?= h($notes !== '' ? $notes : '—') ?></div>
                    </td>
                </tr>
                <tr>
                    <td style="padding:20px 24px 28px 24px;text-align:center;">
                        <?php if ($adminListUrl !== ''): ?>
                            <p style="margin:0 0 14px 0;color:#555555;font-size:14px;">Open this warranty request in admin:</p>
                            <a href="<?= h($adminListUrl) ?>" target="_blank" rel="noopener" style="display:inline-block;padding:12px 28px;background-color:#2889c8;color:#ffffff !important;text-decoration:none;font-weight:bold;font-size:15px;border-radius:6px;">Open product warranty list</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding:14px 24px;background-color:#f0f4f7;border-top:1px solid #e0e6eb;text-align:center;font-size:12px;color:#777777;">
                        <?= h($siteName) ?> · Sent automatically from the customer warranty portal.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
