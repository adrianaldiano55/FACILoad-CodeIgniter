<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SectionsModel;
use App\Models\RoomsModel;
use App\Models\SubjectsModel;
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

// GENERAL FUNCTIONS
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
public function show_sections()
{
    $sectionsModel = new SectionsModel();
    $sections = $sectionsModel
        ->orderBy('sec_code', 'ASC')
        ->findAll();
    return $this->response
        ->setJSON($sections);
}

public function show_subjects()
{
    $subjectsModel = new SubjectsModel();
    return $this->response->setJSON(
        $subjectsModel->findAll()
    );
}
// SCHEDULE MANAGEMENT
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
        sessions.id AS id,
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
        sessions.id AS id,
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
        sessions.id AS id,
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

public function get_session($id = null)
{
    if (!$id) {
        return $this->response->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Session ID is required.'
            ]);
    }
    $sessionsModel = new SessionsModel();
    $session = $sessionsModel->find($id);
    if (!$session) {
        return $this->response->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Session not found.'
            ]);
    }
    return $this->response->setJSON($session);
}

public function update_session($id = null)
{
    if (!$id) {
        return $this->response->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Session ID is required.'
            ]);
    }
    $data = $this->request->getJSON(true);
    if (!$data) {
        return $this->response->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Invalid session data.'
            ]);
    }
    $sessionsModel = new SessionsModel();
    $session = $sessionsModel->find($id);
    if (!$session) {
        return $this->response->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Session not found.'
            ]);
    }
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
        if (!isset($data[$field]) || $data[$field] === '') {
            return $this->response->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' => "Missing field: {$field}"
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
            ->where('id !=', $id)
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
            ->where('id !=', $id)
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
            ->where('id !=', $id)
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
    $updateData = [
        'faculty_id' => $data['faculty_id'],
        'subject_id' => $data['subject_id'],
        'section_id' => $data['section_id'],
        'room_id'    => $data['room_id'],
        'ses_type'   => $data['ses_type'],
        'ses_units'  => $sessionHours,
        'ses_day'    => $data['ses_day'],
        'ses_start'  => $data['ses_start'],
        'ses_end'    => $data['ses_end']
    ];
    $sessionsModel = new SessionsModel();
    if (!$sessionsModel->update($id, $updateData)) {
        return $this->response->setStatusCode(500)
            ->setJSON([
                'success' => false,
                'message' => 'Unable to update session.',
            ]);
    }
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Session updated successfully.'
    ]);
}

public function delete_session($id = null)
{
    if (!$id) {
        return $this->response->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Session ID is required.'
            ]);
    }
    $sessionsModel = new SessionsModel();
    $session = $sessionsModel->find($id);
    if (!$session) {
        return $this->response->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Session not found.'
            ]);
    }
    if (!$sessionsModel->delete($id)) {
        return $this->response->setStatusCode(500)
            ->setJSON([
                'success' => false,
                'message' => 'Unable to delete session.'
            ]);
    }
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Session deleted successfully.'
    ]);
}

// SUBJECT MANAGEMENT

public function create_subject()
{
    $subjectsModel = new SubjectsModel();
    $labHours = (float) $this->request->getPost('sub_lab_hours');
    $lecHours = (float) $this->request->getPost('sub_lec_hours');
    $data = [
        'sub_code'        => $this->request->getPost('sub_code'),
        'sub_name'        => $this->request->getPost('sub_name'),
        'sub_program'     => $this->request->getPost('sub_program'),
        'sub_year'        => $this->request->getPost('sub_year'),
        'sub_sem'         => $this->request->getPost('sub_sem'),
        'sub_lab_hours'   => $labHours,
        'sub_lec_hours'   => $lecHours,
        'sub_total_hours' => $labHours + $lecHours
    ];
    if (!$subjectsModel->insert($data)) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'errors' => $subjectsModel->errors()
            ]);
    }
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Subject added successfully.'
    ]);
}

public function get_subject($id = null)
{
    if (!$id) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Subject ID is required.'
            ]);
    }

    $subjectsModel = new SubjectsModel();

    $subject = $subjectsModel->find($id);

    if (!$subject) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Subject not found.'
            ]);
    }

    return $this->response->setJSON($subject);
}

public function update_subject($id = null)
{
    if (!$id) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Subject ID is required.'
            ]);
    }
    $subjectsModel = new SubjectsModel();
    $labHours = (float) $this->request->getPost('sub_lab_hours');
    $lecHours = (float) $this->request->getPost('sub_lec_hours');
    $data = [
        'sub_code'        => $this->request->getPost('sub_code'),
        'sub_name'        => $this->request->getPost('sub_name'),
        'sub_program'     => $this->request->getPost('sub_program'),
        'sub_year'        => $this->request->getPost('sub_year'),
        'sub_sem'         => $this->request->getPost('sub_sem'),
        'sub_lab_hours'   => $labHours,
        'sub_lec_hours'   => $lecHours,
        'sub_total_hours' => $labHours + $lecHours
    ];
    if (!$subjectsModel->update($id, $data)) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'errors' => $subjectsModel->errors()
            ]);
    }
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Subject updated successfully.'
    ]);
}

public function delete_subject($id = null)
{
    if (!$id) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Subject ID is required.'
            ]);
    }
    $subjectsModel = new SubjectsModel();
    if (!$subjectsModel->find($id)) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Subject not found.'
            ]);
    }

    $subjectsModel->delete($id);

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Subject deleted successfully.'
    ]);
}

// SECTION MANAGEMENT

public function create_section()
{
    $sectionsModel = new SectionsModel();
    $data = [
        'sec_code' => trim($this->request->getPost('sec_code')),
        'sec_name' => trim($this->request->getPost('sec_name')),
        'sec_prog' => trim($this->request->getPost('sec_prog')),
        'sec_size' => $this->request->getPost('sec_size'),
        'sec_year' => trim($this->request->getPost('sec_year'))
    ];
    if (
        empty($data['sec_code']) ||
        empty($data['sec_name']) ||
        empty($data['sec_prog']) ||
        empty($data['sec_year']) ||
        $data['sec_size'] === null ||
        $data['sec_size'] === ''
    ) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Please complete all section fields.'
            ]);
    }
    if (!$sectionsModel->insert($data)) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Unable to create section.',
                'errors' => $sectionsModel->errors()
            ]);
    }
    return $this->response
        ->setJSON([
            'success' => true,
            'message' => 'Section created successfully.'
        ]);
}

public function get_section($id)
{
    $sectionsModel = new SectionsModel();
    $section = $sectionsModel->find($id);
    if (!$section) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Section not found.'
            ]);
    }
    return $this->response
        ->setJSON($section);
}

public function update_section($id)
{
    $sectionsModel = new SectionsModel();
    $section = $sectionsModel->find($id);
    if (!$section) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Section not found.'
            ]);
    }
    $data = [
        'sec_code' => trim($this->request->getPost('sec_code')),
        'sec_name' => trim($this->request->getPost('sec_name')),
        'sec_prog' => trim($this->request->getPost('sec_prog')),
        'sec_size' => $this->request->getPost('sec_size'),
        'sec_year' => trim($this->request->getPost('sec_year'))
    ];
    if (
        empty($data['sec_code']) ||
        empty($data['sec_name']) ||
        empty($data['sec_prog']) ||
        empty($data['sec_year']) ||
        $data['sec_size'] === null ||
        $data['sec_size'] === ''
    ) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Please complete all section fields.'
            ]);
    }
    if (!$sectionsModel->update($id, $data)) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Unable to update section.',
                'errors' => $sectionsModel->errors()
            ]);
    }
    return $this->response
        ->setJSON([
            'success' => true,
            'message' => 'Section updated successfully.'
        ]);
}

public function delete_section($id)
{
    $sectionsModel = new SectionsModel();
    $section = $sectionsModel->find($id);
    if (!$section) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Section not found.'
            ]);
    }
    if (!$sectionsModel->delete($id)) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Unable to delete section.'
            ]);
    }
    return $this->response
        ->setJSON([
            'success' => true,
            'message' => 'Section deleted successfully.'
        ]);
}

// FACULTY MANAGEMENT
public function get_faculty($id = null)
{
    if (!$id) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Faculty ID is required.'
            ]);
    }
    $facultyModel = new UserModel();
    $faculty = $facultyModel
        ->where('id', $id)
        ->where('role', 'faculty')
        ->first();
    if (!$faculty) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Faculty member not found.'
            ]);
    }
    return $this->response->setJSON($faculty);
}

public function create_faculty()
{
    $facultyModel = new UserModel();
    $data = [
        'login_id'          => trim($this->request->getPost('login_id')),
        'username'          => trim($this->request->getPost('username')),
        'email'             => trim($this->request->getPost('email')),
        'academic_rank'     => trim($this->request->getPost('academic_rank')),
        'college'           => trim($this->request->getPost('college')),
        'department'        => trim($this->request->getPost('department')),
        'total_lab_units'   => (float) $this->request->getPost('total_lab_units'),
        'total_lec_units'   => (float) $this->request->getPost('total_lec_units'),
        'total_extra_units' => (float) $this->request->getPost('total_extra_units'),
        'role'              => 'faculty'
    ];
    $password = $this->request->getPost('password');
    if (!empty($password)) {
        $data['hash_password'] = password_hash(
            $password,
            PASSWORD_DEFAULT
        );
    }
    // Required fields
    if (
        empty($data['login_id']) ||
        empty($data['username']) ||
        empty($data['email']) ||
        empty($data['academic_rank']) ||
        empty($data['college']) ||
        empty($data['department'])
    ) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Please complete all required faculty fields.'
            ]);
    }
    if (!$facultyModel->insert($data)) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Unable to create faculty.',
                'errors' => $facultyModel->errors()
            ]);
    }
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Faculty added successfully.'
    ]);
}

public function update_faculty($id = null)
{
    if (!$id) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Faculty ID is required.'
            ]);
    }
    $facultyModel = new UserModel();
    $faculty = $facultyModel
        ->where('id', $id)
        ->where('role', 'faculty')
        ->first();
    if (!$faculty) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Faculty member not found.'
            ]);
    }
    $data = [
        'login_id'          => trim($this->request->getPost('login_id')),
        'username'          => trim($this->request->getPost('username')),
        'email'             => trim($this->request->getPost('email')),
        'academic_rank'     => trim($this->request->getPost('academic_rank')),
        'college'           => trim($this->request->getPost('college')),
        'department'        => trim($this->request->getPost('department')),
        'total_lab_units'   => (float) $this->request->getPost('total_lab_units'),
        'total_lec_units'   => (float) $this->request->getPost('total_lec_units'),
        'total_extra_units' => (float) $this->request->getPost('total_extra_units')
    ];
    // Only change password if a new one was provided
    $password = $this->request->getPost('password');
    if (!empty($password)) {
        $data['hash_password'] = password_hash(
            $password,
            PASSWORD_DEFAULT
        );
    }
    if (!$facultyModel->update($id, $data)) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Unable to update faculty.',
                'errors' => $facultyModel->errors()
            ]);
    }
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Faculty updated successfully.'
    ]);
}

public function delete_faculty($id = null)
{
    if (!$id) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Faculty ID is required.'
            ]);
    }
    $facultyModel = new UserModel();
    $faculty = $facultyModel
        ->where('id', $id)
        ->where('role', 'faculty')
        ->first();
    if (!$faculty) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Faculty member not found.'
            ]);
    }
    if (!$facultyModel->delete($id)) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Unable to delete faculty.'
            ]);
    }
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Faculty deleted successfully.'
    ]);
}

// ROOM MANAGEMENT

public function get_room($id = null)
{
    if (!$id) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Room ID is required.'
            ]);
    }

    $roomModel = new RoomsModel();

    $room = $roomModel->find($id);

    if (!$room) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Room not found.'
            ]);
    }

    return $this->response->setJSON($room);
}

public function create_room()
{
    $roomModel = new RoomsModel();

    $data = [
        'room_code'   => trim($this->request->getPost('room_code')),
        'room_name'   => trim($this->request->getPost('room_name')),
        'room_type'   => trim($this->request->getPost('room_type')),
        'room_time'   => trim($this->request->getPost('room_time')),
        'room_size'   => $this->request->getPost('room_size')
    ];

    if (
        $data['room_code'] === '' ||
        $data['room_name'] === '' ||
        $data['room_type'] === '' ||
        $data['room_time'] === '' ||
        $data['room_size'] === '' ||
        $data['room_size'] === null
    ) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Please complete all required room fields.'
            ]);
    }

    $data['room_size'] = (int) $data['room_size'];

    if (!$roomModel->insert($data)) {

        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Unable to create room.',
                'errors' => $roomModel->errors()
            ]);
    }

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Room added successfully.'
    ]);
}

public function update_room($id = null)
{
    if (!$id) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Room ID is required.'
            ]);
    }

    $roomModel = new RoomsModel();

    $room = $roomModel->find($id);

    if (!$room) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Room not found.'
            ]);
    }

    $data = [
        'room_code'   => trim($this->request->getPost('room_code')),
        'room_name'   => trim($this->request->getPost('room_name')),
        'room_type'   => trim($this->request->getPost('room_type')),
        'room_time'   => trim($this->request->getPost('room_time')),
        'room_size'   => $this->request->getPost('room_size')
    ];

    if (
        $data['room_code'] === '' ||
        $data['room_name'] === '' ||
        $data['room_type'] === '' ||
        $data['room_time'] === '' ||
        $data['room_size'] === '' ||
        $data['room_size'] === null
    ) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Please complete all required room fields.'
            ]);
    }

    $data['room_size'] = (int) $data['room_size'];

    if (!$roomModel->update($id, $data)) {

        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Unable to update room.',
                'errors' => $roomModel->errors()
            ]);
    }

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Room updated successfully.'
    ]);
}

public function delete_room($id = null)
{
    if (!$id) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Room ID is required.'
            ]);
    }

    $roomModel = new RoomsModel();

    $room = $roomModel->find($id);

    if (!$room) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Room not found.'
            ]);
    }

    if (!$roomModel->delete($id)) {

        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Unable to delete room.'
            ]);
    }

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Room deleted successfully.'
    ]);
}

public function get_my_schedule()
{
    $facultyId = session()->get('id');
    if (!$facultyId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Not authenticated.'
        ]);
    }
    $db = \Config\Database::connect();
    $builder = $db->table('sessions');
    $builder->select('
        sessions.id,
        sessions.faculty_id,
        sessions.ses_type,
        sessions.ses_units,
        sessions.ses_day,
        sessions.ses_start,
        sessions.ses_end,
        subjects.sub_code,
        subjects.sub_name,
        sections.sec_code,
        sections.sec_name,
        rooms.room_name
    ');
    $builder->join(
        'subjects',
        'subjects.id = sessions.subject_id',
        'left'
    );
    $builder->join(
        'sections',
        'sections.id = sessions.section_id',
        'left'
    );
    $builder->join(
        'rooms',
        'rooms.id = sessions.room_id',
        'left'
    );
    // VERY IMPORTANT:
    // Only retrieve the logged-in faculty's sessions.
    $builder->where(
        'sessions.faculty_id',
        $facultyId
    );
    $builder->orderBy('sessions.ses_day', 'ASC');
    $builder->orderBy('sessions.ses_start', 'ASC');
    $schedule = $builder->get()->getResultArray();
    return $this->response->setJSON([
        'success' => true,
        'data' => $schedule
    ]);
}

public function get_my_profile()
{
    $facultyId = session()->get('id');
    if (!$facultyId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Not authenticated.'
        ]);
    }
    $userModel = new \App\Models\UserModel();
    $faculty = $userModel
        ->where('id', $facultyId)
        ->where('role', 'faculty')
        ->first();
    if (!$faculty) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Faculty account not found.'
        ]);
    }
    return $this->response->setJSON([
        'success' => true,
        'data' => $faculty
    ]);
}


}