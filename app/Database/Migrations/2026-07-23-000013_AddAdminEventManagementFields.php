<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAdminEventManagementFields extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('event_enquiries')) {
            return;
        }

        $this->forge->modifyColumn('event_enquiries', [
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['new', 'read', 'replied', 'confirmed', 'cancelled'],
                'default' => 'new',
            ],
        ]);

        $columns = [];

        if (! $this->db->fieldExists('source', 'event_enquiries')) {
            $columns['source'] = [
                'type' => 'ENUM',
                'constraint' => ['public', 'admin'],
                'default' => 'public',
                'after' => 'id',
            ];
        }

        if (! $this->db->fieldExists('created_by', 'event_enquiries')) {
            $columns['created_by'] = [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'status',
            ];
        }

        if ($columns !== []) {
            $this->forge->addColumn('event_enquiries', $columns);
        }
    }

    public function down(): void
    {
        if (! $this->db->tableExists('event_enquiries')) {
            return;
        }

        foreach (['source', 'created_by'] as $column) {
            if ($this->db->fieldExists($column, 'event_enquiries')) {
                $this->forge->dropColumn('event_enquiries', $column);
            }
        }

        $this->forge->modifyColumn('event_enquiries', [
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['new', 'read', 'replied'],
                'default' => 'new',
            ],
        ]);
    }
}
