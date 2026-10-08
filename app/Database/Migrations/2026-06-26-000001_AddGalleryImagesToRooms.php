<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGalleryImagesToRooms extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('rooms') || $this->db->fieldExists('gallery_images', 'rooms')) {
            return;
        }

        $this->forge->addColumn('rooms', [
            'gallery_images' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'image',
                'comment' => 'JSON array',
            ],
        ]);
    }

    public function down(): void
    {
        if (! $this->db->tableExists('rooms') || ! $this->db->fieldExists('gallery_images', 'rooms')) {
            return;
        }

        $this->forge->dropColumn('rooms', 'gallery_images');
    }
}
