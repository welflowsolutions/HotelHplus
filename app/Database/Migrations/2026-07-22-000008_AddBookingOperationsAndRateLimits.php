<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBookingOperationsAndRateLimits extends Migration
{
    public function up(): void
    {
        if ($this->db->tableExists('bookings')) {
            $existing = array_map(static fn ($field) => $field->name ?? '', $this->db->getFieldData('bookings'));
            $columns = [];

            if (! in_array('source', $existing, true)) {
                $columns['source'] = ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'website', 'after' => 'id'];
            }

            if (! in_array('invoice_number', $existing, true)) {
                $columns['invoice_number'] = ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true, 'after' => 'booking_code'];
            }

            if (! in_array('created_by', $existing, true)) {
                $columns['created_by'] = ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'notes'];
            }

            if ($columns !== []) {
                $this->forge->addColumn('bookings', $columns);
            }

            if (! in_array('invoice_number', $existing, true)) {
                $this->forge->addKey('invoice_number');
                $this->forge->processIndexes('bookings');
            }
        }

        if (! $this->db->tableExists('rate_limit_attempts')) {
            $this->forge->addField([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'scope' => ['type' => 'VARCHAR', 'constraint' => 80],
                'identifier' => ['type' => 'VARCHAR', 'constraint' => 190],
                'attempts' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
                'locked_until' => ['type' => 'DATETIME', 'null' => true],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey(['scope', 'identifier']);
            $this->forge->createTable('rate_limit_attempts', true);
        }

        $this->seedSettings();
    }

    public function down(): void
    {
        if ($this->db->tableExists('rate_limit_attempts')) {
            $this->forge->dropTable('rate_limit_attempts', true);
        }

        if ($this->db->tableExists('bookings')) {
            $existing = array_map(static fn ($field) => $field->name ?? '', $this->db->getFieldData('bookings'));

            foreach (['source', 'invoice_number', 'created_by'] as $column) {
                if (in_array($column, $existing, true)) {
                    $this->forge->dropColumn('bookings', $column);
                }
            }
        }
    }

    private function seedSettings(): void
    {
        if (! $this->db->tableExists('settings')) {
            return;
        }

        $defaults = [
            'receipt_invoice_prefix' => 'HHP',
            'receipt_tax_label' => '',
            'receipt_tax_number' => '',
            'guest_lookup_enabled' => '1',
            'security_login_max_attempts' => '5',
            'security_login_lock_minutes' => '15',
            'security_refund_otp_max_attempts' => '5',
            'security_refund_otp_resend_minutes' => '2',
        ];

        foreach ($defaults as $key => $value) {
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
}
