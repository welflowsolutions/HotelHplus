<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailChangedAtToUsers extends Migration
{
    public function up(): void
    {
        if (! $this->db->fieldExists('email_changed_at', 'users')) {
            $this->forge->addColumn('users', [
                'email_changed_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'after' => 'email_verified_at',
                ],
            ]);
        }
    }

    public function down(): void
    {
        if ($this->db->fieldExists('email_changed_at', 'users')) {
            $this->forge->dropColumn('users', 'email_changed_at');
        }
    }
}
