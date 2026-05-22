<?php
if (!function_exists('env')) {
    function env($key, $default = null) {
        $v = getenv($key);
        return $v === false ? $default : $v;
    }
}
$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';
require $root . '/config/bootstrap.php';

use Cake\Datasource\ConnectionManager;

$conn = ConnectionManager::get('default');
$specId = 1;
$conn->update('ai_specs', ['revision' => 2, 'doc_reference' => '25-AST-1267-WMM-R2'], ['id' => $specId]);

$_REQUEST['ai_spec_id'] = $specId;
$_REQUEST['pdfname'] = $specId . '-AISPEC_TEST_R2';
chdir($root . '/webroot/dompdf');
ob_start();
include $root . '/webroot/dompdf/generate_aispec_pdf.php';
$out = ob_get_clean();
$json = json_decode($out, true);
if (empty($json['success'])) {
    fwrite(STDERR, $out . PHP_EOL);
    exit(1);
}
$conn->update('ai_specs', ['pdf_attachment' => $json['path']], ['id' => $specId]);
echo "Revision PDF: " . $json['path'] . PHP_EOL;
