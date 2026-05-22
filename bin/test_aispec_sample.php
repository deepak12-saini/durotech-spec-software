<?php
/**
 * Insert sample AiSpec data and generate PDF (CLI QA).
 */
if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);
        return $value === false ? $default : $value;
    }
}

$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

require $root . '/config/bootstrap.php';

$conn = ConnectionManager::get('default');

$sample = [
    'header' => [
        'admin_id' => 1,
        'tracknumber' => 'AISPEC-TEST-' . date('ymd-His'),
        'project' => '573 Gardeners Rd, Mascot',
        'client' => 'Astute Construction',
        'revision' => 1,
        'doc_reference' => '25-AST-1267-WMM-R1',
        'section_number' => '4',
        'section_title' => 'Material Review by Area',
        'subsection_number' => '4.1',
        'subsection_title' => 'Waterproofing Materials Matrix',
        'save_status' => 'submitted',
        'created' => date('Y-m-d H:i:s'),
        'modified' => date('Y-m-d H:i:s'),
    ],
    'sections' => [
        [
            'name' => 'INTERNAL WET AREA',
            'standards_text' => 'AS/NZS 4858 (2004) & AS 3740 (2021)',
            'items' => [
                ['wpm_code' => 'wpm 01', 'tag_color' => '#23550C', 'application_area' => 'tile on screed / sub-sill hob', 'product_name' => 'Durotech Duromastic P15 Diamond', 'description' => 'class III | fully bonded liquid membrane', 'fall_requirement' => 'min 1:100 ssl & ffl fall'],
                ['wpm_code' => 'wpm 03', 'tag_color' => '#FFED00', 'application_area' => 'wet area floor and wall', 'product_name' => 'Durotech Duromastic 007FC', 'description' => 'class III | fully bonded liquid membrane', 'fall_requirement' => 'min 1:100 ssl & min 1:80 ffl fall'],
            ],
        ],
        [
            'name' => 'EXTERNAL ABOVE-GROUND',
            'standards_text' => 'AS 4654.1 (2012) & AS 4654.2 (2012)',
            'items' => [
                ['wpm_code' => 'wpm 02', 'tag_color' => '#633907', 'application_area' => 'pavers on pedestals / podium', 'product_name' => 'Durotech Duroproof NEP STD', 'description' => 'class III | fully bonded liquid membrane', 'fall_requirement' => 'min 1:100 ssl fall'],
                ['wpm_code' => 'wpm 04', 'tag_color' => '#00A0E3', 'application_area' => 'roof', 'product_name' => 'Durotech Duroproof NEP STD + Durotech Duroproof TTC', 'description' => 'class III | fully bonded liquid membrane', 'fall_requirement' => 'min 1:100 ssl fall'],
            ],
        ],
        [
            'name' => 'BELOW-GROUND / MISCELLANEOUS',
            'standards_text' => 'BS 8102 (2022) & BEST PRACTICE',
            'items' => [
                ['wpm_code' => 'wpm 05', 'tag_color' => '#95346C', 'application_area' => 'tank - OSD / RWT / FST / pump-out-pit', 'product_name' => 'Durotech Duroflex Tank', 'description' => 'class II | fully bonded cementitious membrane', 'fall_requirement' => ''],
                ['wpm_code' => 'wpm 06', 'tag_color' => '#E31E24', 'application_area' => 'culvert', 'product_name' => 'Drizoro Maxseal Flex', 'description' => 'class I | fully bonded cementitious membrane', 'fall_requirement' => 'min 1:100 ssl fall'],
                ['wpm_code' => 'wpm 07', 'tag_color' => '#C2364D', 'application_area' => 'waste storage / car wash bay', 'product_name' => 'Durotech Duropoxy SLR 100', 'description' => 'fully bonded epoxy flooring system', 'fall_requirement' => 'min 1:100 ssl fall'],
                ['wpm_code' => 'wpm 08', 'tag_color' => '#EDA708', 'application_area' => 'landscape - positive side', 'product_name' => 'Durotech Duroproof NEP STD', 'description' => 'class III | fully bonded liquid membrane', 'fall_requirement' => 'min 1:100 ssl & ffl fall'],
                ['wpm_code' => 'wpm 09', 'tag_color' => '#470022', 'application_area' => 'perimeter setdown / rendered slab edge', 'product_name' => 'Durotech Duromastic P15 Diamond', 'description' => 'class III | fully bonded liquid membrane', 'fall_requirement' => 'min 1:100 ssl fall'],
                ['wpm_code' => 'wpm 10', 'tag_color' => '#01123E', 'application_area' => 'wet plant room', 'product_name' => 'Durotech Duropoxy SLR 100', 'description' => 'fully bonded epoxy flooring system', 'fall_requirement' => 'min 1:100 ssl fall'],
            ],
        ],
    ],
];

$conn->begin();
try {
    $conn->insert('ai_specs', $sample['header']);
    $specId = (int)$conn->getDriver()->lastInsertId('ai_specs', 'id');
    $so = 0;
    foreach ($sample['sections'] as $sec) {
        $conn->insert('ai_spec_sections', [
            'ai_spec_id' => $specId,
            'name' => $sec['name'],
            'standards_text' => $sec['standards_text'],
            'sort_order' => $so++,
        ]);
        $sectionId = (int)$conn->getDriver()->lastInsertId('ai_spec_sections', 'id');
        $io = 0;
        foreach ($sec['items'] as $item) {
            $conn->insert('ai_spec_items', [
                'ai_spec_section_id' => $sectionId,
                'wpm_code' => $item['wpm_code'],
                'tag_color' => $item['tag_color'],
                'application_area' => $item['application_area'],
                'product_name' => $item['product_name'],
                'description' => $item['description'],
                'fall_requirement' => $item['fall_requirement'],
                'sort_order' => $io++,
            ]);
        }
    }
    $conn->commit();
} catch (\Throwable $e) {
    $conn->rollback();
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
}

$pdfname = $specId . '-AISPEC_TEST';
$url = 'http://localhost/cake3app/dompdf/generate_aispec_pdf.php?ai_spec_id=' . $specId . '&pdfname=' . urlencode($pdfname);

// Try SITEURL from constants if defined in bootstrap
$constantsFile = $root . '/config/constants.php';
if (is_file($constantsFile)) {
    require_once $constantsFile;
}
if (defined('SITEURL')) {
    $url = rtrim(SITEURL, '/') . '/dompdf/generate_aispec_pdf.php?ai_spec_id=' . $specId . '&pdfname=' . urlencode($pdfname);
}

echo "Created ai_spec id={$specId}\n";
echo "Calling: {$url}\n";

$ctx = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
$result = @file_get_contents($url, false, $ctx);
if ($result === false) {
    // CLI direct include
    $_REQUEST['ai_spec_id'] = $specId;
    $_REQUEST['pdfname'] = $pdfname;
    chdir($root . '/webroot/dompdf');
    ob_start();
    include $root . '/webroot/dompdf/generate_aispec_pdf.php';
    $result = ob_get_clean();
    chdir($root);
}

$json = json_decode((string)$result, true);
if (!is_array($json) || empty($json['success'])) {
    fwrite(STDERR, "PDF failed: " . $result . PHP_EOL);
    exit(1);
}

$path = $json['path'] ?? '';
$conn->update('ai_specs', ['pdf_attachment' => $path], ['id' => $specId]);
echo "PDF OK: {$path}\n";
echo "Full path: " . $root . '/webroot/' . str_replace('/', DIRECTORY_SEPARATOR, $path) . "\n";
