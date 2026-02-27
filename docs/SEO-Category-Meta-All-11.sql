-- SEO meta for all 11 active categories (Durotech)
-- Run against your database. Table name may be `categories` or `Categories` (adjust if needed).
-- Updates by category_name so it works regardless of slug format.

-- 1. Water based Waterproofing Membranes
UPDATE categories SET
  meta_title = 'Water Based Waterproofing Membranes Australia | Durotech',
  meta_description = 'Water based acrylic waterproofing membranes for roofs, wet areas & confined spaces. Australian-made. Low VOC, non-toxic. Datasheets & specs. Call 02 9603 1177.',
  meta_keyword = 'water based waterproofing membrane, acrylic membrane, roof waterproofing, Australia, low VOC'
WHERE category_name = 'Water based Waterproofing Membranes';

-- 2. Polyurethane Waterproofing Membrane
UPDATE categories SET
  meta_title = 'Polyurethane Waterproofing Membrane Australia | Durotech',
  meta_description = 'Polyurethane waterproofing membranes for roofs, terraces & structures. Australian-made. NEP, PUM, PPM range. Datasheets & specs. Call 02 9603 1177.',
  meta_keyword = 'polyurethane waterproofing membrane, PU membrane, roof waterproofing, terrace waterproofing, Australia'
WHERE category_name = 'Polyurethane Waterproofing Membrane';

-- 3. Primers
UPDATE categories SET
  meta_title = 'Waterproofing & Coating Primers Australia | Durotech',
  meta_description = 'Primers for waterproofing membranes and coatings. Bonding, sealing & substrate preparation. Australian-made. For builders & specifiers.',
  meta_keyword = 'waterproofing primer, coating primer, bonding primer, Australia, construction'
WHERE category_name = 'Primers';

-- 4. Sealants & Silicone
UPDATE categories SET
  meta_title = 'Construction Sealants & Silicone | Fire Rated Sealant Australia | Durotech',
  meta_description = 'Construction sealants and silicone for joints, fire rating & waterproofing. 50FC, DuroFire, FC PRO. For specifiers & contractors. Australia.',
  meta_keyword = 'construction sealants, silicone sealant, fire rated sealant, Australia, joints'
WHERE category_name = 'Sealants & Silicone';

-- 5. Epoxy Flooring
UPDATE categories SET
  meta_title = 'Epoxy Flooring & Floor Coatings Australia | Durotech',
  meta_description = 'Epoxy flooring and floor coatings for industrial and commercial use. Australian-made. Durable, chemical resistant. Datasheets & specs.',
  meta_keyword = 'epoxy flooring, floor coating, industrial floor, Australia, commercial flooring'
WHERE category_name = 'Epoxy Flooring';

-- 6. Cementitious Membranes
UPDATE categories SET
  meta_title = 'Cementitious Waterproofing Membranes Australia | Durotech',
  meta_description = 'Cementitious waterproofing membranes for basements, tanks & below-ground. Australian-made. For builders & specifiers. Call 02 9603 1177.',
  meta_keyword = 'cementitious membrane, waterproofing membrane, basement waterproofing, Australia'
WHERE category_name = 'Cementitious Membranes';

-- 7. Tapes / Reinforcement Fabric
UPDATE categories SET
  meta_title = 'Tapes & Reinforcement Fabric for Waterproofing | Durotech',
  meta_description = 'Tapes and reinforcement fabric for waterproofing joints and cracks. Australian-made. For membranes and remedial work. Specifiers & contractors.',
  meta_keyword = 'waterproofing tapes, reinforcement fabric, joint tape, Australia, membranes'
WHERE category_name = 'Tapes / Reinforcement Fabric';

-- 8. Thinners
UPDATE categories SET
  meta_title = 'Thinners for Coatings & Waterproofing | Durotech',
  meta_description = 'Thinners for solvent-based coatings and waterproofing. Correct viscosity and application. Australian construction chemicals.',
  meta_keyword = 'thinners, coating thinner, solvent, waterproofing, Australia'
WHERE category_name = 'Thinners';

-- 9. Sealer
UPDATE categories SET
  meta_title = 'Sealers for Concrete & Substrates Australia | Durotech',
  meta_description = 'Sealers for concrete, masonry and substrates. Protection and preparation for waterproofing and coatings. Australian-made.',
  meta_keyword = 'sealer, concrete sealer, substrate sealer, Australia, waterproofing'
WHERE category_name = 'Sealer';

-- 10. Sheet Membranes
UPDATE categories SET
  meta_title = 'Sheet Waterproofing Membranes Australia | Durotech',
  meta_description = 'Sheet waterproofing membranes for roofs, basements and structures. Australian-made. For new build and remedial. Datasheets & specs.',
  meta_keyword = 'sheet membrane, waterproofing membrane, roof membrane, Australia, basement'
WHERE category_name = 'Sheet Membranes';

-- 11. Tile Adhesives
UPDATE categories SET
  meta_title = 'Tile Adhesives & Tiling Products Australia | Durotech',
  meta_description = 'Tile adhesives and tiling products for wet areas and floors. Australian-made. Compatible with waterproofing systems. For tilers & contractors.',
  meta_keyword = 'tile adhesive, tiling products, wet area, Australia, waterproofing'
WHERE category_name = 'Tile Adhesives';
