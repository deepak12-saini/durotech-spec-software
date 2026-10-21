<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

/**
 * Server-side product warranty log (serial, contractor, address, status events).
 */
final class ProductWarrantyEventLogger
{
    /** @var array<int, string> */
    public const SNAPSHOT_FIELDS = [
        'serialnumber',
        'product',
        'used_as',
        'application',
        'area_warranted',
        'building_name',
        'building_address',
        'building_area_name',
        'contract_company_name',
        'contract_name',
        'applicator',
        'applicator_address',
        'applicator_active_abn',
        'email',
        'phone',
        'dateofpurchase',
        'start_requested_warranty',
        'end_requested_warranty',
        'sign_date',
        'status',
    ];

    /**
     * @param array<string, mixed>|object $row
     * @return array<string, string>
     */
    public static function snapshot($row): array
    {
        $arr = is_object($row) && method_exists($row, 'toArray') ? $row->toArray() : (array)$row;
        $out = [];
        foreach (self::SNAPSHOT_FIELDS as $field) {
            $val = $arr[$field] ?? '';
            if ($val instanceof \DateTimeInterface) {
                $val = $val->format('Y-m-d');
            }
            $out[$field] = trim((string)$val);
        }

        return $out;
    }

    /**
     * @param array<string, string> $before
     * @param array<string, string> $after
     * @return array<string, array{from: string, to: string}>
     */
    public static function diff(array $before, array $after): array
    {
        $changed = [];
        foreach ($after as $key => $to) {
            $from = (string)($before[$key] ?? '');
            if ($from !== (string)$to) {
                $changed[$key] = ['from' => $from, 'to' => (string)$to];
            }
        }

        return $changed;
    }

    public static function ensureTable(): void
    {
        static $ready = false;
        if ($ready) {
            return;
        }
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS product_warranty_event_logs (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    product_warranty_request_id INT UNSIGNED NOT NULL,
    action VARCHAR(40) NOT NULL,
    actor_role VARCHAR(30) NULL,
    actor_id INT UNSIGNED NULL,
    actor_name VARCHAR(150) NULL,
    serialnumber VARCHAR(255) NULL,
    contractor_company VARCHAR(255) NULL,
    contractor_name VARCHAR(255) NULL,
    applicator_address TEXT NULL,
    building_address TEXT NULL,
    building_name VARCHAR(255) NULL,
    message VARCHAR(255) NULL,
    before_json MEDIUMTEXT NULL,
    after_json MEDIUMTEXT NULL,
    created DATETIME NOT NULL,
    PRIMARY KEY (id),
    KEY idx_pw_event_request (product_warranty_request_id, created),
    KEY idx_pw_event_serial (serialnumber),
    KEY idx_pw_event_action (action, created)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
SQL;
        try {
            ConnectionManager::get('default')->execute($sql);
            $ready = true;
        } catch (\Throwable $e) {
            Log::error('ProductWarrantyEventLogger ensureTable: ' . $e->getMessage());
        }
    }

    /**
     * @param array<string, mixed> $options
     */
    public static function log(int $requestId, string $action, array $options = []): void
    {
        if ($requestId <= 0) {
            return;
        }
        try {
            self::ensureTable();
            $after = isset($options['after']) && is_array($options['after'])
                ? $options['after']
                : [];
            $before = isset($options['before']) && is_array($options['before'])
                ? $options['before']
                : [];
            $snap = $after !== [] ? $after : $before;
            $table = TableRegistry::getTableLocator()->get('ProductWarrantyEventLogs');
            $entity = $table->newEntity([
                'product_warranty_request_id' => $requestId,
                'action' => $action,
                'actor_role' => (string)($options['actor_role'] ?? ''),
                'actor_id' => isset($options['actor_id']) ? (int)$options['actor_id'] : null,
                'actor_name' => (string)($options['actor_name'] ?? ''),
                'serialnumber' => (string)($snap['serialnumber'] ?? ''),
                'contractor_company' => (string)($snap['contract_company_name'] ?? ''),
                'contractor_name' => (string)($snap['contract_name'] ?? ($snap['applicator'] ?? '')),
                'applicator_address' => (string)($snap['applicator_address'] ?? ''),
                'building_address' => (string)($snap['building_address'] ?? ''),
                'building_name' => (string)($snap['building_name'] ?? ''),
                'message' => (string)($options['message'] ?? ''),
                'before_json' => $before !== [] ? json_encode($before) : null,
                'after_json' => $after !== [] ? json_encode($after) : null,
                'created' => date('Y-m-d H:i:s'),
            ]);
            $table->save($entity);
        } catch (\Throwable $e) {
            Log::error('ProductWarrantyEventLogger: ' . $e->getMessage());
        }
    }
}
