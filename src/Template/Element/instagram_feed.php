<?php
/**
 * Home page Instagram feed slider (admin-managed posts).
 *
 * @var \App\View\AppView $this
 * @var \Cake\Collection\CollectionInterface|\App\Model\Entity\InstagramPost[] $instagramPosts
 */
use App\Utility\InstagramEmbedParser;

$instagramPosts = $instagramPosts ?? [];
$hasPosts = !empty($instagramPosts) && count($instagramPosts) > 0;
?>
<style>
	.instagram-reels {
		background: #e4edf4;
	}
	.instagram-reels .container > h3 {
		color: #2889c8;
		font-weight: 600;
		display: inline-block;
		position: relative;
		transition: color 0.25s ease, text-shadow 0.25s ease, transform 0.25s ease;
		animation: instagramTitleFadeUp 0.7s ease both;
	}
	.instagram-reels .container > h3:after {
		content: "";
		position: absolute;
		left: 50%;
		bottom: -8px;
		width: 70px;
		height: 3px;
		border-radius: 999px;
		background: linear-gradient(90deg, #2889c8 0%, #f4c400 100%);
		transform: translateX(-50%) scaleX(0.55);
		transform-origin: center;
		transition: width 0.25s ease, transform 0.25s ease, box-shadow 0.25s ease;
	}
	.instagram-reels:hover .container > h3 {
		color: #0056b3;
		text-shadow: 0 6px 16px rgba(40, 137, 200, 0.18);
		transform: translateY(-3px);
	}
	.instagram-reels:hover .container > h3:after {
		width: 120px;
		transform: translateX(-50%) scaleX(1);
		box-shadow: 0 4px 12px rgba(40, 137, 200, 0.22);
	}
	@keyframes instagramTitleFadeUp {
		from {
			opacity: 0;
			transform: translateY(12px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}
	.instagram-reels .instagram-follow-cta {
		text-align: center;
		margin: 12px 0 20px;
	}
	.instagram-reels .instagram-follow-btn {
		display: inline-block;
		padding: 10px 22px;
		background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
		color: #fff;
		border-radius: 999px;
		font-weight: 600;
		text-decoration: none;
		transition: opacity 0.2s ease, transform 0.2s ease;
	}
	.instagram-reels .instagram-follow-btn:hover {
		opacity: 0.92;
		color: #fff;
		text-decoration: none;
		transform: translateY(-1px);
	}
	.instagram-slider .slick-track {
		display: flex !important;
	}
	.instagram-slider .slick-slide {
		height: inherit !important;
	}
	.instagram-slider .slide {
		padding: 5px;
		height: auto;
	}
	.insta-reel-wrapper {
		--insta-crop-top: 58px;
		--insta-crop-bottom: 80px;
		width: 100%;
		position: relative;
		height: 330px;
		overflow: hidden;
		background: #fff;
		border: 1px solid #e4e4e4;
		border-radius: 12px;
	}
	.insta-reel-wrapper > blockquote,
	.insta-reel-wrapper > iframe {
		position: static;
		width: 100% !important;
		height: calc(100% + var(--insta-crop-top) + var(--insta-crop-bottom)) !important;
		min-height: calc(100% + var(--insta-crop-top) + var(--insta-crop-bottom)) !important;
		min-width: 100% !important;
		margin: calc(0px - var(--insta-crop-top)) 0 0 !important;
	}
	@media (max-width: 991px) {
		.insta-reel-wrapper {
			height: 320px;
		}
	}
	@media (max-width: 576px) {
		.insta-reel-wrapper {
			height: 300px;
		}
	}
</style>

<?php if ($hasPosts): ?>
<div class="instagram-reels col-lg-12 col-md-12 col-sm-12">
	<div class="container">
		<h3>Our Latest Instagram Posts</h3>
		<div class="instagram-follow-cta">
			<a class="instagram-follow-btn" href="https://www.instagram.com/durotech_australia/" target="_blank" rel="noopener noreferrer">
				Follow @durotech_australia
			</a>
		</div>
		<section class="instagram-slider">
			<?php foreach ($instagramPosts as $post): ?>
				<?php
				$embedUrl = InstagramEmbedParser::embedPermalink((string)$post->permalink);
				?>
				<div class="slide">
					<div class="insta-reel-wrapper">
						<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="<?= h($embedUrl) ?>" data-instgrm-version="14" style="width:100%; max-width:540px;"></blockquote>
					</div>
				</div>
			<?php endforeach; ?>
		</section>
	</div>
</div>
<script async src="//www.instagram.com/embed.js"></script>
<?php endif; ?>
