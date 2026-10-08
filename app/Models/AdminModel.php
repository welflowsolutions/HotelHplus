<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'name',
        'username',
        'phone',
        'profile_photo',
        'email',
        'email_verified_at',
        'email_changed_at',
        'password',
        'remember_token',
        'last_login_at',
        'last_login_ip',
        'usertype',
    ];
    protected $useTimestamps  = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
