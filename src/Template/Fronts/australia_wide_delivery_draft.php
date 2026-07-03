<style>
/* Matches About Us page (Fronts/about.php) — scoped to this draft page only */
.page-about-wrap {
    padding-top: 70px;
    background: #e4edf4;
}
@media (min-width: 768px) {
    .page-about-wrap {
        padding-top: 80px;
    }
}
.page-about-wrap > .content_about {
    padding-top: 0;
    padding-left: 0;
    padding-right: 0;
    padding-bottom: 40px;
}
.banner_about {
    overflow: visible;
    display: block;
    margin-top: 0;
    padding-top: 0;
    margin-bottom: 0;
    padding-bottom: 0;
}
.banner_about img {
    display: block;
    width: 100%;
    height: auto;
    vertical-align: top;
}
.about-intro {
    max-width: 940px;
    margin: 14px auto 26px;
    text-align: center;
}
.about-intro__badge {
    width: 54px;
    height: 54px;
    margin: 0 auto 10px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    color: #5a1ea8;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    font-size: 24px;
}
.about-intro h3 {
    margin: 0 0 10px;
    font-size: 44px;
    font-weight: 700;
    color: #1b4762;
}
.about-intro__text {
    margin: 0;
    background: #e4edf4;
    border-radius: 14px;
    padding: 16px 20px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    line-height: 1.75;
    color: #4f6782;
}
.draft-delivery-content {
    max-width: 940px;
    margin: 0 auto 32px;
    padding: 0 20px;
}
.draft-delivery-content h4 {
    margin: 28px 0 12px;
    font-size: 20px;
    font-weight: 700;
    color: #1b4762;
}
.draft-delivery-content h4:first-child {
    margin-top: 0;
}
.draft-delivery-content p {
    margin: 0 0 14px;
    font-size: 15px;
    line-height: 1.75;
    color: #4f6782;
}
.draft-delivery-content ul {
    margin: 0 0 18px;
    padding-left: 22px;
    color: #4f6782;
}
.draft-delivery-content li {
    margin-bottom: 8px;
    font-size: 15px;
    line-height: 1.65;
}
.draft-delivery-content__card {
    background: #ffffff;
    border-radius: 14px;
    padding: 24px 22px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    margin-bottom: 20px;
}
.draft-delivery-notice {
    max-width: 940px;
    margin: 0 auto 16px;
    padding: 10px 16px;
    background: #fff8e6;
    border: 1px solid #f4c400;
    border-radius: 8px;
    font-size: 13px;
    color: #1b4762;
    text-align: center;
}
.draft-banner-specs {
    max-width: 940px;
    margin: 0 auto 24px;
    padding: 0 20px;
}
.draft-banner-specs__card {
    background: #ffffff;
    border-radius: 14px;
    padding: 24px 22px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    border: 2px solid rgba(40, 137, 200, 0.2);
}
.draft-banner-specs__card h4 {
    margin: 0 0 6px;
    font-size: 20px;
    font-weight: 700;
    color: #1b4762;
}
.draft-banner-specs__card > p {
    margin: 0 0 18px;
    font-size: 14px;
    line-height: 1.6;
    color: #536f8c;
}
.draft-banner-specs__table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 16px;
    font-size: 14px;
}
.draft-banner-specs__table th,
.draft-banner-specs__table td {
    padding: 10px 12px;
    text-align: left;
    border-bottom: 1px solid #e4edf4;
    color: #4f6782;
    vertical-align: top;
}
.draft-banner-specs__table th {
    width: 38%;
    font-weight: 700;
    color: #1b4762;
    background: #f4f9fc;
}
.draft-banner-specs__table tr:last-child th,
.draft-banner-specs__table tr:last-child td {
    border-bottom: none;
}
.draft-banner-specs__note {
    margin: 0;
    padding: 12px 14px;
    background: #eef5fa;
    border-radius: 8px;
    font-size: 13px;
    line-height: 1.65;
    color: #536f8c;
}
.draft-banner-specs__note strong {
    color: #1b4762;
}
@media (max-width: 767px) {
    .about-intro {
        margin: 10px auto 18px;
    }
    .about-intro h3 {
        font-size: 32px;
    }
    .about-intro__text {
        padding: 14px;
    }
    .draft-delivery-content {
        padding: 0 16px;
    }
    .draft-banner-specs {
        padding: 0 16px;
    }
    .draft-banner-specs__table th,
    .draft-banner-specs__table td {
        display: block;
        width: 100%;
    }
    .draft-banner-specs__table th {
        border-bottom: none;
        padding-bottom: 4px;
    }
}
</style>

<div class="page-about-wrap">
    <div class="content_about col-lg-12 col-md-12 col-sm-12">

        <div class="draft-delivery-notice" role="status">
            <strong>Draft page</strong> — Placeholder banner and content for review. Replace before go-live.
        </div>

        <div class="banner_about col-lg-12 col-md-12 col-sm-12">
            <img src="<?php echo SITEURL; ?>customdurotech/images/landing_draft_banner.jpg" alt="Australia Wide Delivery — placeholder banner">
        </div>

        <div class="draft-banner-specs">
            <div class="draft-banner-specs__card">
                <h4><i class="fa fa-picture-o" aria-hidden="true"></i> Banner Image Specifications</h4>
                <table class="draft-banner-specs__table">
                    <tr>
                        <th>Dimensions</th>
                        <td><strong>1300 × 362 pixels</strong> (width × height)</td>
                    </tr>
                    <tr>
                        <th>Aspect ratio</th>
                        <td><strong>~3.59 : 1</strong> (wide panoramic)</td>
                    </tr>
                    <tr>
                        <th>File format</th>
                        <td><strong>JPG</strong> preferred (RGB, 72 DPI). PNG acceptable if transparency is needed.</td>
                    </tr>
                    <tr>
                        <th>File size</th>
                        <td>Under <strong>400 KB</strong> where possible</td>
                    </tr>
                    <tr>
                        <th>File name</th>
                        <td><code>landing_draft_banner.jpg</code></td>
                    </tr>
                    <tr>
                        <th>Text &amp; graphics</th>
                        <td>Include all headline text, CTAs, and graphics <strong>inside the image</strong> (same as About Us — no HTML text overlay on the banner).</td>
                    </tr>
                    <tr>
                        <th>Safe zone</th>
                        <td>Keep important text and buttons at least <strong>60–80 px</strong> from all edges (mobile cropping).</td>
                    </tr>
                    <tr>
                        <th>Brand colours</th>
                        <td>Durotech blue <strong>#2889c8</strong>, navy <strong>#1b4762</strong>, accent yellow <strong>#f4c400</strong></td>
                    </tr>
                    <tr>
                        <th>Optional larger size</th>
                        <td>Home page sliders use <strong>1920 × 577 px</strong> — also works full-width if preferred.</td>
                    </tr>
                </table>
              
            </div>
        </div>

        <div class="about-intro">
            <div class="about-intro__badge"><i class="fa fa-truck" aria-hidden="true"></i></div>
            <h3>Australia Wide Delivery</h3>
            <p class="about-intro__text">
                [Placeholder intro] Durotech delivers waterproofing membranes, coatings, and construction chemical products
                to projects across Australia. Call or email our team for project-specific advice and delivery options direct to you.
            </p>
        </div>

        <div class="draft-delivery-content">

            <div class="draft-delivery-content__card">
                <h4>Nationwide Coverage</h4>
                <p>
                    [Placeholder paragraph] Whether your project is in a capital city, regional centre, or remote area,
                    our logistics network supports reliable supply of Durotech products Australia wide.
                </p>
                <ul>
                    <li>[Placeholder] Sydney, Melbourne, Brisbane, Perth, Adelaide, and Canberra metro areas</li>
                    <li>[Placeholder] Regional NSW, Victoria, Queensland, and other states</li>
                    <li>[Placeholder] Project-site or warehouse delivery options</li>
                </ul>
            </div>

            <div class="draft-delivery-content__card">
                <h4>How We Can Help</h4>
                <p>
                    [Placeholder paragraph] Our technical and sales teams work with contractors, specifiers, and distributors
                    to recommend the right system and arrange delivery to suit your programme.
                </p>
                <ul>
                    <li>[Placeholder] Product selection and specification support</li>
                    <li>[Placeholder] Delivery scheduling and freight options</li>
                    <li>[Placeholder] Access to technical literature and datasheets</li>
                </ul>
            </div>

            <div class="draft-delivery-content__card">
                <h4>Get in Touch</h4>
                <p>
                    [Placeholder paragraph] Contact the Durotech team to discuss your project requirements and Australia-wide delivery options.
                </p>
                <ul>
                    <li>[Placeholder] Phone: <?php echo h(defined('PHONE') && PHONE !== '' ? PHONE : '1300 434 272'); ?></li>
                    <li>[Placeholder] Email: sales@durotechindustries.com.au</li>
                    <li>[Placeholder] <a href="<?php echo SITEURL; ?>contact">Contact form</a></li>
                </ul>
            </div>

        </div>

    </div>
</div>
