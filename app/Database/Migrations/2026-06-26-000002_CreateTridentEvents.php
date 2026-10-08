<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTridentEvents extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('trident_events')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'icon_class' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'default' => 'fa-calendar-days',
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('trident_events', true);
    }

    public function down()
    {
        $this->forge->dropTable('trident_events', true);
    }
}
