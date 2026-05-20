<?php
/**
 * Contact form notification — HTML (CakePHP 3.10).
 * View vars: name, email, phone, message
 */
declare(strict_types=1);

use Cake\Routing\Router;

$name = trim((string)($name ?? ''));
$email = trim((string)($email ?? ''));
$phone = trim((string)($phone ?? ''));
$messageRaw = trim((string)($message ?? ''));

$siteName = defined('SITENAME') ? (string)SITENAME : 'Durotech Industries';
$siteUrl = defined('SITEURL') ? rtrim((string)SITEURL, '/') : Router::url('/', true);
$logoUrl = trim((string)($logoUrl ?? ''));

$enquiryType = '';
$company = '';
$messageBody = $messageRaw;

if (preg_match('/^Enquiry type:\s*(Sales|Technical)\s*\R+\s*Company:\s*(.+?)\s*\R+\s*(.+)$/s', $messageRaw, $m)) {
    $enquiryType = $m[1];
    $company = trim($m[2]);
    $messageBody = trim($m[3]);
}

$row = static function (string $label, string $value): string {
    $v = $value !== '' ? $value : '—';
    return '<tr>'
        . '<td style="padding:12px 14px;font-size:13px;font-weight:600;color:#1a3a52;background:#f1f5f9;border-bottom:1px solid #e2e8f0;width:34%;vertical-align:top;">' . h($label) . '</td>'
        . '<td style="padding:12px 14px;font-size:14px;color:#334155;border-bottom:1px solid #e2e8f0;vertical-align:top;word-break:break-word;">' . $v . '</td>'
        . '</tr>';
};
?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef2f6;padding:24px 12px;font-family:'Segoe UI',Arial,Helvetica,sans-serif;">
	<tr>
		<td align="center">
			<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:640px;background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);">
				<?= $this->element('Email/durotech_logo_header', [
					'siteName' => $siteName,
					'logoUrl' => $logoUrl,
					'linkUrl' => $siteUrl . '/',
					'subtitle' => 'New enquiry · contact form',
				]) ?>
				<tr>
					<td style="padding:28px 24px 12px;color:#2c3e50;">
						<p style="margin:0 0 20px;font-size:15px;line-height:1.6;color:#4a5568;">
							Someone submitted the <strong style="color:#1a3a52;">website contact form</strong>. Reply using the email address below (Reply-To is set to the sender).
						</p>
						<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;border-radius:8px;overflow:hidden;border:1px solid #e2e8f0;">
							<?= $row('Name', h($name)) ?>
							<?= $row('Email', '<a href="mailto:' . h($email) . '" style="color:#0d5c8c;text-decoration:none;">' . h($email) . '</a>') ?>
							<?= $row('Phone', h($phone)) ?>
							<?php if ($enquiryType !== '') : ?>
								<?= $row('Enquiry type', h($enquiryType)) ?>
							<?php endif; ?>
							<?php if ($company !== '') : ?>
								<?= $row('Company', h($company)) ?>
							<?php endif; ?>
							<?php
							$bodyHtml = $messageBody !== '' ? nl2br(h($messageBody)) : '—';
							echo '<tr>'
								. '<td style="padding:12px 14px;font-size:13px;font-weight:600;color:#1a3a52;background:#f1f5f9;border-bottom:0;width:34%;vertical-align:top;">Message</td>'
								. '<td style="padding:12px 14px;font-size:14px;color:#334155;border-bottom:0;vertical-align:top;line-height:1.55;">' . $bodyHtml . '</td>'
								. '</tr>';
							?>
						</table>
						<table role="presentation" cellpadding="0" cellspacing="0" style="margin:22px 0 0;width:100%;">
							<tr>
								<td align="center">
									<a href="<?= h($siteUrl) ?>/contact" style="display:inline-block;padding:12px 28px;background:#8CC63F;color:#ffffff !important;text-decoration:none;border-radius:24px;font-size:14px;font-weight:700;">Open website contact page</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="background:#f8fafc;text-align:center;padding:16px 20px;font-size:12px;line-height:1.6;color:#64748b;border-top:1px solid #e2e8f0;">
						<a href="<?= h($siteUrl) ?>/" style="color:#0d5c8c;text-decoration:none;font-weight:600;"><?= h($siteName) ?></a>
						&nbsp;·&nbsp;
						<span style="color:#94a3b8;">This is an automated notification. Do not reply to this address if it differs from the customer email above.</span>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
