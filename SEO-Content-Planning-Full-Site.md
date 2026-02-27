# Complete SEO Content Planning Workflow — Durotech Website

**Document purpose:** Full SEO content plan based on the existing project structure (CakePHP app: Fronts, Products, Categories, Case Studies, static pages).  
**Audience:** Client-facing deliverable; implementation team.  
**Site context:** Durotech — Australian construction chemical manufacturer (waterproofing membranes, coatings, sealants, building protection). B2B audience: builders, contractors, architects, construction suppliers.

---

## Project page inventory (from codebase)

| URL pattern | Controller / Action | Content source | Meta source |
|-------------|---------------------|----------------|-------------|
| `/` | Fronts::index | Home | Hardcoded in controller |
| `/product` | Products::index | Product listing (first category) | Hardcoded when no slug |
| `/category/:slug` | Products::index | Category listing | DB: `categories.meta_title/description/keyword` |
| `/product/:slug` | Products::detail | Product detail | DB: `products` then fallback `categories` |
| `/about` | Fronts::about | About | Hardcoded |
| `/contact` | Fronts::contact | Contact | Hardcoded |
| `/projects` | Fronts::projects | Case study list | Hardcoded (duplicate of About meta) |
| `/case-study/:slug` | Fronts::caseStudy | Single case study | From CaseStudy title + short_summary |
| `/terrace-waterproofing` | Fronts::terraceWaterproofing | Topic page | Hardcoded |
| `/retaining-walls` | Fronts::retainingWalls | Topic page | Hardcoded |
| `/technical-literature/*` | Fronts::technicalLiteratureNew | Tech lit by category | Generic |
| `/specification`, `/specifiers` | Fronts::specification | Specifiers | Hardcoded |
| `/health-safety` | Fronts::healthSafety | H&S | Hardcoded |
| `/faqs`, `/faq-new` | Fronts::faq / faqNew | FAQ | Hardcoded |
| `/durolab` | Fronts::durolab | Duro Lab | Hardcoded |
| `/durooem` | Fronts::durooem | DuroOEM | Hardcoded (empty meta desc) |
| `/flake` | Fronts::flake | Duro Flake | Hardcoded (thin meta) |
| `/video` | Fronts::video | Videos | Hardcoded |
| `/durotech-institute-of-waterproofing` | Fronts::instituteWaterproofing | Institute | Hardcoded (broken meta desc) |
| `/testimonials` | Fronts::testimonials | Testimonials | Hardcoded |
| `/product_warranty`, `/warranty/*` | Fronts::productWarranty / Stocks | Warranty | Set in controller |
| `/careers` | Careers::index | Careers | — |
| `/competitor-product` (if routed) | Fronts::competitorProduct | Competitor | Hardcoded (wrong desc) |
| `/distribution-list` (if routed) | Fronts::distributionList | Distribution | Hardcoded |

Categories and products are stored in DB; each category has `slug`, `category_name`, `meta_title`, `meta_description`, `meta_keyword`. Products have the same meta fields with fallback to category.

---

# 1. FULL SEO STRATEGY

## 1.1 Business focus (from project content)

- **Offer:** Waterproofing membranes (liquid, sheet, polyurethane), coatings, sealants, building protection products. Australian made/owned since 1977.
- **Audience:** Builders, contractors, architects, specifiers, construction suppliers (B2B).
- **Differentiators:** Natspec/architect CPD, Durotech Institute, technical literature, warranty, case studies, Duro Lab.

## 1.2 Keyword focus areas

| Focus area | Priority | Rationale |
|------------|----------|-----------|
| Waterproofing membranes (liquid, sheet, PU) | P0 | Core product; matches category slugs and content |
| Roof & terrace waterproofing | P0 | Strong in current meta and topic pages |
| Sealants & silicone | P0 | Dedicated category in code (sealants-and-silicone) |
| Construction coatings / floor coatings | P1 | Commercial intent; expand if categories exist |
| Building protection (retaining walls, basement) | P1 | Already have retaining-walls, terrace |
| Specifiers / architects | P1 | Specification, Natspec, CPD pages |
| Location (Sydney, Melbourne, Brisbane, Australia) | P1 | Home meta already “Sydney”; support local intent |
| Technical / standards / datasheets | P2 | Technical literature, specs, authority |

## 1.3 Topical authority structure

- **Pillar 1 — Waterproofing:** Home, `/terrace-waterproofing`, `/retaining-walls`, category pages under waterproofing (e.g. polyurethane-waterproofing-membrane), product pages.
- **Pillar 2 — Coatings & sealants:** Category pages (e.g. sealants-and-silicone), related product pages.
- **Pillar 3 — Resources:** `/specification`, `/technical-literature`, `/durotech-institute-of-waterproofing`, `/faqs`, `/health-safety`.
- **Pillar 4 — Proof & trust:** `/projects`, `/case-study/:slug`, `/testimonials`, `/product_warranty`, `/durolab`.

## 1.4 Internal linking strategy

- **Home:** Link to 3–5 main category pages, terrace-waterproofing, retaining-walls, projects, contact, key products (featured).
- **Category pages:** Link to pillar topics (terrace-waterproofing, retaining-walls), parent “Products” concept, sibling categories, and 2–4 key products in that category; CTA to contact/specification.
- **Product pages:** Link to parent category, “Related products” (already have random 4), terrace/retaining walls if relevant, datasheet/tech lit, contact/specification.
- **Topic pages (terrace, retaining walls):** Link to relevant category and product URLs; link to each other and to projects/case studies.
- **Projects/Case studies:** Link to product(s) used, relevant category, terrace/retaining walls, contact.
- **Specification / Specifiers:** Link to categories, key products, technical-literature, institute, contact.
- **FAQ:** Link to category and product pages where each answer applies; contact.

## 1.5 Priority pages for optimization

1. **Home** (`/`) — Brand + category themes; biggest impact.
2. **Default product listing** (`/product` when no slug) — Currently uses first category; ensure unique meta and H1.
3. **All category pages** (`/category/:slug`) — DB-driven; audit and fill meta_title, meta_description, meta_keyword per category.
4. **High-value product pages** — Top-selling or strategic products; ensure product-level meta and content.
5. **Terrace Waterproofing** (`/terrace-waterproofing`) — Strong intent; improve content depth and internal links.
6. **Retaining Walls** (`/retaining-walls`) — Same as above.
7. **About** (`/about`) — Trust; unique meta (currently same as membrane-focused).
8. **Projects** (`/projects`) — Unique meta and H1 (currently duplicate of About).
9. **Contact** (`/contact`) — Lead gen; clear meta and CTAs.
10. **Specification / Specifiers** — For architect/specifier intent.
11. **Case study singles** — Unique meta from title + short_summary (already dynamic); ensure internal links in body.
12. **FAQ, Duro Lab, Institute, Testimonials** — Meta and internal links.
13. **DuroOEM, Flake, Video, Institute** — Fix empty or thin meta descriptions.

## 1.6 Content expansion opportunities

- Add **pillar intro copy** on category pages (not only product grid) — e.g. “Polyurethane Waterproofing Membrane” intro with 150–300 words, headings, internal links.
- **Location pages** (e.g. “Waterproofing Sydney”, “Melbourne”) if search demand justifies — link from home and footer.
- **Application/substrate guides** — e.g. “Waterproofing for concrete”, “Roof membrane selection” — link from categories and products.
- **Standards/compliance** — e.g. Australian waterproofing standards — link from specifiers and product pages.
- **FAQ schema** on `/faqs` and category-level FAQs for featured snippets.
- **Case studies:** Ensure each links to 1–2 products and one category; add “Used in this project” block.
- **Technical literature:** Unique meta per segment; breadcrumbs and links to products/categories.

## 1.7 Growth roadmap

- **Phase 1 (Weeks 1–4):** Meta and H1 audit for Home, /product, all category pages (DB), terrace-waterproofing, retaining-walls, About, Projects, Contact; fix duplicate/empty meta; add 2–3 internal links per priority page.
- **Phase 2 (Weeks 5–8):** Category page intro copy (150–300 words) for top 5 categories; product meta audit for top 20 products; case study internal links; fix DuroOEM, Flake, Institute, Video meta.
- **Phase 3 (Months 3–4):** FAQ schema; one new application/guide page; location page(s) if validated; ongoing internal linking from new content.
- **Phase 4 (Ongoing):** Quarterly meta and content refresh; new case studies and product pages with blueprints below.

---

# 2. DEEP KEYWORD RESEARCH (BY MAIN PRODUCT CATEGORY)

Categories are DB-driven; below uses **in-code and meta evidence** (e.g. polyurethane-waterproofing-membrane, sealants-and-silicone, default “roof waterproofing membrane”, “liquid waterproofing Sydney”) to define clusters.

## 2.1 Waterproofing membranes (incl. polyurethane, liquid, sheet)

| Type | Keywords |
|------|----------|
| **Primary** | waterproofing membrane Australia, liquid waterproofing membrane, polyurethane waterproofing membrane, sheet membrane waterproofing, roof waterproofing membrane, terrace waterproofing |
| **Secondary** | roof waterproofing Sydney, waterproofing membrane Melbourne, liquid membrane roof, PU waterproofing, waterproofing supplies Australia, remedial waterproofing |
| **Long-tail** | best polyurethane waterproofing membrane Australia, liquid waterproofing membrane for flat roof, waterproofing membrane for concrete, waterproofing terrace balcony Australia, roof and terrace waterproofing new construction |

**Cluster:** Use for `/category/polyurethane-waterproofing-membrane` and any other membrane categories; also for `/terrace-waterproofing`, `/retaining-walls`, home, and product pages (membranes).

## 2.2 Sealants and silicone

| Type | Keywords |
|------|----------|
| **Primary** | construction sealants Australia, silicone sealant waterproofing, sealants and silicone, fire rated sealant |
| **Secondary** | expansion joint sealant, acoustic sealant, silicone sealant Melbourne Sydney, DuroFire, FC PRO |
| **Long-tail** | fire rated sealant Australia, silicone sealant for bathroom waterproofing, best construction sealant suppliers |

**Cluster:** Use for `/category/sealants-and-silicone` and related product pages (50FC, 25C, DuroFire A, etc.).

## 2.3 Roof, terrace, and remedial

| Type | Keywords |
|------|----------|
| **Primary** | roof waterproofing, terrace waterproofing, remedial waterproofing, roof leaks, roof restoration |
| **Secondary** | balcony waterproofing, flat roof waterproofing Australia, Colourbond protection, metal roof waterproofing |
| **Long-tail** | terrace and balcony waterproofing Sydney, remedial waterproofing for roofs Australia, fix roof leaks |

**Cluster:** Use for `/terrace-waterproofing`, `/retaining-walls`, home, projects, and relevant category/product pages.

## 2.4 Coatings (floor, wall, protective)

| Type | Keywords |
|------|----------|
| **Primary** | floor coating Australia, epoxy floor coating, construction coatings, protective coatings |
| **Secondary** | industrial floor coating, wall coating, concrete coating, epoxy coating Sydney Melbourne |
| **Long-tail** | epoxy floor coating for industrial, best floor coating Australia, concrete protective coating |

**Cluster:** Use if you have category slugs like floor-coatings or coatings; else add to “content expansion”.

## 2.5 Retaining walls and below-ground

| Type | Keywords |
|------|----------|
| **Primary** | retaining wall waterproofing, below ground waterproofing, basement waterproofing |
| **Secondary** | waterproofing retaining walls Australia, structural waterproofing, tanking |
| **Long-tail** | waterproofing for retaining walls Sydney, basement waterproofing membrane |

**Cluster:** Use for `/retaining-walls` and any below-ground product/category pages.

## 2.6 Specifiers and B2B

| Type | Keywords |
|------|----------|
| **Primary** | waterproofing specifiers Australia, construction chemicals specifiers, Natspec waterproofing |
| **Secondary** | architect specification waterproofing, CPD waterproofing, construction chemicals suppliers Australia |
| **Long-tail** | specification for waterproofing membrane Australia, B2B waterproofing products |

**Cluster:** Use for `/specification`, `/specifiers`, `/durotech-institute-of-waterproofing`, technical-literature.

## 2.7 Brand and trust

| Type | Keywords |
|------|----------|
| **Primary** | Durotech, Durotech Industries, Durotech waterproofing |
| **Secondary** | Australian waterproofing manufacturer, construction chemicals Australia, Duro Lab |
| **Long-tail** | Durotech waterproofing products Sydney, Durotech membrane datasheet |

**Cluster:** Home, About, testimonials, Duro Lab, contact.

---

# 3. SEARCH INTENT ANALYSIS (MOST IMPORTANT KEYWORDS)

## 3.1 “Waterproofing membrane Australia” / “liquid waterproofing membrane”

- **Intent:** Commercial — find products/suppliers.
- **Ideal content type:** Category page (product grid) + intro copy; product pages with specs and downloads.
- **Depth:** Category: 200–400 words intro + product grid. Product: 150–300 words + specs, datasheet, MSDS, application.
- **Structure to rank:** Clear H1 (e.g. “Liquid Waterproofing Membrane | Australia”), H2s for “Products”, “Applications”, “Technical” or “Downloads”; FAQs; internal links to terrace, retaining walls, contact.

## 3.2 “Terrace waterproofing” / “roof waterproofing”

- **Intent:** Informational + commercial — solutions and products.
- **Ideal content type:** Topic page (like existing `/terrace-waterproofing`) with product recommendations.
- **Depth:** 400–700 words; applications, product types, benefits, CTA to products and contact.
- **Structure:** H1 “Terrace Waterproofing” / “Roof Waterproofing”; H2s by application or product type; short FAQs; links to category and 2–3 products.

## 3.3 “Sealants and silicone” / “construction sealants Australia”

- **Intent:** Commercial — products and suppliers.
- **Ideal content type:** Category page with intro + product grid.
- **Depth:** 200–400 words intro; product pages with use cases and datasheets.
- **Structure:** H1 aligned with category name; H2s for product range, applications, specs; internal links to specification and contact.

## 3.4 “Waterproofing solutions FAQs” / “waterproofing products”

- **Intent:** Informational — answers and trust.
- **Ideal content type:** FAQ page with clear Q&A; optional FAQ schema.
- **Depth:** 5–15 questions; concise answers with links to product/category where relevant.
- **Structure:** H1 “Waterproofing Solutions FAQs”; one H2 per question or per theme; internal links in answers.

## 3.5 “Durotech” / “Durotech Industries”

- **Intent:** Brand — find company, contact, products.
- **Ideal content type:** Home and About; clear value proposition and CTAs.
- **Depth:** Home: clear value prop + category links; About: 300–500 words, story, credentials.
- **Structure:** Unique meta per page; H1 for brand or “About Durotech”; links to products, specification, contact.

## 3.6 “Specifiers” / “waterproofing specification Australia”

- **Intent:** Professional — specs, CPD, Natspec.
- **Ideal content type:** Single page (specification/specifiers) with CPD/Natspec info and links to technical literature and products.
- **Depth:** 300–500 words; how to specify, partnerships, CTA to contact and tech lit.
- **Structure:** H1 “Specifiers” / “Waterproofing Specification”; H2s for partnerships, CPD, resources; internal links.

---

# 4. COMPETITOR STRUCTURE MODEL (CONSTRUCTION CHEMICALS / WATERPROOFING)

## 4.1 Recommended page structure (category)

1. **Breadcrumb:** Home > Products > [Category name].
2. **H1:** One primary keyword (e.g. “Polyurethane Waterproofing Membrane”).
3. **Intro block:** 150–300 words — what the category is, applications, benefits; include 1–2 semantic keywords and internal links (terrace, retaining walls, contact).
4. **Product grid:** Cards with image, title, short line, link to product; optional “View datasheet” or “Specification”.
5. **Optional sections:** “Applications”, “Standards” or “Technical support” (with links to technical-literature, specification).
6. **CTA:** “Need help specifying?” → Contact or Specification.
7. **FAQ (optional):** 2–4 questions with concise answers and links to products.

## 4.2 Recommended page structure (product)

1. **Breadcrumb:** Home > [Category] > [Product name].
2. **H1:** Product name (and variant if applicable).
3. **Short description:** 2–3 sentences; primary keyword in first 50 words.
4. **Key specs / features:** Bullets or table (coverage, finish, standards, substrates).
5. **Applications / uses:** 1–2 short paragraphs; link to terrace or retaining walls if relevant.
6. **Downloads:** Datasheet, MSDS, colour chart (existing); ensure links are crawlable.
7. **Related products:** 2–4 from same category or “Often used with”.
8. **CTA:** Contact, request specification, or technical literature.
9. **Optional:** 1–2 FAQs (e.g. “What substrates can X be used on?”).

## 4.3 Recommended page structure (topic page, e.g. terrace / retaining walls)

1. **Breadcrumb:** Home > Solutions / Applications > [Topic].
2. **H1:** Topic (e.g. “Terrace Waterproofing”).
3. **Intro:** 100–150 words; problem and solution.
4. **Sections:** Applications, product types/systems, benefits, case study teaser.
5. **Product links:** 2–4 relevant products or category link.
6. **CTA:** Contact or “View products”.
7. **Internal links:** To other topic pages, categories, projects.

## 4.4 Common ranking patterns to follow

- **Title:** Primary keyword + brand (e.g. “Liquid Waterproofing Membrane Australia | Durotech”); 50–60 chars.
- **Meta description:** 150–160 chars; benefit or CTA; include primary keyword and location or “Australia” where relevant.
- **One H1 per page;** H2s for main sections; H3 for subsections.
- **First paragraph:** Primary keyword in first 100 words; natural, not stuffed.
- **Internal links:** 3–8 per page to relevant categories, products, topic pages, contact.
- **Downloads:** Datasheet/MSDS as links (not only iframe); descriptive anchor text.

---

# 5. SEO CONTENT BLUEPRINTS (BY PAGE TYPE)

## 5.1 Home (`/`)

| Element | Recommendation |
|---------|----------------|
| **SEO title** | Waterproofing Products & Membranes Australia \| Durotech Industries |
| **Meta description** | Australian-made waterproofing membranes, coatings & sealants since 1977. For builders, contractors & specifiers. Sydney, Melbourne, Brisbane. Call 02 9603 1177. |
| **H1** | Waterproofing Products & Construction Chemicals for Australia |
| **H2** | Product categories (e.g. Waterproofing Membranes, Sealants, Coatings); Why Durotech; Featured solutions (Terrace, Retaining Walls); Case studies; Contact |
| **Semantic keywords** | waterproofing membrane, liquid waterproofing, roof waterproofing, terrace waterproofing, sealants, construction chemicals, Australia, Sydney, Melbourne |
| **FAQ** | 1–2 e.g. “Where can I buy Durotech waterproofing products?” → link to contact/distribution. |
| **Internal links** | 3–5 category URLs, /terrace-waterproofing, /retaining-walls, /projects, /specification, /contact |
| **Content improvement** | Add 80–150 words above the fold (value prop, audience); ensure category blocks have descriptive links (not only images). |

## 5.2 Product listing default (`/product` — no slug)

| Element | Recommendation |
|---------|----------------|
| **SEO title** | Roof Waterproofing Membrane Products \| Liquid Waterproofing Sydney \| Durotech |
| **Meta description** | Waterproofing products for Melbourne, Brisbane & Sydney. Membranes, sealants & coatings. Quality Australian-made. Call 02 9603 1177 or browse categories. |
| **H1** | Waterproofing Products & Membranes |
| **H2** | Browse by category (use category names); or “Our product range” |
| **Semantic keywords** | waterproofing products, membrane products, roof waterproofing, liquid waterproofing, Sydney, Melbourne, Brisbane, Australia |
| **Internal links** | All category pages (from sidebar/grid); terrace-waterproofing, retaining-walls, contact |
| **Content improvement** | Add 100–200 words intro before product/category grid; ensure H1 is unique vs home. |

## 5.3 Category pages (template — DB-driven)

*Apply per category; store in `categories.meta_title`, `meta_description`, `meta_keyword`; add intro in view or DB.*

| Element | Recommendation |
|---------|----------------|
| **SEO title** | [Primary keyword] \| Durotech Australia |
| **Meta description** | [1 sentence: what the category is + benefit/CTA]. Australian-made. For builders & specifiers. [Optional: Call 02 9603 1177.] |
| **H1** | [Category name] — e.g. “Polyurethane Waterproofing Membrane” |
| **H2** | About [category]; Products; Applications (optional); Technical & downloads (optional); Contact / Specification |
| **Semantic keywords** | Category primary + secondary from Section 2; “Australia”, “builders”, “specifiers”, “datasheet” |
| **FAQ** | 2–3 e.g. “What is [category] used for?”, “How do I specify [category]?” → link to product or specification |
| **Internal links** | Parent “Products”; /terrace-waterproofing or /retaining-walls if relevant; 2–4 products in category; /specification; /contact |
| **Content improvement** | Add 150–300 words intro block (not only product grid); ensure meta is unique per category. |

**Example — Polyurethane Waterproofing Membrane:**

- **SEO title:** Polyurethane Waterproofing Membrane Australia \| Durotech
- **Meta description:** Polyurethane waterproofing membranes for roofs, terraces & structures. Australian-made. NEP, PUM, PPM range. Datasheets & specs. Call 02 9603 1177.
- **H1:** Polyurethane Waterproofing Membrane

**Example — Sealants and Silicone:**

- **SEO title:** Construction Sealants & Silicone \| Fire Rated Sealant Australia \| Durotech
- **Meta description:** Construction sealants and silicone for joints, fire rating & waterproofing. 50FC, DuroFire, FC PRO. For specifiers & contractors. Australia.
- **H1:** Sealants and Silicone

## 5.4 Product detail (template — DB-driven)

*Apply per product; store in `products.meta_title`, `meta_description`, `meta_keyword`; body from `products.description` or equivalent.*

| Element | Recommendation |
|---------|----------------|
| **SEO title** | [Product name] \| [Category or type] \| Durotech |
| **Meta description** | [Product name]: [1 line benefit/use]. [Substrate/application]. Datasheet & MSDS available. Australia. |
| **H1** | [Product name] |
| **H2** | Overview / Key features; Applications; Technical specifications; Downloads (Datasheet, MSDS, colour chart); Related products; Contact |
| **Semantic keywords** | Product name, category name, “waterproofing”, “membrane”/“sealant”/“coating”, “Australia”, “datasheet”, “specification” |
| **FAQ** | 1–2 e.g. “What surfaces can [product] be used on?”, “Is [product] suitable for terrace waterproofing?” |
| **Internal links** | Parent category; 2–4 related products; terrace-waterproofing or retaining-walls if relevant; /specification; /contact |
| **Content improvement** | Ensure first 100 words include product name and category; add “Applications” paragraph with internal links; descriptive anchor text for datasheet/MSDS. |

## 5.5 Terrace Waterproofing (`/terrace-waterproofing`)

| Element | Recommendation |
|---------|----------------|
| **SEO title** | Terrace & Balcony Waterproofing \| Roof Waterproofing Australia \| Durotech |
| **Meta description** | Terrace and balcony waterproofing with solvent-based PU and acrylic systems. New build and remedial. Australia. Products & specs. 02 9603 1177. |
| **H1** | Terrace Waterproofing |
| **H2** | Why terrace waterproofing matters; Our systems (e.g. polyurethane, acrylic); Applications; Products for terrace waterproofing; Case studies; Contact |
| **Semantic keywords** | terrace waterproofing, balcony waterproofing, roof waterproofing, polyurethane, acrylic, remedial, Australia |
| **FAQ** | e.g. “What is the best waterproofing for terraces?”, “Do you do remedial terrace waterproofing?” |
| **Internal links** | /category/polyurethane-waterproofing-membrane (or relevant category), 2–3 product URLs, /retaining-walls, /projects, /contact |
| **Content improvement** | Expand to 400–600 words; add “Products” section with links; fix meta (currently good; add CTA). |

## 5.6 Retaining Walls (`/retaining-walls`)

| Element | Recommendation |
|---------|----------------|
| **SEO title** | Retaining Wall Waterproofing \| Below Ground Waterproofing Australia \| Durotech |
| **Meta description** | Waterproofing for retaining walls and below-ground structures. Avoid costly water damage. Australian solutions. Products & technical support. 02 9603 1177. |
| **H1** | Retaining Wall Waterproofing |
| **H2** | Why retaining wall waterproofing; Below-ground solutions; Products; Applications; Contact |
| **Semantic keywords** | retaining wall waterproofing, below ground waterproofing, basement, tanking, Australia |
| **FAQ** | e.g. “Why is retaining wall waterproofing important?”, “What products do you recommend?” |
| **Internal links** | Relevant category and 2–3 products, /terrace-waterproofing, /projects, /contact |
| **Content improvement** | Expand to 300–500 words; add product links; unique meta (already unique). |

## 5.7 About (`/about`)

| Element | Recommendation |
|---------|----------------|
| **SEO title** | About Durotech \| Australian Waterproofing & Construction Chemicals Manufacturer |
| **Meta description** | Durotech Industries — Australian-made waterproofing membranes, coatings & sealants since 1977. For builders, contractors & specifiers. |
| **H1** | About Durotech Industries |
| **H2** | Our story; What we do; Quality & standards; Contact |
| **Internal links** | /product, /terrace-waterproofing, /specification, /projects, /contact |
| **Content improvement** | Differentiate meta from product/membrane pages (currently “Outdoor Liquid Waterproofing Membrane” — move to product/category). |

## 5.8 Projects (`/projects`)

| Element | Recommendation |
|---------|----------------|
| **SEO title** | Waterproofing Projects & Case Studies \| Durotech Australia |
| **Meta description** | See how Durotech waterproofing membranes and coatings are used in real projects across Australia. Case studies for specifiers and contractors. |
| **H1** | Our Projects & Case Studies |
| **H2** | Featured projects; [or filter by type] |
| **Internal links** | Each case study card → /case-study/:slug; /terrace-waterproofing, /retaining-walls, /contact |
| **Content improvement** | Replace duplicate About meta with project-focused meta above. |

## 5.9 Case study single (`/case-study/:slug`)

| Element | Recommendation |
|---------|----------------|
| **SEO title** | [Case study title] \| Durotech Projects |
| **Meta description** | [First 150 chars of short_summary] — keep dynamic. |
| **H1** | [Case study title] |
| **H2** | Project overview; Challenge; Solution; Products used; Result |
| **Internal links** | Link “Products used” to product URLs; link to category; /projects, /contact |
| **Content improvement** | Ensure body includes “Products used” with links; add 1–2 internal links in summary. |

## 5.10 Contact (`/contact`)

| Element | Recommendation |
|---------|----------------|
| **SEO title** | Contact Durotech \| Waterproofing Products & Specification Enquiries |
| **Meta description** | Contact Durotech for waterproofing products, specifications and technical support. Sydney-based, Australia-wide. Enquire online or call 02 9603 1177. |
| **H1** | Contact Us |
| **Internal links** | /specification, /product, /technical-literature |
| **Content improvement** | Keep meta; ensure form and phone are prominent; add short line “For specifiers” → /specification. |

## 5.11 Specification / Specifiers (`/specification`, `/specifiers`)

| Element | Recommendation |
|---------|----------------|
| **SEO title** | Specifiers \| Waterproofing Specification & CPD \| Durotech |
| **Meta description** | Natspec & Architects Australia partner. National specifications and CPD for waterproofing. For architects and specifiers. |
| **H1** | For Specifiers |
| **H2** | Natspec & CPD; Specifications; Technical literature; Contact |
| **Internal links** | /technical-literature, key category pages, /contact, /durotech-institute-of-waterproofing |
| **Content improvement** | Add 200–300 words; clarify CPD and how to request specs. |

## 5.12 FAQ (`/faqs`, `/faq-new`)

| Element | Recommendation |
|---------|----------------|
| **SEO title** | Waterproofing Solutions FAQs \| Durotech Australia |
| **Meta description** | Common questions about waterproofing membranes, products and applications. For builders, contractors and specifiers. |
| **H1** | Waterproofing Solutions FAQs |
| **H2** | One per question or per theme (e.g. Products, Applications, Ordering) |
| **FAQ schema** | Add JSON-LD FAQPage for each Q&A where applicable. |
| **Internal links** | In answers: link to relevant /category/..., /product/..., /terrace-waterproofing, /contact |
| **Content improvement** | Ensure meta is consistent; add 2–3 links in answers. |

## 5.13 Duro Lab (`/durolab`)

| Element | Recommendation |
|---------|----------------|
| **SEO title** | Duro Lab \| Australian Construction Chemicals Manufacturer \| Durotech |
| **Meta description** | Durotech’s R&D and quality facility. Australian-made construction chemicals and waterproofing since 1977. |
| **H1** | Duro Lab |
| **Internal links** | /product, /about, /contact |

## 5.14 DuroOEM, Flake, Video, Institute

| Page | SEO title | Meta description (fix empty/thin) |
|------|-----------|-----------------------------------|
| **DuroOEM** | DuroOEM \| Custom Manufacturing \| Durotech | Custom and OEM construction chemicals and waterproofing. Australian manufacturer. Enquire for formulations. |
| **Flake** | Duro Flake \| Decorative Flake Flooring \| Durotech | Decorative flake flooring systems for commercial and industrial floors. Australian-made. |
| **Video** | Project Videos \| Durotech Waterproofing Projects | Watch Durotech waterproofing and coating projects across Australia. |
| **Institute** | Durotech Institute of Waterproofing \| Training \| Durotech | Training and education in waterproofing for contractors and specifiers. |

## 5.15 Testimonials (`/testimonials`)

| Element | Recommendation |
|---------|----------------|
| **SEO title** | Customer Testimonials \| Durotech Waterproofing Products |
| **Meta description** | Read what builders, contractors and specifiers say about Durotech waterproofing products and service across Australia. |
| **H1** | What Our Customers Say |
| **Internal links** | /product, /projects, /contact |

## 5.16 Health & Safety (`/health-safety`)

| Element | Recommendation |
|---------|----------------|
| **SEO title** | Health & Safety \| Sealants, Waterproofing & Epoxy \| Durotech |
| **Meta description** | Health and safety information for Durotech sealants, waterproofing and epoxy products. SDS and safe use. |
| **H1** | Health & Safety |
| **Internal links** | /product (for SDS), /contact |

---

# 6. PRIORITY IMPLEMENTATION PLAN

## Step 1 — Critical meta and H1 (Week 1)

| Page | What to change | Expected impact |
|------|----------------|----------------|
| **Home** | Set meta_title, meta_description per Section 5.1; ensure H1 in template | Stronger brand + category relevance; better CTR |
| **/product** (no slug) | Set unique meta and H1 (Section 5.2); add 100–200 word intro in view | Distinct from home; better relevance for “waterproofing products” |
| **About** | Replace membrane-focused meta with About-focused (Section 5.7) | Correct targeting; avoid duplicate |
| **Projects** | Replace duplicate About meta with projects meta (Section 5.8) | Correct targeting; avoid duplicate |
| **Contact** | Confirm meta (Section 5.10) | Lead-gen relevance |

**Where:** `FrontsController.php` (index, about, projects, contact); product index view and default meta in `ProductsController.php` (when slug empty).

## Step 2 — Category meta audit (Week 1–2)

| Action | What to do | Expected impact |
|--------|------------|-----------------|
| Export categories | List all `categories` (slug, category_name, meta_title, meta_description, meta_keyword) | — |
| Fill or rewrite meta | For each category: unique title (50–60 chars), description (150–160), 3–5 keywords per Section 2 clusters | Category pages rank for intended keywords |
| Add intro copy | For top 5 categories: 150–300 words intro in view (or CMS) per Section 5.3 | Depth and internal link opportunities |

**Where:** DB `categories` table (admin Categories edit); optionally view or partial for intro.

## Step 3 — Topic pages (Week 2)

| Page | What to change | Expected impact |
|------|----------------|----------------|
| **/terrace-waterproofing** | Meta and H1 per 5.5; expand body to 400–600 words; add “Products” section with links | Better rankings for “terrace waterproofing”, “roof waterproofing” |
| **/retaining-walls** | Meta and H1 per 5.6; expand to 300–500 words; add product links | Better rankings for “retaining wall waterproofing” |

**Where:** `FrontsController.php` (meta); `Fronts/terrace_waterproofing.ctp`, `Fronts/retaining_walls.ctp` (content).

## Step 4 — Thin/empty meta (Week 2)

| Page | What to change | Expected impact |
|------|----------------|----------------|
| **DuroOEM, Flake, Video, Institute** | Set meta_description (and title if needed) per Section 5.14 | No empty meta; better indexing and CTR |

**Where:** `FrontsController.php` (durooem, flake, video, instituteWaterproofing).

## Step 5 — Product meta audit (Weeks 2–3)

| Action | What to do | Expected impact |
|--------|------------|-----------------|
| List products | Export top 20–30 products (by traffic or commercial value) | — |
| Product-level meta | For each: unique meta_title, meta_description (product table); ensure fallback to category is correct | Product pages rank for product + category terms |
| First paragraph | Ensure product description starts with product name + category keyword | On-page relevance |

**Where:** DB `products` (admin product edit); product detail view.

## Step 6 — Internal linking (Weeks 2–4)

| Page type | What to add | Expected impact |
|-----------|-------------|-----------------|
| Home | 3–5 category links, terrace-waterproofing, retaining-walls, projects, contact | Stronger topical and conversion paths |
| Category pages | Intro with links to terrace/retaining walls, 2–4 products, specification, contact | Better crawl and relevance |
| Product pages | Parent category, 2–3 related products, one topic or specification link | Better depth and conversions |
| Terrace / Retaining walls | Links to 2–4 products and category | Commercial intent support |
| Case studies | “Products used” → product URLs; link to category and contact | Link equity and relevance |
| FAQ | 2–4 links in answers to category/product/contact | Snippets and discovery |

**Where:** Layout (footer/nav), `Fronts/index.ctp`, `Products/index.php`, `Products/detail.php`, `Fronts/terrace_waterproofing.ctp`, `Fronts/retaining_walls.ctp`, case study view, FAQ view.

## Step 7 — Case study and specification (Week 3–4)

| Action | What to do | Expected impact |
|--------|------------|-----------------|
| Case study template | Ensure “Products used” block with links to /product/:slug | Internal links and relevance |
| Specification page | Meta and H1 per 5.11; add 200–300 words and links to technical-literature, categories, contact | Specifier intent |

**Where:** `Fronts/case_study.ctp` (or equivalent); `FrontsController::caseStudy`; specification view and controller.

## Step 8 — FAQ schema and technical (Month 2)

| Action | What to do | Expected impact |
|--------|------------|-----------------|
| FAQ schema | Add JSON-LD FAQPage on /faqs (and faq-new if used) for each Q&A | Chance for FAQ rich results |
| Technical literature | Unique meta per segment if multiple pages; breadcrumb and links to products/categories | Better indexing and relevance |

**Where:** FAQ view (script block); `FrontsController::technicalLiteratureNew` and view.

---

## Summary checklist (share with client)

- [ ] **Week 1:** Home, /product, About, Projects, Contact meta + H1; start category meta audit.
- [ ] **Week 2:** All category meta filled; top 5 category intros; terrace-waterproofing and retaining-walls content + meta; DuroOEM/Flake/Video/Institute meta.
- [ ] **Week 3:** Top 20 product meta; internal links on home, category, product, terrace, retaining walls.
- [ ] **Week 4:** Case study product links; specification page content + meta; FAQ internal links.
- [ ] **Month 2:** FAQ schema; technical literature meta; ongoing product/category audits.

---

*Document generated from project structure (routes, controllers, views, DB-driven categories/products). Implement in order; adjust category and product lists to match live DB.*
