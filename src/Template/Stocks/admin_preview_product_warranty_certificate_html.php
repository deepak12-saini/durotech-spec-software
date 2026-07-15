<?php
/**
 * Browser wrapper for product warranty certificate HTML (same as Dompdf input).
 *
 * @var int $requestId
 * @var string $rawPreviewUrl
 * @var string $pdfPreviewUrl
 * @var string $listUrl
 */
$requestId = (int)($requestId ?? 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Certificate HTML Preview #<?= $requestId ?></title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 0;
            background: #e8ecef;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            color: #333;
        }
        .preview-toolbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px 16px;
            padding: 12px 18px;
            background: #1e4f73;
            color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }
        .preview-toolbar strong { font-size: 15px; }
        .preview-toolbar a {
            color: #fff;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.12);
        }
        .preview-toolbar a:hover { background: rgba(255, 255, 255, 0.22); }
        .preview-toolbar a.primary { background: #f0ad4e; color: #222; font-weight: 700; }
        .preview-note {
            text-align: center;
            padding: 12px 16px;
            color: #666;
            font-size: 13px;
        }
        .preview-stage {
            padding: 20px 16px 40px;
            display: flex;
            justify-content: center;
        }
        .preview-frame-wrap {
            width: 210mm;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.18);
            background: #fff;
        }
        .preview-frame {
            display: block;
            width: 210mm;
            height: 620mm;
            border: 0;
            background: #fff;
        }
    </style>
</head>
<body>
    <div class="preview-toolbar">
        <strong>Certificate HTML Preview #<?= $requestId ?></strong>
        <span>Pages 1–2 (same HTML as PDF generator)</span>
        <a href="<?= h($pdfPreviewUrl) ?>" target="_blank" class="primary">Open PDF Preview</a>
        <a href="<?= h($rawPreviewUrl) ?>" target="_blank">Open raw HTML</a>
        <a href="<?= h($listUrl) ?>">Back to list</a>
    </div>
    <p class="preview-note">
        Check layout here first. Final PDF also merges vector terms pages 3–4 from <code>10_year_pdf.pdf</code>.
    </p>
    <div class="preview-stage">
        <div class="preview-frame-wrap">
            <iframe class="preview-frame" src="<?= h($rawPreviewUrl) ?>" title="Certificate HTML"></iframe>
        </div>
    </div>
</body>
</html>
