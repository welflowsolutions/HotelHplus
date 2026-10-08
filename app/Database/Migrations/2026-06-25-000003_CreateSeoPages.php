<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSeoPages extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'route_key' => ['type' => 'VARCHAR', 'constraint' => 120],
            'route_label' => ['type' => 'VARCHAR', 'constraint' => 255],
            'route_path' => ['type' => 'VARCHAR', 'constraint' => 255],
            'route_handler' => ['type' => 'VARCHAR', 'constraint' => 255],
            'scan_status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'active'],
            'last_scanned_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('route_key');
        $this->forge->createTable('seo_pages', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('seo_pages', true);
    }
}
