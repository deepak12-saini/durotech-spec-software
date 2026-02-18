
<div class="banner-section col-12 px-0">
    <div class="banner-container">
        <img src="https://www.durotechindustries.com.au/banner/casestudy_banner.jpg" 
             alt="Case Study Banner" 
             class="img-fluid w-100 d-block banner-img">
    </div>
</div>

<div class="content_projects col-12">

    <div class="container mt-5 mb-5 py-5">

        <div class="text-center mb-5">
            <h1 class="fw-bold text-uppercase text-primary mb-3">What Our Clients Say</h1>
            <p class="text-muted fs-5">
                Real experiences from our valued customers across Australia.
            </p>
        </div>

        <div class="row g-4">
            <?php if (!empty($testimonials)): ?>
                <?php foreach ($testimonials as $t): 
                    $photo = !empty($t['Testimonial']['photo']) 
                        ? SITEURL . 'files/testimonials/' . $t['Testimonial']['photo'] 
                        : SITEURL . 'img/no-image.jpg';
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 h-100 testimonial-card p-4 text-center">
                        <div class="testimonial-photo mx-auto mb-3">
                            <img src="<?php echo h($photo); ?>" alt="Client Photo" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <blockquote class="blockquote mb-3">
                            <p class="text-muted fst-italic">
                                “<?php echo nl2br(h($t['Testimonial']['quote'])); ?>”
                            </p>
                        </blockquote>
                        <h5 class="fw-bold mb-0"><?php echo h($t['Testimonial']['name']); ?></h5>
                        <p class="text-secondary mb-1"><?php echo h($t['Testimonial']['company_name']); ?></p>
                        <small class="text-primary"><?php echo h($t['Testimonial']['role']); ?></small>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted fs-5">No testimonials available right now. Please check back soon.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.testimonial-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px;
    background: #fff;
}
.testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.blockquote {
    min-height: 100px;
}
.testimonial-photo img {
    border: 4px solid #007bff25;
    transition: all 0.3s ease;
}
.testimonial-photo img:hover {
    border-color: #007bff;
}
</style>
