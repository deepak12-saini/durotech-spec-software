<?php
/**
 * Warrant Request v2 — Dompdf HTML certificate (cover + detail + terms).
 * Visual reference: docs/reference/10_Years_Warranty_Harvey_Norman.html
 *
 * @var string $logoDataUri
 * @var string $sealDataUri
 * @var string $mapDataUri
 * @var string $coverBgDataUri
 * @var string $detailHeaderDataUri
 * @var string|int $warrantyYears
 * @var string $product
 * @var array<int, string> $productLines
 * @var string $projectName
 * @var string $applicator
 * @var string $warrantyDate
 * @var string $serialNumber
 * @var string $usedAs
 * @var string $buildingName
 * @var string $buildingAddress
 * @var string $buildingAreaName
 * @var string $areaWarranted
 * @var string $applicatorAbn
 * @var string $applicatorAddress
 * @var string $applicatorContact
 * @var string $startDate
 * @var string $endDate
 * @var string $website
 * @var string $companyName
 * @var bool $includeTermsPages Embed pages 3–4 in Dompdf (false when merged via FPDI)
 * @var string $termsPage3DataUri
 * @var string $termsPage4DataUri
 */
$h = static function ($v): string {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
};

$logoDataUri = $logoDataUri ?? '';
$sealDataUri = $sealDataUri ?? '';
$mapDataUri = $mapDataUri ?? '';
$coverBgDataUri = $coverBgDataUri ?? '';
$detailHeaderDataUri = $detailHeaderDataUri ?? '';
$warrantyYears = $warrantyYears ?? '10';
$product = $product ?? '';
$productLines = $productLines ?? [$product, ''];
$projectName = $projectName ?? '';
$applicator = $applicator ?? '';
$warrantyDate = $warrantyDate ?? '';
$serialNumber = $serialNumber ?? '';
$usedAs = $usedAs ?? '';
$buildingName = $buildingName ?? '';
$buildingAddress = $buildingAddress ?? '';
$buildingAreaName = $buildingAreaName ?? '';
$areaWarranted = $areaWarranted ?? '';
$applicatorAbn = $applicatorAbn ?? '';
$applicatorAddress = $applicatorAddress ?? '';
$applicatorContact = $applicatorContact ?? '';
$startDate = $startDate ?? '';
$endDate = $endDate ?? '';
$website = $website ?? 'www.durotechindustries.com.au';
$companyName = $companyName ?? 'Durotech Industries';
$includeTermsPages = $includeTermsPages ?? false;
$termsPage3DataUri = $termsPage3DataUri ?? '';
$termsPage4DataUri = $termsPage4DataUri ?? '';

$yearsNum = preg_replace('/\D+/', '', (string)$warrantyYears) ?: '10';
$yearsLabel = $yearsNum . ' YEARS PRODUCT WARRANTY';

$wrapDetailFieldLines = static function (string $text, int $width = 44, int $minLines = 1): array {
    $text = trim(str_replace(["\r\n", "\r", "\n"], ' ', $text));
    if ($text === '') {
        return array_fill(0, max(1, $minLines), '');
    }

    $tokens = strpos($text, ',') !== false
        ? (preg_split('/\s*,\s*/u', $text) ?: [])
        : (preg_split('/\s+/u', $text) ?: []);
    $joiner = strpos($text, ',') !== false ? ', ' : ' ';
    $lines = [];
    $current = '';
    foreach ($tokens as $token) {
        $token = trim((string)$token);
        if ($token === '') {
            continue;
        }
        $trial = $current === '' ? $token : $current . $joiner . $token;
        if (mb_strlen($trial) > $width && $current !== '') {
            $lines[] = $current;
            $current = $token;
        } else {
            $current = $trial;
        }
    }
    if ($current !== '') {
        $lines[] = $current;
    }
    while (count($lines) < $minLines) {
        $lines[] = '';
    }

    return $lines;
};

$splitDetailFieldLines = static function (string $text, int $minLines = 1): array {
    $text = trim(str_replace(["\r\n", "\r"], "\n", $text));
    if ($text === '') {
        return array_fill(0, max(1, $minLines), '');
    }
    $lines = explode("\n", $text);
    while (count($lines) < $minLines) {
        $lines[] = '';
    }

    return $lines;
};

$rawCoverProductLines = $wrapDetailFieldLines($product, 58, 1);
$coverProductLines = array_slice(
    array_values(array_filter(
        $rawCoverProductLines,
        static function ($line) {
            return trim((string)$line) !== '';
        }
    )),
    0,
    2
);
if ($coverProductLines === []) {
    $coverProductLines = [''];
}
$coverInsetLeftMm = 40;
$coverInsetRightMm = 40;
$coverCardWidthMm = 140;
$coverFieldsWidthMm = 116;
$coverLabelIndentMm = 22;
$coverBlockBottomMm = 12;
// Taller cover block so PRODUCT (2 lines) + PROJECT + APPLICATOR + DATE stay on page 1.
$coverBlockHeightMm = 92;
$coverSpacerTopMm = 297 - $coverBlockHeightMm - $coverBlockBottomMm;
$coverFieldRowGapMm = 4;
$detailProductLines = $wrapDetailFieldLines($product, 42, 6);
$detailBuildingAreaLines = $splitDetailFieldLines($buildingAreaName, 3);
$detailAreaWarrantedLines = $splitDetailFieldLines($areaWarranted, 8);
$detailBuildingAddressLines = $wrapDetailFieldLines($buildingAddress, 42, 7);
$detailApplicatorAddressLines = $wrapDetailFieldLines($applicatorAddress, 42, 4);
$detailApplicatorLines = $wrapDetailFieldLines($applicator, 42, 6);
$detailApplicatorContactLines = $splitDetailFieldLines($applicatorContact, 2);
$detailUsedAsLines = $splitDetailFieldLines($usedAs, 6);
$detailStartLines = $splitDetailFieldLines($startDate, 3);
$detailEndLines = $splitDetailFieldLines($endDate, 3);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $h($yearsLabel) ?></title>
    <style>
        @page {
            margin: 0;
            size: A4 portrait;
        }
        * { box-sizing: border-box; }
        html, body {
            margin: 0;
            padding: 0;
            width: 210mm;
            font-family: DejaVu Sans, Helvetica, Arial, sans-serif;
            color: #1a1a1a;
            font-size: 11px;
            line-height: 1.35;
            background: #fff;
        }

        .page {
            width: 210mm;
            position: relative;
            page-break-inside: avoid;
        }
        .page-inner {
            padding: 10mm 12mm 12mm 12mm;
        }
        .page-inner-detail {
            padding: 0 12mm 10mm 12mm;
        }
        .detail-body {
            padding-top: 8mm;
        }
        .page-break { page-break-after: always; }

        /* ===== COVER — Dompdf-safe: bg img + fixed spacer row ===== */
        .cover-page {
            width: 210mm;
            height: 297mm;
            max-width: 210mm;
            overflow: hidden;
            position: relative;
        }
        .cover-bg-flow {
            display: block;
            width: 210mm;
            height: 297mm;
            border: 0;
        }
        .cover-grid {
            width: 210mm;
            margin-top: -297mm;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .cover-grid td {
            padding: 0;
            margin: 0;
            vertical-align: top;
        }
        .cover-spacer-top {
            height: <?= (int)$coverSpacerTopMm ?>mm;
            line-height: 1px;
            font-size: 1px;
            padding: 0;
        }
        .cover-block-cell {
            vertical-align: top;
            padding: 0 <?= (int)$coverInsetRightMm ?>mm <?= (int)$coverBlockBottomMm ?>mm <?= (int)$coverInsetLeftMm ?>mm;
            page-break-inside: avoid;
        }
        .cover-title-wrap {
            width: <?= (int)$coverCardWidthMm ?>mm;
            border-collapse: collapse;
            page-break-inside: avoid;
            page-break-after: avoid;
        }
        .cover-title-wrap td {
            text-align: center;
            padding: 0 0 5mm 0;
        }
        .cover-ov-years {
            color: #ffffff;
            font-family: DejaVu Sans, Helvetica, Arial, sans-serif;
            font-size: 10pt;
            font-weight: 700;
            letter-spacing: 0.25pt;
            text-transform: uppercase;
            line-height: 1.1;
            white-space: nowrap;
        }
        .cover-card-stack {
            width: <?= (int)$coverCardWidthMm ?>mm;
            max-width: <?= (int)$coverCardWidthMm ?>mm;
            border-collapse: collapse;
        }
        .cover-ov-card {
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 12px;
            page-break-inside: avoid;
        }
        .cover-ov-card td {
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
        }
        .cover-fields {
            width: <?= (int)$coverFieldsWidthMm ?>mm;
            border-collapse: collapse;
            font-size: 12pt;
        }
        .cover-fields td {
            padding: 0;
            vertical-align: bottom;
        }
        .cover-field-line {
            padding: 3px 0 5px;
            border-bottom: 1px dotted #5f8eb8;
            background-color: #ffffff;
            line-height: 1.4;
            min-height: 14px;
        }
        .cover-field-line-indented {
            padding: 3px 0 5px <?= (int)$coverLabelIndentMm ?>mm;
            border-bottom: 1px dotted #5f8eb8;
            background-color: #ffffff;
            line-height: 1.4;
            min-height: 14px;
        }
        .cover-field-spacer {
            height: <?= (int)$coverFieldRowGapMm ?>mm;
            line-height: 1px;
            font-size: 1px;
            padding: 0;
            border: 0;
        }
        .cover-f-lbl {
            color: #1885c7;
            font-family: DejaVu Sans, Helvetica, Arial, sans-serif;
            font-size: 9pt;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .cover-f-val-txt {
            color: #000000;
            font-family: Arial, DejaVu Sans, Helvetica, sans-serif;
            font-size: 1.017333em;
            font-weight: 400;
            letter-spacing: -0.0001em;
            line-height: 1.117em;
            background-color: #e6ebff;
            padding: 1px 3px 2px;
        }
        .cover-field-line-indented .cover-f-val-txt {
            font-size: 0.919833em;
        }
        .cover-f-val-txt-wide {
            font-size: 1.099em;
        }

        .brand-table { width: 100%; border-collapse: collapse; }
        .brand-table td { vertical-align: top; padding: 0; }
        .logo-img {
            display: block;
            max-width: 210px;
            height: auto;
            max-height: 48px;
        }
        .seal-img {
            display: block;
            width: 72px;
            height: auto;
            margin-left: auto;
        }
        .seal-fallback {
            width: 72px;
            height: 72px;
            margin-left: auto;
            border: 4px solid #2e7d32;
            border-radius: 50%;
            background: #f9c74f;
            color: #1b5e20;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
            line-height: 1.15;
            padding-top: 18px;
        }

        .detail-header { margin: 0 -12mm 4px -12mm; }
        .detail-header-img {
            display: block;
            width: 210mm;
            height: auto;
            border: 0;
        }
        .detail-title {
            text-align: center;
            color: #1b668f;
            font-family: DejaVu Sans, Helvetica, Arial, sans-serif;
            font-size: 15pt;
            font-weight: 700;
            letter-spacing: 0.5pt;
            text-transform: uppercase;
            margin: 0 0 12px;
            padding-top: 2mm;
            line-height: 1.2;
        }
        .detail-box {
            border: 1.5px solid #111111;
            border-radius: 12px;
            padding: 12px 14px 14px;
            margin-top: 2mm;
        }
        .detail-cols {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .detail-col-l {
            width: 50%;
            vertical-align: top;
            padding: 0 9px 0 0;
        }
        .detail-col-r {
            width: 50%;
            vertical-align: top;
            padding: 0 0 0 9px;
        }
        .field-block {
            margin: 0 0 1px;
        }
        .field-label {
            display: block;
            color: #1885c7;
            font-family: DejaVu Sans, Helvetica, Arial, sans-serif;
            font-size: 9pt;
            font-weight: 400;
            margin: 0 0 1px;
            line-height: 1.2;
        }
        .field-line {
            border-bottom: 1px dotted #777777;
            min-height: 14px;
            height: 14px;
            padding: 0 2px 2px;
            font-family: DejaVu Sans, Helvetica, Arial, sans-serif;
            font-size: 9pt;
            font-weight: 400;
            color: #111111;
            line-height: 1.3;
            word-wrap: break-word;
            overflow-wrap: break-word;
            margin: 0 0 2px;
        }
        .field-line:last-child {
            margin-bottom: 8px;
        }
        .detail-footer {
            text-align: right;
            color: #666666;
            font-size: 8.5pt;
            margin-top: 8px;
        }

        .terms-title {
            text-align: center;
            color: #1e4f73;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin: 6px 0 12px;
        }
        .terms-body {
            font-size: 8.5px;
            line-height: 1.4;
            color: #222;
            text-align: justify;
        }
        .terms-body p { margin: 0 0 7px; }
        .terms-body .clause { margin: 0 0 6px; }
        .terms-body .clause-num {
            font-weight: 700;
            display: inline;
        }
        .terms-claim {
            margin-top: 10px;
            border-top: 1px solid #ccc;
            padding-top: 8px;
        }
        .terms-claim h3 {
            margin: 0 0 6px;
            font-size: 11px;
            color: #1e4f73;
            text-transform: uppercase;
        }
        .terms-brand { margin-bottom: 8px; }

        /* Rajan reference — full-page terms images (pages 3 & 4) */
        .terms-image-page {
            width: 210mm;
            height: 297mm;
            margin: 0;
            padding: 0;
            overflow: hidden;
            page-break-inside: avoid;
        }
        .terms-fullpage-img {
            display: block;
            width: 210mm;
            height: 297mm;
            margin: 0;
            padding: 0;
            border: 0;
        }
    </style>
</head>
<body>

<!-- PAGE 1: COVER — Rajan background + dynamic fields -->
<div class="page page-break cover-page">
    <?php if ($coverBgDataUri !== '') : ?>
        <img src="<?= $coverBgDataUri ?>" alt="" class="cover-bg-flow" width="210" height="297">
    <?php endif; ?>
    <table class="cover-grid" width="210" cellpadding="0" cellspacing="0" style="width:210mm;margin-top:-297mm;table-layout:fixed;border-collapse:collapse;">
        <tr>
            <td style="padding:0;margin:0;">
                <table width="210" height="<?= (int)$coverSpacerTopMm ?>" cellpadding="0" cellspacing="0" style="width:210mm;height:<?= (int)$coverSpacerTopMm ?>mm;border-collapse:collapse;table-layout:fixed;">
                    <tr>
                        <td class="cover-spacer-top" height="<?= (int)$coverSpacerTopMm ?>" style="height:<?= (int)$coverSpacerTopMm ?>mm;line-height:1px;font-size:1px;">&#160;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="cover-block-cell" style="padding:0 <?= (int)$coverInsetRightMm ?>mm <?= (int)$coverBlockBottomMm ?>mm <?= (int)$coverInsetLeftMm ?>mm;">
                <table class="cover-title-wrap" width="<?= (int)$coverCardWidthMm ?>" cellpadding="0" cellspacing="0" style="width:<?= (int)$coverCardWidthMm ?>mm;border-collapse:collapse;">
                    <tr>
                        <td align="center" style="width:<?= (int)$coverCardWidthMm ?>mm;text-align:center;padding:0 0 5mm 0;">
                            <span class="cover-ov-years"><?= $h($yearsLabel) ?></span>
                        </td>
                    </tr>
                </table>
                <table class="cover-ov-card" width="<?= (int)$coverCardWidthMm ?>" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="width:<?= (int)$coverCardWidthMm ?>mm;max-width:<?= (int)$coverCardWidthMm ?>mm;border-collapse:collapse;background-color:#ffffff;border-radius:12px;">
                    <tr>
                        <td bgcolor="#ffffff" style="background-color:#ffffff;padding:16px 12px 18px 14px;border-radius:12px;overflow:hidden;">
                            <table class="cover-fields" width="<?= (int)$coverFieldsWidthMm ?>" cellpadding="0" cellspacing="0" style="width:<?= (int)$coverFieldsWidthMm ?>mm;max-width:<?= (int)$coverFieldsWidthMm ?>mm;border-collapse:collapse;">
                                <?php foreach ($coverProductLines as $i => $line) : ?>
                                <tr>
                                    <td class="<?= $i === 0 ? 'cover-field-line' : 'cover-field-line-indented' ?>">
                                        <?php if ($i === 0) : ?><span class="cover-f-lbl">PRODUCT&nbsp;:</span><?php endif; ?>
                                        <span class="cover-f-val-txt"><?= $h($line) !== '' ? $h($line) : '&nbsp;' ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td class="cover-field-spacer" style="height:<?= (int)$coverFieldRowGapMm ?>mm;line-height:1px;font-size:1px;border:0;padding:0;">&#160;</td>
                                </tr>
                                <tr>
                                    <td class="cover-field-line">
                                        <span class="cover-f-lbl">PROJECT&nbsp;:</span>
                                        <span class="cover-f-val-txt cover-f-val-txt-wide"><?= $h($projectName) !== '' ? $h($projectName) : '&nbsp;' ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cover-field-spacer" style="height:<?= (int)$coverFieldRowGapMm ?>mm;line-height:1px;font-size:1px;border:0;padding:0;">&#160;</td>
                                </tr>
                                <tr>
                                    <td class="cover-field-line">
                                        <span class="cover-f-lbl">APPLICATOR&nbsp;:</span>
                                        <span class="cover-f-val-txt"><?= $h($applicator) !== '' ? $h($applicator) : '&nbsp;' ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cover-field-spacer" style="height:<?= (int)$coverFieldRowGapMm ?>mm;line-height:1px;font-size:1px;border:0;padding:0;">&#160;</td>
                                </tr>
                                <tr>
                                    <td class="cover-field-line">
                                        <span class="cover-f-lbl">DATE&nbsp;:</span>
                                        <span class="cover-f-val-txt cover-f-val-txt-wide"><?= $h($warrantyDate) !== '' ? $h($warrantyDate) : '&nbsp;' ?></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<!-- PAGE 2: DETAIL FORM -->
<div class="page page-break">
    <div class="page-inner-detail">
    <div class="detail-header">
        <?php if ($detailHeaderDataUri !== '') : ?>
            <img src="<?= $h($detailHeaderDataUri) ?>" alt="Durotech" class="detail-header-img">
        <?php else : ?>
        <table class="brand-table">
            <tr>
                <td style="width:78%;">
                    <?php if ($logoDataUri !== '') : ?>
                        <img src="<?= $h($logoDataUri) ?>" alt="Durotech" class="logo-img">
                    <?php else : ?>
                        <div style="font-size:22px;font-weight:700;color:#1e4f73;">DUROTECH</div>
                        <div style="font-size:9px;color:#4da3d9;">Waterproofing - Sealants - Adhesives</div>
                    <?php endif; ?>
                </td>
                <td style="width:22%; text-align:right;">
                    <?php if ($sealDataUri !== '') : ?>
                        <img src="<?= $h($sealDataUri) ?>" alt="Australian Made" class="seal-img">
                    <?php else : ?>
                        <div class="seal-fallback">AUSTRALIAN<br>MADE</div>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
        <?php endif; ?>
    </div>

    <div class="detail-body">
    <div class="detail-title"><?= $h($yearsLabel) ?></div>

    <div class="detail-box">
        <table class="detail-cols" cellpadding="0" cellspacing="0">
            <tr>
                <td class="detail-col-l" valign="top">
                    <div class="field-block">
                        <span class="field-label">Warranty Serial No.:</span>
                        <div class="field-line"><?= $h($serialNumber) !== '' ? $h($serialNumber) : '&nbsp;' ?></div>
                    </div>
                    <div class="field-block">
                        <span class="field-label">Product :</span>
                        <?php foreach ($detailProductLines as $line) : ?>
                        <div class="field-line"><?= $h($line) !== '' ? $h($line) : '&nbsp;' ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="field-block">
                        <span class="field-label">Building Name:</span>
                        <div class="field-line"><?= $h($buildingName) !== '' ? $h($buildingName) : '&nbsp;' ?></div>
                    </div>
                    <div class="field-block">
                        <span class="field-label">Building/Area Name :</span>
                        <?php foreach ($detailBuildingAreaLines as $line) : ?>
                        <div class="field-line"><?= $h($line) !== '' ? $h($line) : '&nbsp;' ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="field-block">
                        <span class="field-label">Applicator :</span>
                        <?php foreach ($detailApplicatorLines as $line) : ?>
                        <div class="field-line"><?= $h($line) !== '' ? $h($line) : '&nbsp;' ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="field-block">
                        <span class="field-label">Applicator's active ABN:</span>
                        <div class="field-line"><?= $h($applicatorAbn) !== '' ? $h($applicatorAbn) : '&nbsp;' ?></div>
                    </div>
                    <div class="field-block">
                        <span class="field-label">Commencement Date of Warranty Period:</span>
                        <?php foreach ($detailStartLines as $line) : ?>
                        <div class="field-line"><?= $h($line) !== '' ? $h($line) : '&nbsp;' ?></div>
                        <?php endforeach; ?>
                    </div>
                </td>
                <td class="detail-col-r" valign="top">
                    <div class="field-block">
                        <span class="field-label">Used As :</span>
                        <?php foreach ($detailUsedAsLines as $line) : ?>
                        <div class="field-line"><?= $h($line) !== '' ? $h($line) : '&nbsp;' ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="field-block">
                        <span class="field-label">Building Address :</span>
                        <?php foreach ($detailBuildingAddressLines as $line) : ?>
                        <div class="field-line"><?= $h($line) !== '' ? $h($line) : '&nbsp;' ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="field-block">
                        <span class="field-label">Area Warranted :</span>
                        <?php foreach ($detailAreaWarrantedLines as $line) : ?>
                        <div class="field-line"><?= $h($line) !== '' ? $h($line) : '&nbsp;' ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="field-block">
                        <span class="field-label">Applicator's Address :</span>
                        <?php foreach ($detailApplicatorAddressLines as $line) : ?>
                        <div class="field-line"><?= $h($line) !== '' ? $h($line) : '&nbsp;' ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="field-block">
                        <span class="field-label">Applicator's Contact Detail :</span>
                        <?php foreach ($detailApplicatorContactLines as $line) : ?>
                        <div class="field-line"><?= $h($line) !== '' ? $h($line) : '&nbsp;' ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="field-block">
                        <span class="field-label">End Date of Warranty Period :</span>
                        <?php foreach ($detailEndLines as $line) : ?>
                        <div class="field-line"><?= $h($line) !== '' ? $h($line) : '&nbsp;' ?></div>
                        <?php endforeach; ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="detail-footer"><?= $h($website) ?></div>
    </div>
    </div>
</div>

<?php if ($includeTermsPages) : ?>
<!-- PAGE 3: TERMS (Rajan reference image — Dompdf fallback only) -->
<?php if ($termsPage3DataUri !== '') : ?>
<div class="page page-break terms-image-page">
    <img src="<?= $h($termsPage3DataUri) ?>" alt="Terms, Conditions, Limitations" class="terms-fullpage-img">
</div>
<?php else : ?>
<div class="page page-break">
    <div class="page-inner">
    <div class="terms-brand">
        <table class="brand-table">
            <tr>
                <td style="width:78%;">
                    <?php if ($logoDataUri !== '') : ?>
                        <img src="<?= $h($logoDataUri) ?>" alt="Durotech" class="logo-img">
                    <?php else : ?>
                        <div style="font-size:22px;font-weight:700;color:#1e4f73;">DUROTECH</div>
                        <div style="font-size:9px;color:#4da3d9;">Commercial Waterproofing &amp; Sealants</div>
                    <?php endif; ?>
                </td>
                <td style="width:22%; text-align:right;">
                    <?php if ($sealDataUri !== '') : ?>
                        <img src="<?= $h($sealDataUri) ?>" alt="Australian Made" class="seal-img">
                    <?php else : ?>
                        <div class="seal-fallback">AUSTRALIAN<br>MADE</div>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="terms-title">TERMS, CONDITIONS, LIMITATIONS</div>
    <div class="terms-body">
        <p>Terms page image not found — HTML fallback.</p>
    </div>
    <div class="detail-footer"><?= $h($website) ?></div>
    </div>
</div>
<?php endif; ?>

<!-- PAGE 4: TERMS continued (Rajan reference image) -->
<?php if ($termsPage4DataUri !== '') : ?>
<div class="page terms-image-page">
    <img src="<?= $h($termsPage4DataUri) ?>" alt="Terms, Conditions, Limitations (continued)" class="terms-fullpage-img">
</div>
<?php else : ?>
<div class="page">
    <div class="page-inner">
    <div class="terms-title">TERMS, CONDITIONS, LIMITATIONS (CONTINUED)</div>
    <div class="terms-body"><p>Terms page image not found — HTML fallback.</p></div>
    <div class="detail-footer"><?= $h($website) ?></div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>

</body>
</html>
