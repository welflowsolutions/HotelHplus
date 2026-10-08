<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMediaEditFields extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('media_files')) {
            return;
        }

        $fields = [
            'original_file_name' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'file_name'],
            'original_path'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'path'],
            'original_mime_type' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true, 'after' => 'mime_type'],
            'original_size'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'size'],
            'width'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'alt_text'],
            'height'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'width'],
        ];

        $this->forge->addColumn('media_files', $fields);

        $builder = $this->db->table('media_files');

        foreach ($builder->get()->getResultArray() as $file) {
            $path = (string) ($file['path'] ?? '');
            $absolutePath = FCPATH . $path;
            $width = null;
            $height = null;

            if ($path !== '' && is_file($absolutePath)) {
                $size = @getimagesize($absolutePath);
                if (is_array($size)) {
                    $width = isset($size[0]) ? (int) $size[0] : null;
                    $height = isset($size[1]) ? (int) $size[1] : null;
                }
            }

            $builder->where('id', $file['id'])->update([
                'original_file_name' => $file['file_name'] ?? null,
                'original_path'      => $path !== '' ? $path : null,
                'original_mime_type' => $file['mime_type'] ?? null,
                'original_size'      => $file['size'] ?? null,
                'width'              => $width,
                'height'             => $height,
            ]);
        }
    }

    public function down(): void
    {
        if (! $this->db->tableExists('media_files')) {
            return;
        }

        $this->forge->dropColumn('media_files', [
            'original_file_name',
            'original_path',
            'original_mime_type',
            'original_size',
            'width',
            'height',
        ]);
    }
}
