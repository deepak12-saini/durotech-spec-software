<div class="banner-section col-12 px-0">
    <div class="banner-container">
        <img src="https://www.durotechindustries.com.au/banner/casestudy_banner.jpg"
             alt="Case Study Banner"
             class="img-fluid w-100 d-block banner-img">
    </div>
</div>

<div class="content_projects projects-case-studies-page col-12">
    <div class="container mt-5 mb-5">
        <div class="projects-page-heading text-center mb-4">
            <h2 class="text-uppercase text-primary fw-bold mb-0">
                Case Studies / Projects
            </h2>
        </div>

        <div class="row justify-content-center g-4">
            <?php if (!empty($projects)) : ?>
                <?php foreach ($projects as $project) :
                    $data = $project['CaseStudy'];
                ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-12 d-flex">
                        <div class="card project-case-card border-0 flex-fill">
                            <?php if (!empty($data['featured_image'])): ?>
                                <img src="<?= h(SITEURL . $data['featured_image']) ?>"
                                     class="card-img-top project-case-card__img"
                                     alt="<?= h($data['title']) ?>">
                            <?php else: ?>
                                <img src="https://www.durotechindustries.com.au/customdurotech/images/project_images/28156943_1851826481503969_6097429456538828800_n.jpg"
                                     class="card-img-top project-case-card__img"
                                     alt="Project Default Image">
                            <?php endif; ?>

                            <div class="card-body d-flex flex-column project-case-card__body">
                                <div class="card-content flex-grow-1">
                                    <h5 class="card-title project-case-card__title text-primary mb-2">
                                        <?= h($data['title']) ?>
                                    </h5>
                                    <p class="text-muted small mb-0 project-case-card__location">
                                        <i class="fa fa-map-marker text-danger" aria-hidden="true"></i>
                                        <?= h($data['location']) ?>
                                    </p>
                                </div>

                                <div class="mt-auto pt-3 text-center">
                                    <a href="<?= h(SITEURL . 'case-study/' . $data['slug']) ?>"
                                       class="btn btn-primary project-case-card__btn w-100">
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
.projects-case-studies-page.content_projects {
    background: #e4edf4;
    padding-bottom: 48px;
}

.projects-page-heading {
    border-top: 1px solid rgba(0, 51, 102, 0.2);
    padding-top: 1.25rem;
    max-width: 720px;
    margin-left: auto;
    margin-right: auto;
}

.banner-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.projects-case-studies-page .project-case-card {
    display: flex;
    flex-direction: column;
    height: 100%;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.projects-case-studies-page .project-case-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 28px rgba(0, 0, 0, 0.12);
}

.projects-case-studies-page .project-case-card__img {
    width: 100%;
    height: 240px;
    object-fit: cover;
    flex-shrink: 0;
}

.projects-case-studies-page .project-case-card__body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: #fff;
    padding: 1.1rem 1.15rem 1.15rem;
}

.projects-case-studies-page .project-case-card__title {
    font-size: 1rem;
    font-weight: 600;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.projects-case-studies-page .project-case-card__location {
    line-height: 1.4;
}

.projects-case-studies-page .project-case-card__btn {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    font-weight: 600;
    border-radius: 6px;
}

.projects-case-studies-page .project-case-card .btn {
    margin-top: auto;
}

@media (max-width: 768px) {
    .banner-container {
        height: 250px;
    }

    .projects-case-studies-page .project-case-card__img {
        height: 200px;
    }

    .projects-case-studies-page .project-case-card__body {
        text-align: left;
        align-items: stretch;
    }

    .projects-case-studies-page .project-case-card__body .btn {
        align-self: stretch;
        text-align: center;
    }
}
</style>
