<?php
$log = !empty($entity) ? $entity->toArray() : ($warrantyLog['ProductWarrantyRequest'] ?? []);
$formEntity = $entity ?? null;
$siteName = defined('SITENAME') ? SITENAME : 'Durotech Industries';
$siteUrl = defined('SITEURL') ? rtrim((string)SITEURL, '/') : '';
$logoUrl = $siteUrl !== '' ? $siteUrl . '/customdurotech/images/durotech_logo_new.png?v=20260520' : '';
$headerImageUrl = $siteUrl !== '' ? $siteUrl . '/customdurotech/images/Warranty_Header.png?v=20260602' : '';
$footerImageUrl = $siteUrl !== '' ? $siteUrl . '/customdurotech/images/Warranty_Footer_White.png?v=20260602' : '';
$applicationLines = ['', '', ''];
if (!empty($log['application'])) {
    $applicationLines = array_pad(preg_split('/,\s*/', (string)$log['application'], 3), 3, '');
}
$addressLines = ['', '', ''];
if (!empty($log['applicator_address'])) {
    $addressLines = array_pad(preg_split('/\r\n|\r|\n/', (string)$log['applicator_address'], 3), 3, '');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Warranty Request Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css">
    <style>
        body { background-color: #e8e8e8; font-family: Arial, sans-serif; padding: 24px 16px 40px; margin: 0; }
        .warranty-page {
            max-width: 920px;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 2px 18px rgba(0, 0, 0, 0.12);
            overflow: hidden;
        }
        .warranty-header {
            width: 100%;
            margin: 0;
            padding: 0;
            border: none;
            background: #fff;
            box-shadow: none;
            overflow: hidden;
            line-height: 0;
        }
        .warranty-header-banner {
            display: block;
            width: 100%;
            max-width: 100%;
            height: auto;
            margin: 0;
            padding: 0;
            border: 0;
            vertical-align: top;
        }
        .warranty-footer {
            width: 100%;
            margin: 0;
            padding: 0;
            border: none;
            background: #fff;
            overflow: hidden;
            line-height: 1.45;
        }
        .warranty-footer-banner {
            display: none;
            width: 100%;
            max-width: 100%;
            height: auto;
            margin: 0;
            padding: 0;
            border: 0;
            vertical-align: top;
        }
        .warranty-footer.has-footer-image .warranty-footer-banner {
            display: block;
        }
        .warranty-footer.has-footer-image .warranty-footer-fallback {
            display: none;
        }
        .warranty-footer-fallback {
            display: block;
            text-align: center;
            padding: 28px 32px 32px;
            background: #fff;
            line-height: 1.45;
        }
        .warranty-footer-fallback .footer-note {
            margin: 0 0 14px;
            font-size: 12px;
            color: #888;
        }
        .warranty-footer-fallback .footer-line {
            width: 100%;
            max-width: 100%;
            margin: 0 auto 14px;
            border-top: 3px solid #2f95cd;
        }
        .warranty-footer-fallback .footer-company {
            margin: 0 0 10px;
            font-size: 22px;
            font-weight: 700;
            color: #2f95cd;
        }
        .warranty-footer-fallback .footer-contact {
            margin: 0 0 8px;
            font-size: 12px;
            color: #666;
        }
        .warranty-footer-fallback .footer-website {
            margin: 0;
            font-size: 13px;
            font-weight: 700;
        }
        .warranty-footer-fallback .footer-website a {
            color: #222;
            text-decoration: none;
        }
        .warranty-footer-fallback .footer-website a:hover {
            color: #2f95cd;
            text-decoration: underline;
        }
        .warranty-header-fallback { display: none; }
        .warranty-header-top {
            position: relative;
            padding: 16px 28px 72px;
            background: #fff;
        }
        .warranty-header-top::after {
            content: '';
            position: absolute;
            left: -2%;
            right: -2%;
            bottom: -42px;
            height: 95px;
            background: #ffffff;
            border-top-left-radius: 68% 100%;
            border-top-right-radius: 68% 100%;
        }
        .warranty-header-logos {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
        }
        .warranty-header .brand-logo {
            max-width: 430px;
            width: 100%;
            height: auto;
            display: block;
        }
        .warranty-header-badge {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 4px solid #3c9327;
            background: #f0ba15;
            color: #145d27;
            font-size: 11px;
            font-weight: 700;
            text-align: center;
            line-height: 1.15;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            box-shadow: inset 0 0 0 2px #e9e26a;
        }
        .warranty-header-ribbon {
            min-width: 180px;
            text-align: center;
            color: #bf8f28;
            font-weight: 700;
            line-height: 1;
        }
        .warranty-header-ribbon .year {
            font-size: 52px;
            letter-spacing: 1px;
        }
        .warranty-header-ribbon .since {
            font-size: 19px;
            margin-bottom: 2px;
        }
        .warranty-header-ribbon .trusted {
            margin-top: 4px;
            color: #3a6ea4;
            font-size: 12px;
            font-weight: 600;
        }
        .warranty-sheet {
            border: none;
            background: #fff;
            margin: 0;
        }
        .page-content { max-width: none; margin: 0; padding: 0 0 24px; }
        .page-content > .row {
            margin-left: 0;
            margin-right: 0;
        }
        .page-content > .row > [class*="col-"] {
            padding-left: 0;
            padding-right: 0;
        }
        .warranty-form-title {
            text-align: center;
            padding: 6px 32px 14px;
            margin-top: -48px;
            background: #fff;
            position: relative;
            z-index: 2;
        }
        .warranty-form-title h2 {
            margin: 0 0 8px;
            font-size: 28px;
            font-weight: 700;
            color: #222;
            line-height: 1.2;
        }
        .warranty-form-title .title-line {
            width: 340px;
            max-width: 90%;
            margin: 0 auto;
            border-top: 3px solid #2f95cd;
        }
        .btn { margin-bottom: 2px; }
        .warranty-label {
            display: block;
            color: #4da3d9;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.35;
            margin: 0 0 4px;
        }
        .warranty-label .hint { color: #888; font-size: 12px; }
        .warranty-field { margin-bottom: 16px; }
        .warranty-field input + input { margin-top: 6px; }
        .warranty-period-row { display: flex; align-items: center; gap: 6px; }
        .warranty-period-row input { flex: 1; }
        .warranty-period-sep { color: #666; font-weight: 700; padding: 0 2px; }
        .warranty-legal { font-size: 11px; line-height: 1.55; color: #333; margin: 18px 0; }
        input, textarea {
            border: none !important;
            border-bottom: 1px dashed #444 !important;
            border-left: 0 !important;
            border-right: 0 !important;
            border-top: 0 !important;
            margin-bottom: 0;
            padding: 7px 10px;
            border-radius: 0;
            background: #dde8f2 !important;
            width: 100%;
            font-size: 14px;
            color: #222;
        }
        input:focus, textarea:focus {
            outline: none;
            border-bottom-color: #2f95cd !important;
            background: #fff !important;
        }
        input.has-value, textarea.has-value {
            background: #fff !important;
        }
        input::placeholder, textarea::placeholder { color: transparent; }
        .form-group small { display: none; }
        .text-danger { font-size: 12px; margin-top: 4px; display: block; }
        .warranty-card { border: none; background: #fff; padding: 4px 32px 24px; }
        .form-group { margin-bottom: 0; }
        .warranty-submit-wrap { text-align: center; padding: 12px 0 8px; }
        #add_ser_prd_btn { min-width: 130px; }
        .warranty-signature-box {
            border: 1px dashed #888;
            background: #fff;
            max-width: 100%;
        }
        #signature-pad {
            display: block;
            width: 100%;
            max-width: 360px;
            height: 100px;
            touch-action: none;
            cursor: crosshair;
        }
        .warranty-signature-actions {
            margin: 6px 0 8px;
        }
        .warranty-signature-actions .btn {
            padding: 2px 10px;
            font-size: 12px;
        }

        @media (max-width: 767px) {
            body { padding: 10px 8px 24px; background: #fff; }
            .warranty-page { max-width: 100%; box-shadow: none; }
            .warranty-footer-banner { width: 100%; height: auto; }
            .warranty-footer-fallback { padding: 20px 16px 24px; }
            .warranty-footer-fallback .footer-company { font-size: 18px; }
            .warranty-footer-fallback .footer-contact { font-size: 11px; }
            .warranty-header-top {
                padding: 10px 10px 36px;
            }
            .warranty-header-top::after {
                bottom: -22px;
                height: 52px;
                border-top-left-radius: 75% 100%;
                border-top-right-radius: 75% 100%;
            }
            .warranty-header-logos { gap: 8px; }
            .warranty-header .brand-logo { max-width: 220px; }
            .warranty-header-badge {
                width: 52px;
                height: 52px;
                font-size: 8px;
                border-width: 2px;
                padding: 3px;
            }
            .warranty-header-ribbon {
                min-width: 74px;
            }
            .warranty-header-ribbon .since { font-size: 10px; }
            .warranty-header-ribbon .year { font-size: 25px; }
            .warranty-header-ribbon .trusted { font-size: 8px; margin-top: 1px; }
            .warranty-form-title { padding: 4px 16px 12px; margin-top: -28px; }
            .warranty-form-title h2 { font-size: 22px; margin-bottom: 6px; }
            .warranty-form-title .title-line { border-top-width: 2px; width: 220px; }
            .page-content { padding: 0 0 20px; }
            .warranty-card { padding: 4px 16px 16px; }
            .warranty-label { font-size: 13px; }
            .warranty-legal { font-size: 12px; }
            .form-group [class*="col-"] { margin-bottom: 12px; }
            input, textarea { font-size: 16px; padding: 9px 8px; }
            #add_ser_prd_btn { min-width: 140px; min-height: 44px; font-size: 16px; }
        }
    </style>
</head>
<body>
    <div class="warranty-page">
    <div class="warranty-header">
        <?php if ($headerImageUrl !== '') : ?>
            <img
                src="<?= h($headerImageUrl) ?>"
                alt="Product Warranty Header"
                class="warranty-header-banner"
                onerror="this.style.display='none'; var fb=document.getElementById('warranty-header-fallback'); if(fb){fb.style.display='block';}"
            >
        <?php endif; ?>
        <div class="warranty-header-fallback" id="warranty-header-fallback">
            <div class="warranty-header-top">
                <div class="warranty-header-logos">
                    <div>
                        <?php if ($logoUrl !== '') : ?>
                            <a href="<?= h($siteUrl) ?>/"><img src="<?= h($logoUrl) ?>" alt="<?= h($siteName) ?>" class="brand-logo"></a>
                        <?php else : ?>
                            <span class="brand"><?= h($siteName) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="warranty-header-badge">AUSTRALIAN<br>MADE</div>
                    <div class="warranty-header-ribbon">
                        <div class="since">SINCE</div>
                        <div class="year">1977</div>
                        <div class="trusted">Trusted • Tried • Approved</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-lg-12 warranty-form-title">
                <h2>Product Warranty Request Form</h2>
                <div class="title-line"></div>
            </div>
            <div class="col-lg-12 warranty-sheet">
                <div class="warranty-card">
                <?= $this->Flash->render() ?>
                <?= $this->Form->create($formEntity, ['url' => ['controller' => 'Fronts', 'action' => 'productWarranty'], 'type' => 'post', 'class' => 'form-horizontal', 'id' => 'product-warranty-form']) ?>

                <div class="form-group">
                    <div class="col-sm-6 warranty-field">
                        <label class="warranty-label" for="serialnumber">1. Warranty Serial No.:</label>
                        <input type="text" name="ProductWarrantyRequest[serialnumber]" value="<?= h(@$log['serialnumber']) ?>" id="serialnumber">
                        <?= $this->Form->error('serialnumber', null, ['class' => 'text-danger']) ?>
                    </div>
                    <div class="col-sm-6 warranty-field">
                        <label class="warranty-label" for="dateofpurchase">2. Date Of Purchase of Products:</label>
                        <input type="text" name="ProductWarrantyRequest[dateofpurchase]" value="<?= !empty($log['dateofpurchase']) ? format_db_date('Y-m-d', $log['dateofpurchase']) : '' ?>" id="dateofpurchase" class="datepicker" required>
                        <?= $this->Form->error('dateofpurchase', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6 warranty-field">
                        <label class="warranty-label" for="product">3. Product <span class="hint">(Please specify the amount of the Product used):</span></label>
                        <input type="text" name="ProductWarrantyRequest[product]" value="<?= h(@$log['product']) ?>" id="product" required>
                        <?= $this->Form->error('product', null, ['class' => 'text-danger']) ?>
                    </div>
                    <div class="col-sm-6 warranty-field">
                        <label class="warranty-label" for="used_as">4. Used As <span class="hint">(Please set out in detail the manner in which the Product was used in relation to 6.):</span></label>
                        <input type="text" name="ProductWarrantyRequest[used_as]" value="<?= h(@$log['used_as']) ?>" id="used_as">
                        <?= $this->Form->error('used_as', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12 warranty-field">
                        <label class="warranty-label">5. Application <span class="hint">(Please describe the manner in which the Products were applied, where applicable make reference to Durotech specifications and manuals):</span></label>
                        <input type="text" name="ProductWarrantyRequest[application][]" value="<?= h($applicationLines[0]) ?>" id="application_1">
                        <input type="text" name="ProductWarrantyRequest[application][]" value="<?= h($applicationLines[1]) ?>" id="application_2">
                        <input type="text" name="ProductWarrantyRequest[application][]" value="<?= h($applicationLines[2]) ?>" id="application_3">
                        <?= $this->Form->error('application', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6 warranty-field">
                        <label class="warranty-label" for="area_warranted">6. Area Warranted <span class="hint">(Please provide specific measurements):</span></label>
                        <input type="text" name="ProductWarrantyRequest[area_warranted]" value="<?= h(@$log['area_warranted']) ?>" id="area_warranted">
                        <?= $this->Form->error('area_warranted', null, ['class' => 'text-danger']) ?>
                    </div>
                    <div class="col-sm-6 warranty-field">
                        <label class="warranty-label" for="building_address">7. Building Address:</label>
                        <input type="text" name="ProductWarrantyRequest[building_address]" value="<?= h(@$log['building_address']) ?>" id="building_address" required>
                        <?= $this->Form->error('building_address', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6 warranty-field">
                        <label class="warranty-label" for="building_name">8. Building Name:</label>
                        <input type="text" name="ProductWarrantyRequest[building_name]" value="<?= h(@$log['building_name']) ?>" id="building_name">
                        <?= $this->Form->error('building_name', null, ['class' => 'text-danger']) ?>
                    </div>
                    <div class="col-sm-6 warranty-field">
                        <label class="warranty-label">9. Requested Warranty Period:</label>
                        <div class="warranty-period-row">
                            <input type="text" name="ProductWarrantyRequest[start_requested_warranty]" value="<?= !empty($log['start_requested_warranty']) ? format_db_date('Y-m-d', $log['start_requested_warranty']) : '' ?>" id="start_requested_warranty" class="datepicker" placeholder="Start">
                            <span class="warranty-period-sep">/</span>
                            <input type="text" name="ProductWarrantyRequest[end_requested_warranty]" value="<?= !empty($log['end_requested_warranty']) ? format_db_date('Y-m-d', $log['end_requested_warranty']) : '' ?>" id="end_requested_warranty" class="datepicker" placeholder="End">
                        </div>
                        <?= $this->Form->error('start_requested_warranty', null, ['class' => 'text-danger']) ?>
                        <?= $this->Form->error('end_requested_warranty', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <?php /* Removed from new PDF – kept in DB for older records only
                <div class="form-group">
                    <div class="col-sm-12 warranty-field">
                        <label class="warranty-label" for="building_area_name">Building/Area Name:</label>
                        <input type="text" name="ProductWarrantyRequest[building_area_name]" value="<?= h(@$log['building_area_name']) ?>" id="building_area_name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6 warranty-field">
                        <label class="warranty-label" for="applicator">Applicator:</label>
                        <input type="text" name="ProductWarrantyRequest[applicator]" value="<?= h(@$log['applicator']) ?>" id="applicator">
                    </div>
                    <div class="col-sm-6 warranty-field">
                        <label class="warranty-label" for="applicator_contact">Applicator Contact Details:</label>
                        <input type="text" name="ProductWarrantyRequest[applicator_contact]" value="<?= h(@$log['applicator_contact']) ?>" id="applicator_contact">
                    </div>
                </div>
                */ ?>

                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="warranty-legal">
                            (For reference the process of using the Products listed in point 3 for the purposes set out in point 4, applied in the manner depicted in point 5 for the area described in point 6 in the location set out in points 7 and 8 will be referred to as &lsquo;Durotech Product Application&rsquo;.)<br><br>
                            I confirm that I am the Contractor in charge of the building/development/construction of the location stated at point 7 and 8 and I am properly authorised and in a fully informed position to make these statements.<br><br>
                            I certify that the Durotech Product Application was implemented and I confirm that no Durotech representative or employee were present prior or during the Durotech Product Application process or involved in any aspect of Application noted in point 5.<br><br>
                            I understand that Durotech will rely on this certificate in order to issue a report approving the use of Durotech&rsquo;s Products and that the information on this certificate may be required and relied upon for warranty purposes at a later date. I understand that improper use or application of Durotech Products may result in their failure which may result in legal action or an award of damages against Durotech. As such, I further certify and declare that the facts, details and information herein are correct and that the Durotech Product Application has been conducted in strict accordance with Durotech&rsquo;s specifications and manuals as at the date of purchase of the Product (see point 2).<br><br>
                            By signing below I acknowledge and confirm that I have read, understood and agreed to what has been stated above and will incur any liability for and indemnify Durotech against any claim, expense or order for costs arising from any errors in the aforementioned material.
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6 warranty-field">
                        <label class="warranty-label" for="contract_company_name">Contractors Company name</label>
                        <input type="text" name="ProductWarrantyRequest[contract_company_name]" value="<?= h(@$log['contract_company_name']) ?>" id="contract_company_name" required>
                        <?= $this->Form->error('contract_company_name', null, ['class' => 'text-danger']) ?>
                    </div>
                    <div class="col-sm-6 warranty-field">
                        <label class="warranty-label" for="applicator_active_abn">ABN No.:</label>
                        <input type="text" name="ProductWarrantyRequest[applicator_active_abn]" value="<?= h(@$log['applicator_active_abn']) ?>" id="applicator_active_abn">
                        <?= $this->Form->error('applicator_active_abn', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12 warranty-field">
                        <label class="warranty-label">Address:</label>
                        <input type="text" name="ProductWarrantyRequest[applicator_address][]" value="<?= h($addressLines[0]) ?>" id="applicator_address_1">
                        <input type="text" name="ProductWarrantyRequest[applicator_address][]" value="<?= h($addressLines[1]) ?>" id="applicator_address_2">
                        <input type="text" name="ProductWarrantyRequest[applicator_address][]" value="<?= h($addressLines[2]) ?>" id="applicator_address_3">
                        <?= $this->Form->error('applicator_address', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6 warranty-field">
                        <label class="warranty-label">Signature/Date:</label>
                        <div class="warranty-signature-box">
                            <canvas id="signature-pad" class="signature-pad" width="360" height="100"></canvas>
                        </div>
                        <div class="warranty-signature-actions">
                            <button type="button" class="btn btn-default btn-xs" id="clear-signature">Clear signature</button>
                        </div>
                        <input type="hidden" name="sigimage" id="sigimage" value="">
                        <?= $this->Form->error('contractor_signature', null, ['class' => 'text-danger']) ?>
                        <input type="text" name="ProductWarrantyRequest[sign_date]" value="<?= !empty($log['sign_date']) ? format_db_date('Y-m-d', $log['sign_date']) : '' ?>" id="sign_date" class="datepicker" required placeholder="Date">
                        <?= $this->Form->error('sign_date', null, ['class' => 'text-danger']) ?>
                    </div>
                    <div class="col-sm-6 warranty-field">
                        <label class="warranty-label" for="contract_name">Contractors full name</label>
                        <input type="text" name="ProductWarrantyRequest[contract_name]" value="<?= h(@$log['contract_name']) ?>" id="contract_name" required>
                        <?= $this->Form->error('contract_name', null, ['class' => 'text-danger']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12 warranty-submit-wrap">
                        <?= $this->Form->button('Submit', ['type' => 'submit', 'class' => 'btn btn-success', 'id' => 'add_ser_prd_btn']) ?>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

    <div class="warranty-footer">
        <?php if ($footerImageUrl !== '') : ?>
            <img
                src="<?= h($footerImageUrl) ?>"
                alt="Product Warranty Footer"
                class="warranty-footer-banner"
                onload="this.parentNode.classList.add('has-footer-image');"
                onerror="this.style.display='none';"
            >
        <?php endif; ?>
        <div class="warranty-footer-fallback" id="warranty-footer-fallback">
            <p class="footer-note">Please forward this completed application form together with details of the product(s) purchased to;</p>
            <div class="footer-line"></div>
            <p class="footer-company">Durotech Industries</p>
            <p class="footer-contact">14 Essex Street Minto NSW 2566 &nbsp;|&nbsp; Fax: 02 9475 5059 &nbsp;|&nbsp; Email: sales@durotechindustries.com.au</p>
            <p class="footer-website"><a href="<?= h($siteUrl !== '' ? $siteUrl . '/' : 'https://www.durotechindustries.com.au/') ?>" target="_blank" rel="noopener noreferrer">www.durotechindustries.com.au</a></p>
        </div>
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
    <?php if ($siteUrl !== '') : ?>
    <script src="<?= h($siteUrl) ?>/signature_pad-master/signature_pad-master/js/signature_pad.js"></script>
    <?php endif; ?>
    <script type="text/javascript">
        jQuery(function(){
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });

            function syncInputBg($el) {
                $el.toggleClass('has-value', $.trim($el.val()) !== '');
            }
            $('#product-warranty-form input[type="text"]').on('input change', function() {
                syncInputBg($(this));
            }).each(function() {
                syncInputBg($(this));
            });

            var signatureCanvas = document.getElementById('signature-pad');
            var signaturePad = null;
            if (signatureCanvas && typeof SignaturePad !== 'undefined') {
                signaturePad = new SignaturePad(signatureCanvas, {
                    backgroundColor: 'rgb(255, 255, 255)'
                });

                function resizeSignaturePad() {
                    var ratio = Math.max(window.devicePixelRatio || 1, 1);
                    var width = signatureCanvas.offsetWidth || 360;
                    signatureCanvas.width = width * ratio;
                    signatureCanvas.height = 100 * ratio;
                    signatureCanvas.getContext('2d').scale(ratio, ratio);
                    signaturePad.clear();
                }

                resizeSignaturePad();
                $(window).on('resize', resizeSignaturePad);

                $('#clear-signature').on('click', function() {
                    signaturePad.clear();
                    $('#sigimage').val('');
                });
            }

            $('#product-warranty-form').on('submit', function(e) {
                if (signaturePad) {
                    if (signaturePad.isEmpty()) {
                        e.preventDefault();
                        alert('Please sign in the signature box before submitting.');
                        return false;
                    }
                    $('#sigimage').val(signaturePad.toDataURL('image/png'));
                } else if ($.trim($('#sigimage').val()) === '') {
                    e.preventDefault();
                    alert('Signature pad failed to load. Please refresh the page and try again.');
                    return false;
                }
            });
        });
    </script>
</body>
</html>
