<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>
<style>
   
.existing-images-gallery {
    display: flex;
    flex-wrap: nowrap;
    gap: 15px;
    overflow-x: auto;
    scrollbar-width: thin;
    scrollbar-color: #ccc transparent;
    padding-bottom: 10px;
}
.existing-images-gallery::-webkit-scrollbar {
    height: 8px;
}
.existing-images-gallery::-webkit-scrollbar-thumb {
    background: #bbb;
    border-radius: 10px;
}
.image-card {
    flex: 0 0 auto;
    width: 180px;
    position: relative;
}
.image-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid #ddd;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.image-card img:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}
</style>

<div class="page-content">

  <div class="page-header">
	<h1>Edit Case Study</h1>
  </div><!-- /.page-header -->


  <div class="container mt-4">

    <?php echo $this->Form->create($caseStudy, [
        'type' => 'file',
        'url' => ['controller' => 'CaseStudies', 'action' => 'adminEdit', $caseStudy->id]
    ]); ?>

    <div class="card p-4 shadow-sm">

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <?php
                    echo $this->Form->input('title', [
                        'label' => 'Project Title',
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <?php
                    echo $this->Form->input('slug', [
                        'label' => 'Slug (URL)',
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <?php
                    echo $this->Form->input('project_date', [
                        'label' => 'Project Date',
                        'class' => 'form-control',
                        'type' => 'date'
                    ]);
                    ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <?php
                    echo $this->Form->input('location', [
                        'label' => 'Project Location',
                        'class' => 'form-control'
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label>Short Summary</label>
            <div class="form-group">
            <?php echo $this->Form->textarea('short_summary', ['class' => 'form-control', 'rows' => 3]); ?>
            </div>
        </div>

        <div class="mb-3">
            <label>Challenge</label>
            <?php echo $this->Form->textarea('challenge', ['class' => 'form-control ckeditor']); ?>
        </div>

        <div class="mb-3">
            <label>Solution</label>
            <?php echo $this->Form->textarea('solution', ['class' => 'form-control ckeditor']); ?>
        </div>

        <div class="mb-3">
            <label>Outcome</label>
            <?php echo $this->Form->textarea('outcome', ['class' => 'form-control ckeditor']); ?>
        </div>

        <div class="mb-3">
                <label><strong>Featured Image</strong></label><br>
                <?php echo $this->Form->file('featured_image', ['class' => 'form-control', 'accept' => 'image/*']); ?>

                <?php if (!empty($caseStudy->featured_image)): ?>
                    <div class="mt-2">
                        <p class="fw-bold mb-1">Current Featured Image:</p>
                        <img src="<?= h($this->Url->build('/' . ltrim($caseStudy->featured_image, '/'), ['fullBase' => true])); ?>"
                            alt="Featured Image"
                            class="img-thumbnail"
                            style="max-width: 200px;">
                    </div>
                <?php endif; ?>
            </div>

        

        <div class="col-md-12 mb-3">
            <label>Upload Datasheet (PDF)</label><br>
            <?php echo $this->Form->file('datasheet_file', ['class' => 'form-control']); ?>

            <?php if (!empty($caseStudy->datasheet)): ?>
                <p class="mt-2">
                    <a href="<?= h($this->Url->build('/' . ltrim($caseStudy->datasheet, '/'), ['fullBase' => true])); ?>" target="_blank">View Current Datasheet</a>
                </p>
            <?php endif; ?>
        </div>

        


        <div class="col-md-12 mb-4">
            <label class="fw-bold mb-2 d-block">Upload Images (Before / After)</label>
            <input type="file" name="data[CaseStudy][images][]" accept="image/*" multiple class="form-control">

                 <?php 
                 $caseImages = $caseStudy->case_images ?? [];
                 if (!empty($caseImages)): ?>
            <div class="mb-4">
                <label class="form-label fw-bold mb-3 d-block">Existing Images</label>

                <div class="existing-images-gallery p-3 border rounded bg-light shadow-sm">
                    <?php foreach ($caseImages as $img): 
                        $imgId = is_object($img) ? $img->id : ($img['id'] ?? null);
                        $imgFilename = is_object($img) ? $img->filename : ($img['filename'] ?? '');
                    ?>
                        <div class="image-card position-relative">
                            <!-- Delete Button -->
                            <a href="<?= $this->Url->build('/admin/case_studies/delete_image/' . (int)$imgId); ?>"
                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle shadow"
                            title="Delete Image"
                            onclick="return confirm('Are you sure you want to delete this image?');">
                                <i class="fa fa-trash"></i>
                            </a>

                            <!-- Image Preview -->
                            <img src="<?= h($this->Url->build('/' . ltrim($imgFilename, '/'), ['fullBase' => true])); ?>"
                                alt="Case Image"
                                class="img-fluid rounded shadow-sm">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        </div>

 





        <div class="col-md-12 mb-3">
            <?php
            echo $this->Form->input('status', [
                'type' => 'checkbox',
                'label' => 'Active',
                'checked' => !empty($caseStudy->status)
            ]);
            ?>
        </div>

        <div class="row mt-4">
            <div class="col-12 text-end">
                <?php echo $this->Form->button(
                    'Update Case Study',
                    ['class' => 'btn btn-success me-2']
                ); ?>
                <a href="<?= $this->Url->build(['controller' => 'CaseStudies', 'action' => 'adminIndex']); ?>" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </div>

    </div>

    <?php echo $this->Form->end(); ?>
</div>

<!-- Optional CKEditor -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    if (typeof CKEDITOR !== 'undefined') {
        document.querySelectorAll('.ckeditor').forEach(el => {
            CKEDITOR.replace(el);
        });
    }
</script>

</div>