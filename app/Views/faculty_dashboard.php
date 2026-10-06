<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 225px;
            --primary: #3b185f;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f5f5f7;
            font-family: Arial, sans-serif;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: #212529;
            color: white;
            z-index: 1000;
            padding-top: 20px;
        }

        .sidebar-brand {
            text-align: center;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            border-bottom: 1px solid rgba(255,255,255,.1);
            margin-bottom: 15px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 4px;
        }

        .sidebar-menu button,
        .sidebar-menu a {
            width: 100%;
            display: block;
            border: none;
            background: transparent;
            color: #ddd;
            text-align: left;
            padding: 12px 20px;
            text-decoration: none;
            font-size: 15px;
        }

        .sidebar-menu button:hover,
        .sidebar-menu a:hover {
            background: rgba(255,255,255,.1);
            color: white;
        }

        .sidebar-menu .active {
            background: var(--primary);
            color: white;
        }

        /* =========================
           MAIN
        ========================= */

        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .topbar {
            height: 65px;
            background: white;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
        }

        .page-title {
            font-size: 21px;
            font-weight: 600;
            margin: 0;
        }

        .content {
            padding: 25px;
        }

        /* =========================
           CARDS
        ========================= */

        .dashboard-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
        }

        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
            background: white;
            padding: 20px;
            height: 100%;
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            background: #eee6f8;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .stat-value {
            font-size: 25px;
            font-weight: bold;
            margin-top: 10px;
        }

        .stat-label {
            color: #777;
            font-size: 14px;
        }

        /* =========================
           TIMETABLE
        ========================= */

        .schedule-container {
            overflow-x: auto;
        }

        #scheduleTable {
            min-width: 1000px;
            border-collapse: collapse;
        }

        #scheduleTable th {
            background: #343a40;
            color: white;
            text-align: center;
            vertical-align: middle;
            padding: 12px;
        }

        #scheduleTable td {
            height: 55px;
            border: 1px solid #ddd;
            text-align: center;
            vertical-align: middle;
            background: white;
            padding: 4px;
        }

        #scheduleTable .time-column {
            width: 100px;
            font-weight: 600;
            background: #f8f9fa;
        }

        .schedule-item {
            background: #eee6f8;
            color: #3b185f;
            border-left: 4px solid #3b185f;
            border-radius: 6px;
            padding: 6px;
            margin: 2px;
            font-size: 12px;
            cursor: pointer;
            height: 100%;
        }

        .schedule-item:hover {
            background: #e1d5ef;
        }

        .schedule-subject {
            font-weight: bold;
        }

        .schedule-details {
            font-size: 11px;
            margin-top: 3px;
        }

        /* =========================
           PROFILE
        ========================= */

        .profile-label {
            color: #777;
            font-size: 13px;
            margin-bottom: 3px;
        }

        .profile-value {
            font-weight: 600;
            margin-bottom: 18px;
        }

        /* =========================
           MOBILE
        ========================= */

        .mobile-toggle {
            display: none;
        }

        @media (max-width: 768px) {

            .sidebar {
                transform: translateX(-100%);
                transition: .3s;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .mobile-toggle {
                display: inline-block;
            }

            .content {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<!-- =========================================================
    SIDEBAR
========================================================= -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-person-workspace"></i>
        Faculty Dashboard
    </div>
    <ul class="sidebar-menu">
        <li>
            <button
                class="active"
                id="scheduleMenu"
                onclick="showSchedule();">
                <i class="bi bi-calendar-week me-2"></i>
                My Schedule
            </button>
        </li>
        <li>
            <button
                id="profileMenu"
                onclick="showProfile();">
                <i class="bi bi-person me-2"></i>
                My Profile
            </button>
        </li>
        <li>
            <a href="<?= base_url('logout'); ?>">
                <i class="bi bi-box-arrow-right me-2"></i>
                Logout
            </a>
        </li>
    </ul>
</div>


<!-- =========================================================
    MAIN WRAPPER
========================================================= -->

<div class="main-wrapper">
    <!-- TOPBAR -->
    <div class="topbar">
        <div>
            <button
                class="btn btn-outline-secondary mobile-toggle"
                onclick="toggleSidebar();"
            >
                <i class="bi bi-list"></i>
            </button>
            <span class="page-title ms-2" id="pageTitle">
                My Schedule
            </span>
        </div>
        <div>
            <i class="bi bi-person-circle me-1"></i>
            <span id="topUsername">Faculty</span>
        </div>
    </div>
    <!-- CONTENT -->
    <div class="content">
        <!-- =====================================================
            SCHEDULE MANAGEMENT
        ====================================================== -->
        <div id="scheduleManagement">
            <!-- WORKLOAD SUMMARY -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="stat-label">
                                    Lecture Hours
                                </div>
                                <div
                                    class="stat-value"
                                    id="lectureHours"
                                >
                                    0
                                </div>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-book"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="stat-label">
                                    Laboratory Hours
                                </div>
                                <div
                                    class="stat-value"
                                    id="labHours"
                                >
                                    0
                                </div>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-pc-display"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="stat-label">
                                    Total Hours
                                </div>
                                <div
                                    class="stat-value"
                                    id="totalHours"
                                >
                                    0
                                </div>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SCHEDULE CARD -->
            <div class="card dashboard-card">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">
                                My Weekly Schedule
                            </h5>
                            <small class="text-muted">
                                Your assigned classes for the current schedule
                            </small>
                        </div>
                        <button
                            class="btn btn-outline-secondary btn-sm"
                            onclick="loadMySchedule();"
                        >
                            <i class="bi bi-arrow-clockwise"></i>
                            Refresh
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="schedule-container">
                        <table
                            class="table"
                            id="scheduleTable"
                        >
                            <thead>
                                <tr>
                                    <th class="time-column">
                                        Time
                                    </th>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
                                    <th>Saturday</th>
                                </tr>
                            </thead>
                            <tbody id="scheduleBody">
                                <!-- Generated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- =====================================================
            PROFILE
        ====================================================== -->
        <div
            id="facultyProfile"
            style="display:none;">
            <div class="card dashboard-card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-person me-2"></i>
                        My Profile
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-label">
                                Login ID
                            </div>
                            <div
                                class="profile-value"
                                id="profileLoginId">
                                -
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-label">
                                Username
                            </div>
                            <div
                                class="profile-value"
                                id="profileUsername">
                                -
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-label">
                                Email
                            </div>
                            <div
                                class="profile-value"
                                id="profileEmail">
                                -
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-label">
                                College
                            </div>
                            <div
                                class="profile-value"
                                id="profileCollege">
                                -
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-label">
                                Department
                            </div>
                            <div
                                class="profile-value"
                                id="profileDepartment">
                                -
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-label">
                                Academic Rank
                            </div>
                            <div
                                class="profile-value"
                                id="profileRank">
                                -
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- =========================================================
    VIEW SESSION MODAL
========================================================= -->
<div
    class="modal fade"
    id="sessionViewModal"
    tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-calendar-event me-2"></i>
                    Schedule Details
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">
                        Subject
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        id="viewSubject"
                        readonly
                    >
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Section
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="viewSection"
                            readonly
                        >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Room
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="viewRoom"
                            readonly
                        >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Type
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="viewType"
                            readonly
                        >
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Day
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="viewDay"
                            readonly
                        >
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Hours
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="viewUnits"
                            readonly
                        >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">
                            Start Time
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="viewStart"
                            readonly
                        >
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                            End Time
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="viewEnd"
                            readonly
                        >
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let facultySchedule = [];


    /* =========================================================
    PAGE NAVIGATION
    ========================================================= */

    function showSchedule() {
        document.getElementById('scheduleManagement').style.display = 'block';
        document.getElementById('facultyProfile').style.display = 'none';
        document.getElementById('pageTitle').innerText = 'My Schedule';
        document.getElementById('scheduleMenu').classList.add('active');
        document.getElementById('profileMenu').classList.remove('active');
        loadMySchedule();
    }

    function showProfile() {
        document.getElementById('scheduleManagement').style.display = 'none';
        document.getElementById('facultyProfile').style.display = 'block';
        document.getElementById('pageTitle').innerText = 'My Profile';
        document.getElementById('scheduleMenu').classList.remove('active');
        document.getElementById('profileMenu').classList.add('active');
        loadMyProfile();
    }

    /* =========================================================
    SIDEBAR
    ========================================================= */
    function toggleSidebar() {
        document
            .getElementById('sidebar')
            .classList
            .toggle('show');
    }


    /* =========================================================
    LOAD FACULTY SCHEDULE
    ========================================================= */
    async function loadMySchedule() {
        try {
            const response = await fetch(
                "<?= base_url('get_my_schedule'); ?>"
            );
            const result = await response.json();
            if (!result.success) {
                console.error(result.message);
                return;
            }
            facultySchedule = result.data || [];
            renderSchedule();
            calculateWorkload();
        } catch (error) {
            console.error(
                "Failed to load schedule:",
                error
            );
        }
    }


    /* =========================================================
    RENDER TIMETABLE
    ========================================================= */
    function renderSchedule() {
        const body = document.getElementById('scheduleBody');
        body.innerHTML = '';
        const startMinutes = 7 * 60;
        const endMinutes = 20 * 60 + 30;
        const interval = 30;
        for (
            let minutes = startMinutes;
            minutes < endMinutes;
            minutes += interval
        ) {
            const row = document.createElement('tr');
            const timeCell = document.createElement('td');
            timeCell.className = 'time-column';
            timeCell.innerText =
                formatTime(minutes);
            row.appendChild(timeCell);
            const days = [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday'
            ];
            days.forEach(day => {
                const cell = document.createElement('td');
                const sessions = facultySchedule.filter(session => {
                    return session.ses_day === day &&
                        timeToMinutes(session.ses_start) === minutes;
                });
                sessions.forEach(session => {
                    const item = document.createElement('div');
                    item.className = 'schedule-item';
                    item.innerHTML = `
                        <div class="schedule-subject">
                            ${escapeHtml(
                                session.sub_name || 'Subject'
                            )}
                        </div>
                        <div class="schedule-details">
                            ${escapeHtml(
                                session.sec_code || 'Section'
                            )}
                        </div>
                        <div class="schedule-details">
                            Room:
                            ${escapeHtml(
                                session.room_name || 'N/A'
                            )}
                        </div>
                        <div class="schedule-details">
                            ${escapeHtml(
                                session.ses_type || ''
                            )}
                        </div>
                    `;
                    item.addEventListener(
                        'click',
                        function () {
                            viewSession(session);
                        }
                    );
                    cell.appendChild(item);
                });
                row.appendChild(cell);
            });
            body.appendChild(row);
        }
    }

    /* =========================================================
    VIEW SESSION
    ========================================================= */
    function viewSession(session) {
        document.getElementById('viewSubject').value =
            session.sub_name || '-';
        document.getElementById('viewSection').value =
            session.sec_code || '-';
        document.getElementById('viewRoom').value =
            session.room_name || '-';
        document.getElementById('viewType').value =
            session.ses_type || '-';
        document.getElementById('viewDay').value =
            session.ses_day || '-';
        document.getElementById('viewUnits').value =
            session.ses_units || '-';
        document.getElementById('viewStart').value =
            formatDisplayTime(session.ses_start);
        document.getElementById('viewEnd').value =
            formatDisplayTime(session.ses_end);
        const modal =
            new bootstrap.Modal(
                document.getElementById('sessionViewModal')
            );
        modal.show();
    }


    /* =========================================================
    WORKLOAD
    ========================================================= */
    function calculateWorkload() {
        let lecture = 0;
        let laboratory = 0;
        facultySchedule.forEach(session => {
            const hours =
                parseFloat(session.ses_units) || 0;
            if (
                String(session.ses_type).toLowerCase()
                === 'lecture'
            ) {
                lecture += hours;
            } else if (
                String(session.ses_type).toLowerCase()
                === 'lab'
            ) {
                laboratory += hours;
            }
        });
        document.getElementById('lectureHours').innerText =
            lecture;
        document.getElementById('labHours').innerText =
            laboratory;
        document.getElementById('totalHours').innerText =
            lecture + laboratory;
    }


    /* =========================================================
    LOAD PROFILE
    ========================================================= */
    async function loadMyProfile() {
        try {
            const response = await fetch(
                "<?= base_url('get_my_profile'); ?>"
            );
            const result = await response.json();
            if (!result.success) {
                return;
            }
            const faculty = result.data;
            document.getElementById('profileLoginId').innerText =
                faculty.login_id || '-';
            document.getElementById('profileUsername').innerText =
                faculty.username || '-';
            document.getElementById('profileEmail').innerText =
                faculty.email || '-';
            document.getElementById('profileCollege').innerText =
                faculty.college || '-';
            document.getElementById('profileDepartment').innerText =
                faculty.department || '-';
            document.getElementById('profileRank').innerText =
                faculty.academic_rank || '-';
            document.getElementById('topUsername').innerText =
                faculty.username || 'Faculty';
        } catch (error) {
            console.error(
                "Failed to load profile:",
                error
            );
        }
    }

    /* =========================================================
    TIME FUNCTIONS
    ========================================================= */
    function timeToMinutes(time) {
        if (!time) {
            return 0;
        }
        const parts = time.split(':');
        return (
            parseInt(parts[0]) * 60 +
            parseInt(parts[1])
        );
    }

    function formatTime(minutes) {
        let hour =
            Math.floor(minutes / 60);
        let minute =
            minutes % 60;
        let suffix =
            hour >= 12 ? 'PM' : 'AM';
        let displayHour =
            hour % 12;
        if (displayHour === 0) {
            displayHour = 12;
        }
        return (
            displayHour +
            ':' +
            String(minute).padStart(2, '0') +
            ' ' +
            suffix
        );
    }

    function formatDisplayTime(time) {
        if (!time) {
            return '-';
        }
        return formatTime(
            timeToMinutes(time)
        );
    }

    /* =========================================================
    HTML ESCAPE
    ========================================================= */
    function escapeHtml(value) {
        if (value === null || value === undefined) {
            return '';
        }
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    /* =========================================================
    INITIALIZE
    ========================================================= */
    document.addEventListener(
        'DOMContentLoaded',
        function () {
            showSchedule();
        }
    );
</script>
</body>
</html>