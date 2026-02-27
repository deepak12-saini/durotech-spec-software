# Category meta — examples for DB update

Category pages get **meta_title**, **meta_description**, and **meta_keyword** from the `categories` table. Use Admin → Categories → Edit, or run SQL below (adjust table name if different, e.g. `Categories`).

## Example 1: Polyurethane Waterproofing Membrane

Use when `slug` = `polyurethane-waterproofing-membrane`.

| Field | Value |
|-------|--------|
| **meta_title** | Polyurethane Waterproofing Membrane Australia \| Durotech |
| **meta_description** | Polyurethane waterproofing membranes for roofs, terraces & structures. Australian-made. NEP, PUM, PPM range. Datasheets & specs. Call 02 9603 1177. |
| **meta_keyword** | polyurethane waterproofing membrane, PU membrane, roof waterproofing, terrace waterproofing, Australia |

**SQL (replace `categories` if your table name differs):**

```sql
UPDATE categories
SET
  meta_title = 'Polyurethane Waterproofing Membrane Australia | Durotech',
  meta_description = 'Polyurethane waterproofing membranes for roofs, terraces & structures. Australian-made. NEP, PUM, PPM range. Datasheets & specs. Call 02 9603 1177.',
  meta_keyword = 'polyurethane waterproofing membrane, PU membrane, roof waterproofing, terrace waterproofing, Australia'
WHERE slug = 'polyurethane-waterproofing-membrane';
```

## Example 2: Sealants and Silicone

Use when `slug` = `sealants-and-silicone`.

| Field | Value |
|-------|--------|
| **meta_title** | Construction Sealants & Silicone \| Fire Rated Sealant Australia \| Durotech |
| **meta_description** | Construction sealants and silicone for joints, fire rating & waterproofing. 50FC, DuroFire, FC PRO. For specifiers & contractors. Australia. |
| **meta_keyword** | construction sealants, silicone sealant, fire rated sealant, Australia |

**SQL:**

```sql
UPDATE categories
SET
  meta_title = 'Construction Sealants & Silicone | Fire Rated Sealant Australia | Durotech',
  meta_description = 'Construction sealants and silicone for joints, fire rating & waterproofing. 50FC, DuroFire, FC PRO. For specifiers & contractors. Australia.',
  meta_keyword = 'construction sealants, silicone sealant, fire rated sealant, Australia'
WHERE slug = 'sealants-and-silicone';
```

## For other categories

- **meta_title:** Primary keyword + " | Durotech" (keep under ~60 characters).
- **meta_description:** One sentence (what the category is + benefit/CTA), ~150–160 characters.
- **meta_keyword:** 3–5 relevant keywords from `SEO-Content-Planning-Full-Site.md` Section 2.

Run an export of all `slug`, `category_name`, `meta_title`, `meta_description`, `meta_keyword` and fill or correct in Admin or via SQL.
