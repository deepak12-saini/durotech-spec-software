<style>
/* ---- Typography & Layout ---- */
.container h2 {
    font-size: 2rem;
    color: #0d6efd;
    font-weight: 700;
    letter-spacing: 1px;
    margin-bottom: 20px;
    border-left: 5px solid #0d6efd;
    padding-left: 15px;
}

.container h4 {
    font-weight: 600;
    color: #333;
    margin-top: 25px;
    margin-bottom: 10px;
}

/* ---- Project Gallery ---- */
.project-gallery img {
    transition: all 0.4s ease;
    cursor: pointer;
    border-radius: 10px;
    width: 100%;
    height: auto;
}

.project-gallery .col-md-6 {
    padding: 0 10px;
}

.project-gallery img:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
}

/* ---- Buttons ---- */
.btn-outline-primary {
    border-radius: 8px;
    padding: 10px 18px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background-color: #0d6efd;
    color: #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.btn-secondary {
    border-radius: 8px;
    padding: 10px 18px;
}

/* ---- Text ---- */
.product_text_section {
    font-size: 15px;
    line-height: 26px;
    color: #444;
}

/* ---- Banner ---- */
.banner {
    position: relative;
    overflow: hidden;
    height: 60vh;
    min-height: 400px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
    margin-bottom: 40px;
    background-color: #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: center;
}

.banner img {
    width: 100%;
    height: 100%;
    /* object-fit: cover;
    transition: transform 0.5s ease; */
}

.back_btn{
    margin-top: 20px;
}

/* ---- Responsive ---- */
@media (max-width: 768px) {
    .banner {
        height: 45vh;
        min-height: 250px;
    }

    .container h2 {
        font-size: 1.6rem;
    }

    .product_text_section {
        font-size: 14px;
        line-height: 24px;
    }
}


.case-section {
    background: #f9f9f9;
    border-left: 4px solid #0d6efd;
    border-radius: 8px;
    padding: 20px 25px;
    margin-bottom: 30px;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.case-section:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

.case-section h4 {
    font-weight: 600;
    color: #0d6efd;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.case-section p {
    font-size: 15px;
    line-height: 1.8;
    color: #333;
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .case-section {
        padding: 15px 18px;
        text-align: center;
    }

    .case-section h4 {
        font-size: 1.1rem;
    }

    .case-section p {
        font-size: 14px;
        line-height: 1.6;
    }
}

.datasheet-section {
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    padding: 30px 20px;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
}

.datasheet-section h4 {
    font-weight: 600;
    color: #0d6efd;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.datasheet-section iframe {
    width: 100%;
    height: 600px;
    border-radius: 10px;
}

@media (max-width: 768px) {
    .datasheet-section {
        padding: 20px 10px;
    }
    .datasheet-section iframe {
        height: 400px;
    }
}


</style>

<!-- ====================== PAGE CONTENT ====================== -->

<div class="banner col-lg-12 col-md-12 col-sm-12 p-0">
    <?php if (!empty($case['CaseStudy']['featured_image'])): ?>
        <img src="<?php echo SITEURL . $case['CaseStudy']['featured_image']; ?>" 
             alt="<?php echo h($case['CaseStudy']['title']); ?>" 
             class="img-fluid w-100">
    <?php else: ?>
        <img src="https://www.durotechindustries.com.au/banner/Project.jpg" 
             alt="Default Project Image" 
             class="img-fluid w-100">
    <?php endif; ?>
</div>

<div class="container mt-5 mb-5">
   <div class="case-info text-md-start text-center mb-4">
        <h1 class="case-title" style="font-size:28px;"><?php echo h($case['CaseStudy']['title']); ?></h1>

        <?php if (!empty($case['CaseStudy']['location'])): ?>
            <p class="case-location mb-1">
                <strong>📍 Location:</strong> <?php echo h($case['CaseStudy']['location']); ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($case['CaseStudy']['project_date'])): ?>
            <p class="case-date mb-0">
                <strong>📅 Date:</strong> <?php echo date('d M Y', strtotime($case['CaseStudy']['project_date'])); ?>
            </p>
        <?php endif; ?>
    </div>


    <hr>

        <?php if (!empty($case['CaseStudy']['short_summary'])): ?>
            <div class="case-section">
                <h4>Short Summary</h4>
                <p class="product_text_section"><?php echo nl2br(h($case['CaseStudy']['short_summary'])); ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($case['CaseStudy']['challenge'])): ?>
            <div class="case-section">
                <h4>Challenge</h4>
                <p class="product_text_section"><?php echo $case['CaseStudy']['challenge']; ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($case['CaseStudy']['solution'])): ?>
            <div class="case-section">
                <h4>Solution</h4>
                <p class="product_text_section"><?php echo $case['CaseStudy']['solution']; ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($case['CaseStudy']['outcome'])): ?>
            <div class="case-section">
                <h4>Outcome</h4>
                <p class="product_text_section"><?php echo $case['CaseStudy']['outcome']; ?></p>
            </div>
        <?php endif; ?>


    <?php if (!empty($case['CaseImage'])): ?>
        <h4 class="mt-5 mb-3">Before / After Comparison</h4>
        <div class="row project-gallery">
            <?php foreach ($case['CaseImage'] as $img): ?>
                <div class="col-md-6 col-sm-6 mb-4">
                    <img src="<?php echo SITEURL . $img['filename']; ?>" 
                         class="img-fluid rounded shadow-sm"
                         alt="Project Image">
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($case['CaseStudy']['datasheet'])): ?>
        <div class="case-section datasheet-section text-center mt-5">
            <h4><i class="fa fa-file-pdf-o text-danger me-2"></i> Datasheet</h4>
            <iframe 
                src="<?php echo SITEURL . $case['CaseStudy']['datasheet']; ?>" 
                width="100%" 
                height="600px" 
                style="border: 1px solid #ddd; border-radius: 10px;">
            </iframe>
            <a href="<?php echo SITEURL . $case['CaseStudy']['datasheet']; ?>" 
            class="btn btn-outline-primary mt-3" 
            target="_blank">
                <i class="fa fa-download"></i> Download Datasheet
            </a>
        </div>
    <?php endif; ?>


    <div class="case-section mt-4">
        <h4>Products &amp; support</h4>
        <p class="product_text_section">View our <a href="<?php echo h($this->Url->build('/product')); ?>">waterproofing products</a> and <a href="<?php echo h($this->Url->build('/projects')); ?>">more case studies</a>. For specifications and technical support, <a href="<?php echo h($this->Url->build('/contact')); ?>">contact us</a>.</p>
    </div>

    <div class="back_btn mt-4">
        <a href="<?php echo SITEURL . 'projects'; ?>" class="btn btn-secondary">
            ← Back to Projects
        </a>
    </div>
</div>
