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
        ->select('
            id,
            login_id,
            username,
            email,
            academic_rank,
            college,
            department,
            total_lab_units,
            total_lec_units,
            total_extra_units
        ')
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
    $builder = $db->table('sessions');
    $builder->select('
        sessions.id AS session_id,
        sessions.faculty_id,
        sessions.subject_id,
        sessions.section_id,
        sessions.room_id,
        sessions.ses_type,
        sessions.ses_units,
        sessions.ses_day,
        sessions.ses_start,
        sessions.ses_end,

        users.username,
        users.login_id,
        users.academic_rank,
        users.college,
        users.department,

        subjects.sub_code,
        subjects.sub_name,

        sections.sec_code,
        sections.sec_name,

        rooms.room_code,
        rooms.room_name
    ');
    $builder->join(
        'users',
        'users.id = sessions.faculty_id',
        'inner'
    );
    $builder->join(
        'subjects',
        'subjects.id = sessions.subject_id',
        'inner'
    );
    $builder->join(
        'sections',
        'sections.id = sessions.section_id',
        'inner'
    );
    $builder->join(
        'rooms',
        'rooms.id = sessions.room_id',
        'inner'
    );
    $builder->where(
        'sessions.faculty_id',
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
    $schedule = $builder
        ->get()
        ->getResultArray();
    return $this->response->setJSON($schedule);
}

public function show_room_schedule($room_id = null)
{
    if (!$room_id) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'status' => false,
                'message' => 'Room ID is required.'
            ]);
    }
    $db = \Config\Database::connect();
    $builder = $db->table('sessions');
    $builder->select('
        sessions.id AS session_id,
        sessions.faculty_id,
        sessions.subject_id,
        sessions.section_id,
        sessions.room_id,
        sessions.ses_type,
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
        'users',
        'users.id = sessions.faculty_id',
        'inner'
    );
    $builder->join(
        'subjects',
        'subjects.id = sessions.subject_id',
        'inner'
    );
    $builder->join(
        'sections',
        'sections.id = sessions.section_id',
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
    $builder = $db->table('sessions');
    $builder->select('
        sessions.id AS session_id,
        sessions.faculty_id,
        sessions.subject_id,
        sessions.section_id,
        sessions.room_id,
        sessions.ses_type,
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
        'users',
        'users.id = sessions.faculty_id',
        'inner'
    );
    $builder->join(
        'subjects',
        'subjects.id = sessions.subject_id',
        'inner'
    );
    $builder->join(
        'sections',
        'sections.id = sessions.section_id',
        'inner'
    );
    $builder->join(
        'rooms',
        'rooms.id = sessions.room_id',
        'inner'
    );
    $builder->where(
        'sessions.section_id',
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
        /*
        * Required fields
        */
        $required = [
            'faculty_id',
            'subject_id',
            'section_id',
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
        /*
        * Validate session type
        */
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
                    'message' =>
                        'Invalid session type.'
                ]);
        }
        /*
        * Validate time
        */
        $start = strtotime(
            $data['ses_start']
        );
        $end = strtotime(
            $data['ses_end']
        );
        if (
            $start === false ||
            $end === false
        ) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        'Invalid session time.'
                ]);
        }
        if ($end <= $start) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        'End time must be later than start time.'
                ]);
        }
        /*
        * Restrict schedule to 7:00 AM - 8:30 PM
        */
        $startMinutes =
            ((int)date('H', $start) * 60) +
            (int)date('i', $start);
        $endMinutes =
            ((int)date('H', $end) * 60) +
            (int)date('i', $end);
        if (
            $startMinutes < 420 ||
            $endMinutes > 1230
        ) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        'Sessions must be scheduled between 7:00 AM and 8:30 PM.'
                ]);
        }
        /*
        * Calculate session hours
        */
        $durationMinutes =
            ($end - $start) / 60;
        $sessionHours =
            $durationMinutes / 60;
        /*
        * Validate Faculty
        */
        $userModel =
            new \App\Models\UserModel();
        $faculty =
            $userModel
                ->where('id', $data['faculty_id'])
                ->where('role', 'faculty')
                ->first();
        if (!$faculty) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        'Faculty member not found.'
                ]);
        }
        /*
        * Validate Subject
        */
        $subjectModel =
            new \App\Models\SubjectsModel();
        $subject =
            $subjectModel->find(
                $data['subject_id']
            );
        if (!$subject) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        'Subject not found.'
                ]);
        }
        /*
        * Validate Section
        */
        $sectionModel =
            new \App\Models\SectionsModel();
        $section =
            $sectionModel->find(
                $data['section_id']
            );
        if (!$section) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        'Section not found.'
                ]);
        }
        /*
        * Validate Room
        */
        $roomModel =
            new \App\Models\RoomsModel();
        $room =
            $roomModel->find(
                $data['room_id']
            );
        if (!$room) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        'Room not found.'
                ]);
        }
        /*
        * Determine available subject hours
        */
        if ($data['ses_type'] === 'Lab') {
            $subjectHours =
                (float)(
                    $subject['sub_lab_hours'] ?? 0
                );
        } else {
            $subjectHours =
                (float)(
                    $subject['sub_lec_hours'] ?? 0
                );
        }
        /*
        * Validate session duration
        */
        if ($sessionHours > $subjectHours) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        "Session requires {$sessionHours} hours, but only {$subjectHours} hours are available for this session type."
                ]);
        }
        /*
        * Check room availability
        */
        $db =
            \Config\Database::connect();
        $roomConflict =
            $db->table('sessions')
                ->where(
                    'room_id',
                    $data['room_id']
                )
                ->where(
                    'ses_day',
                    $data['ses_day']
                )
                ->where(
                    'ses_start <',
                    $data['ses_end']
                )
                ->where(
                    'ses_end >',
                    $data['ses_start']
                )
                ->get()
                ->getRowArray();
        if ($roomConflict) {
            return $this->response
                ->setStatusCode(409)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        'The selected room is already occupied during this time.'
                ]);
        }
        /*
        * Check faculty availability
        */
        $facultyConflict =
            $db->table('sessions')
                ->where(
                    'faculty_id',
                    $data['faculty_id']
                )
                ->where(
                    'ses_day',
                    $data['ses_day']
                )
                ->where(
                    'ses_start <',
                    $data['ses_end']
                )
                ->where(
                    'ses_end >',
                    $data['ses_start']
                )
                ->get()
                ->getRowArray();
        if ($facultyConflict) {
            return $this->response
                ->setStatusCode(409)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        'The selected faculty member already has a session during this time.'
                ]);
        }
        /*
        * Check section availability
        */
        $sectionConflict =
            $db->table('sessions')
                ->where(
                    'section_id',
                    $data['section_id']
                )
                ->where(
                    'ses_day',
                    $data['ses_day']
                )
                ->where(
                    'ses_start <',
                    $data['ses_end']
                )
                ->where(
                    'ses_end >',
                    $data['ses_start']
                )
                ->get()
                ->getRowArray();
        if ($sectionConflict) {
            return $this->response
                ->setStatusCode(409)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        'The selected section already has a session during this time.'
                ]);
        }
        /*
        * Create Session
        */
        $sessionModel =
            new \App\Models\SessionsModel();
        $inserted =
            $sessionModel->insert([
                'faculty_id' =>
                    $data['faculty_id'],
                'subject_id' =>
                    $data['subject_id'],
                'section_id' =>
                    $data['section_id'],
                'room_id' =>
                    $data['room_id'],
                'ses_type' =>
                    $data['ses_type'],
                'ses_units' =>
                    $sessionHours,
                'ses_day' =>
                    $data['ses_day'],
                'ses_start' =>
                    $data['ses_start'],
                'ses_end' =>
                    $data['ses_end']
            ]);
        if (!$inserted) {
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'message' =>
                        'Failed to create session.'
                ]);
        }
        return $this->response
            ->setJSON([
                'success' => true,
                'message' =>
                    'Session created successfully.'
            ]);
    }
}