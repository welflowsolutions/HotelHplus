<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMediaFiles extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'file_name'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'original_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'path'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'mime_type'     => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'size'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'alt_text'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('media_files', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('media_files', true);
    }
}
