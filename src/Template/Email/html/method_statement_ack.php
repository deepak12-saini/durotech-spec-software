<?php
/**
 * Visitor acknowledgement: Method Statement request received.
 */
declare(strict_types=1);

use Cake\Routing\Router;

$name = trim((string)($name ?? ''));
$siteName = defined('SITENAME') ? SITENAME : (string)($site_name ?? 'Durotech Industries');
$id = (int)($id ?? 0);
$siteUrl = defined('SITEURL') ? rtrim((string)SITEURL, '/') : '';
$logoUrl = Router::url('/customdurotech/images/durotech_logo_new.png', true);
$greeting = $name !== '' ? $name : 'there';
?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef2f6;padding:24px 12px;font-family:'Segoe UI',Arial,Helvetica,sans-serif;">
	<tr>
		<td align="center">
			<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
				<?= $this->element('Email/durotech_logo_header', [
					'siteName' => $siteName,
					'logoUrl' => $logoUrl,
					'linkUrl' => $siteUrl !== '' ? $siteUrl . '/' : '',
				]) ?>
				<tr>
					<td style="padding:32px 28px 28px;color:#2c3e50;">
						<p style="margin:0 0 16px;font-size:18px;line-height:1.45;font-weight:600;color:#1a3a52;">Hi <?= h($greeting) ?>,</p>
						<p style="margin:0 0 14px;font-size:15px;line-height:1.6;color:#4a5568;">
							Thank you for your <strong style="color:#1a3a52;">Method Statement</strong> request<?php echo $id > 0 ? ' <span style="color:#5a6c7d;">(reference #' . h((string)$id) . ')</span>' : ''; ?>.
						</p>
						<p style="margin:0 0 14px;font-size:15px;line-height:1.6;color:#4a5568;">
							Our team has received your details and will be in touch using the contact information you provided.
						</p>
						<table role="presentation" cellpadding="0" cellspacing="0" style="margin:22px 0;width:100%;background:#f7fafc;border-radius:8px;border:1px solid #e2e8f0;">
							<tr>
								<td style="padding:16px 18px;font-size:14px;line-height:1.55;color:#4a5568;">
									<strong style="color:#1a3a52;display:block;margin-bottom:6px;">Need to speak to us urgently?</strong>
									Call <a href="tel:1300434272" style="color:#0d5c8c;font-weight:700;text-decoration:none;">1300 434 272</a>
								</td>
							</tr>
						</table>
						<p style="margin:24px 0 0;font-size:15px;line-height:1.6;color:#4a5568;">
							Regards,<br>
							<strong style="color:#1a3a52;"><?= h($siteName) ?></strong>
						</p>
					</td>
				</tr>
				<tr>
					<td style="background:#f1f5f9;text-align:center;padding:16px 20px;font-size:12px;line-height:1.5;color:#64748b;border-top:1px solid #e2e8f0;">
						© <?= date('Y') ?> <?= h($siteName) ?>. All rights reserved.
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
