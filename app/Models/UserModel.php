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
        'department',
        'college',
        'academic_rank',
        'total_lab_units',
        'total_lec_units',
        'total_extra_units',
        'login_at',
        'logout_at',
    ];

    protected $returnType = 'array';
}