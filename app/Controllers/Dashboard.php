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
    public function show_faculty()
    {
        $facultyModel = new UserModel();
        $faculty = $facultyModel
            ->where('role', 'faculty')
            ->findAll();
        return $this->response->setJSON($faculty);
    }
    public function show_room()
{
    $roomModel = new RoomsModel();
    $rooms = $roomModel->findAll();
    return $this->response->setJSON($rooms);
}
    public function show_section()
{
    $sectionModel = new SectionsModel();
    $sections = $sectionModel->findAll();
    return $this->response->setJSON($sections);
}
    public function show_faculty_schedule($faculty_id = null) {
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

    public function show_room_schedule($room_id = null) {
    if (!$room_id) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'status' => false,
                'message' => 'Room ID is required.'
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
        sessions.ses_units,
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
    $builder->join(
        'subjects',
        'subjects.id = loads.sub_id',
        'inner'
    );
    $builder->join(
        'sections',
        'sections.id = loads.section_id',
        'inner'
    );
    $builder->join(
        'rooms',
        'rooms.id = sessions.room_id',
        'inner'
    );
    $builder->where(
        'sessions.room_id',
        $room_id
    );
    $builder->orderBy(
        'sessions.ses_day',
        'ASC'
    );
    $builder->orderBy(
        'sessions.ses_start',
        'ASC'
    );
    $schedule = $builder
        ->get()
        ->getResultArray();
    return $this->response->setJSON($schedule);
}
public function show_section_schedule($section_id = null)
{
    if (!$section_id) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'status' => false,
                'message' => 'Section ID is required.'
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
    $builder->join(
        'subjects',
        'subjects.id = loads.sub_id',
        'inner'
    );
    $builder->join(
        'sections',
        'sections.id = loads.section_id',
        'inner'
    );
    $builder->join(
        'rooms',
        'rooms.id = sessions.room_id',
        'inner'
    );
    $builder->where(
        'loads.section_id',
        $section_id
    );
    $builder->orderBy(
        'sessions.ses_day',
        'ASC'
    );
    $builder->orderBy(
        'sessions.ses_start',
        'ASC'
    );
    $schedule = $builder
        ->get()
        ->getResultArray();
    return $this->response->setJSON($schedule);
}

    public function create_session()
    {
        $data = $this->request->getJSON(true);
        if (!$data) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' => 'Invalid request data.'
                ]);
        }
        $required = [
            'faculty_id',
            'load_id',
            'room_id',
            'ses_type',
            'ses_day',
            'ses_start',
            'ses_end'
        ];
        foreach ($required as $field) {
            if (
                !isset($data[$field]) ||
                $data[$field] === ''
            ) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON([
                        'success' => false,
                        'message' =>
                            "Missing field: {$field}"
                    ]);
            }
        }
        if (
            !in_array(
                $data['ses_type'],
                ['Lecture', 'Lab'],
                true
            )
        ) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' => 'Invalid session type.'
                ]);
        }
        $start = strtotime(
            $data['ses_start']
        );
        $end = strtotime(
            $data['ses_end']
        );
        if ($end <= $start) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        'End time must be later than start time.'
                ]);
        }
        $durationMinutes =
            ($end - $start) / 60;
        $sessionUnits =
            $durationMinutes / 60;
        $loadModel =
            new \App\Models\LoadsModel();
        $load =
            $loadModel->find(
                $data['load_id']
            );
        if (!$load) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'message' => 'Load not found.'
                ]);
        }
        if (
            (int)$load['user_id'] !==
            (int)$data['faculty_id']
        ) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        'The selected load does not belong to this faculty member.'
                ]);
        }
        $subjectModel =
            new \App\Models\SubjectsModel();
        $subject =
            $subjectModel->find(
                $load['subject_id']
            );
        if (!$subject) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'message' => 'Subject not found.'
                ]);
        }
        if ($data['ses_type'] === 'Lab') {
            $loadUnits =
                (float)$subject['sub_lab_units'];
        } else {
            $loadUnits =
                (float)$subject['sub_lec_units'];
        }
        if ($sessionUnits > $loadUnits) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        "Session requires {$sessionUnits} units, but only {$loadUnits} units are available."
                ]);
        }
        $db = \Config\Database::connect();
        $conflict = $db->table('sessions')
            ->where('room_id', $data['room_id'])
            ->where('ses_day', $data['ses_day'])
            ->where(
                "ses_start <",
                $data['ses_end']
            )
            ->where(
                "ses_end >",
                $data['ses_start']
            )
            ->get()
            ->getRowArray();
        if ($conflict) {
            return $this->response
                ->setStatusCode(409)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        'The selected room is already occupied during this time.'
                ]);
        }
        $sessionModel =
            new \App\Models\SessionsModel();
        $sessionModel->insert([
            'faculty_id' =>
                $data['faculty_id'],
            'load_id' =>
                $data['load_id'],
            'room_id' =>
                $data['room_id'],
            'ses_type' =>
                $data['ses_type'],
            'ses_units' =>
                $sessionUnits,
            'ses_day' =>
                $data['ses_day'],
            'ses_start' =>
                $data['ses_start'],
            'ses_end' =>
                $data['ses_end']
        ]);
        return $this->response
            ->setJSON([
                'success' => true,
                'message' =>
                    'Session created successfully.'
            ]);
    }
}