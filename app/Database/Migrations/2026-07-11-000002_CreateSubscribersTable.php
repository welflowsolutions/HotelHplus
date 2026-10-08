<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubscribersTable extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('subscribers')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 180,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'unsubscribed'],
                'default' => 'active',
            ],
            'subscribed_at' => [
                'type' => 'DATETIME',
                'null' => true,
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
        $this->forge->createTable('subscribers', true);
        $this->db->query('ALTER TABLE subscribers ADD UNIQUE KEY subscribers_email_unique (email)');
    }

    public function down()
    {
        $this->forge->dropTable('subscribers', true);
    }
}
