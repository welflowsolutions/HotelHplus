<?php

namespace App\Models;

use CodeIgniter\Model;

class MediaFileModel extends Model
{
    protected $table = 'media_files';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'file_name',
        'original_file_name',
        'original_name',
        'path',
        'original_path',
        'mime_type',
        'original_mime_type',
        'size',
        'original_size',
        'alt_text',
        'width',
        'height',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
