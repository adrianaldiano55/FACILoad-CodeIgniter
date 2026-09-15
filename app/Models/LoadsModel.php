<?php

namespace App\Models;

use CodeIgniter\Model;

class LoadsModel extends Model
{
    protected $table = 'loads';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_id',
        'sub_id',
        'section_id',
    ];

    protected $returnType = 'array';
}