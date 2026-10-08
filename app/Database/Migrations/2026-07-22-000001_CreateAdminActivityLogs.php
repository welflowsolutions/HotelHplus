<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminActivityLogs extends Migration
{
    public function up(): void
    {
        if ($this->db->tableExists('admin_activity_logs')) {
            return;
        }

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'admin_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'admin_name' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'action' => ['type' => 'VARCHAR', 'constraint' => 80],
            'entity_type' => ['type' => 'VARCHAR', 'constraint' => 80],
            'entity_id' => ['type' => 'VARCHAR', 'constraint' => 80, 'null' => true],
            'summary' => ['type' => 'VARCHAR', 'constraint' => 255],
            'changes' => ['type' => 'LONGTEXT', 'null' => true],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'user_agent' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('admin_id');
        $this->forge->addKey('action');
        $this->forge->addKey('entity_type');
        $this->forge->addKey('created_at');
        $this->forge->createTable('admin_activity_logs', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('admin_activity_logs', true);
    }
}
