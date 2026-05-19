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
/* Media uploads section */
.case-media-section {
    margin-top: 2rem;
    margin-bottom: 2rem;
    padding: 1.75rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
}
.case-media-section__title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 0.35rem;
}
.case-media-section__subtitle {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
}
.case-upload-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}
@media (max-width: 768px) {
    .case-upload-grid { grid-template-columns: 1fr; }
}
.case-upload-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 1.25rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.case-upload-card:hover {
    border-color: #94a3b8;
}
.case-upload-card--full {
    grid-column: 1 / -1;
}
.case-upload-card__label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}
.case-upload-card__badge {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
}
.case-upload-card__badge--before { background: #fef3c7; color: #92400e; }
.case-upload-card__badge--after { background: #d1fae5; color: #065f46; }
.case-upload-card__badge--featured { background: #dbeafe; color: #1e40af; }
.case-upload-card__badge--pdf { background: #fce7f3; color: #9d174d; }
.case-upload-zone {
    position: relative;
    border: 2px dashed #cbd5e1;
    border-radius: 8px;
    padding: 1.5rem 1rem;
    text-align: center;
    cursor: pointer;
    background: #fafbfc;
    transition: border-color 0.2s, background 0.2s;
    min-height: 120px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}
.case-upload-zone:hover,
.case-upload-zone.is-dragover,
.case-upload-zone.has-file {
    border-color: #3b82f6;
    background: #eff6ff;
}
.case-upload-zone.has-file .case-upload-zone__icon {
    color: #3b82f6;
}
.case-upload-zone__icon {
    font-size: 1.75rem;
    color: #94a3b8;
}
.case-upload-zone__text {
    font-size: 0.875rem;
    color: #64748b;
    margin: 0;
}
.case-upload-zone__filename {
    font-size: 0.8rem;
    color: #3b82f6;
    font-weight: 600;
    word-break: break-all;
    max-width: 100%;
}
.case-upload-zone input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
.case-upload-preview {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}
.case-upload-preview__label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
}
.case-upload-preview__img-wrap {
    position: relative;
    display: inline-block;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.case-upload-preview__img-wrap img {
    display: block;
    max-width: 100%;
    max-height: 180px;
    width: auto;
    height: auto;
    object-fit: contain;
    background: #f1f5f9;
}
.case-upload-preview__delete {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    opacity: 0.95;
}
.case-upload-preview__new {
    margin-top: 0.75rem;
}
.case-upload-preview__new img {
    max-height: 120px;
    border-radius: 6px;
    border: 2px solid #3b82f6;
}
.case-status-row {
    margin-top: 1.5rem;
    padding: 1rem 1.25rem;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
}
.case-form-actions {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}
</style>

<div class="page-content">

  <div class="page-header">
	<h1>Edit Case Study</h1>
  </div><!-- /.page-header -->


  <div class="container mt-4">
    <?php $editCaseStudy = $caseStudy ?? null; ?>

    <?php echo $this->Form->create($editCaseStudy, [
        'type' => 'file',
        'url' => ['controller' => 'CaseStudies', 'action' => 'adminEdit', (int)($editCaseStudy->id ?? 0)]
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

        <?php
        $selectedProductIds = [];
        if (!empty($caseStudy->products)) {
            foreach ($caseStudy->products as $p) {
                $pid = is_object($p) ? ($p->id ?? null) : ($p['id'] ?? null);
                if ($pid !== null) {
                    $selectedProductIds[] = (int)$pid;
                }
            }
        }
        echo $this->element('products_used_picker', [
            'products' => $products ?? [],
            'selectedIds' => $selectedProductIds,
        ]);
        ?>

        <?= $this->element('case_study_media_uploads', ['caseStudy' => $caseStudy]); ?>

        <div class="case-status-row">
            <?php
            echo $this->Form->input('status', [
                'type' => 'checkbox',
                'label' => 'Publish as active (visible on website)',
                'checked' => !empty($caseStudy->status)
            ]);
            ?>
        </div>

        <div class="row case-form-actions">
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

    (function () {
        function initUploadZone(zone) {
            var input = zone.querySelector('input[type="file"]');
            var filenameEl = zone.querySelector('[data-filename]');
            var fieldName = zone.getAttribute('data-upload-zone');
            var previewEl = document.querySelector('[data-preview="' + fieldName + '"]');
            if (!input) {
                return;
            }

            function showFile(file) {
                if (!file) {
                    return;
                }
                if (filenameEl) {
                    filenameEl.textContent = file.name;
                }
                zone.classList.add('has-file');
                if (previewEl && file.type && file.type.indexOf('image/') === 0) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        previewEl.innerHTML = '<div class="case-upload-preview__label">New upload preview</div><img src="' + e.target.result + '" alt="Preview">';
                        previewEl.hidden = false;
                    };
                    reader.readAsDataURL(file);
                }
            }

            input.addEventListener('change', function () {
                if (input.files && input.files[0]) {
                    showFile(input.files[0]);
                }
            });

            ['dragenter', 'dragover'].forEach(function (ev) {
                zone.addEventListener(ev, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    zone.classList.add('is-dragover');
                });
            });
            ['dragleave', 'drop'].forEach(function (ev) {
                zone.addEventListener(ev, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    zone.classList.remove('is-dragover');
                });
            });
            zone.addEventListener('drop', function (e) {
                var files = e.dataTransfer && e.dataTransfer.files;
                if (files && files.length) {
                    input.files = files;
                    showFile(files[0]);
                }
            });
        }

        document.querySelectorAll('.case-upload-zone').forEach(initUploadZone);
    })();
</script>

</div>