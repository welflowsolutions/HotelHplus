<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRefundNotificationFields extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('payment_refunds')) {
            return;
        }

        $fields = $this->db->getFieldData('payment_refunds');
        $existing = array_map(static fn ($field) => $field->name ?? '', $fields);
        $columns = [];

        if (! in_array('notified_at', $existing, true)) {
            $columns['notified_at'] = ['type' => 'DATETIME', 'null' => true, 'after' => 'processed_at'];
        }

        if ($columns !== []) {
            $this->forge->addColumn('payment_refunds', $columns);
        }
    }

    public function down(): void
    {
        if (! $this->db->tableExists('payment_refunds')) {
            return;
        }

        $fields = $this->db->getFieldData('payment_refunds');
        $existing = array_map(static fn ($field) => $field->name ?? '', $fields);

        if (in_array('notified_at', $existing, true)) {
            $this->forge->dropColumn('payment_refunds', 'notified_at');
        }
    }
}
