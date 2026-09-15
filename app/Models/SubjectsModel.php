<?php

namespace App\Models;

use CodeIgniter\Model;

class SubjectsModel extends Model
{
    protected $table = 'subjects';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sub_code',
        'sub_name',
        'sub_program',
        'sub_sem',
        'sub_lab_units',
        'sub_lec_units',
    ];

    protected $returnType = 'array';
}