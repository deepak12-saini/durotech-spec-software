# Fronts Pages – CakePHP 3.10 Migration Summary

This document describes the migration of **Fronts pages only** from CakePHP 2 to CakePHP 3.10, with the same UI and behavior.

---

## 1. Controller Conversion

**File:** `src/Controller/FrontsController.php`

- **Namespace:** `App\Controller`
- **Extends:** `AppController`
- **Models:** Loaded in `initialize()` via `$this->loadModel()`:
  - CaseStudies, Categories, Products, Testimonials
- **beforeFilter(EventInterface):** Uses CakePHP 3 style; sets layout `front_layout` for all actions except `captch` (no layout).
- **Actions:** CamelCase; views are snake_case (e.g. `healthSafety()` → `health_safety.php`).
- **Contact:** Handles GET (form + captcha) and POST (validation, captcha check, email via ContactMailer).
- **captch():** Returns PNG captcha image and uses session `cap_code` (same code as on contact form).
- **Mailer:** Uses `MailerAwareTrait` and `$this->getMailer('Contact')->send('contactForm', [$data])`.

---

## 2. Views

- **Location:** `templates/Fronts/`
- **Naming:** Action `technicalLiteratureNew` → view `technical_literature_new.php`; others follow camelCase → snake_case.
- **Contact view:** Updated to CakePHP 3:
  - `$this->Session->flash()` → `$this->Flash->render()`
  - `$this->Session->read('cap_code')` → `$this->request->getSession()->read('cap_code')` and `$cap_code` from controller
  - Captcha image URL → `$this->Url->build(['controller' => 'Fronts', 'action' => 'captch'])`
  - Form → `$this->Form->create()` / `$this->Form->end()` for CSRF and correct action
  - Submit → `<button type="submit">` instead of `<a onclick="subscribe()">`

---

## 3. Layouts

- **Index:** Uses `customduro_layout` (set in `index()`).
- **Other Fronts:** Use `front_layout` (set in `beforeFilter()`).
- **Constants:** `SITEURL`, `SITENAME`, `META_TITLE`, `META_DESCRIPTION`, `META_KEYWORD`, `MAILTO`, `PHONE`, `ADDRESS`, `EMAIL` are defined in `config/bootstrap.php` from `config/app.php` → `Site` key.

---

## 4. Routing

**File:** `config/routes.php`

- `/` → Fronts::index
- `/projects` → Fronts::projects
- `/case-study/:slug` → Fronts::caseStudy
- `/technical-literature/*` → Fronts::technicalLiteratureNew
- `/testimonials` → Fronts::testimonials
- `/contact` → Fronts::contact
- `/faqs` → Fronts::faq
- `/terrace-waterproofing` → Fronts::terraceWaterproofing
- `/fronts/captch` → Fronts::captch (captcha image)

Other Fronts routes are already present and match the controller/action names above.

---

## 5. Models / Tables

Only Fronts-related tables are used:

- **CaseStudiesTable** – `case_studies`; hasMany CaseImages
- **CaseImagesTable** – `case_images`
- **CategoriesTable** – `categories`; hasMany Products
- **ProductsTable** – `products`
- **TestimonialsTable** – `testimonials`

No model changes were required for Fronts-only migration.

---

## 6. Email (Contact Form)

- **CakePHP 2:** `CakeEmail` (not used in Fronts controller after migration).
- **CakePHP 3.10:** `App\Mailer\ContactMailer`:
  - Method: `contactForm(array $data)` – sends to site email with name, email, phone, message.
  - Template: `templates/Email/html/contact_form.ctp`
- **Config:** `config/app.php` → `Email` and `EmailTransport`; `Site.email` used as recipient.

---

## 7. Manual Checks / Fixes

1. **Layout elements**
   - `customduro_layout.ctp` uses `$this->element('customduro_header')` and `$this->element('customduro_footer')`.
   - If these are missing, copy from the CakePHP 2 app:
     - `View/Elements/customduro_header.ctp` → `templates/Element/customduro_header.ctp`
     - `View/Elements/customduro_footer.ctp` → `templates/Element/customduro_footer.ctp`

2. **Static assets**
   - Layouts use `SITEURL` for paths like `customdurotech/css/`, `theme/js/`, etc.
   - Ensure these exist under `webroot/` (e.g. `webroot/customdurotech/`, `webroot/theme/`).

3. **Config**
   - Override `config/app.php` → `Site` (or use env vars) for SITENAME, META_*, MAILTO, PHONE, ADDRESS if different from defaults.
   - Set `EmailTransport` and `Email.from` in `config/app_local.php` for real SMTP/from address.

4. **Testing Fronts URLs**
   - `/` – Home
   - `/projects` – Projects list
   - `/case-study/<slug>` – Single case study
   - `/technical-literature` and `/technical-literature/<segment>` – Technical literature
   - `/testimonials` – Testimonials
   - `/contact` – Contact form (GET + POST, captcha)
   - `/faqs` – FAQ
   - `/terrace-waterproofing` – Terrace waterproofing

---

## 8. Files Touched / Added

| File | Change |
|------|--------|
| `src/Controller/FrontsController.php` | Full CakePHP 3.10 conversion, contact POST, captch, MailerAwareTrait |
| `config/bootstrap.php` | Site constants (SITEURL, SITENAME, META_*, MAILTO, PHONE, ADDRESS, EMAIL) |
| `config/app.php` | `Site` config block |
| `config/routes.php` | Route for `/fronts/captch` |
| `src/Mailer/ContactMailer.php` | **New** – contact form email |
| `src/Template/Email/html/contact_form.ctp` | **New** – contact email body |
| `src/Template/Fronts/contact.php` | CakePHP 3 Flash, Session, Url, Form |

Admin, Employee, and other modules were not changed.
