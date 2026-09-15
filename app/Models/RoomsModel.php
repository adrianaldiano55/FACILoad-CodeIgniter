<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomsModel extends Model
{
    protected $table = 'rooms';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'room_code',
        'room_name',
        'room_time',
        'room_type',
        'room_size',
    ];

    protected $returnType = 'array';
}