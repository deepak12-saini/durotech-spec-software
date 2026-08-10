	<div class="page-content">
		<div class="page-header">
			<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
			<h1>Category<small><i class="ace-icon fa fa-angle-double-right"></i> Edit Category</small>
			</h1>
		</div>

	<?php $editCategory = $category ?? null; ?>
	<div class="row">
		<div class="col-xs-12">
			<?= $this->Form->create($editCategory, ['class' => 'form-horizontal', 'type' => 'file', 'method' => 'post', 'url' => rtrim(SITEURL, '/') . '/admin/categories/edit/' . (int)($editCategory->id ?? 0)]) ?>
			<?= $this->Form->control('id', ['type' => 'hidden']) ?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Category name: <br> <small>The name is how it appears on your site.</small></label>
					<div class="col-sm-8">
						<?= $this->Form->control('category_name', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'category_name', 'placeholder' => 'Category Name']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Description: <br> <small>The description is not prominent by default; however, some themes may show it.</small></label>
					<div class="col-sm-9">
						<?= $this->Form->control('description', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'description', 'placeholder' => 'Description']) ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Meta Title: </label>
					<div class="col-sm-9">
						<input type="text" name="Category[meta_title]" id="meta_title" value="<?= h($Category['Category']['meta_title'] ?? '') ?>" class="col-xs-10 col-sm-5" placeholder="Meta Title">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Meta Keyword: </label>
					<div class="col-sm-9">
						<input type="text" name="Category[meta_keyword]" id="meta_keyword" value="<?= h($Category['Category']['meta_keyword'] ?? '') ?>" class="col-xs-10 col-sm-5" placeholder="Meta Keyword">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Meta Description: </label>
					<div class="col-sm-9">
						<textarea name="Category[meta_description]" id="meta_description" class="col-xs-10 col-sm-5" placeholder="Meta Description" ><?= h($Category['Category']['meta_description'] ?? '') ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sequence: <br> <small>Display order on website (lower number = first).</small></label>
					<div class="col-sm-9">
						<input type="number" name="Category[sort]" id="category_sort" value="<?= (int)($Category['Category']['sort'] ?? 0) ?>" min="0" class="col-xs-10 col-sm-5" placeholder="0">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="category_image"> Category Image: </label>
					<div class="col-sm-9">
						<input type="file" name="image" id="category_image" accept=".jpg,.jpeg,.gif,.png,image/*">
						<br/>
						<?php $img = $Category['Category']['image'] ?? ''; if ($img): ?>
							<p>
								<img src="<?= h(rtrim(SITEURL, '/') . '/files/category/' . $img) ?>" alt="Category image" style="max-width:280px;height:auto;"/>
								<br><small>File: <?= h($img) ?></small>
							</p>
						<?php endif; ?>
						<small>Used on category listing / browse cards.</small>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="category_page_image"> Category Page Image: </label>
					<div class="col-sm-9">
						<input type="file" name="category_page_image" id="category_page_image" accept=".jpg,.jpeg,.gif,.png,image/*">
						<br/>
						<?php $pageImg = $Category['Category']['category_page_image'] ?? ''; if ($pageImg): ?>
							<p>
								<img src="<?= h(rtrim(SITEURL, '/') . '/files/category/' . $pageImg) ?>" alt="Category page image" style="max-width:280px;height:auto;"/>
								<br><small>File: <?= h($pageImg) ?></small>
							</p>
						<?php endif; ?>
						<small>Used on category detail page hero section. Saved with a different filename than Category Image.</small>
					</div>
				</div>
				<div class="form-group">
					<label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Status: </label>
						<div class="col-sm-9">
						<?php
						$status = $Category['Category']['status'] ?? 0;
						$active = ($status == 1) ? 'checked' : '';
						$inactive = ($status == 0) ? 'checked' : '';
						?>

						<div class="radio"><label>
						<input type="radio" value="1" <?= $active ?> class="ace" id="ServiceCategoryActive1" name="Category[status]"><span class="lbl"> Active</span>
						</label></div>

						<div class="radio">
							<label>
							<input type="radio" value="0" class="ace" <?= $inactive ?> id="ServiceCategoryActive0" name="Category[status]"><span class="lbl"> Inactive</span>
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Is Brand: </label>
						<div class="col-sm-9">
						<?php
						$isBrand = $Category['Category']['is_brand'] ?? 0;
						$brandYes = ($isBrand == 1) ? 'checked' : '';
						$brandNo = ($isBrand == 0) ? 'checked' : '';
						?>

						<div class="radio"><label>
						<input type="radio" value="1" <?= $brandYes ?> class="ace" id="ServiceCategoryBrand1" name="Category[is_brand]"><span class="lbl"> Yes</span>
						</label></div>

						<div class="radio"><label>
							<input type="radio" value="0" class="ace" <?= $brandNo ?> id="ServiceCategoryBrand0" name="Category[is_brand]"><span class="lbl"> No</span>
						</label></div>


					</div>
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
	<script type="text/javascript">
			jQuery(function(){

				$("#category_name").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter service category name"
                });
			});
			</script>
