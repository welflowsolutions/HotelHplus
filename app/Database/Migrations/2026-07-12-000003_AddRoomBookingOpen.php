<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoomBookingOpen extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('rooms')) {
            return;
        }

        $fields = $this->db->getFieldData('rooms');
        $hasBookingOpen = false;

        foreach ($fields as $field) {
            if (($field->name ?? '') === 'booking_open') {
                $hasBookingOpen = true;
                break;
            }
        }

        if (! $hasBookingOpen) {
            $this->forge->addColumn('rooms', [
                'booking_open' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 1,
                    'after' => 'is_active',
                ],
            ]);
        }
    }

    public function down(): void
    {
        if (! $this->db->tableExists('rooms')) {
            return;
        }

        $fields = $this->db->getFieldData('rooms');

        foreach ($fields as $field) {
            if (($field->name ?? '') === 'booking_open') {
                $this->forge->dropColumn('rooms', 'booking_open');
                break;
            }
        }
    }
}
