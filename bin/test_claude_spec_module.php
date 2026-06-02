<?php
/**
 * Smoke test for Claude Spec Assistant module (no API call).
 */
$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';
require $root . '/config/bootstrap.php';

use App\Service\ClaudeSpecService;
use Cake\ORM\TableRegistry;

$service = new ClaudeSpecService();
$sample = [
    'header' => [
        'name' => 'Test',
        'email' => 'a@b.com',
        'company' => 'Proj',
        'address' => '1 St',
        'subject' => 'Subj',
        'specification' => 'Spec',
        'date' => '2026-06-01',
    ],
    'comments' => ['Note 1'],
    'products' => [
        [
            'title' => 'Deck',
            'product' => 'Prod A',
            'serial' => '1',
            'coverage' => '2mm',
            'coverage_by_pack' => '10',
            'Warranty' => '10yr',
            'types' => '1',
        ],
    ],
];
$normalized = $service->normalizePayload($sample);
if ($normalized === null) {
    fwrite(STDERR, "normalizePayload failed\n");
    exit(1);
}
$sections = $service->productsToSections($normalized['products']);
if (count($sections) !== 1 || empty($sections[0]['rows'])) {
    fwrite(STDERR, "productsToSections failed\n");
    exit(1);
}

$table = TableRegistry::getTableLocator()->get('ClaudeSpecDrafts');
if (!$table->getSchema()->hasColumn('generated_payload')) {
    fwrite(STDERR, "claude_spec_drafts table missing\n");
    exit(1);
}

$track = $table->getNextTrackNumber();
if (strpos($track, 'CLAUDE ') !== 0) {
    fwrite(STDERR, "unexpected track number: $track\n");
    exit(1);
}

echo "Claude Spec module smoke test OK (track sample: $track)\n";
