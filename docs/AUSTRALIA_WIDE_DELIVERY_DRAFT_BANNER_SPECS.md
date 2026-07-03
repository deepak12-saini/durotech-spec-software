# Australia Wide Delivery — Draft Page & Banner Specifications

## Draft page URL

| Environment | URL |
|-------------|-----|
| Production | https://durotechindustries.com.au/australia-wide-delivery-draft |
| Local | http://localhost/cake3app/australia-wide-delivery-draft |

- **Template:** Based on About Us (`Fronts/about.php`) layout and styling
- **Layout:** `customduro_layout` (site header + footer unchanged)
- **Navigation:** Not linked in main menu (link-only / draft)
- **Robots:** `noindex, nofollow`
- **Placeholder banner file:** `webroot/customdurotech/images/landing_draft_banner.jpg`

---

## Banner specifications (from About Us page)

Derived from the live About Us banner at  
`webroot/customdurotech/images/about_us_banner.jpg` and its markup in `src/Template/Fronts/about.php`.

### Recommended dimensions

| Property | Value |
|----------|--------|
| **Width** | **1300 px** |
| **Height** | **362 px** |
| **Aspect ratio** | **~3.59 : 1** (1300 ÷ 362) |

The image is displayed at **100% container width** with `height: auto`, so it scales on smaller screens while keeping proportion.

### Preferred file format

| Property | Value |
|----------|--------|
| **Format** | **JPG** (same as About Us banner) |
| **Colour mode** | RGB |
| **Resolution** | 72 DPI (web) |
| **Target file size** | Under 400 KB where possible |

PNG is acceptable if the design requires transparency (About Us uses JPG).

### Overlay and text positioning (About Us)

The About Us page does **not** use a CSS/HTML text overlay on the banner.

```211:213:src/Template/Fronts/about.php
	        <div class="banner_about col-lg-12 col-md-12 col-sm-12">
				<img src="<?php echo SITEURL ;?>customdurotech/images/about_us_banner.jpg" alt="About Durotech">
			</div>
```

- **Implementation:** Single full-width `<img>` inside `.banner_about`
- **Text/graphics:** Any headline, CTA, or brand graphics (e.g. “WE DELIVER AUSTRALIA WIDE”) are **baked into the image file** by the designer — not added via HTML/CSS on top
- **No gradient overlay** on the About Us banner in code
- **Safe area:** Keep critical text and buttons away from edges (~60–80 px) for mobile crop

### Delivery for this draft page

| Item | Detail |
|------|--------|
| **Upload path** | `webroot/customdurotech/images/landing_draft_banner.jpg` |
| **Replace** | Swap file only; no template change required if dimensions are similar |

### Optional larger format (home slider reference)

Home page sliders use **1920 × 577 px** (`banner 4.jpg`). That also works full-width; **1300 × 362 px** matches About Us exactly.

---

## Files added (new page only)

| File | Purpose |
|------|---------|
| `config/routes.php` | Route `/australia-wide-delivery-draft` |
| `src/Controller/FrontsController.php` | Action `australiaWideDeliveryDraft()` |
| `src/Template/Fronts/australia_wide_delivery_draft.php` | Draft view |
| `webroot/customdurotech/images/landing_draft_banner.jpg` | Placeholder banner |
| `docs/AUSTRALIA_WIDE_DELIVERY_DRAFT_BANNER_SPECS.md` | This document |

No existing pages or global styles were modified.
