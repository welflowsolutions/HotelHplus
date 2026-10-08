<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBookingPaymentFields extends Migration
{
    public function up(): void
    {
        $fields = $this->db->getFieldData('bookings');
        $existing = array_map(static fn ($field) => $field->name ?? '', $fields);

        $columns = [];

        if (! in_array('booking_code', $existing, true)) {
            $columns['booking_code'] = ['type' => 'VARCHAR', 'constraint' => 40, 'null' => true, 'after' => 'id'];
        }

        if (! in_array('room_id', $existing, true)) {
            $columns['room_id'] = ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'room_type'];
        }

        if (! in_array('total_amount', $existing, true)) {
            $columns['total_amount'] = ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00, 'after' => 'guests'];
        }

        if (! in_array('currency', $existing, true)) {
            $columns['currency'] = ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'INR', 'after' => 'total_amount'];
        }

        if (! in_array('payment_required', $existing, true)) {
            $columns['payment_required'] = ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'after' => 'currency'];
        }

        if (! in_array('payment_gateway', $existing, true)) {
            $columns['payment_gateway'] = ['type' => 'VARCHAR', 'constraint' => 40, 'null' => true, 'after' => 'payment_required'];
        }

        if (! in_array('payment_status', $existing, true)) {
            $columns['payment_status'] = ['type' => 'ENUM', 'constraint' => ['not_required', 'initiated', 'pending', 'paid', 'failed', 'cancelled'], 'default' => 'not_required', 'after' => 'payment_gateway'];
        }

        if (! in_array('payment_notified_at', $existing, true)) {
            $columns['payment_notified_at'] = ['type' => 'DATETIME', 'null' => true, 'after' => 'payment_status'];
        }

        if ($columns !== []) {
            $this->forge->addColumn('bookings', $columns);
        }

        if (! in_array('booking_code', $existing, true)) {
            $this->forge->addUniqueKey('booking_code');
            $this->forge->processIndexes('bookings');
        }

        if (! $this->db->tableExists('payment_transactions')) {
            $this->forge->addField([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'booking_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'gateway' => ['type' => 'VARCHAR', 'constraint' => 40],
                'gateway_order_id' => ['type' => 'VARCHAR', 'constraint' => 120],
                'gateway_payment_id' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
                'amount' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
                'currency' => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'INR'],
                'status' => ['type' => 'ENUM', 'constraint' => ['created', 'checkout_ready', 'pending', 'paid', 'failed', 'cancelled'], 'default' => 'created'],
                'session_token' => ['type' => 'TEXT', 'null' => true],
                'request_payload' => ['type' => 'LONGTEXT', 'null' => true],
                'response_payload' => ['type' => 'LONGTEXT', 'null' => true],
                'verified_payload' => ['type' => 'LONGTEXT', 'null' => true],
                'paid_at' => ['type' => 'DATETIME', 'null' => true],
                'verified_at' => ['type' => 'DATETIME', 'null' => true],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addKey('booking_id');
            $this->forge->addUniqueKey('gateway_order_id');
            $this->forge->createTable('payment_transactions', true);
        }
    }

    public function down(): void
    {
        if ($this->db->tableExists('payment_transactions')) {
            $this->forge->dropTable('payment_transactions', true);
        }

        $fields = $this->db->getFieldData('bookings');
        $existing = array_map(static fn ($field) => $field->name ?? '', $fields);

        foreach (['booking_code', 'room_id', 'total_amount', 'currency', 'payment_required', 'payment_gateway', 'payment_status', 'payment_notified_at'] as $column) {
            if (in_array($column, $existing, true)) {
                $this->forge->dropColumn('bookings', $column);
            }
        }
    }
}
