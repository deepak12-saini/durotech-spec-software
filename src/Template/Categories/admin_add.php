
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>Category<small><i class="ace-icon fa fa-angle-double-right"></i> Add New Category</small>
		</h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
		<?= $this->Form->create(null, ['class' => 'form-horizontal', 'type' => 'file', 'url' => ['action' => 'adminAdd']]) ?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Category Name: <br> <small>The name is how it appears on your site.</small></label>
				<div class="col-sm-9">
					<?= $this->Form->control('category_name', ['name' => 'Category[category_name]', 'div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'category_name', 'placeholder' => 'Category Name']) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Description: <br> <small>The description is not prominent by default; however, some themes may show it.</small></label>
				<div class="col-sm-9">
					<?= $this->Form->control('description', ['name' => 'Category[description]', 'div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'description', 'placeholder' => 'Description']) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Meta Title: </label>
				<div class="col-sm-9">
					<input type="text" name="Category[meta_title]" id="meta_title" class="col-xs-10 col-sm-5" placeholder="Meta Title">

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Meta Keyword: </label>
				<div class="col-sm-9">
					<input type="text" name="Category[meta_keyword]" id="meta_keyword" class="col-xs-10 col-sm-5" placeholder="Meta Keyword">

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Meta Description: </label>
				<div class="col-sm-9">
					<textarea name="Category[meta_description]" id="meta_description" class="col-xs-10 col-sm-5" placeholder="Meta Description" ></textarea>

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sequence: <br> <small>Display order on website (lower number = first).</small></label>
				<div class="col-sm-9">
					<input type="number" name="Category[sort]" id="category_sort" value="0" min="0" class="col-xs-10 col-sm-5" placeholder="0">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Category Image: </label>
				<div class="col-sm-9">
					<input type="file" name="image" id="image" >
				</div>
		</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Category Page Image: </label>
				<div class="col-sm-9">
					<input type="file" name="category_page_image" id="category_page_image" >
					<br><small>Used on category detail page hero section.</small>
				</div>
			</div>
			<div class="form-group">
				<label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Status: </label>
				<div class="col-sm-9">

				<div class="radio"><label>
				<input type="radio" checked="checked" value="1"  class="ace" id="CategoryActive1" name="Category[status]"><span class="lbl"> Active</span>
				</label></div>

				<div class="radio"><label>
					<input type="radio" value="0"  class="ace" id="CategoryActive0" name="Category[status]"><span class="lbl"> Inactive</span>
				</label></div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?= $this->Form->submit('Submit', ['div' => false, 'label' => false, 'class' => 'btn btn-success', 'id' => 'add_ser_prd_btn']) ?>&nbsp;
					<?= $this->Html->link('Cancel', 'javascript:window.history.back();', ['class' => 'btn btn-danger', 'escape' => false]) ?>

				</div>
			</div>
			<?= $this->Form->end() ?>
		</div>
	</div>
	</div>
<script type="text/javascript">
			jQuery(function(){

				$("#category_name").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter category name"
                }); $("#imagse").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please select image"
                });
			});
			</script>
