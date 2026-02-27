# SEO meta for all 11 active categories

Use this with **Admin → Categories → Edit** (paste into each category) or run **`docs/SEO-Category-Meta-All-11.sql`** in your database.  
Table name in the SQL is `categories`; if your table is different (e.g. `Categories`), change it in the script.

---

| # | Category name | meta_title | meta_description | meta_keyword |
|---|---------------|------------|------------------|--------------|
| 1 | Water based Waterproofing Membranes | Water Based Waterproofing Membranes Australia \| Durotech | Water based acrylic waterproofing membranes for roofs, wet areas & confined spaces. Australian-made. Low VOC, non-toxic. Datasheets & specs. Call 02 9603 1177. | water based waterproofing membrane, acrylic membrane, roof waterproofing, Australia, low VOC |
| 2 | Polyurethane Waterproofing Membrane | Polyurethane Waterproofing Membrane Australia \| Durotech | Polyurethane waterproofing membranes for roofs, terraces & structures. Australian-made. NEP, PUM, PPM range. Datasheets & specs. Call 02 9603 1177. | polyurethane waterproofing membrane, PU membrane, roof waterproofing, terrace waterproofing, Australia |
| 3 | Primers | Waterproofing & Coating Primers Australia \| Durotech | Primers for waterproofing membranes and coatings. Bonding, sealing & substrate preparation. Australian-made. For builders & specifiers. | waterproofing primer, coating primer, bonding primer, Australia, construction |
| 4 | Sealants & Silicone | Construction Sealants & Silicone \| Fire Rated Sealant Australia \| Durotech | Construction sealants and silicone for joints, fire rating & waterproofing. 50FC, DuroFire, FC PRO. For specifiers & contractors. Australia. | construction sealants, silicone sealant, fire rated sealant, Australia, joints |
| 5 | Epoxy Flooring | Epoxy Flooring & Floor Coatings Australia \| Durotech | Epoxy flooring and floor coatings for industrial and commercial use. Australian-made. Durable, chemical resistant. Datasheets & specs. | epoxy flooring, floor coating, industrial floor, Australia, commercial flooring |
| 6 | Cementitious Membranes | Cementitious Waterproofing Membranes Australia \| Durotech | Cementitious waterproofing membranes for basements, tanks & below-ground. Australian-made. For builders & specifiers. Call 02 9603 1177. | cementitious membrane, waterproofing membrane, basement waterproofing, Australia |
| 7 | Tapes / Reinforcement Fabric | Tapes & Reinforcement Fabric for Waterproofing \| Durotech | Tapes and reinforcement fabric for waterproofing joints and cracks. Australian-made. For membranes and remedial work. Specifiers & contractors. | waterproofing tapes, reinforcement fabric, joint tape, Australia, membranes |
| 8 | Thinners | Thinners for Coatings & Waterproofing \| Durotech | Thinners for solvent-based coatings and waterproofing. Correct viscosity and application. Australian construction chemicals. | thinners, coating thinner, solvent, waterproofing, Australia |
| 9 | Sealer | Sealers for Concrete & Substrates Australia \| Durotech | Sealers for concrete, masonry and substrates. Protection and preparation for waterproofing and coatings. Australian-made. | sealer, concrete sealer, substrate sealer, Australia, waterproofing |
| 10 | Sheet Membranes | Sheet Waterproofing Membranes Australia \| Durotech | Sheet waterproofing membranes for roofs, basements and structures. Australian-made. For new build and remedial. Datasheets & specs. | sheet membrane, waterproofing membrane, roof membrane, Australia, basement |
| 11 | Tile Adhesives | Tile Adhesives & Tiling Products Australia \| Durotech | Tile adhesives and tiling products for wet areas and floors. Australian-made. Compatible with waterproofing systems. For tilers & contractors. | tile adhesive, tiling products, wet area, Australia, waterproofing |

---

## Slug reference (for URLs)

Category URLs use the `slug` field (e.g. `/category/{slug}` or `/product?slug={slug}`). Typical slugs from these names would be:

- Water based Waterproofing Membranes → `water-based-waterproofing-membranes`
- Polyurethane Waterproofing Membrane → `polyurethane-waterproofing-membrane`
- Primers → `primers`
- Sealants & Silicone → `sealants-and-silicone`
- Epoxy Flooring → `epoxy-flooring`
- Cementitious Membranes → `cementitious-membranes`
- Tapes / Reinforcement Fabric → `tapes-/-reinforcement-fabric` (or `tapes-reinforcement-fabric` if you normalise)
- Thinners → `thinners`
- Sealer → `sealer`
- Sheet Membranes → `sheet-membranes`
- Tile Adhesives → `tile-adhesives`

The SQL above updates by **category_name**, so it works no matter how slug is stored.
