<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'user_id';

    protected $allowedFields = [
        'username',
        'email',
        'hash_password',
        'role',
        'logged_at'
    ];

    protected $returnType = 'array';
}