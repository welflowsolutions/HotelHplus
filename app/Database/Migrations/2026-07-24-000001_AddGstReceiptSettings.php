<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGstReceiptSettings extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('settings')) {
            return;
        }

        foreach ([
            'receipt_gst_enabled' => '0',
            'receipt_gst_rate' => '12',
        ] as $key => $value) {
            if ($this->db->table('settings')->where('key', $key)->countAllResults() > 0) {
                continue;
            }

            $this->db->table('settings')->insert([
                'key' => $key,
                'value' => $value,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function down(): void
    {
        if (! $this->db->tableExists('settings')) {
            return;
        }

        $this->db->table('settings')->whereIn('key', ['receipt_gst_enabled', 'receipt_gst_rate'])->delete();
    }
}
