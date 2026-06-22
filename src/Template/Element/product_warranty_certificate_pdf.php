<?php
/**
 * Product Warranty Request Form — single-page PDF (client reference layout).
 *
 * @var array<string, mixed> $log
 * @var array<int, string> $applicationLines
 * @var array<int, string> $addressLines
 * @var string $headerImageDataUri
 * @var string $footerImageDataUri
 * @var string $dateOfPurchase
 * @var string $startWarranty
 * @var string $endWarranty
 * @var string $signDate
 * @var string $siteName
 * @var string $siteUrl
 */
$h = static function ($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
};
$val = static function ($v) use ($h) {
    return $h($v);
};
$fieldLine = static function ($v) use ($val) {
    return '<div class="field-line">' . $val($v) . '&nbsp;</div>';
};
$inlineFieldLine = static function ($label, $value, $labelSuffix = '') use ($val, $h) {
    return '<div class="field-line"><span class="label-inline">' . $h($label) . $h($labelSuffix) . '</span> ' . $val($value) . '&nbsp;</div>';
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Warranty Request Form</title>
    <style>
        @page { margin: 3mm 5mm 2mm 5mm; size: A4 portrait; }
        * { box-sizing: border-box; }
        html, body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10px;
            color: #222;
            margin: 0;
            padding: 0;
            line-height: 1.3;
        }
        .page {
            width: 100%;
            background: #fff;
            page-break-inside: avoid;
            position: relative;
            min-height: 288mm;
        }
        .page-body {
            padding: 0 0 72px;
        }
        .page-footer {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
        }
        .header-img {
            display: block;
            width: 100%;
            height: auto;
            margin: 0;
            padding: 0;
        }
        .title-wrap {
            text-align: center;
            margin-top: -48px;
            padding: 0 16px 2px;
            background: #fff;
            position: relative;
            z-index: 2;
        }
        .title-wrap h1 {
            margin: 0 0 2px;
            font-size: 18px;
            font-weight: 700;
            color: #222;
            line-height: 1.15;
        }
        .title-line {
            width: 72%;
            max-width: 300px;
            margin: 0 auto;
            border-top: 2.5px solid #2f95cd;
        }
        .content { padding: 0 14px 0; }
        .label {
            display: block;
            color: #4da3d9;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.35;
            margin: 0 0 3px;
        }
        .label .hint {
            color: #222;
            font-size: 9.5px;
            line-height: 1.38;
            font-weight: 400;
        }
        .label-inline {
            color: #4da3d9;
            font-size: 14px;
            font-weight: 400;
        }
        .label-below {
            display: block;
            margin-top: 1px;
        }
        .fine-print {
            font-size: 9.5px;
            line-height: 1.38;
            color: #222;
        }
        .field-line {
            border-bottom: 1px dashed #555;
            padding: 2px 6px 3px;
            font-size: 12px;
            font-weight: 400;
            color: #222;
            min-height: 14px;
            margin: 0 0 1px;
            line-height: 1.28;
            background: #fff;
        }
        .field-block { margin-bottom: 1px; }
        .grid-2 {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }
        .grid-2 td {
            width: 50%;
            vertical-align: top;
            padding: 0 6px 0 0;
        }
        .grid-2 td.col-right { padding: 0 0 0 6px; }
        .legal {
            text-align: justify;
            margin: 2px 0 2px;
        }
        .legal p { margin: 0 0 2px; }
        .legal.fine-print {
            font-size: 10.5px;
            line-height: 1.36;
        }
        .legal p.legal-gap-after { margin-bottom: 3px; }
        .legal p.legal-gap-before-next { margin-bottom: 7px; }
        .bottom-grid {
            width: 100%;
            border-collapse: collapse;
            margin-top: 3px;
        }
        .bottom-grid td {
            vertical-align: top;
            width: 33.33%;
            padding: 0 5px 0 0;
        }
        .bottom-grid td.col-mid { padding: 0 3px 0; text-align: center; }
        .bottom-grid td.col-right { padding: 0 0 0 5px; }
        .bottom-grid .field-line { margin-bottom: 0; }
        .bottom-grid .label,
        .bottom-grid .label-below,
        .bottom-grid .label-inline {
            color: #222;
            font-size: 12px;
            font-weight: 400;
        }
        .bottom-grid .label-below {
            display: block;
            margin: 1px 0 2px;
            text-align: left;
        }
        .bottom-grid td.col-mid .label-below {
            text-align: center;
        }
        .bottom-grid td.col-right .label-below {
            text-align: left;
        }
        .sign-area {
            min-height: 20px;
            padding: 1px 0 0;
            text-align: center;
        }
        .signature-img {
            display: block;
            max-width: 92%;
            max-height: 38px;
            margin: 0 auto;
        }
        .period-line { font-size: 12px; font-weight: 400; }
        .period-line .sub { color: #666; font-size: 11px; font-weight: 400; }
        .footer-block {
            text-align: center;
            padding: 4px 14px 2px;
            margin-top: 0;
            page-break-inside: avoid;
        }
        .footer-note {
            margin: 0 0 4px;
        }
        .footer-line {
            border-top: 3px solid #2f95cd;
            margin: 0 0 5px;
            width: 100%;
        }
        .footer-company {
            font-size: 18px;
            font-weight: 700;
            color: #2f95cd;
            margin: 0 0 4px;
            line-height: 1.2;
            letter-spacing: 0.15px;
        }
        .footer-contact {
            font-size: 9px;
            color: #444;
            margin: 0 0 3px;
        }
        .footer-website {
            font-size: 10px;
            font-weight: 400;
            color: #222;
            margin: 0;
        }
        .footer-img {
            display: block;
            width: 100%;
            height: auto;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="page">
    <div class="page-body">
    <?php if ($headerImageDataUri !== '') : ?>
        <img src="<?= $headerImageDataUri ?>" alt="Header" class="header-img">
    <?php endif; ?>

    <div class="title-wrap">
        <h1>Product Warranty Request Form</h1>
        <div class="title-line"></div>
    </div>

    <div class="content">
        <table class="grid-2">
            <tr>
                <td>
                    <div class="field-block">
                        <span class="label">1. Warranty Serial No.:</span>
                        <?= $fieldLine($log['serialnumber'] ?? '') ?>
                    </div>
                </td>
                <td class="col-right">
                    <div class="field-block">
                        <span class="label">2. Date Of Purchase of Products:</span>
                        <?= $fieldLine($dateOfPurchase) ?>
                    </div>
                </td>
            </tr>
        </table>

        <table class="grid-2">
            <tr>
                <td>
                    <div class="field-block">
                        <span class="label">3. Product <span class="hint">(Please specify the amount of the Product used):</span></span>
                        <?= $fieldLine($log['product'] ?? '') ?>
                    </div>
                </td>
                <td class="col-right">
                    <div class="field-block">
                        <span class="label">4. Used As <span class="hint">(Please set out in detail the manner in which the Product was used in relation to 6.):</span></span>
                        <?= $fieldLine($log['used_as'] ?? '') ?>
                    </div>
                </td>
            </tr>
        </table>

        <div class="field-block">
            <span class="label">5. Application <span class="hint">(Please describe the manner in which the Products were applied, where applicable make reference to Durotech specifications and manuals):</span></span>
            <?= $fieldLine($applicationLines[0]) ?>
            <?= $fieldLine($applicationLines[1]) ?>
        </div>

        <table class="grid-2">
            <tr>
                <td>
                    <div class="field-block">
                        <span class="label">6. Area Warranted <span class="hint">(Please provide specific measurements):</span></span>
                        <?= $fieldLine($log['area_warranted'] ?? '') ?>
                    </div>
                </td>
                <td class="col-right">
                    <div class="field-block">
                        <span class="label">7. Building Address:</span>
                        <?= $fieldLine($log['building_address'] ?? '') ?>
                    </div>
                </td>
            </tr>
        </table>

        <table class="grid-2">
            <tr>
                <td>
                    <div class="field-block">
                        <span class="label">8. Building Name:</span>
                        <?= $fieldLine($log['building_name'] ?? '') ?>
                    </div>
                </td>
                <td class="col-right">
                    <div class="field-block">
                        <span class="label">9. Requested Warranty Period:</span>
                        <div class="field-line period-line">
                            <span class="sub">Start</span> <?= $val($startWarranty) ?>
                            &nbsp;/&nbsp;
                            <span class="sub">End</span> <?= $val($endWarranty) ?>&nbsp;
                        </div>
                    </div>
                </td>
            </tr>
        </table><br>

        <div class="legal fine-print">
            <p class="legal-gap-after">(For reference the process of using the Products listed in point 3 for the purposes set out in point 4, applied in the manner depicted in point 5 for the area described in point 6 in the location set out in points 7 and 8 will be referred to as &lsquo;Durotech Product Application&rsquo;.)</p>
            <p class="legal-gap-after">I confirm that I am the Contractor in charge of the building/development/construction of the location stated at point 7 and 8 and I am properly authorised and in a fully informed position to make these statements.</p>
            <p class="legal-gap-after">I certify that the Durotech Product Application was implemented and I confirm that no Durotech representative or employee were present prior or during the Durotech Product Application process or involved in any aspect of Application noted in point 5.</p>
            <p class="legal-gap-before-next">I understand that Durotech will rely on this certificate in order to issue a report approving the use of Durotech&rsquo;s Products and that the information on this certificate may be required and relied upon for warranty purposes at a later date. I understand that improper use or application of Durotech Products may result in their failure which may result in legal action or an award of damages against Durotech. As such, I further certify and declare that the facts, details and information herein are correct and that the Durotech Product Application has been conducted in strict accordance with Durotech&rsquo;s specifications and manuals as at the date of purchase of the Product (see point 2).</p>
            <p>By signing below I acknowledge and confirm that I have read, understood and agreed to what has been stated above and will incur any liability for and indemnify Durotech against any claim, expense or order for costs arising from any errors in the aforementioned material.</p>
        </div>

        <table class="bottom-grid">
            <tr>
                <td><?= $fieldLine($log['contract_company_name'] ?? '') ?></td>
                <td class="col-mid"><div class="field-line"><?= $val($signDate) ?> / .........&nbsp;</div></td>
                <td class="col-right"><?= $fieldLine($log['contract_name'] ?? '') ?></td>
            </tr>
            <tr>
                <td><span class="label label-below">Contractors Company name</span></td>
                <td class="col-mid"><span class="label label-below">Signature/Date</span></td>
                <td class="col-right"><div class="field-line">................ / ............................&nbsp;</div></td>
            </tr>
            <tr>
                <td><?= $inlineFieldLine('ABN No.', $log['applicator_active_abn'] ?? '', ' ') ?></td>
                <td class="col-mid">
                    <div class="sign-area">
                        <?php if (!empty($signatureImageDataUri)) : ?>
                            <img src="<?= $signatureImageDataUri ?>" alt="Signature" class="signature-img">
                        <?php endif; ?>
                    </div>
                </td>
                <td class="col-right"><span class="label label-below">Contractors full name</span></td>
            </tr>
            <tr>
                <td><?= $inlineFieldLine('Address', $addressLines[0] ?? '', ' : ') ?></td>
                <td class="col-mid">&nbsp;</td>
                <td class="col-right">&nbsp;</td>
            </tr>
            <?php if (trim((string)($addressLines[1] ?? '')) !== '') : ?>
            <tr>
                <td><?= $fieldLine($addressLines[1]) ?></td>
                <td class="col-mid">&nbsp;</td>
                <td class="col-right">&nbsp;</td>
            </tr>
            <?php endif; ?>
            <?php if (trim((string)($addressLines[2] ?? '')) !== '') : ?>
            <tr>
                <td><?= $fieldLine($addressLines[2]) ?></td>
                <td class="col-mid">&nbsp;</td>
                <td class="col-right">&nbsp;</td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
    </div>

    <div class="page-footer">
    <?php if ($footerImageDataUri !== '') : ?>
        <img src="<?= $footerImageDataUri ?>" alt="Footer" class="footer-img">
    <?php else : ?>
        <div class="footer-block">
            <p class="footer-note fine-print">Please forward this completed application form together with details of the product(s) purchased to;</p>
            <div class="footer-line"></div>
            <p class="footer-company" style="color:#2f95cd;font-size:20px;font-weight:bold;margin:0 0 4px;"><?= $h($siteName) ?></p>
            <p class="footer-contact">14 Essex Street Minto NSW 2566 &nbsp;|&nbsp; Fax: 02 9475 5059 &nbsp;|&nbsp; Email: sales@durotechindustries.com.au</p>
            <p class="footer-website">www.durotechindustries.com.au</p>
        </div>
    <?php endif; ?>
    </div>
</div>
</body>
</html>
