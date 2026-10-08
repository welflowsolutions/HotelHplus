<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventPayments extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('event_payments')) {
            $this->forge->addField([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'payment_code' => ['type' => 'VARCHAR', 'constraint' => 50],
                'event_enquiry_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
                'customer_name' => ['type' => 'VARCHAR', 'constraint' => 160],
                'customer_email' => ['type' => 'VARCHAR', 'constraint' => 180],
                'customer_phone' => ['type' => 'VARCHAR', 'constraint' => 20],
                'event_type' => ['type' => 'VARCHAR', 'constraint' => 120],
                'event_date' => ['type' => 'DATE', 'null' => true],
                'guests' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
                'amount' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
                'currency' => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'INR'],
                'payment_gateway' => ['type' => 'VARCHAR', 'constraint' => 40, 'null' => true],
                'payment_status' => ['type' => 'ENUM', 'constraint' => ['created', 'pending', 'paid', 'failed', 'cancelled'], 'default' => 'created'],
                'notes' => ['type' => 'TEXT', 'null' => true],
                'paid_at' => ['type' => 'DATETIME', 'null' => true],
                'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('payment_code');
            $this->forge->addKey('event_enquiry_id');
            $this->forge->createTable('event_payments', true);
        }

        if ($this->db->tableExists('payment_transactions')) {
            if ($this->db->fieldExists('booking_id', 'payment_transactions')) {
                $this->forge->modifyColumn('payment_transactions', [
                    'booking_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
                ]);
            }

            if (! $this->db->fieldExists('payment_for', 'payment_transactions')) {
                $this->forge->addColumn('payment_transactions', [
                    'payment_for' => [
                        'type' => 'ENUM',
                        'constraint' => ['booking', 'event'],
                        'default' => 'booking',
                        'after' => 'id',
                    ],
                ]);
            }

            if (! $this->db->fieldExists('event_payment_id', 'payment_transactions')) {
                $this->forge->addColumn('payment_transactions', [
                    'event_payment_id' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => true,
                        'null' => true,
                        'after' => 'booking_id',
                    ],
                ]);
            }
        }
    }

    public function down()
    {
        if ($this->db->tableExists('payment_transactions')) {
            foreach (['payment_for', 'event_payment_id'] as $column) {
                if ($this->db->fieldExists($column, 'payment_transactions')) {
                    $this->forge->dropColumn('payment_transactions', $column);
                }
            }
        }

        if ($this->db->tableExists('event_payments')) {
            $this->forge->dropTable('event_payments', true);
        }
    }
}
