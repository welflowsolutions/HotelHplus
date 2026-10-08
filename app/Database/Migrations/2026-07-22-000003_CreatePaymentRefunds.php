<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentRefunds extends Migration
{
    public function up(): void
    {
        if ($this->db->tableExists('payment_refunds')) {
            return;
        }

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'payment_transaction_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'booking_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'gateway' => ['type' => 'VARCHAR', 'constraint' => 40],
            'gateway_order_id' => ['type' => 'VARCHAR', 'constraint' => 120],
            'gateway_payment_id' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'gateway_refund_id' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'refund_reference' => ['type' => 'VARCHAR', 'constraint' => 40],
            'amount' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'currency' => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'INR'],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'processed', 'failed'], 'default' => 'pending'],
            'note' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'request_payload' => ['type' => 'LONGTEXT', 'null' => true],
            'response_payload' => ['type' => 'LONGTEXT', 'null' => true],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'processed_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('payment_transaction_id');
        $this->forge->addKey('booking_id');
        $this->forge->addKey('gateway_order_id');
        $this->forge->addKey('status');
        $this->forge->addUniqueKey('refund_reference');
        $this->forge->createTable('payment_refunds', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('payment_refunds', true);
    }
}
