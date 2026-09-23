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
        'sub_year',
        'sub_sem',
        'sub_lab_hours',
        'sub_lec_hours',
        'sub_total_hours'
    ];

    protected $returnType = 'array';
}