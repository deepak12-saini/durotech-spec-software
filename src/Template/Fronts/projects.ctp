<div class="banner-section col-12 px-0">
    <div class="banner-container">
        <img src="https://www.durotechindustries.com.au/banner/casestudy_banner.jpg"
             alt="Case Study Banner"
             class="img-fluid w-100 d-block banner-img">
    </div>
</div>

<div class="content_projects col-12">
    <div class="container mt-5 mb-5">
        <h2 class="text-uppercase text-primary fw-bold mb-4 text-center">
            Case Studies / Projects
        </h2>

        <div class="row justify-content-center">
            <?php if (!empty($projects)) : ?>
                <?php foreach ($projects as $project) :
                    $data = $project['CaseStudy'];
                ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex">
                        <div class="card shadow-sm border-0 flex-fill">
                            <?php if (!empty($data['featured_image'])): ?>
                                <img src="<?= h(SITEURL . $data['featured_image']) ?>"
                                     class="card-img-top"
                                     alt="<?= h($data['title']) ?>">
                            <?php else: ?>
                                <img src="https://www.durotechindustries.com.au/customdurotech/images/project_images/28156943_1851826481503969_6097429456538828800_n.jpg"
                                     class="card-img-top"
                                     alt="Project Default Image">
                            <?php endif; ?>

                            <div class="card-body d-flex flex-column">
                                <div class="card-content flex-grow-1">
                                    <h5 class="card-title text-primary mb-2 text-truncate-2">
                                        <?= h($data['title']) ?>
                                    </h5>
                                    <p class="text-muted small mb-0">
                                        <i class="fa fa-map-marker text-danger"></i>
                                        <?= h($data['location']) ?>
                                    </p>
                                </div>

                                <div class="mt-auto pt-3 text-center">
                                    <a href="<?= h(SITEURL . 'case-study/' . $data['slug']) ?>"
                                    class="btn btn-primary btn-sm w-100">
                                    View Details
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No case studies available at this time.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.banner-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}
.card {
    display: flex;
    flex-direction: column;
    height: 100%;
}
.card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}
.card-img-top {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}
.card-body {
    background: #fff;
    padding: 15px;
}
.btn-sm {
    padding: 6px 14px;
    font-size: 13px;
    border-radius: 6px;
}
.text-truncate-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: 42px;
}
.card .btn {
    margin-top: auto;
}
@media (max-width: 768px) {
    .banner-container {
        height: 250px;
    }
    .card-img-top {
        height: 180px;
    }
    .card-body {
        text-align: left !important;
        align-items: stretch !important;
    }
    .card-body .btn {
        align-self: center !important;
        width: 100%;
        text-align: center;
    }
}
</style>
