<?php
/**
 * Internal notification: website Quick Spec form submission.
 * Vars: id, project_name, project_type, area, system_interest, quantity_or_size,
 *       name, email, phone, company, state, notes, admin_view_url, site_name
 */
declare(strict_types=1);

use Cake\Routing\Router;

$id = (int)($id ?? 0);
$siteName = defined('SITENAME') ? SITENAME : (string)($site_name ?? 'Durotech Industries');
$logoUrl = Router::url('/customdurotech/images/durotech_logo.png', true);
$adminUrl = trim((string)($admin_view_url ?? ''));

$row = static function (string $label, string $value): string {
	$v = $value !== '' ? $value : '—';
	return '<tr>'
		. '<td style="padding:12px 14px;font-size:13px;font-weight:600;color:#1a3a52;background:#f1f5f9;border-bottom:1px solid #e2e8f0;width:34%;vertical-align:top;">' . h($label) . '</td>'
		. '<td style="padding:12px 14px;font-size:14px;color:#334155;border-bottom:1px solid #e2e8f0;vertical-align:top;">' . $v . '</td>'
		. '</tr>';
};
?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef2f6;padding:24px 12px;font-family:'Segoe UI',Arial,Helvetica,sans-serif;">
	<tr>
		<td align="center">
			<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:640px;background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
				<tr>
					<td style="background:linear-gradient(180deg,#e8f0f8 0%,#dce8f4 100%);padding:26px 24px;text-align:center;border-bottom:1px solid #c5d8e8;">
						<img src="<?= h($logoUrl) ?>" alt="<?= h($siteName) ?>" width="190" style="max-width:190px;height:auto;display:block;margin:0 auto 10px;border:0;">
						<p style="margin:0;font-size:14px;font-weight:700;color:#1a3a52;letter-spacing:0.03em;text-transform:uppercase;">New Quick Spec request</p>
					</td>
				</tr>
				<tr>
					<td style="padding:28px 24px 8px;color:#2c3e50;">
						<p style="margin:0 0 20px;font-size:15px;line-height:1.6;color:#4a5568;">
							A visitor submitted a <strong style="color:#1a3a52;">Quick Spec</strong> from the website. Summary below.
						</p>
						<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;border-radius:8px;overflow:hidden;border:1px solid #e2e8f0;">
							<?php
							echo $row('Request ID', h((string)$id));
							echo $row('Project name', h((string)($project_name ?? '')));
							echo $row('Project type', h((string)($project_type ?? '')));
							echo $row('Area / application', h((string)($area ?? '')));
							echo $row('Product / system', h((string)($system_interest ?? '')) ?: '—');
							echo $row('Quantity / size', h((string)($quantity_or_size ?? '')) ?: '—');
							echo $row('Name', h((string)($name ?? '')));
							echo $row('Email', h((string)($email ?? '')));
							echo $row('Phone', h((string)($phone ?? '')));
							echo $row('Company', h((string)($company ?? '')) ?: '—');
							echo $row('State', h((string)($state ?? '')) ?: '—');
							$notesHtml = trim((string)($notes ?? '')) !== '' ? nl2br(h((string)($notes ?? ''))) : '—';
							echo '<tr>'
								. '<td style="padding:12px 14px;font-size:13px;font-weight:600;color:#1a3a52;background:#f1f5f9;border-bottom:0;width:34%;vertical-align:top;">Notes</td>'
								. '<td style="padding:12px 14px;font-size:14px;color:#334155;border-bottom:0;vertical-align:top;">' . $notesHtml . '</td>'
								. '</tr>';
							?>
						</table>
						<?php if ($adminUrl !== '') : ?>
							<table role="presentation" cellpadding="0" cellspacing="0" style="margin:24px 0 8px;width:100%;">
								<tr>
									<td align="center">
										<a href="<?= h($adminUrl) ?>" style="display:inline-block;padding:12px 24px;background:#0d5c8c;color:#ffffff !important;text-decoration:none;border-radius:6px;font-size:14px;font-weight:600;">Open in admin</a>
									</td>
								</tr>
								<tr>
									<td style="padding-top:10px;text-align:center;font-size:11px;color:#94a3b8;word-break:break-all;"><?= h($adminUrl) ?></td>
								</tr>
							</table>
						<?php endif; ?>
						<p style="margin:20px 0 0;font-size:13px;color:#64748b;">— <?= h($siteName) ?></p>
					</td>
				</tr>
				<tr>
					<td style="background:#f1f5f9;text-align:center;padding:14px 20px;font-size:11px;line-height:1.5;color:#94a3b8;border-top:1px solid #e2e8f0;">
						Internal notification · do not forward to clients
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
