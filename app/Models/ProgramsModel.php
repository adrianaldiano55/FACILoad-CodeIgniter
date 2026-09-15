<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramsModel extends Model
{
    protected $table = 'programs';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'pro_code',
        'pro_name',
        'pro_year',
        'pro_sem',
        'status',
    ];

    protected $returnType = 'array';
}