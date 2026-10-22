<?php
/**
 * Product Warranty v2 — customer portal (approved / pending; linked from approval email).
 *
 * @var string $status
 * @var string $product
 * @var string $coverage
 * @var string $area
 * @var string $certificateUrl
 * @var bool $hasCertificate
 * @var string $contractName
 * @var string $companyName
 * @var string $customerEmail
 */
$siteName = defined('SITENAME') ? SITENAME : 'Durotech Industries';
$siteUrl = defined('SITEURL') ? rtrim((string)SITEURL, '/') : '';
$salesEmail = 'sales@durotechindustries.com.au';
$status = $status ?? 'approved';
$product = $product ?? '';
$coverage = $coverage ?? '';
$area = $area ?? '';
$certificateUrl = $certificateUrl ?? '';
$hasCertificate = !empty($hasCertificate);
$portalToken = $portalToken ?? '';
$contractName = $contractName ?? '';
$companyName = $companyName ?? '';
$customerEmail = $customerEmail ?? '';
$isApproved = strtolower((string)$status) === 'approved';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($siteName) ?> | Product Warranty</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        :root {
            --pw-navy: #0b2d4a;
            --pw-navy-dark: #071f35;
            --pw-gold: #f5b335;
            --pw-gold-dark: #d99612;
            --pw-green: #1f8f4e;
            --pw-green-bg: #e8f7ee;
            --pw-page-bg: #eef1f4;
            --pw-text: #1a2b3c;
            --pw-muted: #6b7c8f;
            --pw-border: #d8dee6;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, Helvetica, sans-serif;
            background: var(--pw-page-bg);
            color: var(--pw-text);
            line-height: 1.5;
        }
        a { color: inherit; }

        .pw-hero {
            background: linear-gradient(165deg, var(--pw-navy) 0%, var(--pw-navy-dark) 100%);
            color: #fff;
            padding: 0 0 88px;
            position: relative;
            overflow: hidden;
        }
        .pw-hero::after {
            content: "";
            position: absolute;
            right: -80px;
            top: -40px;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            pointer-events: none;
        }
        .pw-hero-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 14px 24px 0;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.82);
        }
        .pw-stripes {
            height: 14px;
            margin: 14px 0 0;
            background: repeating-linear-gradient(
                -45deg,
                var(--pw-gold) 0,
                var(--pw-gold) 12px,
                var(--pw-navy-dark) 12px,
                var(--pw-navy-dark) 24px
            );
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            border-bottom: 1px solid rgba(0, 0, 0, 0.15);
        }
        .pw-hero-body {
            max-width: 980px;
            margin: 0 auto;
            padding: 28px 24px 0;
        }
        .pw-badge {
            display: inline-block;
            background: rgba(245, 179, 53, 0.18);
            color: var(--pw-gold);
            border: 1px solid rgba(245, 179, 53, 0.45);
            border-radius: 999px;
            padding: 5px 14px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-bottom: 14px;
        }
        .pw-hero h1 {
            margin: 0 0 12px;
            font-size: 42px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .pw-hero-intro {
            max-width: 720px;
            margin: 0 0 24px;
            font-size: 15px;
            color: rgba(255, 255, 255, 0.9);
        }
        .pw-meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.88);
        }
        .pw-meta-row strong {
            display: block;
            color: #fff;
            font-size: 14px;
            margin-top: 2px;
        }

        .pw-wrap {
            max-width: 980px;
            margin: -56px auto 0;
            padding: 0 16px 40px;
            position: relative;
            z-index: 2;
        }
        .pw-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(11, 45, 74, 0.12);
            border: 1px solid rgba(11, 45, 74, 0.06);
            padding: 28px 28px 24px;
            margin-bottom: 22px;
        }
        .pw-approved-icon {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: var(--pw-green);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 12px;
        }
        .pw-status-pill {
            display: inline-block;
            background: var(--pw-green-bg);
            color: var(--pw-green);
            border-radius: 999px;
            padding: 5px 12px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .pw-card h2 {
            margin: 0 0 8px;
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            color: var(--pw-navy);
        }
        .pw-card-lead {
            text-align: center;
            color: var(--pw-muted);
            max-width: 640px;
            margin: 0 auto 24px;
            font-size: 14px;
        }
        .pw-summary {
            display: flex;
            flex-wrap: wrap;
            border: 1px solid var(--pw-border);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 22px;
        }
        .pw-summary-item {
            flex: 1 1 180px;
            padding: 16px 18px;
            border-right: 1px solid var(--pw-border);
        }
        .pw-summary-item:last-child { border-right: 0; }
        .pw-summary-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.7px;
            text-transform: uppercase;
            color: var(--pw-muted);
            margin-bottom: 6px;
        }
        .pw-summary-value {
            font-size: 16px;
            font-weight: 700;
            color: var(--pw-text);
        }
        .pw-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
        }
        .pw-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 46px;
            padding: 0 22px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            border: 2px solid transparent;
            cursor: pointer;
            transition: background 0.15s ease, border-color 0.15s ease;
        }
        .pw-btn-primary {
            background: var(--pw-gold);
            color: #1a1a1a;
            border-color: var(--pw-gold);
        }
        .pw-btn-primary:hover,
        .pw-btn-primary:focus {
            background: var(--pw-gold-dark);
            border-color: var(--pw-gold-dark);
            color: #1a1a1a;
            text-decoration: none;
        }
        .pw-btn-secondary {
            background: #fff;
            color: var(--pw-navy);
            border-color: var(--pw-navy);
        }
        .pw-btn-secondary:hover,
        .pw-btn-secondary:focus {
            background: #f7fafc;
            color: var(--pw-navy);
            text-decoration: none;
        }
        .pw-btn[disabled],
        .pw-btn.is-disabled {
            opacity: 0.65;
            cursor: not-allowed;
            pointer-events: none;
        }

        .pw-update-head {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 20px;
        }
        .pw-update-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: var(--pw-navy);
            color: var(--pw-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .pw-update-head h3 {
            margin: 0 0 4px;
            font-size: 20px;
            font-weight: 700;
            color: var(--pw-navy);
        }
        .pw-update-head p {
            margin: 0;
            color: var(--pw-muted);
            font-size: 14px;
        }
        .pw-form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--pw-text);
            margin-bottom: 6px;
        }
        .pw-form-control {
            width: 100%;
            border: 1px solid var(--pw-border);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            color: var(--pw-text);
            background: #fff;
        }
        .pw-form-control:focus {
            outline: none;
            border-color: var(--pw-navy);
            box-shadow: 0 0 0 3px rgba(11, 45, 74, 0.12);
        }
        textarea.pw-form-control {
            min-height: 110px;
            resize: vertical;
        }
        .pw-upload {
            border: 2px dashed var(--pw-border);
            border-radius: 10px;
            padding: 24px 16px;
            text-align: center;
            color: var(--pw-muted);
            background: #fafbfc;
            cursor: pointer;
            position: relative;
            transition: border-color 0.15s ease, background 0.15s ease;
        }
        .pw-upload:hover,
        .pw-upload.is-dragover {
            border-color: #2889c8;
            background: #f0f7fc;
        }
        .pw-upload i {
            font-size: 28px;
            color: var(--pw-navy);
            margin-bottom: 8px;
        }
        .pw-upload strong {
            display: block;
            color: var(--pw-text);
            margin-bottom: 4px;
        }
        .pw-upload-filename {
            display: block;
            margin-top: 10px;
            font-size: 13px;
            color: var(--pw-navy);
            font-weight: 600;
        }
        .pw-upload-clear {
            display: none;
            margin-top: 8px;
            background: none;
            border: 0;
            color: #c0392b;
            font-size: 13px;
            text-decoration: underline;
            cursor: pointer;
            padding: 0;
        }
        .pw-upload.has-file .pw-upload-clear {
            display: inline-block;
        }
        .pw-update-footer {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 18px;
        }
        .pw-update-note {
            color: var(--pw-muted);
            font-size: 13px;
            max-width: 420px;
        }
        .pw-page-footer {
            text-align: center;
            color: var(--pw-muted);
            font-size: 12px;
            line-height: 1.7;
            padding: 8px 16px 24px;
        }
        .pw-pending {
            text-align: center;
            padding: 12px 0 4px;
        }
        .pw-pending .pw-status-pill {
            background: #fff4df;
            color: #9a6700;
        }

        @media (max-width: 767px) {
            .pw-hero h1 { font-size: 32px; }
            .pw-hero-top { flex-direction: column; align-items: flex-start; }
            .pw-summary-item {
                border-right: 0;
                border-bottom: 1px solid var(--pw-border);
            }
            .pw-summary-item:last-child { border-bottom: 0; }
            .pw-actions { flex-direction: column; }
            .pw-btn { width: 100%; }
            .pw-update-footer { flex-direction: column; align-items: stretch; }
        }
    </style>
</head>
<body>

<section class="pw-hero">
    <div class="pw-hero-top">
        <span><?= h($siteName) ?> — Commercial Waterproofing &amp; Sealants</span>
        <span>Trialled · Tested · Approved since 1977</span>
    </div>
    <div class="pw-stripes"></div>
    <div class="pw-hero-body">
        <span class="pw-badge">Warranty Registration</span>
        <h1>Product Warranty</h1>
        <p class="pw-hero-intro">
            Register your completed Durotech application to activate coverage. Fill in every field below —
            the more precise the detail, the faster your certificate is issued.
        </p>
        <div class="pw-meta-row">
            <div>
                <span>Processing time</span>
                <strong>3–5 business days</strong>
            </div>
            <div>
                <span>Sent to</span>
                <strong><?= h($salesEmail) ?></strong>
            </div>
            <div>
                <span>Reference</span>
                <strong>Retain for your records</strong>
            </div>
        </div>
    </div>
</section>

<div class="pw-wrap">
    <?= $this->Flash->render() ?>

    <?php if ($isApproved) : ?>
    <div class="pw-card">
        <div class="pw-approved-icon"><i class="fa fa-check"></i></div>
        <div class="text-center">
            <span class="pw-status-pill">Warranty Approved</span>
        </div>
        <h2>Your warranty has been approved</h2>
        <p class="pw-card-lead">
            Durotech has reviewed and approved your Product Warranty Request. Your certificate is ready —
            download it now or send a copy straight to your inbox.
        </p>

        <div class="pw-summary">
            <div class="pw-summary-item">
                <span class="pw-summary-label">Product</span>
                <span class="pw-summary-value"><?= h($product) ?></span>
            </div>
            <div class="pw-summary-item">
                <span class="pw-summary-label">Coverage</span>
                <span class="pw-summary-value"><?= h($coverage) ?></span>
            </div>
            <div class="pw-summary-item">
                <span class="pw-summary-label">Area</span>
                <span class="pw-summary-value"><?= h($area) ?></span>
            </div>
        </div>

        <div class="pw-actions">
            <?php if ($hasCertificate || $certificateUrl !== '') : ?>
            <a href="<?= h($certificateUrl) ?>" class="pw-btn pw-btn-primary">
                <i class="fa fa-download"></i> Download Certificate (PDF)
            </a>
            <?php else : ?>
            <span class="pw-btn pw-btn-primary is-disabled" title="Certificate is being prepared">
                <i class="fa fa-download"></i> Download Certificate (PDF)
            </span>
            <?php endif; ?>
            <button type="button" class="pw-btn pw-btn-secondary" id="pw-email-toggle">
                <i class="fa fa-envelope-o"></i> Email Certificate to Me
            </button>
        </div>

        <div id="pw-email-panel" style="display:none;margin-top:18px;padding-top:18px;border-top:1px solid var(--pw-border);">
            <?= $this->Form->create(null, [
                'url' => ['controller' => 'Fronts', 'action' => 'productWarrantyV2PortalEmail', $portalToken],
                'type' => 'post',
            ]) ?>
            <label class="pw-form-label" for="pw-email-address">Email address</label>
            <div style="display:flex;flex-wrap:wrap;gap:10px;align-items:center;">
                <input type="email" class="pw-form-control" id="pw-email-address" name="email" placeholder="you@company.com" value="<?= h($customerEmail) ?>" required style="max-width:320px;">
                <button type="submit" class="pw-btn pw-btn-primary">Send Certificate</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <?php else : ?>
    <div class="pw-card pw-pending">
        <span class="pw-status-pill">Under Review</span>
        <h2>Your warranty request is being reviewed</h2>
        <p class="pw-card-lead">
            Thank you for submitting your Product Warranty Request. Our team will review your application and notify you when your certificate is ready.
        </p>
    </div>
    <?php endif; ?>

    <?php /* Customer "update warranty" form — unused for now. Change false to true to show again. */ if (false) : ?>
    <div class="pw-card">
        <div class="pw-update-head">
            <div class="pw-update-icon"><i class="fa fa-pencil"></i></div>
            <div>
                <h3>Want to update something in your warranty?</h3>
                <p>Send us the correction and supporting documents — we'll review and follow up.</p>
            </div>
        </div>

        <?= $this->Form->create(null, [
            'id' => 'pw-update-form',
            'url' => ['controller' => 'Fronts', 'action' => 'productWarrantyV2PortalUpdate', $portalToken],
            'type' => 'file',
        ]) ?>
            <div class="row">
                <div class="col-sm-6">
                    <label class="pw-form-label" for="pw-update-name">Name</label>
                    <input type="text" class="pw-form-control" id="pw-update-name" name="name" placeholder="Your full name" value="<?= h($contractName) ?>" required>
                </div>
                <div class="col-sm-6">
                    <label class="pw-form-label" for="pw-update-company">Company Name</label>
                    <input type="text" class="pw-form-control" id="pw-update-company" name="company_name" placeholder="Your company name" value="<?= h($companyName) ?>">
                </div>
            </div>
            <div style="margin-top:14px;">
                <div style="display:flex;justify-content:space-between;align-items:center;gap:8px;">
                    <label class="pw-form-label" for="pw-update-notes" style="margin:0;">Notes</label>
                    <span style="font-size:12px;color:var(--pw-muted);">what needs to be updated</span>
                </div>
                <textarea class="pw-form-control" id="pw-update-notes" name="notes" placeholder="Describe the change you'd like made to your warranty..." required></textarea>
            </div>
            <div style="margin-top:14px;">
                <label class="pw-form-label">Attach Supporting PDF <span style="font-weight:400;color:var(--pw-muted);">(optional)</span></label>
                <div class="pw-upload" id="pw-upload-zone" role="button" tabindex="0" aria-label="Attach supporting PDF">
                    <i class="fa fa-file-pdf-o"></i>
                    <strong id="pw-upload-title">Click to attach a PDF or drag and drop here</strong>
                    <span>max 10MB</span>
                    <span class="pw-upload-filename" id="pw-upload-filename" style="display:none;"></span>
                    <button type="button" class="pw-upload-clear" id="pw-upload-clear">Remove file</button>
                    <input type="file" id="pw-supporting-pdf" name="supporting_pdf" accept="application/pdf,.pdf" style="display:none;">
                </div>
            </div>
            <div class="pw-update-footer">
                <div class="pw-update-note">
                    Our warranty team typically responds to update requests within 2 business days.
                </div>
                <button type="submit" class="pw-btn pw-btn-primary" id="pw-update-submit">
                    Send Update Request <i class="fa fa-arrow-right"></i>
                </button>
            </div>
        <?= $this->Form->end() ?>
    </div>
    <?php endif; ?>
</div>

<footer class="pw-page-footer">
    <?= h($siteName) ?> — 14 Essex Street, Minto NSW 2566<br>
    Fax 02 9475 5059 — <?= h($salesEmail) ?> — <?= h($siteUrl !== '' ? $siteUrl : 'www.durotechindustries.com.au') ?>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
(function () {
    $('#pw-email-toggle').on('click', function () {
        $('#pw-email-panel').slideToggle(150);
    });

    <?php /* Update-request upload JS — unused while the form above is hidden. */ if (false) : ?>
    var $zone = $('#pw-upload-zone');
    var $input = $('#pw-supporting-pdf');
    var $filename = $('#pw-upload-filename');
    var $title = $('#pw-upload-title');
    var $clear = $('#pw-upload-clear');
    var maxBytes = 10 * 1024 * 1024;

    function setFile(file) {
        if (!file) {
            clearFile();
            return;
        }
        var name = (file.name || '').toLowerCase();
        var type = (file.type || '').toLowerCase();
        if (name.slice(-4) !== '.pdf' && type !== 'application/pdf') {
            alert('Please attach a PDF file only.');
            clearFile();
            return;
        }
        if (file.size > maxBytes) {
            alert('PDF must be 10MB or smaller.');
            clearFile();
            return;
        }

        try {
            var dt = new DataTransfer();
            dt.items.add(file);
            $input[0].files = dt.files;
        } catch (e) {
            // Fallback: only click-to-select works in older browsers without DataTransfer.
            if (!$input[0].files || !$input[0].files.length) {
                alert('Please use Click to attach a PDF (drag and drop is not supported in this browser).');
                return;
            }
        }

        $filename.text(file.name).show();
        $title.text('PDF selected');
        $zone.addClass('has-file');
    }

    function clearFile() {
        $input.val('');
        $filename.hide().text('');
        $title.text('Click to attach a PDF or drag and drop here');
        $zone.removeClass('has-file');
    }

    $zone.on('click', function (e) {
        if ($(e.target).is($clear) || $(e.target).closest('#pw-upload-clear').length) {
            return;
        }
        $input.trigger('click');
    });

    $zone.on('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            $input.trigger('click');
        }
    });

    $input.on('click', function (e) {
        e.stopPropagation();
    });

    $input.on('change', function () {
        var file = this.files && this.files[0] ? this.files[0] : null;
        if (file) {
            setFile(file);
        } else {
            clearFile();
        }
    });

    $clear.on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        clearFile();
    });

    $zone.on('drag dragstart dragend dragover dragenter dragleave drop', function (e) {
        e.preventDefault();
        e.stopPropagation();
    });

    $zone.on('dragover dragenter', function () {
        $zone.addClass('is-dragover');
    });

    $zone.on('dragleave dragend drop', function () {
        $zone.removeClass('is-dragover');
    });

    $zone.on('drop', function (e) {
        var files = e.originalEvent.dataTransfer && e.originalEvent.dataTransfer.files
            ? e.originalEvent.dataTransfer.files
            : null;
        if (files && files.length) {
            setFile(files[0]);
        }
    });

    $('#pw-update-form').on('submit', function () {
        var notes = $.trim($('#pw-update-notes').val() || '');
        var name = $.trim($('#pw-update-name').val() || '');
        if (!name) {
            alert('Please enter your name.');
            return false;
        }
        if (!notes) {
            alert('Please describe what needs to be updated.');
            return false;
        }
        $('#pw-update-submit').prop('disabled', true).html('Sending…');
        return true;
    });
    <?php endif; ?>
})();
</script>
</body>
</html>
