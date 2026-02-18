<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>
<style>
    .error-message,
    .invalid-feedback {
        color: #c0392b;
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 0.25rem;
        display: block;
    }
    .form-control.is-invalid,
    input.is-invalid,
    textarea.is-invalid {
        border-color: #c0392b;
        padding-right: calc(1.5em + 0.75rem);
    }
    .form-group.has-error .form-control {
        border-color: #c0392b;
    }

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

    <?php
    $caseId = is_object($case) ? $case->id : ($case['id'] ?? $case['CaseStudy']['id'] ?? null);
    $caseStudy = is_object($case) ? $case->toArray() : ($case['CaseStudy'] ?? $case);
    $caseImages = [];
    if (is_object($case)) {
        $caseImages = $case->case_images ?? $case->case_image ?? [];
        if ($caseImages && !is_array($caseImages) && !($caseImages instanceof \Traversable)) {
            $caseImages = [];
        }
        $caseImages = $caseImages ? (is_array($caseImages) ? $caseImages : iterator_to_array($caseImages)) : [];
    } else {
        $caseImages = $case['case_images'] ?? $case['CaseImage'] ?? [];
        $caseImages = is_array($caseImages) ? $caseImages : [];
    }
    $baseUrl = defined('SITEURL') ? rtrim(SITEURL, '/') : $this->Url->build('/', true);
    echo $this->Form->create($case, [
        'type' => 'file',
        'url' => ['controller' => 'Employees', 'action' => 'case_edit', $caseId]
    ]);
    ?>

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
                    $projectDateVal = is_object($case) ? ($case->project_date ?? '') : ($caseStudy['project_date'] ?? '');
                    if (is_array($projectDateVal)) {
                        $projectDateVal = sprintf('%04d-%02d-%02d', (int)($projectDateVal['year'] ?? date('Y')), (int)($projectDateVal['month'] ?? 1), (int)($projectDateVal['day'] ?? 1));
                    } elseif ($projectDateVal instanceof \DateTimeInterface) {
                        $projectDateVal = $projectDateVal->format('Y-m-d');
                    } elseif (is_string($projectDateVal) && $projectDateVal !== '') {
                        $projectDateVal = strlen($projectDateVal) > 10 ? date('Y-m-d', strtotime($projectDateVal)) : $projectDateVal;
                    }
                    echo $this->Form->input('project_date', [
                        'label' => 'Project Date',
                        'class' => 'form-control',
                        'type' => 'text',
                        'id' => 'project_date',
                        'placeholder' => 'mm/dd/yyyy',
                        'value' => $projectDateVal
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

                <?php
                $featuredImg = is_object($case) ? ($case->featured_image ?? '') : ($case['CaseStudy']['featured_image'] ?? $case['featured_image'] ?? '');
                if (!empty($featuredImg)): ?>
                    <div class="mt-2">
                        <p class="fw-bold mb-1">Current Featured Image:</p>
                        <img src="<?php echo $baseUrl . '/' . ltrim($featuredImg, '/'); ?>"
                            alt="Featured Image"
                            class="img-thumbnail"
                            style="max-width: 200px;">
                    </div>
                <?php endif; ?>
            </div>

        

        <div class="col-md-12 mb-3">
            <label>Upload Datasheet (PDF)</label><br>
            <?php echo $this->Form->file('datasheet_file', ['class' => 'form-control']); ?>

            <?php
            $datasheet = is_object($case) ? ($case->datasheet ?? '') : ($case['CaseStudy']['datasheet'] ?? $case['datasheet'] ?? '');
            if (!empty($datasheet)): ?>
                <p class="mt-2">
                    <a href="<?php echo $baseUrl . '/' . ltrim($datasheet, '/'); ?>" target="_blank">View Current Datasheet</a>
                </p>
            <?php endif; ?>
        </div>

        


        <div class="col-md-12 mb-4">
            <label class="fw-bold mb-2 d-block">Upload Images (Before / After)</label>
            <input type="file" name="data[CaseStudy][images][]" accept="image/*" multiple class="form-control">

                 <?php if (!empty($caseImages)): ?>
            <div class="mb-4">
                <label class="form-label fw-bold mb-3 d-block">Existing Images</label>

                <div class="existing-images-gallery p-3 border rounded bg-light shadow-sm">
                    <?php foreach ($caseImages as $img):
                        $imgId = is_object($img) ? $img->id : $img['id'];
                        $imgFilename = is_object($img) ? $img->filename : $img['filename'];
                    ?>
                        <div class="image-card position-relative">
                            <a href="<?php echo $this->Url->build(['controller' => 'Employees', 'action' => 'delete_case_image', $caseId, $imgId]); ?>"
                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle shadow"
                            title="Remove this image"
                            onclick="return confirm('Remove this image?');">
                                <i class="fa fa-trash"></i>
                            </a>

                            <!-- Image Preview -->
                            <img src="<?php echo $baseUrl . '/' . ltrim($imgFilename, '/'); ?>"
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
            $isActive = is_object($case) ? !empty($case->status) : !empty($caseStudy['status']);
            echo $this->Form->control('status', [
                'type' => 'checkbox',
                'label' => 'Active',
                'checked' => $isActive
            ]);
            ?>
        </div>

        <div class="row mt-4">
            <div class="col-12 text-end">
                <?php echo $this->Form->button(
                    'Update Case Study',
                    ['class' => 'btn btn-success me-2']
                ); ?>
                <a href="<?php echo $this->Url->build(['controller' => 'Employees', 'action' => 'case_studies']); ?>" class="btn btn-secondary">
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
document.addEventListener("DOMContentLoaded", function() {
    var dateInput = document.getElementById('project_date');
    if (dateInput) {
        dateInput.setAttribute('type', 'date');
    }
    if (typeof CKEDITOR !== 'undefined') {
        document.querySelectorAll('.ckeditor').forEach(el => {
            CKEDITOR.replace(el);
        });
    }
});
</script>

</div>