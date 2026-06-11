<?php
declare(strict_types=1);

namespace App\Utility;

/**
 * Parse Instagram embed HTML or post URLs into a normalized permalink.
 */
class InstagramEmbedParser
{
    /**
     * @return array{permalink: string, media_type: string}|null
     */
    public static function parse(string $input): ?array
    {
        $input = trim(html_entity_decode($input, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        if ($input === '') {
            return null;
        }

        $rawUrl = null;

        if (preg_match('/data-instgrm-permalink=["\']([^"\']+)["\']/i', $input, $matches)) {
            $rawUrl = html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        } elseif (preg_match('#https?://(?:www\.)?instagram\.com/(p|reel|tv)/([A-Za-z0-9_-]+)#i', $input, $matches)) {
            $rawUrl = $matches[0];
        } elseif (preg_match('#(?:www\.)?instagram\.com/(p|reel|tv)/([A-Za-z0-9_-]+)#i', $input, $matches)) {
            $rawUrl = 'https://www.instagram.com/' . $matches[1] . '/' . $matches[2];
        }

        if ($rawUrl === null) {
            return null;
        }

        if (!preg_match('#https?://(?:www\.)?instagram\.com/(p|reel|tv)/([A-Za-z0-9_-]+)#i', $rawUrl, $parts)) {
            return null;
        }

        $segment = strtolower($parts[1]);
        $shortcode = $parts[2];

        $mediaType = 'post';
        if ($segment === 'reel') {
            $mediaType = 'reel';
        } elseif ($segment === 'tv') {
            $mediaType = 'tv';
        }

        $permalink = 'https://www.instagram.com/' . $segment . '/' . $shortcode . '/';

        return [
            'permalink' => $permalink,
            'media_type' => $mediaType,
        ];
    }

    /**
     * Permalink used by Instagram embed.js (always uses /p/ path for blockquote).
     */
    public static function embedPermalink(string $permalink): string
    {
        if (preg_match('#instagram\.com/(p|reel|tv)/([A-Za-z0-9_-]+)#i', $permalink, $matches)) {
            return 'https://www.instagram.com/' . strtolower($matches[1]) . '/' . $matches[2] . '/?utm_source=ig_embed&utm_campaign=loading';
        }

        return $permalink;
    }
}
