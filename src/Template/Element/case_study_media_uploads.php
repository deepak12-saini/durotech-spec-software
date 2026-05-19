<?= $this->element('case_study_media_styles'); ?>
<?php
/**
 * Media upload section for case study add/edit forms (admin + employee).
 *
 * Options:
 *   caseStudy / case - entity or array
 *   caseId - required for employee delete URLs
 *   panel - 'admin' (default) or 'employee'
 *   caseImages, beforeImage, afterImage, otherImages - optional pre-split
 */
$caseStudyEntity = $caseStudy ?? $case ?? null;
$panel = $panel ?? 'admin';
$caseId = $caseId ?? null;

if ($caseId === null && $caseStudyEntity) {
    $caseId = is_object($caseStudyEntity) ? ($caseStudyEntity->id ?? null) : ($caseStudyEntity['id'] ?? null);
}

$featuredPath = '';
$datasheetPath = '';
if ($caseStudyEntity) {
    if (is_object($caseStudyEntity)) {
        $featuredPath = $caseStudyEntity->featured_image ?? '';
        $datasheetPath = $caseStudyEntity->datasheet ?? '';
    } else {
        $featuredPath = $caseStudyEntity['featured_image'] ?? $caseStudyEntity['CaseStudy']['featured_image'] ?? '';
        $datasheetPath = $caseStudyEntity['datasheet'] ?? $caseStudyEntity['CaseStudy']['datasheet'] ?? '';
    }
}

$imagesList = [];
if (!empty($caseImages)) {
    $imagesList = is_array($caseImages) ? $caseImages : (is_iterable($caseImages) ? iterator_to_array($caseImages) : []);
} elseif ($caseStudyEntity && is_object($caseStudyEntity) && !empty($caseStudyEntity->case_images)) {
    $ci = $caseStudyEntity->case_images;
    $imagesList = is_array($ci) ? $ci : (is_iterable($ci) ? iterator_to_array($ci) : []);
} elseif ($caseStudyEntity && is_array($caseStudyEntity)) {
    $imagesList = $caseStudyEntity['case_images'] ?? $caseStudyEntity['CaseImage'] ?? [];
}

$beforeImage = $beforeImage ?? null;
$afterImage = $afterImage ?? null;
$otherImages = $otherImages ?? [];

if ($beforeImage === null || $afterImage === null) {
    foreach ($imagesList as $img) {
        $imgType = is_object($img) ? ($img->type ?? 'other') : ($img['type'] ?? 'other');
        if ($imgType === 'before' && $beforeImage === null) {
            $beforeImage = $img;
        } elseif ($imgType === 'after' && $afterImage === null) {
            $afterImage = $img;
        } elseif ($imgType !== 'before' && $imgType !== 'after') {
            $otherImages[] = $img;
        }
    }
}

$beforeId = $beforeId ?? ($beforeImage ? (is_object($beforeImage) ? $beforeImage->id : ($beforeImage['id'] ?? null)) : null);
$beforeFilename = $beforeFilename ?? ($beforeImage ? (is_object($beforeImage) ? $beforeImage->filename : ($beforeImage['filename'] ?? '')) : '');
$afterId = $afterId ?? ($afterImage ? (is_object($afterImage) ? $afterImage->id : ($afterImage['id'] ?? null)) : null);
$afterFilename = $afterFilename ?? ($afterImage ? (is_object($afterImage) ? $afterImage->filename : ($afterImage['filename'] ?? '')) : '');

$buildDeleteUrl = function ($imageId) use ($panel, $caseId) {
    if ($panel === 'employee' && $caseId) {
        return $this->Url->build(['controller' => 'Employees', 'action' => 'delete_case_image', (int)$caseId, (int)$imageId]);
    }

    return $this->Url->build('/admin/case_studies/delete_image/' . (int)$imageId);
};

$buildFeaturedDeleteUrl = function () use ($panel, $caseId) {
    if (!$caseId) {
        return null;
    }
    if ($panel === 'employee') {
        return $this->Url->build(['controller' => 'Employees', 'action' => 'delete_case_featured', (int)$caseId]);
    }

    return $this->Url->build('/admin/case_studies/delete_featured/' . (int)$caseId);
};

$buildDatasheetDeleteUrl = function () use ($panel, $caseId) {
    if (!$caseId) {
        return null;
    }
    if ($panel === 'employee') {
        return $this->Url->build(['controller' => 'Employees', 'action' => 'delete_case_datasheet', (int)$caseId]);
    }

    return $this->Url->build('/admin/case_studies/delete_datasheet/' . (int)$caseId);
};

$featuredDeleteUrl = ($featuredPath !== '' && $caseId) ? $buildFeaturedDeleteUrl() : null;
$datasheetDeleteUrl = ($datasheetPath !== '' && $caseId) ? $buildDatasheetDeleteUrl() : null;

$imgUrl = function ($filename) {
    return h($this->Url->build('/' . ltrim((string)$filename, '/'), ['fullBase' => true]));
};
?>

<section class="case-media-section">
    <h2 class="case-media-section__title">Media &amp; Files</h2>
    <p class="case-media-section__subtitle">Upload images and documents. Click or drag files into each area below.</p>

    <div class="case-upload-grid">
        <div class="case-upload-card">
            <div class="case-upload-card__label">
                <span class="case-upload-card__badge case-upload-card__badge--featured">Featured</span>
                Main cover image
            </div>
            <div class="case-upload-zone" data-upload-zone="featured_image">
                <i class="fa fa-image case-upload-zone__icon"></i>
                <p class="case-upload-zone__text">Click or drag image here</p>
                <span class="case-upload-zone__filename" data-filename></span>
                <?php echo $this->Form->file('featured_image', ['accept' => 'image/*', 'id' => 'featured_image']); ?>
            </div>
            <?php if ($featuredPath !== ''): ?>
                <div class="case-upload-preview">
                    <div class="case-upload-preview__label">Current image</div>
                    <div class="case-upload-preview__img-wrap">
                        <?php if ($featuredDeleteUrl): ?>
                            <a href="<?= h($featuredDeleteUrl); ?>"
                               class="btn btn-danger btn-sm case-upload-preview__delete"
                               title="Remove cover image"
                               onclick="return confirm('Remove this cover image?');">
                                <i class="fa fa-trash"></i>
                            </a>
                        <?php endif; ?>
                        <img src="<?= $imgUrl($featuredPath); ?>" alt="Featured">
                    </div>
                </div>
            <?php endif; ?>
            <div class="case-upload-preview__new" data-preview="featured_image" hidden></div>
        </div>

        <div class="case-upload-card">
            <div class="case-upload-card__label">
                <span class="case-upload-card__badge case-upload-card__badge--pdf">PDF</span>
                Project datasheet
            </div>
            <div class="case-upload-zone" data-upload-zone="datasheet_file">
                <i class="fa fa-file-pdf-o case-upload-zone__icon"></i>
                <p class="case-upload-zone__text">Click or drag PDF here</p>
                <span class="case-upload-zone__filename" data-filename></span>
                <?php echo $this->Form->file('datasheet_file', ['accept' => 'application/pdf', 'id' => 'datasheet_file']); ?>
            </div>
            <?php if ($datasheetPath !== ''): ?>
                <div class="case-upload-preview">
                    <div class="case-upload-preview__label">Current file</div>
                    <div class="case-upload-preview__file-wrap">
                        <?php if ($datasheetDeleteUrl): ?>
                            <a href="<?= h($datasheetDeleteUrl); ?>"
                               class="btn btn-danger btn-sm case-upload-preview__delete"
                               title="Remove datasheet"
                               onclick="return confirm('Remove this datasheet?');">
                                <i class="fa fa-trash"></i>
                            </a>
                        <?php endif; ?>
                        <a href="<?= $imgUrl($datasheetPath); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-external-link"></i> View datasheet
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="case-upload-card">
            <div class="case-upload-card__label">
                <span class="case-upload-card__badge case-upload-card__badge--before">Before</span>
                Before work started
            </div>
            <div class="case-upload-zone" data-upload-zone="before_image">
                <i class="fa fa-camera case-upload-zone__icon"></i>
                <p class="case-upload-zone__text">Click or drag before photo</p>
                <span class="case-upload-zone__filename" data-filename></span>
                <?php echo $this->Form->file('before_image', ['accept' => 'image/*', 'id' => 'before_image']); ?>
            </div>
            <?php if ($beforeImage): ?>
                <div class="case-upload-preview">
                    <div class="case-upload-preview__label">Current before image</div>
                    <div class="case-upload-preview__img-wrap">
                        <a href="<?= h($buildDeleteUrl($beforeId)); ?>"
                           class="btn btn-danger btn-sm case-upload-preview__delete"
                           title="Remove before image"
                           onclick="return confirm('Remove this before image?');">
                            <i class="fa fa-trash"></i>
                        </a>
                        <img src="<?= $imgUrl($beforeFilename); ?>" alt="Before">
                    </div>
                </div>
            <?php endif; ?>
            <div class="case-upload-preview__new" data-preview="before_image" hidden></div>
        </div>

        <div class="case-upload-card">
            <div class="case-upload-card__label">
                <span class="case-upload-card__badge case-upload-card__badge--after">After</span>
                Completed result
            </div>
            <div class="case-upload-zone" data-upload-zone="after_image">
                <i class="fa fa-check-circle case-upload-zone__icon"></i>
                <p class="case-upload-zone__text">Click or drag after photo</p>
                <span class="case-upload-zone__filename" data-filename></span>
                <?php echo $this->Form->file('after_image', ['accept' => 'image/*', 'id' => 'after_image']); ?>
            </div>
            <?php if ($afterImage): ?>
                <div class="case-upload-preview">
                    <div class="case-upload-preview__label">Current after image</div>
                    <div class="case-upload-preview__img-wrap">
                        <a href="<?= h($buildDeleteUrl($afterId)); ?>"
                           class="btn btn-danger btn-sm case-upload-preview__delete"
                           title="Remove after image"
                           onclick="return confirm('Remove this after image?');">
                            <i class="fa fa-trash"></i>
                        </a>
                        <img src="<?= $imgUrl($afterFilename); ?>" alt="After">
                    </div>
                </div>
            <?php endif; ?>
            <div class="case-upload-preview__new" data-preview="after_image" hidden></div>
        </div>
    </div>

    <div class="case-upload-card case-upload-card--full case-gallery-card">
        <div class="case-upload-card__label">
            <span class="case-upload-card__badge case-upload-card__badge--gallery">Gallery</span>
            Project photos (multiple)
        </div>
        <p class="case-gallery-card__hint text-muted">Add as many site / finished photos as you need. Hold Ctrl (Windows) or Cmd (Mac) to select multiple files at once. Each save adds to the gallery below.</p>
        <div class="case-upload-zone case-upload-zone--gallery" data-upload-zone="gallery_images">
            <i class="fa fa-images case-upload-zone__icon"></i>
            <p class="case-upload-zone__text">Click or drag multiple photos here</p>
            <span class="case-upload-zone__filename" data-gallery-filename></span>
            <input type="file" name="gallery_images[]" id="gallery_images" accept="image/*" multiple class="case-gallery-file-input">
        </div>

        <?php if (!empty($otherImages)): ?>
            <div class="case-upload-preview__label" style="margin-top: 1rem;">Current gallery (<?= count($otherImages); ?>)</div>
            <div class="existing-images-gallery">
                <?php foreach ($otherImages as $img):
                    $imgId = is_object($img) ? $img->id : ($img['id'] ?? null);
                    $imgFilename = is_object($img) ? $img->filename : ($img['filename'] ?? '');
                ?>
                    <div class="image-card position-relative">
                        <?php if ($caseId && $imgId): ?>
                            <a href="<?= h($buildDeleteUrl($imgId)); ?>"
                               class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle shadow"
                               title="Remove photo"
                               onclick="return confirm('Remove this photo from the gallery?');">
                                <i class="fa fa-trash"></i>
                            </a>
                        <?php endif; ?>
                        <img src="<?= $imgUrl($imgFilename); ?>" alt="Project photo">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted small mb-0 mt-2">No gallery photos yet.</p>
        <?php endif; ?>
    </div>
</section>
