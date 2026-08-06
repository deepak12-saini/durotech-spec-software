<?php
/**
 * Shared Spec create/edit form UI (employee panel).
 * Matches webroot/spec_ui_preview.html look while keeping Ace form-horizontal fields.
 */
?>
<style>
	.spec-ui-page.page-content,
	.page-content.spec-ui-page {
		padding-top: 18px;
	}
	.spec-ui-page .page-header {
		border-bottom: 0;
		margin-bottom: 0;
		padding-bottom: 0;
		padding-top: 6px;
	}
	.spec-ui-shell {
		background: #fff;
		border: 1px solid #d7e0ea;
		border-radius: 16px;
		box-shadow: 0 10px 28px rgba(30, 51, 72, 0.08);
		overflow: visible;
		margin-bottom: 48px;
	}
	/* Keep ACE absolute footer from colliding with Submit / Publish */
	.spec-ui-page {
		padding-bottom: 72px;
	}
	.spec-ui-page .spec-ui-actions {
		margin-top: 8px;
		padding: 16px 0 8px;
		border-top: 1px solid #e6eef5;
	}
	body.no-skin .main-container > .footer .footer-content {
		white-space: nowrap;
		text-align: center;
	}
	body.no-skin .main-container > .footer .footer-content .bigger-120,
	body.no-skin .main-container > .footer .footer-content .blue.bolder {
		display: inline !important;
		white-space: nowrap;
	}
	.spec-ui-head {
		padding: 18px 22px 14px;
		border-bottom: 1px solid #d7e0ea;
		display: flex;
		justify-content: space-between;
		gap: 12px;
		align-items: flex-start;
		background: linear-gradient(180deg, #fff 0%, #f7fbff 100%);
		border-radius: 16px 16px 0 0;
	}
	.spec-ui-head h1 {
		margin: 0 !important;
		font-size: 22px;
		font-weight: 700;
		color: #1e3348;
	}
	.spec-ui-head h1 small {
		display: block;
		margin-top: 4px;
		font-size: 13px;
		color: #5b6f82;
		font-weight: 600;
	}
	.spec-ui-head .btn {
		border-radius: 8px;
		font-weight: 700;
	}
	.spec-ui-status {
		margin: 14px 22px 0;
		background: #eaf4ff;
		border: 1px solid #c7ddf5;
		border-radius: 10px;
		padding: 10px 14px;
		display: flex;
		flex-wrap: wrap;
		gap: 10px 18px;
		align-items: center;
		font-size: 13px;
		color: #1e3348;
	}
	.spec-ui-status .status-pill {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		background: #fff;
		border: 1px solid #c7ddf5;
		border-radius: 999px;
		padding: 3px 10px;
		font-weight: 700;
		color: #1f5fa8;
	}
	.spec-ui-body {
		padding: 18px 22px 8px;
	}
	.spec-ui-card {
		border: 1px solid #d7e0ea;
		border-radius: 12px;
		background: #fff;
		margin-bottom: 16px;
		overflow: visible;
		position: relative;
	}
	.spec-ui-card > .spec-ui-card-title {
		margin: 0;
		padding: 12px 16px;
		font-size: 13px;
		letter-spacing: .02em;
		text-transform: uppercase;
		color: #355875;
		background: #f4f8fc;
		border-bottom: 1px solid #d7e0ea;
		border-radius: 12px 12px 0 0;
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 10px;
		font-weight: 700;
	}
	.spec-ui-card > .spec-ui-card-title .hint {
		text-transform: none;
		letter-spacing: 0;
		font-weight: 600;
		color: #5b6f82;
		font-size: 12px;
	}
	.spec-ui-card > .spec-ui-card-body {
		padding: 20px 16px 10px;
	}
	.spec-ui-card .form-group {
		margin-bottom: 12px !important;
		overflow: visible;
	}
	.spec-ui-card .control-label {
		color: #5b6f82 !important;
		font-weight: 700 !important;
		font-size: 12px !important;
	}
	#specForm.spec-ui-form input[type="text"],
	#specForm.spec-ui-form input[type="file"],
	#specForm.spec-ui-form select,
	.spec-ui-form input[type="text"],
	.spec-ui-form input[type="file"],
	.spec-ui-form select {
		border-radius: 8px !important;
		border: 1px solid #c9d5e3 !important;
		height: 38px;
		padding: 8px 12px !important;
		transition: border-color .2s ease, box-shadow .2s ease;
	}
	#specForm.spec-ui-form input[type="text"]:focus,
	#specForm.spec-ui-form select:focus,
	.spec-ui-form input[type="text"]:focus,
	.spec-ui-form select:focus {
		border-color: #2f7bd7 !important;
		box-shadow: 0 0 0 3px rgba(47,123,215,.16) !important;
		outline: none;
	}
	#specForm.spec-ui-form input[readonly],
	.spec-ui-form input[readonly] {
		background: #edf1f5 !important;
		color: #475569;
	}
	.spec-ui-toolbar {
		display: flex;
		justify-content: space-between;
		align-items: center;
		gap: 10px;
		flex-wrap: wrap;
		margin-bottom: 12px;
	}
	.spec-ui-toolbar .muted,
	.spec-ui-toolbar-note.muted {
		font-size: 13px;
		color: #5b6f82;
		margin: 2px 0 14px;
	}
	.spec-ui-add-section {
		margin: 4px 0 12px;
		text-align: left;
	}
	.spec-ui-add-section .btn {
		min-width: 120px;
	}
	.spec-ui-actions {
		position: sticky;
		bottom: 0;
		background: rgba(255,255,255,.96);
		border-top: 1px solid #d7e0ea;
		padding: 12px 22px;
		display: flex;
		justify-content: flex-end;
		gap: 10px;
		flex-wrap: wrap;
		z-index: 50;
		border-radius: 0 0 16px 16px;
		box-shadow: 0 -6px 18px rgba(30,51,72,.06);
	}
	.spec-ui-actions .btn {
		border-radius: 8px !important;
		font-weight: 700;
		padding: 8px 16px !important;
		min-height: 38px;
	}
	.spec-ui-actions .btn-success {
		background: #3a9d6e !important;
		border-color: #3a9d6e !important;
	}
	/* Use Area: full-width, left-aligned (no empty col-sm-3 gutter) */
	.spec-ui-form .form-group.addsection {
		margin-left: 0 !important;
		margin-right: 0 !important;
	}
	.spec-ui-form .form-group.addsection > label.col-sm-3,
	.spec-ui-form .form-group.addsection > .col-sm-3 {
		display: none !important;
		width: 0 !important;
		padding: 0 !important;
		margin: 0 !important;
	}
	.spec-ui-form .form-group.addsection > .col-sm-9,
	.spec-ui-form .form-group.addsection > .col-xs-12 {
		width: 100% !important;
		max-width: 100% !important;
		float: none !important;
		margin-left: 0 !important;
		margin-right: 0 !important;
		padding-left: 0 !important;
		padding-right: 0 !important;
		background: #fbfdff !important;
		border: 1px solid #d5e2ef !important;
		border-radius: 10px !important;
		box-shadow: none !important;
		padding: 12px !important;
		margin-bottom: 12px !important;
		overflow-x: auto;
		-webkit-overflow-scrolling: touch;
	}
	.spec-ui-form .addsection table {
		width: 100%;
		min-width: 560px;
		border-collapse: separate;
		border-spacing: 0 6px;
	}
	/* Space between Use Area title field and S.No / Product Type heading row */
	.spec-ui-form .addsection table > tbody > tr:first-child > td,
	.spec-ui-form .addsection table > tr:first-child > td {
		padding-bottom: 8px;
	}
	.spec-ui-form .addsection input[name^="title"] {
		width: 100% !important;
		max-width: 100% !important;
		margin-bottom: 0;
		/* Soft PDF-style Use Area title bar only (not product rows) */
		background: #e8f1f8 !important;
		border-color: #b7c9dc !important;
		color: #1f1f1f !important;
		font-weight: 700 !important;
		font-size: 14px !important;
		font-family: Arial, Helvetica, sans-serif !important;
	}
	.spec-ui-form .addsection input[name^="title"]:focus {
		background: #e8f1f8 !important;
		border-color: #2f7bd7 !important;
	}
	.spec-ui-form .addsection th {
		font-size: 11px;
		font-weight: 700;
		color: #46607a;
		white-space: nowrap;
		padding: 0 4px 6px;
	}
	.spec-ui-form .addsection td {
		padding: 0 4px;
		vertical-align: middle;
	}
	.spec-ui-form .addsection input[type="text"] {
		max-width: 100%;
		box-sizing: border-box;
	}
	.spec-ui-form .addsection input[name="serial[]"] {
		width: 56px !important;
	}
	.spec-ui-form .addsection input[name="coverage[]"],
	.spec-ui-form .addsection input[name="product[]"] {
		width: 100% !important;
		min-width: 120px;
		max-width: 220px;
	}
	.spec-ui-form .addsection input[name="coverage_by_pack[]"],
	.spec-ui-form .addsection input[name="Warranty[]"] {
		width: 90px !important;
	}
	/* Comments / empty-label rows inside cards: also left-align */
	.spec-ui-form .spec-ui-card-body > .form-group > label.col-sm-3:empty {
		display: none !important;
	}
	.spec-ui-form .spec-ui-card-body > .form-group > label.col-sm-3:empty + .col-sm-9 {
		width: 100% !important;
		float: none !important;
		margin-left: 0 !important;
	}
	.spec-ui-form .commentdiv {
		width: 100%;
		max-width: 100%;
		margin-bottom: 12px;
		border-collapse: collapse;
		table-layout: fixed;
	}
	.spec-ui-form .commentdiv th {
		text-align: left;
		font-size: 12px;
		color: #5b6f82;
		padding: 0 0 6px;
		font-weight: 700;
	}
	.spec-ui-form .commentdiv th:last-child {
		width: 40px;
	}
	.spec-ui-form .commentdiv td {
		vertical-align: middle !important;
		padding: 0;
	}
	.spec-ui-form .commentdiv td:first-child {
		width: calc(100% - 40px);
		padding-right: 8px;
	}
	.spec-ui-form .commentdiv td:last-child {
		width: 40px;
		text-align: center;
		vertical-align: middle !important;
		white-space: nowrap;
	}
	.spec-ui-form .commentdiv td:last-child a {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 32px;
		height: 38px;
		line-height: 1;
		margin: 0;
		padding: 0;
		color: #c65353 !important;
		font-size: 16px;
		font-weight: 700;
		text-decoration: none;
		vertical-align: middle;
	}
	.spec-ui-form .commentdiv input[type="text"],
	.spec-ui-form .spec-comment-input {
		width: 100% !important;
		max-width: 100% !important;
		min-width: 0 !important;
		display: block;
		box-sizing: border-box;
	}
	@media (max-width: 991px) {
		.spec-ui-form .addsection input[name="coverage[]"],
		.spec-ui-form .addsection input[name="product[]"] {
			max-width: 160px;
		}
		.spec-ui-card > .spec-ui-card-title {
			flex-wrap: wrap;
		}
	}
	@media (max-width: 767px) {
		.spec-ui-head { flex-direction: column; }
		.spec-ui-status { margin-left: 12px; margin-right: 12px; }
		.spec-ui-body { padding: 12px; }
		.spec-ui-actions { padding: 12px; }
		.spec-ui-form .form-horizontal .form-group > .col-sm-3,
		.spec-ui-form .form-horizontal .form-group > .col-sm-9 {
			width: 100% !important;
			float: none !important;
			text-align: left !important;
			padding-left: 0 !important;
			padding-right: 0 !important;
		}
		.spec-ui-form .form-horizontal .control-label {
			margin-bottom: 4px;
			padding-top: 0 !important;
		}
		.spec-ui-form .col-xs-10.col-sm-8,
		.spec-ui-form input.col-xs-10,
		.spec-ui-form select.col-xs-10 {
			width: 100% !important;
			max-width: 100% !important;
		}
		.spec-ui-form .addsection table {
			min-width: 480px;
		}
		.spec-ui-form .addsection input[name="coverage[]"],
		.spec-ui-form .addsection input[name="product[]"] {
			max-width: 140px;
		}
		.spec-ui-toolbar {
			flex-direction: column;
			align-items: stretch;
		}
	}
	@media (max-width: 480px) {
		.spec-ui-shell { border-radius: 10px; }
		.spec-ui-head { padding: 14px; }
		.spec-ui-card > .spec-ui-card-body { padding: 10px; }
		.spec-ui-form .addsection table {
			min-width: 440px;
		}
		.spec-ui-form .addsection input[name="serial[]"] {
			width: 44px !important;
		}
		.spec-ui-form .addsection input[name="coverage_by_pack[]"],
		.spec-ui-form .addsection input[name="Warranty[]"] {
			width: 72px !important;
		}
	}

	/* ---- Spec Comments panel (presets chips + polished rows) ---- */
	.spec-comments-panel {
		width: 100%;
	}
	.spec-comment-presets {
		border: 1px solid #d7e3ef;
		border-radius: 12px;
		background: linear-gradient(180deg, #f8fbff 0%, #eef5fb 100%);
		padding: 14px;
		margin: 0 0 16px;
	}
	.spec-comment-presets__head {
		display: flex;
		flex-wrap: wrap;
		align-items: baseline;
		justify-content: space-between;
		gap: 6px 12px;
		margin-bottom: 12px;
	}
	.spec-comment-presets__head strong {
		color: #1f4f7a;
		font-size: 13px;
		letter-spacing: 0.02em;
		text-transform: uppercase;
	}
	.spec-comment-presets__head span {
		color: #6a7f93;
		font-size: 12px;
	}
	.spec-comment-chips {
		display: flex;
		flex-wrap: wrap;
		gap: 8px;
	}
	.spec-comment-chip {
		display: inline-flex;
		align-items: flex-start;
		gap: 6px;
		max-width: 100%;
		margin: 0;
		padding: 8px 12px;
		border: 1px solid #c9daf0;
		border-radius: 999px;
		background: #fff;
		color: #31485c;
		font-size: 12px;
		font-weight: 600;
		line-height: 1.35;
		text-align: left;
		cursor: pointer;
		box-shadow: 0 2px 6px rgba(20, 33, 61, 0.04);
		transition: border-color 0.15s ease, background 0.15s ease, color 0.15s ease, transform 0.15s ease;
	}
	.spec-comment-chip .fa {
		margin-top: 1px;
		color: #2f7bd7;
		flex-shrink: 0;
	}
	.spec-comment-chip:hover,
	.spec-comment-chip:focus {
		border-color: #6fb3e0;
		background: #eef7fd;
		color: #1565a8;
		transform: translateY(-1px);
		outline: none;
	}
	.spec-comment-chip.is-used {
		border-color: #b7cfc0;
		background: #eef8f1;
		color: #2f6b45;
		cursor: default;
		transform: none;
	}
	.spec-comment-chip.is-used .fa {
		color: #2f6b45;
	}
	.spec-comment-chip.is-used:hover {
		transform: none;
	}
	.spec-comments-list {
		display: flex;
		flex-direction: column;
		gap: 10px;
	}
	.spec-comment-row.commentdiv,
	.commentdiv.spec-comment-row {
		display: flex;
		align-items: stretch;
		gap: 10px;
		width: 100%;
		margin: 0;
		padding: 10px 12px;
		border: 1px solid #e1e8f0;
		border-radius: 12px;
		background: #fff;
		box-shadow: 0 3px 10px rgba(20, 33, 61, 0.04);
		box-sizing: border-box;
	}
	.spec-comment-row__num {
		flex: 0 0 34px;
		width: 34px;
		height: 34px;
		align-self: center;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		border-radius: 50%;
		background: #e8f1f8;
		color: #1f4f7a;
		font-size: 13px;
		font-weight: 700;
	}
	.spec-comment-row .spec-comment-input,
	.spec-comment-row input.spec-comment-input {
		flex: 1 1 auto;
		width: auto !important;
		min-width: 0;
		height: 40px;
		margin: 0;
		padding: 8px 12px;
		border: 1px solid #d5dde6;
		border-radius: 10px;
		background: #fbfcfe;
		color: #243b4d;
		font-size: 13px;
		box-shadow: none;
	}
	.spec-comment-row .spec-comment-input:focus {
		border-color: #6fb3e0;
		background: #fff;
		box-shadow: 0 0 0 3px rgba(111, 179, 224, 0.2);
		outline: none;
	}
	.spec-comment-row__remove {
		flex: 0 0 34px;
		width: 34px;
		height: 34px;
		align-self: center;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		border: 1px solid #f0c9c9;
		border-radius: 10px;
		background: #fff5f5;
		color: #c0392b !important;
		font-size: 18px;
		line-height: 1;
		text-decoration: none !important;
		cursor: pointer;
	}
	.spec-comment-row__remove:hover {
		background: #fde8e8;
		border-color: #e0a0a0;
	}
	.spec-comments-add-btn {
		margin-top: 12px;
	}
	@media (max-width: 575px) {
		.spec-comment-chip {
			border-radius: 12px;
			width: 100%;
		}
	}
</style>
