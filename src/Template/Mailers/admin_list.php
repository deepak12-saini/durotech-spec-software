<?php
if (!empty($userarea)) {
	$listKey = isset($userarea[0]['SpecUsearea']) ? 'SpecUsearea' : 'spec_useareas';
?>
	<ul id="country-list" class="country-list">
	<?php
	foreach ($userarea as $userareas) {
		$row = $userareas[$listKey] ?? $userareas;
		$product = h($row['product'] ?? '');
		$coverage = h($row['coverage'] ?? '');
		$coverageByPack = h($row['coverage_by_pack'] ?? '');
		$warranty = h($row['Warranty'] ?? '');
	?>
		<li onclick="selectCountry('<?php echo addslashes($product); ?>','<?php echo addslashes($coverage); ?>','<?php echo addslashes($coverageByPack); ?>','<?php echo addslashes($warranty); ?>','<?php echo h($id); ?>','<?php echo h($newdiv); ?>')"><?php echo $product; ?></li>
	<?php } ?>
	</ul>
<?php } ?>