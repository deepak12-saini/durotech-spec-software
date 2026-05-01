<?php
/**
 * Build public URL for price-list PDFs stored under webroot.
 * DB often stores dir as "webroot/durotech.../folder" — browsers must NOT request /webroot/...
 * when the site document root is already webroot (403 Forbidden on directory).
 *
 * @var string $dir lab_files.dir
 * @var string $filename lab_files.filename
 */
$dirRaw = (string)($dir ?? '');
$dirRaw = preg_replace('#^webroot[/\\\\]+#i', '', $dirRaw);
$dirRaw = trim(str_replace('\\', '/', $dirRaw), '/');
$fn = (string)($filename ?? '');
$base = rtrim((string)(defined('SITEURL') ? SITEURL : ''), '/');
$url = '';
if ($fn !== '') {
    $url = $dirRaw !== '' ? $base . '/' . $dirRaw . '/' . $fn : $base . '/' . $fn;
}
echo h($url);
