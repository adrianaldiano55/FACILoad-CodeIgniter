<?php

namespace App\Models;

use CodeIgniter\Model;

class SectionsModel extends Model
{
    protected $table = 'sections';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sec_code',
        'sec_name',
        'sec_prog',
        'sec_size',
    ];

    protected $returnType = 'array';
}