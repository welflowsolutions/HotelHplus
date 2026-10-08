<?php

namespace App\Models;

use CodeIgniter\Model;

class SeoPageModel extends Model
{
    protected $table = 'seo_pages';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'route_key',
        'route_label',
        'route_path',
        'route_handler',
        'scan_status',
        'last_scanned_at',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
