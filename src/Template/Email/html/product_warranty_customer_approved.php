<?php
/**
 * Customer email: approved product warranty certificate attached.
 *
 * View vars: siteName, contractName, product, portalUrl
 */
$siteName = $siteName ?? 'Durotech Industries';
$contractName = trim((string)($contractName ?? ''));
$product = trim((string)($product ?? ''));
$portalUrl = $portalUrl ?? '';
$greeting = $contractName !== '' ? $contractName : 'there';
?>
<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin:0;padding:0;background-color:#e8eef2;font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.45;color:#333333;">
    <tr>
        <td align="center" style="padding:24px 12px;">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" style="max-width:600px;width:100%;background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                <tr>
                    <td style="padding:24px 24px 8px;">
                        <p style="margin:0 0 8px;font-size:13px;color:#1f8f4e;font-weight:bold;text-transform:uppercase;letter-spacing:0.06em;">Warranty approved</p>
                        <h1 style="margin:0 0 12px;font-size:22px;color:#0b2d4a;">Your product warranty certificate</h1>
                        <p style="margin:0 0 16px;color:#555;">Hi <?= h($greeting) ?>,</p>
                        <p style="margin:0 0 16px;color:#555;">Your Durotech product warranty<?= $product !== '' ? ' for <strong>' . h($product) . '</strong>' : '' ?> has been approved. Your certificate PDF is attached to this email.</p>
                        <?php if ($portalUrl !== '') : ?>
                        <p style="margin:0 0 16px;color:#555;">You can also open your warranty portal any time:</p>
                        <p style="margin:0 0 20px;"><a href="<?= h($portalUrl) ?>" style="color:#0b2d4a;font-weight:bold;"><?= h($portalUrl) ?></a></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding:14px 24px;background-color:#f0f4f7;border-top:1px solid #e0e6eb;text-align:center;font-size:12px;color:#777;">
                        <?= h($siteName) ?> · sales@durotechindustries.com.au
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
