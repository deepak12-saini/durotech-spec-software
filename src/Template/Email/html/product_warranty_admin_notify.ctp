<?php
/**
 * Admin notification: new product warranty request (HTML email).
 *
 * View vars: siteName, logoUrl, introLine, detailRows (label => value), adminListUrl
 *
 * Inline styles for common mail clients; logo uses absolute URL.
 * (.ctp — CakePHP Email resolves this template name with .ctp extension.)
 */
$siteName = $siteName ?? 'Durotech Industries';
$logoUrl = $logoUrl ?? '';
$introLine = $introLine ?? 'A new product warranty request was submitted from the website.';
$detailRows = is_array($detailRows ?? null) ? $detailRows : [];
$adminListUrl = $adminListUrl ?? '';
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
                        <p style="margin:0;padding:10px 0 4px 0;font-size:13px;color:#2889c8;font-weight:bold;text-transform:uppercase;letter-spacing:0.06em;">Product warranty</p>
                        <h1 style="margin:0 0 12px 0;font-size:20px;font-weight:bold;color:#1a1a1a;line-height:1.3;">New request submitted</h1>
                        <p style="margin:0 0 20px 0;color:#555555;"><?= h($introLine) ?></p>
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
                                $display = trim((string)$value) !== '' ? (string)$value : '—';
                                ?>
                                <tr>
                                    <td valign="top" width="38%" style="padding:12px 14px;background-color:<?= $bg ?>;border-bottom:1px solid #e8eef2;font-weight:bold;color:#1a4a6e;font-size:14px;"><?= h((string)$label) ?></td>
                                    <td valign="top" style="padding:12px 14px;background-color:<?= $bg ?>;border-bottom:1px solid #e8eef2;color:#333333;font-size:14px;"><?= h($display) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:20px 24px 28px 24px;text-align:center;">
                        <?php if ($adminListUrl !== ''): ?>
                            <p style="margin:0 0 14px 0;color:#555555;font-size:14px;">Review and approve this request in the admin panel:</p>
                            <a href="<?= h($adminListUrl) ?>" target="_blank" rel="noopener" style="display:inline-block;padding:12px 28px;background-color:#2889c8;color:#ffffff !important;text-decoration:none;font-weight:bold;font-size:15px;border-radius:6px;">Open product warranty list</a>
                            <p style="margin:16px 0 0 0;font-size:12px;color:#888888;word-break:break-all;">
                                <a href="<?= h($adminListUrl) ?>" style="color:#2889c8;"><?= h($adminListUrl) ?></a>
                            </p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding:14px 24px;background-color:#f0f4f7;border-top:1px solid #e0e6eb;text-align:center;font-size:12px;color:#777777;">
                        <?= h($siteName) ?> · This message was sent automatically from the website form.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
