<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TightenUsersUsertype extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('users')) {
            return;
        }

        $this->db->table('users')
            ->groupStart()
                ->where('usertype', null)
                ->orWhere('usertype', '')
            ->groupEnd()
            ->update(['usertype' => 'admin']);

        $this->forge->modifyColumn('users', [
            'usertype' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => false,
                'default'    => 'admin',
            ],
        ]);
    }

    public function down(): void
    {
        if (! $this->db->tableExists('users')) {
            return;
        }

        $this->forge->modifyColumn('users', [
            'usertype' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
                'default'    => 'admin',
            ],
        ]);
    }
}
