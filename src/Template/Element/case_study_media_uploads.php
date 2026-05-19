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
                    <a href="<?= $imgUrl($datasheetPath); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-external-link"></i> View datasheet
                    </a>
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

    <?php if (!empty($otherImages)): ?>
        <div class="case-upload-card case-upload-card--full" style="margin-top: 1.25rem;">
            <div class="case-upload-card__label">Other gallery images</div>
            <div class="existing-images-gallery">
                <?php foreach ($otherImages as $img):
                    $imgId = is_object($img) ? $img->id : ($img['id'] ?? null);
                    $imgFilename = is_object($img) ? $img->filename : ($img['filename'] ?? '');
                ?>
                    <div class="image-card position-relative">
                        <a href="<?= h($buildDeleteUrl($imgId)); ?>"
                           class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle shadow"
                           title="Delete image"
                           onclick="return confirm('Delete this image?');">
                            <i class="fa fa-trash"></i>
                        </a>
                        <img src="<?= $imgUrl($imgFilename); ?>" alt="Gallery">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
