<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SectionsModel;
use App\Models\RoomsModel;
use App\Models\LoadsModel;
use App\Models\SessionsModel;

class Dashboard extends BaseController
{
    public function admin()
    {
        return view('admin_dashboard');
    }
    public function faculty()
    {
        return view('faculty_dashboard');
    }
    // ==========================================
    // SHOW FACULTY
    // ==========================================
    public function show_faculty()
    {
        $facultyModel = new UserModel();
        $faculty = $facultyModel
            ->where('role', 'faculty')
            ->findAll();
        return $this->response->setJSON($faculty);
    }
    // ==========================================
    // SHOW FACULTY SCHEDULE
    // ==========================================
    public function show_faculty_schedule($faculty_id = null)
    {
        if (!$faculty_id) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'status' => false,
                    'message' => 'Faculty ID is required.'
                ]);
        }
        $db = \Config\Database::connect();
        $builder = $db->table('loads');
        $builder->select('
            loads.id AS load_id,
            loads.faculty_id,
            loads.sub_id,
            loads.section_id,
            sessions.id AS session_id,
            sessions.room_id,
            sessions.sec_units,
            sessions.ses_day,
            sessions.ses_start,
            sessions.ses_end,
            users.username,
            users.login_id,
            subjects.sub_code,
            subjects.sub_name,
            sections.sec_code,
            sections.sec_name,
            rooms.room_code,
            rooms.room_name
        ');
        $builder->join(
            'sessions',
            'sessions.load_id = loads.id',
            'inner'
        );
        $builder->join(
            'users',
            'users.id = loads.faculty_id',
            'inner'
        );
        $builder->join('subjects', 'subjects.id = loads.sub_id', 'inner');
        $builder->join('sections', 'sections.id = loads.section_id', 'inner');
        $builder->join('rooms', 'rooms.id = sessions.room_id', 'inner');
        $builder->where(
            'loads.faculty_id',
            $faculty_id
        );
        $builder->orderBy(
            'sessions.ses_day',
            'ASC'
        );
        $builder->orderBy(
            'sessions.ses_start',
            'ASC'
        );
        $schedule = $builder->get()->getResultArray();
        return $this->response->setJSON($schedule);
    }
}