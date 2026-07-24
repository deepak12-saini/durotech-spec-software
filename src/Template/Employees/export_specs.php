<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>DuroEzy Specification</title>
	<style>
		body { font-family: Arial, sans-serif; font-size: 12px; margin: 16px; }
		h1 { font-size: 16px; margin: 0 0 12px; }
		.meta { margin-bottom: 10px; color: #555; }
		table { border-collapse: collapse; width: 100%; }
		th, td { border: 1px solid #333; padding: 4px 6px; text-align: left; vertical-align: top; word-break: break-word; }
		th { background: #eee; }
		a { color: #06c; }
		@media print {
			body { margin: 0; }
			.no-print { display: none; }
		}
	</style>
</head>
<body>
	<p class="no-print">
		<button type="button" onclick="window.print()">Print / Save as PDF</button>
	</p>
	<h1>DuroEzy Specification</h1>
	<div class="meta"><?php echo (int)count($rows); ?> record(s)</div>
	<table>
		<thead>
			<tr>
				<th>TrackNumber</th>
				<th>Employee Name</th>
				<th>Name/Attn</th>
				<th>Email</th>
				<th>Project</th>
				<th>Address</th>
				<th>Specification</th>
				<th>Date</th>
				<th>PDF Attachment</th>
				<th>Approve Status</th>
				<th>Revision</th>
				<th>Created</th>
				<th>Customer email</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($rows as $row): ?>
			<tr>
				<td><?php echo h($row['tracknumber']); ?></td>
				<td><?php echo h($row['employee_name']); ?></td>
				<td><?php echo h($row['name']); ?></td>
				<td><?php echo h($row['email']); ?></td>
				<td><?php echo h($row['company']); ?></td>
				<td><?php echo h($row['address']); ?></td>
				<td><?php echo h($row['specification']); ?></td>
				<td><?php echo h($row['date']); ?></td>
				<td>
					<?php if (!empty($row['pdf_url'])): ?>
						<a href="<?php echo h($row['pdf_url']); ?>" target="_blank"><?php echo h($row['pdf_url']); ?></a>
					<?php else: ?>
						<?php echo h($row['pdf_attachment']); ?>
					<?php endif; ?>
				</td>
				<td><?php echo h($row['approve_status']); ?></td>
				<td><?php echo h($row['revision']); ?></td>
				<td><?php echo h($row['created']); ?></td>
				<td><?php echo h($row['customer_email']); ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<script>
		window.addEventListener('load', function () {
			setTimeout(function () { window.print(); }, 300);
		});
	</script>
</body>
</html>
