<!-- FancyBox for YouTube -->
<script type="text/javascript" src="<?php echo SITEURL ?>fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript" src="<?php echo SITEURL ?>fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox-media')
			.attr('rel', 'media-gallery')
			.fancybox({
				openEffect: 'none',
				closeEffect: 'none',
				prevEffect: 'none',
				nextEffect: 'none',
				arrows: false,
				helpers: {
					media: {},
					buttons: {}
				}
			});
	});
</script>

<style>
.video-page {
	--vp-blue: #2889c9;
	--vp-ink: #1f3347;
	--vp-muted: #5f7388;
	--vp-bg: #eaf1f7;
	--vp-card: #ffffff;
	background: var(--vp-bg);
	/* Clear fixed site header so banner isn’t covered */
	padding-top: 90px;
	padding-bottom: 48px;
}
@media (min-width: 768px) {
	.video-page {
		padding-top: 110px;
	}
}
.video-page__banner {
	width: 100%;
	overflow: visible;
	background: #dfe8f0;
	line-height: 0;
	margin-top: 0px;
}
.video-page__banner img {
	display: block;
	width: 100%;
	height: auto;
	max-height: none;
	object-fit: contain;
	object-position: center top;
}
.video-page__wrap {
	max-width: 1140px;
	margin: 0 auto;
	padding: 28px 16px 0;
}
.video-page__head {
	text-align: center;
	margin: 0 0 24px;
}
.video-page__head h1 {
	margin: 0 0 8px;
	color: var(--vp-ink);
	font-size: clamp(1.5rem, 2.4vw, 2rem);
	font-weight: 700;
}
.video-page__head p {
	margin: 0;
	color: var(--vp-muted);
	font-size: 15px;
	line-height: 1.5;
}
.video-grid {
	display: grid;
	grid-template-columns: repeat(3, minmax(0, 1fr));
	gap: 18px;
	margin: 0;
	padding: 0;
	list-style: none;
}
.video-grid::before,
.video-grid::after {
	content: none !important;
	display: none !important;
}
.video-card {
	display: flex;
	flex-direction: column;
	background: var(--vp-card);
	border: 1px solid #e1e8f0;
	border-radius: 14px;
	overflow: hidden;
	box-shadow: 0 6px 18px rgba(20, 33, 61, 0.08);
	transition: transform 0.18s ease, box-shadow 0.18s ease;
	min-width: 0;
}
.video-card:hover {
	transform: translateY(-3px);
	box-shadow: 0 12px 28px rgba(20, 33, 61, 0.14);
}
.video-card__media {
	position: relative;
	display: block;
	aspect-ratio: 16 / 9;
	background: #0f1c2a;
	overflow: hidden;
	text-decoration: none !important;
}
.video-card__media img {
	display: block;
	width: 100%;
	height: 100%;
	object-fit: cover;
	transition: transform 0.25s ease, opacity 0.25s ease;
}
.video-card:hover .video-card__media img {
	transform: scale(1.04);
	opacity: 0.92;
}
.video-card__play {
	position: absolute;
	inset: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	pointer-events: none;
}
.video-card__play span {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	width: 54px;
	height: 54px;
	border-radius: 50%;
	background: rgba(219, 35, 35, 0.92);
	color: #fff;
	font-size: 20px;
	box-shadow: 0 6px 16px rgba(0, 0, 0, 0.35);
}
.video-card__title {
	margin: 0;
	padding: 12px 14px 14px;
	color: var(--vp-ink);
	font-size: 14px;
	font-weight: 600;
	line-height: 1.4;
	min-height: 3.2em;
}
@media (max-width: 991px) {
	.video-grid {
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 14px;
	}
}
@media (max-width: 575px) {
	.video-grid {
		grid-template-columns: 1fr;
		gap: 12px;
	}
	.video-page__wrap {
		padding-top: 20px;
	}
}
</style>

<?php
$videos = [
	['url' => 'https://youtu.be/G1jBNPQNwKs', 'title' => 'New Product Arrive DuroSpray PU340 | Durotech Industries'],
	['url' => 'https://youtu.be/510mzXP9Fyc', 'title' => 'Existing Waterproofing Failed | Durotech Industries'],
	['url' => 'https://youtu.be/-3lJ7o_4FrI', 'title' => 'Hybird Polyurea Crack Repir joint Sealant | Cure Time 15 Min | Durotech Industries'],
	['url' => 'https://youtu.be/vANt4zRompg', 'title' => 'Durotech Polyurethane Technology | Durotech Industries'],
	['url' => 'https://youtu.be/Nc6-gO9BBKQ', 'title' => 'Polyurethane Membrane - Durotech Industries'],
	['url' => 'https://youtu.be/g8wvjeST8eg', 'title' => 'Roof Shield Durotech Industries'],
	['url' => 'https://youtu.be/kW-41suIODI', 'title' => 'Waterproofing Detail Works Durotech Industries'],
	['url' => 'https://youtu.be/NSc8DO5uMg0', 'title' => 'Existing Waterproofing Membrane Fail'],
	['url' => 'https://youtu.be/gYaesYn463M', 'title' => 'Duromastic P15 being tested Durotech Industries'],
	['url' => 'https://youtu.be/by0txJpd40I', 'title' => 'Buy Waterproofing Membrane'],
	['url' => 'https://youtu.be/p2Nv1MH-kM0', 'title' => 'Polyurethane Waterproofing Membrane'],
	['url' => 'https://youtu.be/oTmjZzfvQKM', 'title' => 'Internal Wet Area Waterproofing'],
	['url' => 'https://youtu.be/8mqWlZqnyz8', 'title' => 'Waterproofing Products'],
];
$thumb = SITEURL . 'img/video.jpg';
?>

<div class="video-page">
	<div class="video-page__banner">
		<img src="<?php echo SITEURL; ?>banner/BANNER video.jpg" alt="Durotech Videos">
	</div>

	<div class="video-page__wrap">
		<div class="video-page__head">
			<h1>Durotech Videos</h1>
			<p>Watch product demos, application tips and waterproofing project videos.</p>
		</div>

		<div class="video-grid">
			<?php foreach ($videos as $video): ?>
			<article class="video-card">
				<a class="fancybox-media video-card__media" href="<?php echo h($video['url']); ?>">
					<img src="<?php echo h($thumb); ?>" alt="<?php echo h($video['title']); ?>" loading="lazy">
					<span class="video-card__play" aria-hidden="true"><span><i class="fa fa-play"></i></span></span>
				</a>
				<h2 class="video-card__title"><?php echo h($video['title']); ?></h2>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</div>
