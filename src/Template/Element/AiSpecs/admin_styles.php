<style>
.aispec-admin {
	--aispec-teal: #0099cc;
	--aispec-dark: #2c3e50;
	--aispec-grey: #5a5a5a;
	--aispec-border: #e2e8f0;
	--aispec-bg: #f4f7fb;
}
.aispec-admin .page-header {
	border-bottom: 1px solid var(--aispec-border);
	margin-bottom: 20px;
	padding-bottom: 14px;
}
.aispec-admin .page-header h1 {
	margin: 0;
	font-size: 22px;
	font-weight: 600;
	color: var(--aispec-dark);
}
.aispec-admin .page-header h1 small {
	font-size: 13px;
	color: #7a8a99;
	font-weight: normal;
}
.aispec-admin .page-header-actions .btn {
	margin-left: 6px;
}
.aispec-admin .aispec-stat-row {
	margin-bottom: 18px;
}
.aispec-admin .aispec-stat-card {
	background: #fff;
	border: 1px solid var(--aispec-border);
	border-radius: 6px;
	padding: 14px 16px;
	text-align: center;
	box-shadow: 0 1px 3px rgba(0,0,0,.04);
	transition: box-shadow .2s, transform .2s;
}
.aispec-admin .aispec-stat-card:hover {
	box-shadow: 0 4px 12px rgba(0,0,0,.08);
	transform: translateY(-1px);
}
.aispec-admin .aispec-stat-card .stat-num {
	font-size: 26px;
	font-weight: 700;
	color: var(--aispec-teal);
	line-height: 1.2;
}
.aispec-admin .aispec-stat-card .stat-label {
	font-size: 12px;
	color: #7a8a99;
	text-transform: uppercase;
	letter-spacing: .4px;
	margin-top: 4px;
}
.aispec-admin .widget-box {
	border-radius: 6px;
	border: 1px solid var(--aispec-border);
	box-shadow: 0 1px 4px rgba(0,0,0,.05);
}
.aispec-admin .widget-header {
	background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
	border-bottom: 1px solid var(--aispec-border);
	padding: 10px 14px;
}
.aispec-admin .widget-header h5 {
	margin: 0;
	font-size: 14px;
	font-weight: 600;
	color: var(--aispec-dark);
}
.aispec-admin .widget-body {
	padding: 0;
}
.aispec-admin .widget-body .table-responsive {
	border: none;
	margin-bottom: 0;
}
.aispec-admin #aispec-table,
.aispec-admin #aispec-table.dataTable {
	width: 100% !important;
	margin-bottom: 0;
	border: 1px solid var(--aispec-border);
	border-collapse: collapse !important;
	border-spacing: 0 !important;
}
.aispec-admin #aispec-table thead th,
.aispec-admin #aispec-table tbody td,
.aispec-admin table.dataTable#aispec-table thead th,
.aispec-admin table.dataTable#aispec-table tbody td {
	border: 1px solid var(--aispec-border) !important;
	box-sizing: border-box;
}
.aispec-admin #aispec-table thead th {
	background: var(--aispec-grey);
	color: #fff;
	font-size: 11px;
	font-weight: 600;
	text-transform: uppercase;
	letter-spacing: .3px;
	padding: 10px 8px;
	white-space: nowrap;
}
.aispec-admin #aispec-table tbody td {
	vertical-align: middle;
	padding: 10px 8px;
	font-size: 13px;
}
.aispec-admin .dataTables_wrapper {
	border: none;
	padding: 0;
}
.aispec-admin .dataTables_wrapper .dataTables_scroll,
.aispec-admin .dataTables_wrapper .dataTables_scrollHead,
.aispec-admin .dataTables_wrapper .dataTables_scrollBody {
	border: none !important;
}
.aispec-admin #aispec-table tbody tr:hover {
	background: #f0f7fc;
}
.aispec-admin .aispec-project strong {
	display: block;
	color: var(--aispec-dark);
	max-width: 220px;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}
.aispec-admin .aispec-project small {
	color: #7a8a99;
}
.aispec-admin .aispec-track {
	font-family: Consolas, Monaco, monospace;
	font-size: 12px;
	color: #555;
	background: #f1f5f9;
	padding: 3px 8px;
	border-radius: 4px;
	display: inline-block;
}
.aispec-admin .aispec-actions .btn-group {
	display: inline-flex;
}
.aispec-admin .aispec-actions .btn {
	margin: 0 1px;
}
.aispec-admin .label-draft { background: #f0ad4e; }
.aispec-admin .label-submitted { background: #5cb85c; }

/* Form */
.aispec-form-admin .track-badge {
	display: inline-block;
	background: var(--aispec-dark);
	color: #fff;
	font-family: Consolas, Monaco, monospace;
	font-size: 13px;
	padding: 8px 14px;
	border-radius: 4px;
	margin-bottom: 16px;
}
.aispec-form-admin .panel-aispec {
	border: 1px solid var(--aispec-border);
	border-radius: 6px;
	margin-bottom: 18px;
	box-shadow: 0 1px 3px rgba(0,0,0,.04);
	overflow: hidden;
}
.aispec-form-admin .panel-aispec > .panel-heading {
	background: linear-gradient(90deg, var(--aispec-teal) 0%, #007aa3 100%);
	color: #fff;
	border: none;
	padding: 10px 16px;
	font-size: 14px;
	font-weight: 600;
}
.aispec-form-admin .panel-aispec > .panel-heading i {
	margin-right: 6px;
}
.aispec-form-admin .panel-aispec > .panel-body {
	padding: 16px;
	background: #fff;
}
.aispec-form-admin .panel-aispec.panel-matrix > .panel-heading {
	background: linear-gradient(90deg, var(--aispec-grey) 0%, #444 100%);
}
.aispec-form-admin .matrix-toolbar {
	background: var(--aispec-bg);
	border: 1px solid var(--aispec-border);
	border-radius: 6px;
	padding: 12px 14px;
	margin-bottom: 14px;
}
.aispec-form-admin .matrix-toolbar .btn {
	margin-right: 6px;
}
.aispec-form-admin .aispec-section-card {
	border: 1px solid var(--aispec-border);
	border-radius: 6px;
	margin-bottom: 16px;
	background: #fff;
	overflow: hidden;
	transition: box-shadow .2s;
}
.aispec-form-admin .aispec-section-card:hover {
	box-shadow: 0 4px 14px rgba(0,0,0,.07);
}
.aispec-form-admin .aispec-section-head {
	background: var(--aispec-grey);
	color: #fff;
	padding: 10px 14px;
	cursor: pointer;
	user-select: none;
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 12px;
	min-height: 48px;
}
.aispec-form-admin .aispec-section-head-main {
	flex: 1;
	min-width: 0;
	padding-right: 8px;
}
.aispec-form-admin .aispec-section-head .section-title {
	font-weight: 600;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: .3px;
	display: block;
	line-height: 1.35;
}
.aispec-form-admin .aispec-section-head .section-meta {
	font-size: 11px;
	opacity: .85;
	margin-top: 2px;
	line-height: 1.3;
}
.aispec-form-admin .aispec-section-head-actions {
	display: flex;
	align-items: center;
	flex-shrink: 0;
	gap: 10px;
}
.aispec-form-admin .aispec-section-head .btn-remove-section {
	margin: 0;
	border-color: rgba(255, 255, 255, 0.35);
	box-shadow: none;
	white-space: nowrap;
}
.aispec-form-admin .aispec-section-head .btn-remove-section:hover,
.aispec-form-admin .aispec-section-head .btn-remove-section:focus {
	border-color: #fff;
}
.aispec-form-admin .aispec-section-toggle {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	width: 28px;
	height: 28px;
	border-radius: 4px;
	background: rgba(255, 255, 255, 0.12);
	flex-shrink: 0;
}
.aispec-form-admin .aispec-section-head .toggle-icon {
	float: none;
	margin: 0;
	font-size: 14px;
	line-height: 1;
}
.aispec-form-admin .aispec-section-body {
	padding: 14px;
	background: #fafbfc;
}
.aispec-form-admin .aispec-section-body.collapsed {
	display: none;
}
.aispec-form-admin .aispec-row-table {
	width: 100%;
	margin: 0;
	background: #fff;
	border: 1px solid var(--aispec-border);
	border-radius: 4px;
	overflow: hidden;
}
.aispec-form-admin .aispec-row-table thead th {
	background: #e8eef4;
	color: var(--aispec-dark);
	font-size: 11px;
	font-weight: 600;
	text-transform: uppercase;
	padding: 8px 6px;
	border-bottom: 1px solid var(--aispec-border);
}
.aispec-form-admin .aispec-row-table tbody td {
	padding: 8px 6px;
	vertical-align: middle;
	border-top: 1px solid #edf2f7;
}
.aispec-form-admin .aispec-row-table .btn-remove-row {
	margin: 0;
	padding: 4px 8px;
	line-height: 1.2;
}
.aispec-form-admin .aispec-row-table tbody tr:hover {
	background: #f8fbff;
}
.aispec-form-admin .aispec-color-cell {
	min-width: 100px;
}
.aispec-form-admin .aispec-swatch {
	display: inline-block;
	width: 28px;
	height: 28px;
	border-radius: 4px;
	border: 2px solid rgba(0,0,0,.12);
	vertical-align: middle;
	margin-right: 6px;
}
.aispec-form-admin .aispec-color-inputs select,
.aispec-form-admin .aispec-color-inputs input {
	display: inline-block;
	vertical-align: middle;
}
.aispec-form-admin .btn-add-row-wrap {
	margin-top: 10px;
}
.aispec-form-admin .form-actions-sticky {
	position: sticky;
	bottom: 0;
	z-index: 50;
	background: rgba(255,255,255,.97);
	border-top: 2px solid var(--aispec-teal);
	padding: 14px 0;
	margin-top: 20px;
	box-shadow: 0 -4px 12px rgba(0,0,0,.06);
}
.aispec-form-admin .form-actions-sticky .btn-lg {
	min-width: 200px;
}
.aispec-form-admin .help-hint {
	font-size: 12px;
	color: #7a8a99;
	margin-top: 4px;
}
.aispec-form-admin .alert-example {
	border-left: 4px solid var(--aispec-teal);
}
.aispec-admin .dataTables_wrapper .dataTables_filter {
	float: right;
	margin-bottom: 12px;
}
.aispec-admin .dataTables_wrapper .dataTables_filter label {
	font-weight: normal;
	margin: 0;
}
.aispec-admin .dataTables_wrapper .dataTables_filter input {
	margin-left: 6px;
	min-width: 220px;
}
.aispec-admin .dataTables_wrapper .dataTables_length {
	float: left;
	margin-bottom: 12px;
}
.aispec-admin .dataTables_wrapper .dataTables_info,
.aispec-admin .dataTables_wrapper .dataTables_paginate {
	margin-top: 10px;
}
.aispec-admin .widget-box .widget-body {
	padding-top: 14px;
}
.aispec-view .aispec-view-meta-bar {
	background: #f4f7fb;
	border: 1px solid var(--aispec-border);
	border-radius: 6px;
	padding: 10px 14px;
	margin-bottom: 16px;
	font-size: 13px;
}
.aispec-view .aispec-view-meta-item {
	display: inline-block;
	margin-right: 20px;
	margin-bottom: 4px;
}
.aispec-view .label-sm {
	font-size: 11px;
	padding: 3px 8px;
}
/* PDF-style preview (matches generated PDF layout) */
.aispec-view .aispec-pdf-preview {
	max-width: 900px;
	margin: 0 auto 24px;
	border: 1px solid #bbbbbb;
	box-shadow: 0 4px 18px rgba(0, 0, 0, 0.12);
	font-family: Arial, Helvetica, sans-serif;
	background: #fff;
}
.aispec-view .aispec-pdf-title {
	background: #000000;
	color: #ffffff;
	text-align: center;
	font-size: 16px;
	font-weight: bold;
	padding: 10px 14px;
	letter-spacing: 0.2px;
}
.aispec-view .aispec-pdf-header-meta {
	background: #000000;
	color: #ffffff;
	padding: 4px 14px 12px;
}
.aispec-view .aispec-pdf-meta-table {
	border: none;
}
.aispec-view .aispec-pdf-meta-label {
	width: 72px;
	text-align: right;
	font-size: 11px;
	color: #ffffff;
	padding: 3px 10px 3px 0;
	vertical-align: top;
	white-space: nowrap;
}
.aispec-view .aispec-pdf-meta-value {
	font-size: 12px;
	font-weight: bold;
	color: #ffffff;
	padding: 3px 0;
	line-height: 1.35;
	vertical-align: top;
	word-break: break-word;
}
.aispec-view .aispec-pdf-standards {
	background: #625d59;
	border-top: 1px solid #bbbbbb;
	border-bottom: 1px solid #bbbbbb;
	padding: 6px 0;
}
.aispec-view .aispec-pdf-standards-table {
	width: 100%;
}
.aispec-view .aispec-pdf-standards-name {
	width: 46%;
	font-size: 11px;
	font-weight: bold;
	color: #ffffff;
	padding: 4px 8px 4px 12px;
	vertical-align: top;
	letter-spacing: 0.2px;
}
.aispec-view .aispec-pdf-standards-text {
	width: 54%;
	font-size: 10px;
	font-weight: normal;
	color: #ffffff;
	padding: 4px 12px 4px 0;
	text-align: right;
	line-height: 1.3;
	vertical-align: top;
	word-break: break-word;
}
.aispec-view .aispec-pdf-matrix {
	border-bottom: 1px solid #bbbbbb;
}
.aispec-view .aispec-pdf-row {
	display: table;
	width: 100%;
	table-layout: fixed;
	border-bottom: 1px solid #bbbbbb;
}
.aispec-view .aispec-pdf-row-last {
	border-bottom: none;
}
.aispec-view .aispec-pdf-wpm,
.aispec-view .aispec-pdf-content {
	display: table-cell;
	vertical-align: middle;
}
.aispec-view .aispec-pdf-wpm {
	width: 28px;
	min-width: 28px;
	max-width: 28px;
	text-align: center;
	font-size: 10px;
	font-weight: bold;
	line-height: 1.15;
	padding: 8px 2px;
	border-right: 1px solid #bbbbbb;
	word-wrap: break-word;
}
.aispec-view .aispec-pdf-content {
	padding: 8px 14px 8px 10px;
	background: #ffffff;
}
.aispec-view .aispec-pdf-topline {
	margin-bottom: 4px;
}
.aispec-view .aispec-pdf-area {
	float: left;
	width: 52%;
	font-size: 11px;
	color: #333333;
	line-height: 1.3;
	padding-right: 8px;
	word-break: break-word;
}
.aispec-view .aispec-pdf-fall {
	float: right;
	width: 48%;
	font-size: 10px;
	color: #444444;
	font-style: italic;
	line-height: 1.25;
	text-align: right;
	word-break: break-word;
}
.aispec-view .aispec-pdf-product {
	font-size: 12px;
	font-weight: bold;
	color: #000000;
	line-height: 1.3;
	margin-bottom: 2px;
	word-break: break-word;
}
.aispec-view .aispec-pdf-desc {
	font-size: 11px;
	color: #333333;
	line-height: 1.35;
	word-break: break-word;
}
.aispec-view .aispec-pdf-empty {
	padding: 16px 14px;
	font-size: 11px;
	color: #666666;
	background: #ffffff;
}
.aispec-view .aispec-pdf-footer {
	background: #000000;
	color: #ffffff;
	text-align: right;
	font-size: 10px;
	padding: 8px 14px;
	min-height: 18px;
	word-break: break-word;
}
@media (max-width: 767px) {
	.aispec-view .aispec-pdf-standards-name,
	.aispec-view .aispec-pdf-standards-text {
		display: block;
		width: 100%;
		text-align: left;
		padding: 4px 12px;
	}
	.aispec-view .aispec-pdf-area,
	.aispec-view .aispec-pdf-fall {
		float: none;
		width: 100%;
		text-align: left;
	}
	.aispec-view .aispec-pdf-fall {
		margin-top: 4px;
	}
}
@media (max-width: 991px) {
	.aispec-form-admin .aispec-row-table { font-size: 12px; }
	.aispec-form-admin .aispec-row-table input { min-width: 80px; }
}
</style>
