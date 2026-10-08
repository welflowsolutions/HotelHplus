<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'name'              => 'Hotel Admin',
            'username'          => 'admin',
            'phone'             => '+91 92530 72122',
            'profile_photo'     => null,
            'email'             => 'admin@hotelhplus.in',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password'          => password_hash('Admin@123', PASSWORD_BCRYPT),
            'remember_token'    => null,
            'usertype'          => 'admin',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ];

        // Only insert if not already exists
        $exists = $this->db->table('users')
            ->groupStart()
                ->where('email', $data['email'])
                ->orWhere('username', $data['username'])
            ->groupEnd()
            ->countAllResults();

        if (! $exists) {
            $this->db->table('users')->insert($data);
            echo "Admin created: admin / Admin@123\n";
        } else {
            $this->db->table('users')
                ->groupStart()
                    ->where('email', $data['email'])
                    ->orWhere('username', $data['username'])
                ->groupEnd()
                ->update([
                    'name'              => $data['name'],
                    'username'          => $data['username'],
                    'phone'             => $data['phone'],
                    'email'             => $data['email'],
                    'email_verified_at' => $data['email_verified_at'],
                    'usertype'          => $data['usertype'],
                    'updated_at'        => $data['updated_at'],
                ]);
            echo "Admin already exists — user fields refreshed.\n";
        }

        // ── Default settings ──────────────────────────────────────────────
        $settings = [
            ['key' => 'hotel_name',    'value' => 'Hotel H Plus'],
            ['key' => 'hotel_phone',   'value' => '+91 92530 72122'],
            ['key' => 'hotel_email',   'value' => 'info@hotelhplus.in'],
            ['key' => 'hotel_address', 'value' => 'Opposite Sector-7, Pipli Road, Kurukshetra'],
        ];

        foreach ($settings as $s) {
            $exists = $this->db->table('settings')->where('key', $s['key'])->countAllResults();
            if (! $exists) {
                $s['updated_at'] = date('Y-m-d H:i:s');
                $this->db->table('settings')->insert($s);
            }
        }
        echo "Default settings seeded.\n";
    }
}
