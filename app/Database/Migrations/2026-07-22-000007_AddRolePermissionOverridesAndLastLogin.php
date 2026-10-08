<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRolePermissionOverridesAndLastLogin extends Migration
{
    public function up(): void
    {
        if ($this->db->tableExists('users')) {
            $fields = array_flip($this->db->getFieldNames('users'));
            $columns = [];

            if (! isset($fields['last_login_at'])) {
                $columns['last_login_at'] = ['type' => 'DATETIME', 'null' => true, 'after' => 'remember_token'];
            }

            if (! isset($fields['last_login_ip'])) {
                $columns['last_login_ip'] = ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true, 'after' => 'last_login_at'];
            }

            if ($columns !== []) {
                $this->forge->addColumn('users', $columns);
            }
        }

        if (! $this->db->tableExists('role_permission_overrides')) {
            $this->forge->addField([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'role' => ['type' => 'VARCHAR', 'constraint' => 30],
                'permission' => ['type' => 'VARCHAR', 'constraint' => 80],
                'is_allowed' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addKey('role');
            $this->forge->addUniqueKey(['role', 'permission'], 'role_permission_unique');
            $this->forge->createTable('role_permission_overrides', true);
        }
    }

    public function down(): void
    {
        $this->forge->dropTable('role_permission_overrides', true);

        if ($this->db->tableExists('users')) {
            $fields = array_flip($this->db->getFieldNames('users'));

            foreach (['last_login_at', 'last_login_ip'] as $field) {
                if (isset($fields[$field])) {
                    $this->forge->dropColumn('users', $field);
                }
            }
        }
    }
}
