<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NormalizeAdminRoles extends Migration
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

        $owner = $this->db->table('users')->where('usertype', 'owner')->get()->getRowArray();

        if (! $owner) {
            $firstAdmin = $this->db->table('users')
                ->whereIn('usertype', ['admin', 'owner'])
                ->orderBy('id', 'ASC')
                ->get()
                ->getRowArray();

            if ($firstAdmin) {
                $this->db->table('users')->where('id', (int) $firstAdmin['id'])->update([
                    'usertype' => 'owner',
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function down(): void
    {
        if (! $this->db->tableExists('users')) {
            return;
        }

        $this->db->table('users')->where('usertype', 'owner')->update([
            'usertype' => 'admin',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
