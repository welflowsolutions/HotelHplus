<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminTables extends Migration
{
    public function up(): void
    {
        // ── users ─────────────────────────────────────────────────────────
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'              => ['type' => 'VARCHAR', 'constraint' => 120],
            'username'          => ['type' => 'VARCHAR', 'constraint' => 80, 'unique' => true],
            'phone'             => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'profile_photo'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'email'             => ['type' => 'VARCHAR', 'constraint' => 180, 'unique' => true],
            'email_verified_at' => ['type' => 'DATETIME', 'null' => true],
            'email_changed_at'  => ['type' => 'DATETIME', 'null' => true],
            'password'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'remember_token'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'usertype'          => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'admin'],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users', true);

        // ── rooms ─────────────────────────────────────────────────────────
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 120],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 120, 'unique' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'price'       => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'max_guests'  => ['type' => 'TINYINT', 'constraint' => 3, 'default' => 2],
            'amenities'   => ['type' => 'TEXT', 'null' => true, 'comment' => 'JSON array'],
            'image'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'sort_order'  => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('rooms', true);

        // ── enquiries (contact form) ──────────────────────────────────────
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'first_name' => ['type' => 'VARCHAR', 'constraint' => 80],
            'last_name'  => ['type' => 'VARCHAR', 'constraint' => 80],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 180],
            'phone'      => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'subject'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'message'    => ['type' => 'TEXT'],
            'room_type'  => ['type' => 'VARCHAR', 'constraint' => 80, 'null' => true],
            'checkin'    => ['type' => 'DATE', 'null' => true],
            'checkout'   => ['type' => 'DATE', 'null' => true],
            'status'     => ['type' => 'ENUM', 'constraint' => ['new', 'read', 'replied'], 'default' => 'new'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('enquiries', true);

        // ── bookings ──────────────────────────────────────────────────────
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 160],
            'phone'       => ['type' => 'VARCHAR', 'constraint' => 20],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 180, 'null' => true],
            'room_type'   => ['type' => 'VARCHAR', 'constraint' => 80],
            'checkin'     => ['type' => 'DATE'],
            'checkout'    => ['type' => 'DATE'],
            'guests'      => ['type' => 'TINYINT', 'constraint' => 3, 'default' => 2],
            'status'      => ['type' => 'ENUM', 'constraint' => ['pending', 'confirmed', 'cancelled'], 'default' => 'pending'],
            'notes'       => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('bookings', true);

        // ── gallery ───────────────────────────────────────────────────────
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'filename'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'caption'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'category'   => ['type' => 'ENUM', 'constraint' => ['all', 'rooms', 'lobby', 'exterior', 'dining'], 'default' => 'all'],
            'sort_order' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('gallery', true);

        // ── trident_enquiries ─────────────────────────────────────────────
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 160],
            'phone'        => ['type' => 'VARCHAR', 'constraint' => 20],
            'email'        => ['type' => 'VARCHAR', 'constraint' => 180],
            'event_type'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'event_date'   => ['type' => 'DATE', 'null' => true],
            'guests'       => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'message'      => ['type' => 'TEXT', 'null' => true],
            'status'       => ['type' => 'ENUM', 'constraint' => ['new', 'read', 'replied'], 'default' => 'new'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('trident_enquiries', true);

        // ── settings ──────────────────────────────────────────────────────
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'key'        => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'value'      => ['type' => 'TEXT', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('settings', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('users',             true);
        $this->forge->dropTable('rooms',             true);
        $this->forge->dropTable('enquiries',         true);
        $this->forge->dropTable('bookings',          true);
        $this->forge->dropTable('gallery',           true);
        $this->forge->dropTable('trident_enquiries', true);
        $this->forge->dropTable('settings',          true);
    }
}
