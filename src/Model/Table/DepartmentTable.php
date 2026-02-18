<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Department table (alias "Department" for loadModel('Department')).
 * Uses table name "departments" - create it if missing:
 * CREATE TABLE departments (id INT AUTO_INCREMENT PRIMARY KEY, department_title VARCHAR(255), ...);
 */
class DepartmentTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('departments');
        $this->setPrimaryKey('id');
        $this->setDisplayField('department_title');
    }
}
