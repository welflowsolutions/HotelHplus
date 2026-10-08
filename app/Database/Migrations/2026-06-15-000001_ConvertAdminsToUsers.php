<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ConvertAdminsToUsers extends Migration
{
    public function up(): void
    {
        if ($this->db->tableExists('admins') && ! $this->db->tableExists('users')) {
            $this->forge->renameTable('admins', 'users');
        }

        if (! $this->db->tableExists('users')) {
            return;
        }

        $fields = $this->db->getFieldNames('users');

        if (! in_array('username', $fields, true)) {
            $this->forge->addColumn('users', [
                'username' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 80,
                    'null'       => true,
                    'after'      => 'name',
                ],
            ]);
        }

        if (! in_array('phone', $fields, true)) {
            $this->forge->addColumn('users', [
                'phone' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'null'       => true,
                    'after'      => 'username',
                ],
            ]);
        }

        if (! in_array('profile_photo', $fields, true)) {
            $this->forge->addColumn('users', [
                'profile_photo' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'phone',
                ],
            ]);
        }

        if (! in_array('email_verified_at', $fields, true)) {
            $this->forge->addColumn('users', [
                'email_verified_at' => [
                    'type'  => 'DATETIME',
                    'null'  => true,
                    'after' => 'email',
                ],
            ]);
        }

        if (! in_array('remember_token', $fields, true)) {
            $this->forge->addColumn('users', [
                'remember_token' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                    'after'      => 'password',
                ],
            ]);
        }

        if (! in_array('usertype', $fields, true)) {
            $this->forge->addColumn('users', [
                'usertype' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 30,
                    'null'       => false,
                    'default'    => 'admin',
                    'after'      => 'remember_token',
                ],
            ]);
        }

        $this->db->table('users')
            ->groupStart()
                ->where('username', null)
                ->orWhere('username', '')
            ->groupEnd()
            ->update(['username' => 'admin']);

        $this->forge->modifyColumn('users', [
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => false,
            ],
        ]);

        if (! $this->hasIndex('users', 'users_username_unique')) {
            $this->db->query('ALTER TABLE `users` ADD UNIQUE KEY `users_username_unique` (`username`)');
        }
    }

    public function down(): void
    {
        if ($this->db->tableExists('users') && ! $this->db->tableExists('admins')) {
            $this->forge->renameTable('users', 'admins');
        }
    }

    private function hasIndex(string $table, string $indexName): bool
    {
        $rows = $this->db->query('SHOW INDEX FROM `' . $table . '` WHERE Key_name = ' . $this->db->escape($indexName))
            ->getResultArray();

        return $rows !== [];
    }
}
