<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddManualEventPaymentFields extends Migration
{
    public function up(): void
    {
        if ($this->db->tableExists('event_payments')) {
            $columns = [];

            if (! $this->db->fieldExists('payment_method', 'event_payments')) {
                $columns['payment_method'] = [
                    'type' => 'VARCHAR',
                    'constraint' => 40,
                    'null' => true,
                    'after' => 'payment_gateway',
                ];
            }

            if (! $this->db->fieldExists('payment_reference', 'event_payments')) {
                $columns['payment_reference'] = [
                    'type' => 'VARCHAR',
                    'constraint' => 160,
                    'null' => true,
                    'after' => 'payment_method',
                ];
            }

            if ($columns !== []) {
                $this->forge->addColumn('event_payments', $columns);
            }
        }

        if ($this->db->tableExists('payment_transactions')) {
            $columns = [];

            if (! $this->db->fieldExists('payment_method', 'payment_transactions')) {
                $columns['payment_method'] = [
                    'type' => 'VARCHAR',
                    'constraint' => 40,
                    'null' => true,
                    'after' => 'gateway',
                ];
            }

            if (! $this->db->fieldExists('payment_reference', 'payment_transactions')) {
                $columns['payment_reference'] = [
                    'type' => 'VARCHAR',
                    'constraint' => 160,
                    'null' => true,
                    'after' => 'gateway_payment_id',
                ];
            }

            if ($columns !== []) {
                $this->forge->addColumn('payment_transactions', $columns);
            }
        }
    }

    public function down(): void
    {
        if ($this->db->tableExists('payment_transactions')) {
            foreach (['payment_method', 'payment_reference'] as $column) {
                if ($this->db->fieldExists($column, 'payment_transactions')) {
                    $this->forge->dropColumn('payment_transactions', $column);
                }
            }
        }

        if ($this->db->tableExists('event_payments')) {
            foreach (['payment_method', 'payment_reference'] as $column) {
                if ($this->db->fieldExists($column, 'event_payments')) {
                    $this->forge->dropColumn('event_payments', $column);
                }
            }
        }
    }
}
