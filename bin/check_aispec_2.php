<?php
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';

use Cake\Datasource\ConnectionManager;

$c = ConnectionManager::get('default');
$id = 2;
$sections = $c->execute(
    'SELECT id, name, sort_order FROM ai_spec_sections WHERE ai_spec_id = ? ORDER BY sort_order',
    [$id]
)->fetchAll('assoc');
echo "Sections for ai_spec $id:\n";
print_r($sections);

$items = $c->execute(
    'SELECT i.id, i.wpm_code, i.product_name, s.name AS section_name
     FROM ai_spec_items i
     INNER JOIN ai_spec_sections s ON s.id = i.ai_spec_section_id
     WHERE s.ai_spec_id = ?
     ORDER BY i.wpm_code',
    [$id]
)->fetchAll('assoc');
echo "Items:\n";
print_r($items);

$spec = $c->execute('SELECT pdf_attachment FROM ai_specs WHERE id = ?', [$id])->fetch('assoc');
echo "PDF: " . ($spec['pdf_attachment'] ?? '') . "\n";
