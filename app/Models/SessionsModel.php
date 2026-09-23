<?php

namespace App\Models;

use CodeIgniter\Model;

class SessionsModel extends Model
{
    protected $table = 'sessions';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'faculty_id',
        'subject_id',
        'section_id',
        'room_id',
        'ses_type',
        'ses_units',
        'ses_day',
        'ses_start',
        'ses_end',
    ];

    protected $returnType = 'array';
}