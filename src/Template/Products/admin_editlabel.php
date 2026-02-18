<?php
$labelArr = $labelArr ?? null;
$LabelCategory = $LabelCategory ?? [];
$labelCateId = $labelArr ? (int)($labelArr->label_cate_id ?? 0) : 0;
$status = $labelArr ? (int)($labelArr->status ?? 1) : 1;
?>
<script src="<?= h(SITEURL ?? '') ?>ckeditor/ckeditor.js"></script>
<div class="page-content">
	<div class="page-header">
		<div class="right_btn pull-right"><a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'admin_label']) ?>" class="btn btn-mini btn-inverse">Back</a></div>
		<h1>Product Label <small><i class="ace-icon fa fa-angle-double-right"></i> Edit Label</small></h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<?= $this->Form->create(null, ['class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data']) ?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Label Category: </label>
				<div class="col-sm-9">
					<select class="col-xs-10 col-sm-5" name="data[Label][label_cate_id]" id="category_id">
						<option value="">Please select Label category</option>
						<?php foreach ($LabelCategory as $cat): ?>
							<?php $cid = is_object($cat) ? ($cat->id ?? '') : ($cat['LabelCategory']['id'] ?? $cat['id'] ?? ''); ?>
							<option <?= ($labelCateId && $labelCateId == $cid) ? 'selected' : '' ?> value="<?= h($cid) ?>"><?= h(is_object($cat) ? ($cat->category ?? '') : ($cat['LabelCategory']['category'] ?? $cat['category'] ?? '')) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Label Name : </label>
				<div class="col-sm-9">
					<input type="text" name="data[Label][name]" value="<?= h($labelArr->name ?? '') ?>" id="name" class="col-xs-10 col-sm-5" placeholder="Label Name">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Upload Product Label : </label>
				<div class="col-sm-9">
					<input type="file" name="data[Label][url]" id="url" class="col-xs-10 col-sm-5">
				</div>
				&nbsp; &nbsp; &nbsp; <?php if (!empty($labelArr->url)): ?><a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'download', $labelArr->url]) ?>">Download Label</a><?php endif; ?>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Weight: </label>
				<div class="col-sm-9">
					<input type="text" placeholder="weight" value="<?= h($labelArr->weight ?? '') ?>" name="data[Label][weight]" id="weight" class="col-xs-10 col-sm-5">
				</div>
			</div>
			<div class="form-group">
				<label for="form-field-2" class="col-sm-3 control-label no-padding-right">Label Status : </label>
				<div class="col-sm-9">
					<div class="radio"><label>
						<input type="radio" value="1" class="ace" id="CategoryActive1" name="data[Label][status]" <?= $status === 1 ? 'checked' : '' ?>><span class="lbl"> Active</span>
					</label></div>
					<div class="radio"><label>
						<input type="radio" value="0" class="ace" id="CategoryActive0" name="data[Label][status]" <?= $status === 0 ? 'checked' : '' ?>><span class="lbl"> Inactive</span>
					</label></div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?= $this->Form->button('Submit', ['class' => 'btn btn-success', 'id' => 'add_ser_prd_btn']) ?>&nbsp;
					<?= $this->Html->link('Cancel', 'javascript:window.history.back();', ['class' => 'btn btn-danger']) ?>
				</div>
			</div>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>

<script type="text/javascript">
jQuery(function(){
	$("#product_name").validate({ expression: "if (VAL) return true; else return false;", message: "Please enter product name" });
	$("#weightE").validate({ expression: "if (VAL) return true; else return false;", message: "Please enter weight" });
	$("#file").validate({ expression: "if (VAL) return true; else return false;", message: "Please select file" });
});
</script>
