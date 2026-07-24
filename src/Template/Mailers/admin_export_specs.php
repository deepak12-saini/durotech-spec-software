<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DuroEzy Specification v3</title>
	<style>
		* { box-sizing: border-box; }
		html, body {
			margin: 0;
			padding: 0;
			background: #f0f2f5;
			font-family: Arial, Helvetica, sans-serif;
			color: #222;
		}
		.page {
			max-width: 100%;
			margin: 0 auto;
			padding: 16px;
			background: #fff;
			min-height: 100vh;
		}
		.toolbar {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			gap: 10px;
			margin-bottom: 14px;
			padding-bottom: 12px;
			border-bottom: 1px solid #ddd;
		}
		.toolbar button {
			padding: 8px 14px;
			font-size: 13px;
			cursor: pointer;
			border: 1px solid #4f99c6;
			background: #4f99c6;
			color: #fff;
			border-radius: 3px;
		}
		.toolbar button.secondary {
			background: #fff;
			color: #444;
			border-color: #ccc;
		}
		h1 {
			font-size: 18px;
			font-weight: 600;
			margin: 0 0 4px;
		}
		.meta {
			margin: 0 0 12px;
			color: #666;
			font-size: 13px;
		}
		.table-wrap {
			width: 100%;
			overflow-x: auto;
			border: 1px solid #ddd;
			background: #fff;
		}
		table.export-table {
			border-collapse: collapse;
			width: 100%;
			min-width: 1100px;
			table-layout: auto;
			font-size: 11px;
		}
		table.export-table th,
		table.export-table td {
			border: 1px solid #ccc;
			padding: 5px 6px;
			text-align: left;
			vertical-align: top;
			word-break: normal;
			overflow-wrap: anywhere;
		}
		table.export-table th {
			background: #f3f5f7;
			font-weight: 600;
			white-space: nowrap;
		}
		table.export-table td.nowrap,
		table.export-table th.nowrap {
			white-space: nowrap;
			overflow-wrap: normal;
			word-break: keep-all;
		}
		table.export-table td.pdf-cell a {
			color: #06c;
			text-decoration: underline;
			word-break: break-all;
		}
		table.export-table tbody tr:nth-child(even) td {
			background: #fafafa;
		}

		@media print {
			html, body {
				background: #fff;
			}
			.page {
				padding: 0;
				max-width: none;
			}
			.no-print {
				display: none !important;
			}
			.table-wrap {
				overflow: visible;
				border: none;
			}
			table.export-table {
				min-width: 0;
				width: 100%;
				font-size: 8pt;
			}
			table.export-table th,
			table.export-table td {
				padding: 3px 4px;
				border-color: #999;
			}
			/* Prefer landscape for wide tables */
			@page {
				size: A4 landscape;
				margin: 8mm;
			}
		}
	</style>
</head>
<body>
	<div class="page">
		<div class="toolbar no-print">
			<button type="button" onclick="window.print()">Print / Save as PDF</button>
			<button type="button" class="secondary" onclick="window.close()">Close</button>
		</div>
		<h1>DuroEzy Specification v3</h1>
		<div class="meta"><?php echo (int)count($rows); ?> record(s)</div>
		<div class="table-wrap">
			<table class="export-table">
				<thead>
					<tr>
						<th class="nowrap">Track Number</th>
						<th>Send Name</th>
						<th>Name/Attn</th>
						<th>Email</th>
						<th>Project</th>
						<th>Address</th>
						<th>Specification</th>
						<th class="nowrap">Date</th>
						<th>PDF Attachment</th>
						<th class="nowrap">Created</th>
						<th>Customer email</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($rows as $row): ?>
					<tr>
						<td class="nowrap"><?php echo h($row['tracknumber']); ?></td>
						<td><?php echo h($row['send_name']); ?></td>
						<td><?php echo h($row['name']); ?></td>
						<td><?php echo h($row['email']); ?></td>
						<td><?php echo h($row['company']); ?></td>
						<td><?php echo h($row['address']); ?></td>
						<td><?php echo h($row['specification']); ?></td>
						<td class="nowrap"><?php echo h($row['date']); ?></td>
						<td class="pdf-cell">
							<?php if (!empty($row['pdf_url'])): ?>
								<a href="<?php echo h($row['pdf_url']); ?>" target="_blank"><?php echo h($row['pdf_url']); ?></a>
							<?php else: ?>
								<?php echo h($row['pdf_attachment']); ?>
							<?php endif; ?>
						</td>
						<td class="nowrap"><?php echo h($row['created']); ?></td>
						<td><?php echo h($row['customer_email']); ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
