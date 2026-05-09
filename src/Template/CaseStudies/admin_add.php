<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>
<style>
    .error-message {
    color: #ff0000; /* Bright red */
    font-weight: 500;
    font-size: 13px;
    margin-top: 4px;
    display: block;
}
.products-used-picker {
    min-height: 210px !important;
    border: 1px solid #cfd8e3;
    border-radius: 8px;
    padding: 6px;
    background: #fff;
}
.products-used-picker option {
    padding: 8px 10px;
    border-radius: 6px;
    margin-bottom: 3px;
}
.products-used-search {
    margin-bottom: 8px;
    border-radius: 8px;
}
.products-used-selected {
    margin-top: 8px;
    min-height: 24px;
}
.products-used-tag {
    display: inline-block;
    background: #e7f2ff;
    border: 1px solid #b9dafb;
    color: #19578f;
    border-radius: 999px;
    padding: 4px 10px;
    margin: 0 6px 6px 0;
    font-size: 12px;
    font-weight: 600;
}
</style>
<div class="page-content">

  <div class="page-header">
	<h1>
	Add New Case Study
	</h1>
	</div><!-- /.page-header -->
<div class="container-fluid">

    <?php echo $this->Form->create('CaseStudy', array('type' => 'file','enctype'=>'multipart/form-data', 'class' => 'form-horizontal')); ?>

    <?php if ($this->Session->check('Message.flash')): ?>
        <div class="alert alert-danger">
            <?php echo $this->Flash->render(); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo $this->Form->input('title', [
                    'class' => 'form-control',
                    'label' => 'Project Title',
                    'placeholder' => 'Enter project title'
                ]); ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <?php echo $this->Form->input('slug', [
                    'class' => 'form-control',
                    'label' => 'Slug (URL identifier)',
                    'placeholder' => 'e.g. rooftop-waterproofing'
                ]); ?>
            </div>
        </div>

       <div class="col-md-6">
            <div class="form-group">
                <?php
                echo $this->Form->input('project_date', [
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => 'project_date',
                    'label' => 'Project Date',
                    'placeholder' => 'Select project date'
                ]);

                ?>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group">
                <?php echo $this->Form->input('location', [
                    'class' => 'form-control',
                    'label' => 'Location',
                    'placeholder' => 'e.g. Sydney, NSW'
                ]); ?>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <?php echo $this->Form->input('short_summary', [
                    'type' => 'textarea',
                    'rows' => 3,
                    'class' => 'form-control',
                    'label' => 'Short Summary',
                    'placeholder' => 'Brief overview of the project'
                ]); ?>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <?php echo $this->Form->input('challenge', [
                    'type' => 'textarea',
                    'rows' => 5,
                    'class' => 'form-control ckeditor',
                    'label' => 'Challenge',
                    'placeholder' => 'Describe the challenge'
                ]); ?>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <?php echo $this->Form->input('solution', [
                    'type' => 'textarea',
                    'rows' => 5,
                    'class' => 'form-control ckeditor',
                    'label' => 'Solution',
                    'placeholder' => 'Describe the solution applied'
                ]); ?>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <?php echo $this->Form->input('outcome', [
                    'type' => 'textarea',
                    'rows' => 5,
                    'class' => 'form-control ckeditor',
                    'label' => 'Outcome',
                    'placeholder' => 'Describe the final results'
                ]); ?>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <?php
                echo $this->Form->control('products._ids', [
                    'type' => 'select',
                    'multiple' => true,
                    'size' => 10,
                    'options' => $products ?? [],
                    'class' => 'form-control products-used-picker',
                    'label' => 'Products Used',
                    'id' => 'products-used-picker',
                ]);
                ?>
                <input type="text" id="products-used-search" class="form-control products-used-search" placeholder="Search active products...">
                <small class="text-muted">Only active products are shown. Hold Ctrl (Windows) to select multiple products.</small>
                <div id="products-used-selected" class="products-used-selected"></div>
            </div>
        </div>


    </div>

    <hr>

   <div class="row">
        <div class="col-md-6">
            <label><strong>Datasheet (PDF)</strong></label>
            <input type="file" name="data[CaseStudy][datasheet_file]" accept="application/pdf" class="form-control">
        </div>

        <div class="col-md-6">
            <label><strong>Featured Image</strong></label>
            <input type="file" name="data[CaseStudy][featured_image]" accept="image/*" class="form-control">
            <small class="text-muted">Upload a main image for this case study.</small>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <label><strong>Upload Images (Before / After)</strong></label>
            <input type="file" name="images[]" multiple accept="image/*" class="form-control">
            <small class="text-muted">You can select multiple images at once.</small>
        </div>
    </div>



    <div class="form-group mt-3">
        <div class="checkbox">
            <label>
                <?php echo $this->Form->checkbox('status'); ?> Publish this case study
            </label>
        </div>
    </div>

    <div class="form-group mt-3 text-center">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fa fa-save"></i> Save Case Study
        </button>
    </div>

    <?php echo $this->Form->end(); ?>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var dateInput = document.getElementById('project_date');
    if (dateInput) {
        dateInput.setAttribute('type', 'date'); // Convert it to date picker
    }

    var searchInput = document.getElementById('products-used-search');
    var select = document.getElementById('products-used-picker');
    var selectedWrap = document.getElementById('products-used-selected');
    if (searchInput && select) {
        searchInput.addEventListener('input', function() {
            var term = (this.value || '').toLowerCase();
            Array.prototype.forEach.call(select.options, function(opt) {
                var txt = (opt.text || '').toLowerCase();
                opt.style.display = txt.indexOf(term) !== -1 ? '' : 'none';
            });
        });

        function renderSelectedTags() {
            if (!selectedWrap) {
                return;
            }
            var html = '';
            Array.prototype.forEach.call(select.options, function(opt) {
                if (opt.selected) {
                    html += '<span class="products-used-tag">' + (opt.text || '') + '</span>';
                }
            });
            selectedWrap.innerHTML = html || '<small class="text-muted">No product selected yet.</small>';
        }

        select.addEventListener('change', renderSelectedTags);
        renderSelectedTags();
    }
});
</script>
