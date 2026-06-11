<?php
/**
 * Home page Instagram feed — 2×3 grid (latest 6), expand for more posts.
 *
 * @var \App\View\AppView $this
 * @var \Cake\Collection\CollectionInterface|\App\Model\Entity\InstagramPost[] $instagramPosts
 */
use App\Utility\InstagramEmbedParser;

$instagramPosts = $instagramPosts ?? [];
$postsList = [];
foreach ($instagramPosts as $post) {
    $postsList[] = $post;
}
$initialPosts = array_slice($postsList, 0, 6);
$morePosts = array_slice($postsList, 6);
$hasPosts = count($initialPosts) > 0;
$hasMore = count($morePosts) > 0;

$renderInstagramItem = function ($post) {
    $embedUrl = InstagramEmbedParser::embedPermalink((string)$post->permalink);
    ?>
    <div class="instagram-grid-item">
        <div class="insta-reel-wrapper">
            <blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="<?= h($embedUrl) ?>" data-instgrm-version="14" style="width:100%; max-width:540px;"></blockquote>
        </div>
    </div>
    <?php
};
?>
<style>
	.instagram-reels {
		background: #e4edf4;
		padding-bottom: 40px;
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
		margin: 12px 0 24px;
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
	.instagram-grid {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 16px;
	}
	.instagram-grid-item {
		min-width: 0;
	}
	.instagram-grid-expand-wrap {
		display: grid;
		grid-template-rows: 0fr;
		transition: grid-template-rows 0.45s ease;
	}
	.instagram-grid-expand-wrap.is-open {
		grid-template-rows: 1fr;
	}
	.instagram-grid-expand-inner {
		overflow: hidden;
	}
	.instagram-grid-expand-wrap .instagram-grid {
		margin-top: 16px;
	}
	.insta-reel-wrapper {
		--insta-crop-top: 46px;
		--insta-crop-bottom: 12px;
		width: 100%;
		position: relative;
		height: 380px;
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
	.instagram-view-more {
		text-align: center;
		margin-top: 20px;
	}
	.instagram-view-more-toggle {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		padding: 10px 20px;
		border: 2px solid #2889c8;
		border-radius: 999px;
		background: #fff;
		color: #2889c8;
		font-weight: 600;
		font-size: 15px;
		cursor: pointer;
		transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
	}
	.instagram-view-more-toggle:hover {
		background: #2889c8;
		color: #fff;
		transform: translateY(-1px);
	}
	.instagram-view-more-toggle .toggle-icon {
		display: inline-block;
		transition: transform 0.35s ease;
	}
	.instagram-view-more-toggle.is-open .toggle-icon {
		transform: rotate(180deg);
	}
	.instagram-profile-link {
		display: block;
		text-align: center;
		margin-top: 16px;
		font-size: 14px;
	}
	.instagram-profile-link a {
		color: #585A5A;
		text-decoration: none;
	}
	.instagram-profile-link a:hover {
		color: #2889c8;
		text-decoration: underline;
	}
	@media (max-width: 991px) {
		.instagram-grid {
			grid-template-columns: repeat(2, 1fr);
		}
		.insta-reel-wrapper {
			height: 360px;
		}
	}
	@media (max-width: 576px) {
		.instagram-grid {
			grid-template-columns: 1fr;
			gap: 12px;
		}
		.insta-reel-wrapper {
			height: 340px;
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

		<section class="instagram-grid instagram-grid-primary">
			<?php foreach ($initialPosts as $post): ?>
				<?php $renderInstagramItem($post); ?>
			<?php endforeach; ?>
		</section>

		<?php if ($hasMore): ?>
		<div class="instagram-grid-expand-wrap" id="instagram-grid-expand">
			<div class="instagram-grid-expand-inner">
				<section class="instagram-grid instagram-grid-more">
					<?php foreach ($morePosts as $post): ?>
						<?php $renderInstagramItem($post); ?>
					<?php endforeach; ?>
				</section>
				<p class="instagram-profile-link">
					<a href="https://www.instagram.com/durotech_australia/" target="_blank" rel="noopener noreferrer">
						See all posts on @durotech_australia
					</a>
				</p>
			</div>
		</div>

		<div class="instagram-view-more">
			<button type="button" class="instagram-view-more-toggle" id="instagram-view-more-toggle" aria-expanded="false" aria-controls="instagram-grid-expand">
				<span class="toggle-label">View more on Instagram</span>
				<span class="toggle-icon" aria-hidden="true">&darr;</span>
			</button>
		</div>
		<?php endif; ?>
	</div>
</div>
<script async src="//www.instagram.com/embed.js"></script>
<script>
(function () {
	function processInstagramEmbeds() {
		if (window.instgrm && window.instgrm.Embeds && typeof window.instgrm.Embeds.process === 'function') {
			window.instgrm.Embeds.process();
			return true;
		}
		return false;
	}

	var embedAttempts = 0;
	function waitForEmbeds() {
		if (processInstagramEmbeds()) {
			return;
		}
		if (embedAttempts < 20) {
			embedAttempts++;
			setTimeout(waitForEmbeds, 250);
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', waitForEmbeds);
	} else {
		waitForEmbeds();
	}

	var toggleBtn = document.getElementById('instagram-view-more-toggle');
	var expandWrap = document.getElementById('instagram-grid-expand');
	if (toggleBtn && expandWrap) {
		toggleBtn.addEventListener('click', function () {
			var isOpen = expandWrap.classList.toggle('is-open');
			toggleBtn.classList.toggle('is-open', isOpen);
			toggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
			toggleBtn.querySelector('.toggle-label').textContent = isOpen
				? 'Show less'
				: 'View more on Instagram';

			if (isOpen) {
				setTimeout(function () {
					processInstagramEmbeds();
					expandWrap.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
				}, 100);
			}
		});
	}
})();
</script>
<?php endif; ?>
