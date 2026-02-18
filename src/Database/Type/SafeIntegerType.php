<?php
declare(strict_types=1);

namespace App\Database\Type;

use Cake\Database\Driver;
use Cake\Database\Type\IntegerType;
use PDO;

/**
 * Integer type that never throws: non-numeric strings are converted to null.
 * Use to avoid "Cannot convert value of type `string` to integer" when
 * DB or request data contains empty or non-numeric values in integer columns.
 */
class SafeIntegerType extends IntegerType
{
    /**
     * Convert integer data into the database format.
     * Non-numeric strings are treated as null instead of throwing.
     *
     * @param mixed $value The value to convert.
     * @param \Cake\Database\Driver $driver The driver instance.
     * @return int|null
     */
    public function toDatabase($value, Driver $driver)
    {
        if ($value === null || $value === '') {
            return null;
        }
        if (is_numeric($value)) {
            return (int)$value;
        }
        return null;
    }

    /**
     * Convert integer values to PHP integers when reading from DB.
     * Non-numeric values are converted to null instead of throwing.
     *
     * @param mixed $value The value to convert.
     * @param \Cake\Database\Driver $driver The driver instance.
     * @return int|null
     */
    public function toPHP($value, Driver $driver)
    {
        if ($value === null || $value === '') {
            return null;
        }
        if (is_numeric($value)) {
            return (int)$value;
        }
        return null;
    }

    /**
     * Batch convert integer values when reading from DB (e.g. in ResultSet).
     * Non-numeric values are converted to null instead of throwing.
     *
     * @param array $values Row data.
     * @param array $fields List of integer fields.
     * @param \Cake\Database\Driver $driver The driver instance.
     * @return array
     */
    public function manyToPHP(array $values, array $fields, Driver $driver)
    {
        foreach ($fields as $field) {
            if (!array_key_exists($field, $values)) {
                continue;
            }
            $v = $values[$field];
            if ($v === null || $v === '') {
                $values[$field] = null;
            } elseif (is_numeric($v)) {
                $values[$field] = (int)$v;
            } else {
                $values[$field] = null;
            }
        }
        return $values;
    }

    /**
     * @param mixed $value The value being bound.
     * @param \Cake\Database\Driver $driver The driver.
     * @return int
     */
    public function toStatement($value, Driver $driver)
    {
        return PDO::PARAM_INT;
    }
}
