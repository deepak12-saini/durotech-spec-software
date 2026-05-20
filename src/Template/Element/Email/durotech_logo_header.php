<?php
/**
 * Shared Durotech logo header row for HTML emails (white background, latest logo).
 *
 * Optional vars: siteName, logoUrl, linkUrl, subtitle, logoWidth
 */
declare(strict_types=1);

use App\Utility\EmailLogo;
use Cake\Routing\Router;

$siteName = (string)($siteName ?? (defined('SITENAME') ? SITENAME : 'Durotech Industries'));
$logoUrl = (string)($logoUrl ?? '');
if ($logoUrl === '' || EmailLogo::isLocalhostUrl($logoUrl)) {
    $logoUrl = EmailLogo::publicUrl();
}
$linkUrl = (string)($linkUrl ?? (defined('SITEURL') ? rtrim((string)SITEURL, '/') . '/' : Router::url('/', true)));
$subtitle = trim((string)($subtitle ?? ''));
$logoWidth = (int)($logoWidth ?? 220);
if ($logoWidth < 120) {
    $logoWidth = 220;
}
?>
<tr>
    <td style="background-color:#ffffff;padding:28px 24px;text-align:center;border-bottom:1px solid #e8eef2;">
        <?php if ($logoUrl !== '') : ?>
            <?php if ($linkUrl !== '') : ?>
                <a href="<?= h($linkUrl) ?>" style="text-decoration:none;display:inline-block;border:0;" target="_blank" rel="noopener">
                    <img src="<?= h($logoUrl) ?>" alt="<?= h($siteName) ?>" width="<?= $logoWidth ?>" style="max-width:<?= $logoWidth ?>px;height:auto;display:block;margin:0 auto;border:0;outline:none;" />
                </a>
            <?php else : ?>
                <img src="<?= h($logoUrl) ?>" alt="<?= h($siteName) ?>" width="<?= $logoWidth ?>" style="max-width:<?= $logoWidth ?>px;height:auto;display:block;margin:0 auto;border:0;outline:none;" />
            <?php endif; ?>
        <?php else : ?>
            <span style="font-size:20px;font-weight:bold;color:#2889c8;letter-spacing:0.5px;"><?= h($siteName) ?></span>
        <?php endif; ?>
        <?php if ($subtitle !== '') : ?>
            <p style="margin:14px 0 0;font-size:13px;font-weight:600;color:#2889c8;letter-spacing:0.06em;text-transform:uppercase;"><?= h($subtitle) ?></p>
        <?php endif; ?>
    </td>
</tr>
