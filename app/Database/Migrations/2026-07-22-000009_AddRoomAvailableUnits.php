<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoomAvailableUnits extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('rooms') || $this->db->fieldExists('available_units', 'rooms')) {
            return;
        }

        $this->forge->addColumn('rooms', [
            'available_units' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
                'after' => 'max_guests',
            ],
        ]);
    }

    public function down(): void
    {
        if (! $this->db->tableExists('rooms') || ! $this->db->fieldExists('available_units', 'rooms')) {
            return;
        }

        $this->forge->dropColumn('rooms', 'available_units');
    }
}
