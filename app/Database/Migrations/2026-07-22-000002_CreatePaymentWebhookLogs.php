<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentWebhookLogs extends Migration
{
    public function up(): void
    {
        if ($this->db->tableExists('payment_webhook_logs')) {
            return;
        }

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'gateway' => ['type' => 'VARCHAR', 'constraint' => 40],
            'event_type' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'gateway_event_id' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'signature_valid' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'gateway_order_id' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'gateway_payment_id' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'headers_json' => ['type' => 'LONGTEXT', 'null' => true],
            'payload_json' => ['type' => 'LONGTEXT', 'null' => true],
            'process_status' => ['type' => 'VARCHAR', 'constraint' => 60],
            'error_message' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('gateway');
        $this->forge->addKey('gateway_order_id');
        $this->forge->addKey('process_status');
        $this->forge->addKey('created_at');
        $this->forge->createTable('payment_webhook_logs', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('payment_webhook_logs', true);
    }
}
