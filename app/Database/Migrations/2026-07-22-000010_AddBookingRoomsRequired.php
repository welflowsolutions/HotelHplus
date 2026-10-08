<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBookingRoomsRequired extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('bookings')) {
            return;
        }

        if (! $this->db->fieldExists('rooms_required', 'bookings')) {
            $this->forge->addColumn('bookings', [
                'rooms_required' => [
                    'type' => 'INT',
                    'constraint' => 5,
                    'default' => 1,
                    'after' => 'guests',
                ],
            ]);
        }

        $this->db->table('bookings')
            ->groupStart()
                ->where('rooms_required IS NULL', null, false)
                ->orWhere('rooms_required <', 1)
            ->groupEnd()
            ->update(['rooms_required' => 1]);
    }

    public function down()
    {
        if ($this->db->tableExists('bookings') && $this->db->fieldExists('rooms_required', 'bookings')) {
            $this->forge->dropColumn('bookings', 'rooms_required');
        }
    }
}
