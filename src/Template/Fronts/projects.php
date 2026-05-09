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

        <div class="row projects-cards-row">
            <?php if (!empty($projects)) : ?>
                <?php
                $cardIndex = 0;
                foreach ($projects as $project) :
                    $data = $project['CaseStudy'];
                    $cardIndex++;
                    $detailUrl = rtrim(SITEURL, '/') . '/case-study/' . ($data['slug'] ?? '');
                    $imgSrc = 'https://www.durotechindustries.com.au/customdurotech/images/project_images/28156943_1851826481503969_6097429456538828800_n.jpg';
                    if (!empty($data['featured_image'])) {
                        $fi = (string)$data['featured_image'];
                        $imgSrc = (strpos($fi, 'http') === 0) ? $fi : rtrim(SITEURL, '/') . '/' . ltrim($fi, '/');
                    }
                    $excerpt = '';
                    if (!empty($data['short_summary'])) {
                        $excerpt = strip_tags((string)$data['short_summary']);
                        $excerpt = preg_replace('/\s+/u', ' ', trim($excerpt));
                        if (function_exists('mb_strlen') && mb_strlen($excerpt) > 180) {
                            $excerpt = mb_substr($excerpt, 0, 177) . '…';
                        } elseif (strlen($excerpt) > 180) {
                            $excerpt = substr($excerpt, 0, 177) . '…';
                        }
                    }
                    $badges = ['Case Study', 'Project'];
                    $badgeLabel = $badges[($cardIndex - 1) % 2];
                ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 d-flex">
                        <div class="card project-case-card border-0 flex-fill">
                            <a href="<?= h($detailUrl) ?>"
                               class="project-case-card__full-link"
                               aria-label="Open project: <?= h($data['title'] ?? 'Project') ?>"></a>
                            <div class="project-case-card__media">
                                <span class="project-case-card__badge"><?= h($badgeLabel) ?></span>
                                <img src="<?= h($imgSrc) ?>"
                                     class="project-case-card__img"
                                     alt="<?= h($data['title'] ?? '') ?>">
                            </div>

                            <div class="card-body d-flex flex-column project-case-card__body">
                                <h5 class="card-title project-case-card__title mb-2">
                                    <?= h($data['title'] ?? '') ?>
                                </h5>
                                <?php if ($excerpt !== '') : ?>
                                    <p class="project-case-card__excerpt mb-2"><?= h($excerpt) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($data['location'])) : ?>
                                    <p class="project-case-card__location mb-0">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        <?= h($data['location']) ?>
                                    </p>
                                <?php endif; ?>

                                <div class="project-case-card__footer mt-auto pt-3">
                                    <a href="<?= h($detailUrl) ?>"
                                       class="project-case-card__link">
                                        View Project <span class="project-case-card__arrow" aria-hidden="true">→</span>
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

/* 2 columns, tight horizontal gap, equal-height cards (works with BS3/BS4 mix) */
.projects-cards-row {
    display: flex;
    flex-wrap: wrap;
    margin-left: -8px;
    margin-right: -8px;
}
.projects-cards-row > [class*="col-"] {
    display: flex;
    padding-left: 8px;
    padding-right: 8px;
    margin-bottom: 22px;
}
.projects-case-studies-page .project-case-card.flex-fill {
    flex: 1 1 auto;
    width: 100%;
}

.projects-case-studies-page .project-case-card {
    display: flex;
    flex-direction: column;
    position: relative;
    height: 100%;
    border-radius: 0 0 14px 14px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 6px 22px rgba(20, 33, 61, 0.1);
    transition: transform 0.22s ease, box-shadow 0.22s ease;
}

.projects-case-studies-page .project-case-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 36px rgba(20, 33, 61, 0.14);
}

.projects-case-studies-page .project-case-card__full-link {
    position: absolute;
    inset: 0;
    z-index: 2;
    border-radius: inherit;
}

.projects-case-studies-page .project-case-card__full-link:focus {
    outline: 3px solid rgba(40, 137, 201, 0.45);
    outline-offset: -3px;
}

.projects-case-studies-page .project-case-card__media {
    position: relative;
    flex-shrink: 0;
    border-radius: 14px 14px 0 0;
    overflow: hidden;
}

.projects-case-studies-page .project-case-card__badge {
    position: absolute;
    top: 12px;
    left: 12px;
    z-index: 2;
    background: #22a06b;
    color: #fff;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    padding: 6px 12px;
    border-radius: 999px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.projects-case-studies-page .project-case-card__img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    display: block;
    border-radius: 14px 14px 0 0;
}

.projects-case-studies-page .project-case-card__body {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    background: #eef2f7;
    padding: 1.25rem 1.35rem 1.2rem;
    border-radius: 0 0 14px 14px;
}

.projects-case-studies-page .project-case-card__title {
    font-size: 1.05rem;
    font-weight: 700;
    line-height: 1.35;
    color: #4a1d6a;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.projects-case-studies-page .project-case-card__excerpt {
    font-size: 0.9rem;
    line-height: 1.55;
    color: #5a6d7e;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.projects-case-studies-page .project-case-card__location {
    font-size: 0.9rem;
    line-height: 1.5;
    font-weight: 700;
    color: #1a2b3c;
    margin-top: 1rem;
    padding-top: 0.35rem;
    letter-spacing: 0.01em;
}

.projects-case-studies-page .project-case-card__location .fa-map-marker {
    color: #c62828;
    margin-right: 6px;
}

.projects-case-studies-page .project-case-card__footer {
    position: relative;
    z-index: 3;
    text-align: right;
    margin-top: auto;
}

.projects-case-studies-page .project-case-card__link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 1.125rem;
    font-weight: 700;
    color: #3d8b3d;
    text-decoration: none;
    transition: color 0.2s ease, gap 0.2s ease;
}

.projects-case-studies-page .project-case-card__link:hover,
.projects-case-studies-page .project-case-card__link:focus {
    color: #449d44;
    text-decoration: none;
}

.projects-case-studies-page .project-case-card__link:hover .project-case-card__arrow {
    transform: translateX(3px);
}

.projects-case-studies-page .project-case-card__arrow {
    display: inline-block;
    transition: transform 0.2s ease;
}

@media (max-width: 768px) {
    .banner-container {
        height: 250px;
    }

    .projects-case-studies-page .project-case-card__img {
        height: 220px;
    }

    .projects-case-studies-page .project-case-card__body {
        text-align: left;
    }

    .projects-case-studies-page .project-case-card__footer {
        text-align: left;
    }
}
</style>
