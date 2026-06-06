<?php
/**
 * Bottom-of-page strip: office locations + phone + email (mirrors header top bar).
 *
 * @var \App\View\AppView $this
 */
use Cake\Core\Configure;

$promoPhoneTel = preg_replace('/\D+/', '', (string)PHONE);
$salesEmail = 'sales@durotechindustries.com.au';
$officeMaps = (array)Configure::read('Durotech.officeMapUrls');
?>
<style>
.locations-promo-strip {
	--lp-blue: #2889c9;
	--lp-blue-dark: #1a6aa8;
	--lp-ink: #1a4860;
	--lp-ink-soft: #3d5a6e;
	--lp-surface: #ffffff;
	--lp-radius: 18px;
	--lp-shadow: 0 4px 6px rgba(26, 72, 96, 0.04), 0 18px 40px rgba(40, 137, 201, 0.12);
	--lp-gutter: 16px;
	font-family: Raleway, "Segoe UI", system-ui, -apple-system, sans-serif;
	position: relative;
	box-sizing: border-box;
	width: 100%;
	max-width: 100%;
	float: none;
	clear: both;
	display: block;
	margin-left: auto;
	margin-right: auto;
	margin-bottom: 0;
	padding: 36px var(--lp-gutter) 42px;
	padding-left: max(var(--lp-gutter), env(safe-area-inset-left, 0px));
	padding-right: max(var(--lp-gutter), env(safe-area-inset-right, 0px));
	overflow: hidden;
	background:
		radial-gradient(120% 80% at 50% -20%, rgba(255, 255, 255, 0.75) 0%, transparent 55%),
		linear-gradient(165deg, #e8f3fb 0%, #d4e8f5 45%, #c5dff0 100%);
	border-top: 1px solid rgba(40, 137, 201, 0.18);
	border-bottom: 1px solid rgba(26, 72, 96, 0.08);
}
@media (min-width: 768px) {
	.locations-promo-strip {
		--lp-gutter: 20px;
	}
}
.locations-promo-strip::before {
	content: "";
	position: absolute;
	left: 0;
	right: 0;
	top: 0;
	height: 3px;
	background: linear-gradient(90deg, transparent, var(--lp-blue) 20%, #f4c400 50%, var(--lp-blue) 80%, transparent);
	opacity: 0.85;
}
.locations-promo-strip .locations-promo-inner {
	position: relative;
	z-index: 1;
	box-sizing: border-box;
	width: 100%;
	max-width: 1040px;
	margin-left: auto;
	margin-right: auto;
	background: var(--lp-surface);
	border-radius: var(--lp-radius);
	box-shadow: var(--lp-shadow);
	border: 1px solid rgba(40, 137, 201, 0.12);
	padding: 28px 22px 26px;
}
@media (min-width: 768px) {
	.locations-promo-strip .locations-promo-inner {
		padding: 34px 40px 32px;
	}
}
.locations-promo-head {
	text-align: center;
	margin-bottom: 22px;
	padding-bottom: 20px;
	border-bottom: 1px solid rgba(40, 137, 201, 0.12);
	background: linear-gradient(180deg, rgba(248, 252, 255, 0.6) 0%, transparent 100%);
	margin-left: -22px;
	margin-right: -22px;
	margin-top: -28px;
	padding-left: 22px;
	padding-right: 22px;
	padding-top: 26px;
	border-radius: var(--lp-radius) var(--lp-radius) 0 0;
}
@media (min-width: 768px) {
	.locations-promo-head {
		margin-left: -40px;
		margin-right: -40px;
		padding-left: 40px;
		padding-right: 40px;
		padding-top: 30px;
	}
}
.locations-promo-kicker {
	margin: 0 0 6px;
	font-size: 11px;
	font-weight: 800;
	letter-spacing: 0.2em;
	text-transform: uppercase;
	color: var(--lp-blue);
}
.locations-promo-strip .locations-promo-heading {
	margin: 0 0 8px;
	font-size: 22px;
	font-weight: 800;
	color: var(--lp-ink);
	line-height: 1.25;
	letter-spacing: -0.02em;
}
@media (min-width: 768px) {
	.locations-promo-strip .locations-promo-heading {
		font-size: 26px;
	}
}
.locations-promo-sub {
	margin: 0;
	font-size: 14px;
	line-height: 1.5;
	color: var(--lp-ink-soft);
	max-width: 520px;
	margin-left: auto;
	margin-right: auto;
}
.locations-promo-strip .locations-promo-locs {
	list-style: none;
	margin: 0 0 24px;
	padding: 0;
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px;
	align-items: stretch;
}
.locations-promo-strip .locations-promo-locs li {
	margin: 0;
	padding: 0;
	min-width: 0;
}
@media (min-width: 992px) {
	.locations-promo-strip .locations-promo-locs {
		grid-template-columns: repeat(4, 1fr);
	}
}
.locations-promo-strip .locations-promo-locs a {
	display: flex;
	align-items: center;
	justify-content: flex-start;
	width: 100%;
	box-sizing: border-box;
	gap: 10px;
	min-height: 48px;
	padding: 10px 14px;
	font-size: 14px;
	font-weight: 700;
	color: var(--lp-ink);
	text-decoration: none;
	background: linear-gradient(180deg, #fbfdff 0%, #f2f8fc 100%);
	border: 1px solid rgba(40, 137, 201, 0.2);
	border-radius: 12px;
	box-shadow: 0 1px 0 rgba(255, 255, 255, 0.9) inset;
	transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease, color 0.2s ease;
}
.locations-promo-strip .locations-promo-locs a:hover,
.locations-promo-strip .locations-promo-locs a:focus {
	color: var(--lp-blue-dark);
	border-color: rgba(40, 137, 201, 0.45);
	box-shadow: 0 8px 22px rgba(40, 137, 201, 0.15);
	transform: translateY(-2px);
	outline: none;
}
.locations-promo-strip .locations-promo-locs a:focus-visible {
	box-shadow: 0 0 0 3px rgba(40, 137, 201, 0.35), 0 8px 22px rgba(40, 137, 201, 0.12);
}
.locations-promo-strip .locations-promo-locs .loc-icon {
	display: flex;
	align-items: center;
	justify-content: center;
	width: 32px;
	height: 32px;
	border-radius: 10px;
	background: linear-gradient(145deg, var(--lp-blue) 0%, #1f7ab8 100%);
	color: #fff;
	font-size: 14px;
	flex-shrink: 0;
	box-shadow: 0 2px 8px rgba(40, 137, 201, 0.35);
}
.locations-promo-strip .locations-promo-contact {
	display: grid;
	grid-template-columns: 1fr;
	gap: 12px;
}
@media (min-width: 600px) {
	.locations-promo-strip .locations-promo-contact {
		grid-template-columns: 1fr 1fr;
		gap: 14px;
	}
}
.locations-promo-cta {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 12px;
	min-height: 54px;
	padding: 12px 18px;
	font-size: 15px;
	font-weight: 700;
	text-decoration: none;
	border-radius: 12px;
	transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, color 0.2s ease;
	text-align: center;
}
.locations-promo-cta .cta-icon {
	display: flex;
	align-items: center;
	justify-content: center;
	width: 40px;
	height: 40px;
	border-radius: 50%;
	font-size: 18px;
	flex-shrink: 0;
}
.locations-promo-cta span {
	word-break: break-word;
	line-height: 1.3;
}
.locations-promo-cta--phone {
	background: linear-gradient(145deg, var(--lp-blue) 0%, #2178b0 100%);
	color: #fff;
	box-shadow: 0 4px 14px rgba(40, 137, 201, 0.4);
	border: 1px solid rgba(255, 255, 255, 0.2);
}
.locations-promo-cta--phone .cta-icon {
	background: rgba(255, 255, 255, 0.18);
	color: #fff;
}
.locations-promo-cta--phone:hover,
.locations-promo-cta--phone:focus {
	background: linear-gradient(145deg, #3498d9 0%, var(--lp-blue) 100%);
	box-shadow: 0 8px 24px rgba(40, 137, 201, 0.45);
	transform: translateY(-2px);
	color: #fff;
	outline: none;
}
.locations-promo-cta--phone:focus-visible {
	box-shadow: 0 0 0 3px rgba(244, 196, 0, 0.55), 0 8px 24px rgba(40, 137, 201, 0.4);
}
.locations-promo-cta--email {
	background: #fff;
	color: var(--lp-blue-dark);
	border: 2px solid rgba(40, 137, 201, 0.35);
	box-shadow: 0 2px 8px rgba(26, 72, 96, 0.06);
}
.locations-promo-cta--email .cta-icon {
	background: rgba(40, 137, 201, 0.1);
	color: var(--lp-blue);
}
.locations-promo-cta--email:hover,
.locations-promo-cta--email:focus {
	border-color: var(--lp-blue);
	background: #f8fbfe;
	transform: translateY(-2px);
	box-shadow: 0 8px 22px rgba(40, 137, 201, 0.12);
	outline: none;
}
.locations-promo-cta--email:focus-visible {
	box-shadow: 0 0 0 3px rgba(40, 137, 201, 0.25), 0 8px 22px rgba(40, 137, 201, 0.1);
}
</style>
<section class="locations-promo-strip" aria-label="Office locations and sales contact">
	<div class="locations-promo-inner">
		<header class="locations-promo-head">
			<p class="locations-promo-kicker">Nationwide</p>
			<h2 class="locations-promo-heading">Australian offices &amp; sales</h2>
			<p class="locations-promo-sub">Tap a state for directions, or contact our team for product support and project advice.</p>
		</header>
		<ul class="locations-promo-locs">
			<li>
				<a href="<?php echo h($officeMaps['nsw'] ?? '#'); ?>" target="_blank" rel="noopener noreferrer">
					<span class="loc-icon" aria-hidden="true"><i class="fa fa-map-marker"></i></span>
					<span>NSW</span>
				</a>
			</li>
			<li>
				<a href="<?php echo h($officeMaps['vic'] ?? '#'); ?>" target="_blank" rel="noopener noreferrer">
					<span class="loc-icon" aria-hidden="true"><i class="fa fa-map-marker"></i></span>
					<span>Victoria</span>
				</a>
			</li>
			<li>
				<a href="<?php echo h($officeMaps['qld'] ?? '#'); ?>" target="_blank" rel="noopener noreferrer">
					<span class="loc-icon" aria-hidden="true"><i class="fa fa-map-marker"></i></span>
					<span>Queensland</span>
				</a>
			</li>
			<li>
				<a href="<?php echo h($officeMaps['sa'] ?? '#'); ?>" target="_blank" rel="noopener noreferrer">
					<span class="loc-icon" aria-hidden="true"><i class="fa fa-map-marker"></i></span>
					<span>South Australia</span>
				</a>
			</li>
		</ul>
		<div class="locations-promo-contact">
			<a class="locations-promo-cta locations-promo-cta--phone" href="tel:<?php echo h($promoPhoneTel); ?>">
				<span class="cta-icon" aria-hidden="true"><i class="fa fa-phone"></i></span>
				<span><?php echo h(PHONE); ?></span>
			</a>
			<a class="locations-promo-cta locations-promo-cta--email" href="mailto:<?php echo h($salesEmail); ?>">
				<span class="cta-icon" aria-hidden="true"><i class="fa fa-envelope"></i></span>
				<span><?php echo h($salesEmail); ?></span>
			</a>
		</div>
	</div>
</section>
