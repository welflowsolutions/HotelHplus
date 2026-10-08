<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOtpEmailToPaymentRefunds extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('payment_refunds')) {
            return;
        }

        $fields = $this->db->getFieldData('payment_refunds');
        $existing = array_map(static fn ($field) => $field->name ?? '', $fields);

        if (! in_array('otp_email', $existing, true)) {
            $this->forge->addColumn('payment_refunds', [
                'otp_email' => ['type' => 'VARCHAR', 'constraint' => 190, 'null' => true, 'after' => 'created_by'],
            ]);
        }
    }

    public function down(): void
    {
        if (! $this->db->tableExists('payment_refunds')) {
            return;
        }

        $fields = $this->db->getFieldData('payment_refunds');
        $existing = array_map(static fn ($field) => $field->name ?? '', $fields);

        if (in_array('otp_email', $existing, true)) {
            $this->forge->dropColumn('payment_refunds', 'otp_email');
        }
    }
}
