<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'login_id',
        'username',
        'email',
        'hash_password',
        'role',
        'login_at',
        'logout_at',
        'sec_id',
        'total_units',
    ];

    protected $returnType = 'array';
}