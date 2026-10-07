<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 225px;
            --primary: #3b185f;
        }
        body {
            background-color: #f5f5f7;
            font-family: Arial, sans-serif;
        }
        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #212529;
            z-index: 1000;
            transition: margin-left 0.3s ease;
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
            overflow: hidden;
        }
        .sidebar .nav-link {
            color: #ddd;
            padding: 0.75rem 1rem;
            margin-bottom: 0.2rem;
            border-radius: 8px;
        }
        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active {
            color: #fff;
            background-color: var(--primary);
            border-radius: 8px;
        }
        /* Main Layout */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }
        /* Top Navbar */
        header.navbar {
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
        }
        /* Content Area */
        .content-area {
            flex: 1;
            padding: 25px;
        }
        /* Responsive Sidebar for Small Screens */
        @media (max-width: 991.98px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            .sidebar.show {
                margin-left: 0;
            }
            .main-wrapper {
                margin-left: 0;
            }
        }
        /* Cards & Containers — soft edges */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
        }
        .card-header {
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
        }
        .card-body {
            border-radius: 12px;
        }
        /* Tables — soft edges */
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th:first-child {
            border-top-left-radius: 10px;
        }
        .table thead th:last-child {
            border-top-right-radius: 10px;
        }
        .table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }
        .table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 10px;
        }
        /* All management tables — dark header */
        .table thead th {
            background-color: #212529 !important;
            color: #ffffff !important;
            border-color: #212529 !important;
        }
        /* Thin white divider lines between header columns */
        .table thead th + th {
            border-left: 1px solid rgba(255, 255, 255, 0.25) !important;
        }
        /* Data tables — grey row background */
        .data-table tbody tr td,
        #subjectTableBody tr td,
        #sectionTableBody tr td,
        #facultyTableBody tr td,
        #roomTableBody tr td {
            background-color: #f0f0f0;
        }
        /* Buttons — soft edges */
        .btn {
            border-radius: 8px;
        }
        /* Form Controls — soft edges */
        .form-control,
        .form-select {
            border-radius: 8px;
        }
        /* Modals — soft edges */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
        }
        .modal-header {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        .modal-footer {
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }
        /* Dropdown — soft edges */
        .dropdown-menu {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
        }
        /* Alert — soft edges */
        .alert {
            border-radius: 8px;
        }
        /* Footer — soft edges */
        footer {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        #scheduleTable { min-width: 1000px; } 
        #scheduleTable th { vertical-align: middle; padding: 12px; } 
        #scheduleTable td { height: 55px; min-width: 140px; vertical-align: middle; } 
        /* Schedule session card — base style (color is set inline via JS) */
        .schedule-cell { 
            border-left: 4px solid #3b185f; 
            border-radius: 6px; 
            padding: 6px; 
            font-size: 12px; 
        } 
        .schedule-subject { font-weight: bold; font-size: 14px; } 
        .schedule-section { font-size: 12px; } 
        .schedule-room { font-size: 12px; color: #777; }
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
            color: #3b185f;
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
        .schedule-item {
            background: #eee6f8;
            color: #3b185f;
            border-left: 4px solid #3b185f;
            border-radius: 6px;
            padding: 6px;
            margin: 2px;
            font-size: 12px;
            cursor: pointer;
        }
        .schedule-item:hover {
            background: #e1d5ef;
        }
        .profile-label {
            color: #777;
            font-size: 13px;
            margin-bottom: 3px;
        }
        .profile-value {
            font-weight: 600;
            margin-bottom: 18px;
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="sidebar p-3 d-flex flex-column justify-content-between" id="sidebar">
        <div>
            <!-- Brand / Logo Placeholder -->
            <a href="#" class="d-flex align-items-center mb-3 text-white text-decoration-none fs-4 fw-bold">
                <i class="bi bi-speedometer2 me-2"></i> Admin Dashboard
            </a>
            <hr class="text-secondary">
            
            <!-- Navigation Links -->
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="#" onclick="showSchedule();" class="nav-link">
                        <i class="bi bi-folder me-2"></i>
                        Schedule Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" onclick="showFaculty(); " class="nav-link">
                        <i class="bi bi-folder me-2"></i>
                        Faculty Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" onclick="showRooms(); " class="nav-link">
                        <i class="bi bi-folder me-2"></i>
                        Room Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" onclick="showSections(); " class="nav-link">
                        <i class="bi bi-folder me-2"></i>
                        Section Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" onclick="showSubjects()" class="nav-link">
                        <i class="bi bi-folder me-2"></i>
                        Subject Management
                    </a>
                </li>
                </div>
            </ul>
        </div>
        <!-- Sidebar Footer / User Info -->
        <div>
            <hr class="text-secondary">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <span>Admin User</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="userMenu">
                    <li><a class="dropdown-item" href="<?php echo base_url('logout'); ?>">Sign out</a></li>
                </ul>
            </div>
        </div>
    </aside>
    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        
        <!-- Top Navbar -->
        <header class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-3">
            <div class="container-fluid">
                <!-- Mobile Sidebar Toggle -->
                <button class="btn btn-outline-secondary d-lg-none me-2" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <span class="navbar-brand mb-0 h1 fs-5">Admin Dashboard</span>            
            </div>
        </header>
        <!-- Main Workspace Area -->
        <main class="content-area">
            
            <div class="container-fluid">
                <!-- SCHEDULE MANAGEMENT -->
                <div class="card border-0 shadow-sm mb-4" id="scheduleManagement"style="display: none;">
                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <!-- FILTER -->
                            <div class="col-md-3">
                                <label for="managementFilter" class="form-label">
                                    <i class="bi bi-funnel me-1"></i>
                                    Filter By
                                </label>
                                <select
                                    id="managementFilter"
                                    class="form-select"
                                    onchange="changeManagementFilter()">
                                    
                                    <option value="faculty">Faculty</option>
                                    <option value="room">Room</option>
                                    <option value="section">Section</option>
                                </select>
                            </div>
                            <!-- SEARCH -->
                            <div
                                class="col-md-7"
                                id="searchArea"
                                style="display: none;">
                                <label for="searchInput" class="form-label" id="searchLabel">
                                    Search
                                </label>
                                <input
                                    type="text"
                                    id="searchInput"
                                    class="form-control"
                                    placeholder="Enter search term">
                            </div>
                            <!-- SEARCH BUTTON -->
                            <div class="col-md-2" id="searchButton" style="display: none;">
                                <button
                                    type="button"
                                    class="btn btn-primary w-100"
                                    onclick="searchSchedule()">
                                    <i class="bi bi-search me-1"></i>
                                    Search
                                </button>
                            </div>
                            <!-- SESSION BUTTON -->
                            <div class="col-md-2" id="sessionButton" style="display: none;">
                                <button
                                    type="button"
                                    class="btn btn-primary w-100"
                                    onclick="openSessionModal()">
                                    Add Session
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ADD SESSION MODAL -->
                <div class="modal fade" id="addSessionModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="sessionModalTitle">
                                    <i class="bi bi-calendar-plus me-2"></i>
                                    Add Session
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>
                            </div>
                            <form id="addSessionForm">
                                <div class="modal-body">
                                    <!-- FACULTY -->
                                    <div class="mb-3">
                                        <label for="sessionFaculty" class="form-label">
                                            Faculty
                                        </label>
                                        <select
                                            id="sessionFaculty"
                                            class="form-select"
                                            required>
                                            <option value="">
                                                Select Faculty
                                            </option>
                                        </select>
                                    </div>
                                    <!-- SUBJECT -->
                                    <div class="mb-3">
                                        <label for="sessionSubject" class="form-label">
                                            Subject
                                        </label>
                                        <select
                                            id="sessionSubject"
                                            class="form-select"
                                            required
                                            onchange="filterSectionsBySubject(); updateSubjectInformation();">
                                            <option value="">
                                                Select Subject
                                            </option>
                                        </select>
                                        <div
                                            id="subjectInformation"
                                            class="form-text">
                                        </div>
                                    </div>
                                    <!-- SECTION -->
                                    <div class="mb-3">
                                        <label for="sessionSection" class="form-label">
                                            Section
                                        </label>
                                        <select
                                            id="sessionSection"
                                            class="form-select"
                                            required
                                            onchange="filterSubjectsBySection(); updateSubjectInformation();">
                                            <option value="">
                                                Select Section
                                            </option>
                                        </select>
                                    </div>
                                    <!-- ROOM -->
                                    <div class="mb-3">
                                        <label for="sessionRoom" class="form-label">
                                            Room
                                        </label>
                                        <select
                                            id="sessionRoom"
                                            class="form-select"
                                            required>
                                            <option value="">
                                                Select Room
                                            </option>
                                        </select>
                                        <div
                                            id="roomInformation"
                                            class="form-text">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!-- SESSION TYPE -->
                                        <div class="col-md-6 mb-3">
                                            <label for="sessionType" class="form-label">
                                                Session Type
                                            </label>
                                            <select
                                                id="sessionType"
                                                class="form-select"
                                                required
                                                onchange="updateSessionHours()">
                                                <option value="">
                                                    Select Type
                                                </option>
                                                <option value="Lecture">
                                                    Lecture
                                                </option>
                                                <option value="Lab">
                                                    Lab
                                                </option>
                                            </select>
                                        </div>
                                        <!-- DAY -->
                                        <div class="col-md-6 mb-3">
                                            <label for="sessionDay" class="form-label">
                                                Session Day
                                            </label>
                                            <select
                                                id="sessionDay"
                                                class="form-select"
                                                required>
                                                <option value="">
                                                    Select Day
                                                </option>
                                                <option value="Monday">Monday</option>
                                                <option value="Tuesday">Tuesday</option>
                                                <option value="Wednesday">Wednesday</option>
                                                <option value="Thursday">Thursday</option>
                                                <option value="Friday">Friday</option>
                                                <option value="Saturday">Saturday</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- TIME -->
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="sessionStart" class="form-label">
                                                Start Time
                                            </label>
                                            <input
                                                type="time"
                                                id="sessionStart"
                                                class="form-control"
                                                min="07:00"
                                                max="20:30"
                                                step="1800"
                                                required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="sessionEnd" class="form-label">
                                                End Time
                                            </label>
                                            <input
                                                type="time"
                                                id="sessionEnd"
                                                class="form-control"
                                                min="07:00"
                                                max="20:30"
                                                step="1800"
                                                required>
                                        </div>
                                    </div>
                                    <!-- UNIT INFORMATION -->
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <div class="row text-center">
                                                <div class="col-md-4">
                                                    <small class="text-muted">
                                                        Subject Hours
                                                    </small>
                                                    <h5 id="subjectHours">
                                                        0
                                                    </h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted">
                                                        Session Hours
                                                    </small>
                                                    <h5 id="sessionUnits">
                                                        0
                                                    </h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted">
                                                        Remaining Hours
                                                    </small>
                                                    <h5 id="remainingUnits">
                                                        0
                                                    </h5>
                                                </div>
                                            </div>
                                            <div
                                                id="sessionValidation"
                                                class="mt-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        id="deleteSessionButton"
                                        class="btn btn-danger me-auto"
                                        style="display:none;"
                                        onclick="deleteSession()">
                                        <i class="bi bi-trash me-1"></i>
                                        Delete Session
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        id="saveSessionButton"
                                        class="btn btn-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Create Session
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- SCHEDULE TABLE -->
                <div
                    id="scheduleTable"
                    style="display: none;">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="mb-3">
                                <i class="bi bi-calendar-week me-2"></i>
                                Weekly Schedule
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th style="width: 120px;">Time</th>
                                            <th>Monday</th>
                                            <th>Tuesday</th>
                                            <th>Wednesday</th>
                                            <th>Thursday</th>
                                            <th>Friday</th>
                                            <th>Saturday</th>
                                        </tr>
                                    </thead>
                                    <tbody id="scheduleBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FACULTY MANAGEMENT-->
                <div id="facultyManagement" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Faculty Management</h3>
                        <button class="btn btn-primary" onclick="openFacultyModal()">
                            <i class="bi bi-plus-lg me-1"></i>
                            Add Faculty
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>Login ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>College</th>
                                    <th>Academic Rank</th>
                                    <th>Lab Hours</th>
                                    <th>Lec Hours</th>
                                    <th>Extra (Manual)</th>
                                    <th>Total</th>
                                    <th style="width:180px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="facultyTableBody">
                                <tr><td colspan="11" class="text-center text-muted py-4">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- ADD FACULTY MODAL-->
                <div class="modal fade" id="facultyModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="facultyModalTitle">
                                    Add Faculty
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                                </button>
                            </div>
                            <div class="modal-body">
                                <input
                                    type="hidden"
                                    id="facultyId">
                                <!-- LOGIN ID -->
                                <div class="mb-3">
                                    <label for="loginId" class="form-label">
                                        Login ID
                                    </label>
                                    <input
                                        type="number"
                                        id="loginId"
                                        class="form-control"
                                        required>
                                </div>
                                <!-- USERNAME -->
                                <div class="mb-3">
                                    <label for="username" class="form-label">
                                        UserName
                                    </label>
                                    <input
                                        type="text"
                                        id="username"
                                        class="form-control"
                                        required>
                                </div>
                                <!-- EMAIL -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        Email
                                    </label>
                                    <input
                                        type="email"
                                        id="email"
                                        class="form-control"
                                        required>
                                </div>
                                <!-- PASSWORD -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        Password
                                    </label>
                                    <input
                                        type="password"
                                        id="password"
                                        class="form-control"
                                        required>
                                </div>
                                <!-- COLLEGE & DEPARTMENT-->
                                    <div class="col-md-6 mb-3">
                                        <label for="college" class="form-label">
                                            College
                                        </label>
                                        <select
                                            id="college"
                                            class="form-select"
                                            required>
                                            <option value="COTE">
                                                COTE
                                            </option>
                                            <option value="CAS">
                                                CAS
                                            </option>
                                            <option value="CTE">
                                                CTE
                                            </option>
                                            <option value="COMED">
                                                COMED
                                            </option>
                                            <option value="CGS">
                                                CGS
                                            </option>
                                        </select>
                                </div>
                                <div class ="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="department" class="form-label">
                                            Department
                                        </label>
                                        <select
                                            id="department"
                                            class="form-select"
                                            required>
                                            <option value="">
                                                Select Department
                                            </option>
                                            <option value="IT">
                                                IT
                                            </option>
                                            <option value="InT">
                                                InT
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <!-- ACADEMIC RANK -->
                                <div class ="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="academicRank" class="form-label">
                                            Academic Rank
                                        </label>
                                        <select
                                            id="academicRank"
                                            class="form-select"
                                            required>
                                            <option value="">
                                                Select Position
                                            </option>
                                            <option value="fullTime">
                                                Full time
                                            </option>
                                            <option value="partTime">
                                                Part time
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <!-- LAB, LEC AND EXTRA UNITS -->
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="labUnits" class="form-label">
                                            Lab Units
                                        </label>
                                        <input
                                            type="number"
                                            id="labUnits"
                                            class="form-control"
                                            min="0"
                                            step="0.5"
                                            value="0"
                                            readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="lecUnits" class="form-label">
                                            Lec Units 
                                        </label>
                                        <input
                                            type="number"
                                            id="lecUnits"
                                            class="form-control"
                                            min="0"
                                            step="0.5"
                                            value="0"
                                            readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="extraUnits" class="form-label">
                                            Extra Units
                                        </label>
                                        <input
                                            type="number"
                                            id="extraUnits"
                                            class="form-control"
                                            min="0"
                                            step="0.5"
                                            value="0"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    onclick="saveFaculty()">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Save Faculty
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROOM MANAGEMENT-->
                <div id="roomManagement" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Room Management</h3>
                        <button
                            type="button"
                            class="btn btn-primary"
                            onclick="openRoomModal()">
                            <i class="bi bi-plus-lg me-1"></i>
                            Add Room
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>Room Code</th>
                                    <th>Room Name</th>
                                    <th>Room Type</th>
                                    <th>Availability</th>
                                    <th>Room Size</th>
                                    <th style="width:180px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="roomTableBody">
                                <tr>
                                    <td
                                        colspan="6"
                                        class="text-center text-muted py-4">
                                        Loading...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- ADD ROOM MODAL-->
                <div
                    class="modal fade"
                    id="roomModal"
                    tabindex="-1"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5
                                    class="modal-title"
                                    id="roomModalTitle">
                                    Add Room
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                                </button>
                            </div>
                            <div class="modal-body">
                                <input
                                    type="hidden"
                                    id="roomId">
                                <div class="row">
                                    <!-- Room Code -->
                                    <div class="col-md-6 mb-3">
                                        <label
                                            for="roomCode"
                                            class="form-label">
                                            Room Code
                                        </label>
                                        <input
                                            type="text"
                                            id="roomCode"
                                            class="form-control"
                                            maxlength="45"
                                            required>
                                    </div>
                                    <!-- Room Name -->
                                    <div class="col-md-6 mb-3">
                                        <label
                                            for="roomName"
                                            class="form-label">
                                            Room Name
                                        </label>
                                        <input
                                            type="text"
                                            id="roomName"
                                            class="form-control"
                                            maxlength="45"
                                            required>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Room Type -->
                                    <div class="col-md-6 mb-3">
                                        <label
                                            for="roomType"
                                            class="form-label">
                                            Room Type
                                        </label>
                                        <select
                                            id="roomType"
                                            class="form-select"
                                            required>
                                            <option value="">
                                                Select Room Type
                                            </option>
                                            <option value="Lecture">
                                                Lecture Room
                                            </option>
                                            <option value="Laboratory">
                                                Laboratory
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Room Availability -->
                                    <div class="col-md-6 mb-3">
                                        <label
                                            for="roomTime"
                                            class="form-label">
                                            Room Availability
                                        </label>
                                        <input
                                            type="text"
                                            id="roomTime"
                                            class="form-control"
                                            placeholder="e.g. 7:00 AM - 8:30 PM"
                                            maxlength="45"
                                            required>
                                    </div>
                                    <!-- Room Size -->
                                    <div class="col-md-6 mb-3">
                                        <label
                                            for="roomSize"
                                            class="form-label">
                                            Room Size
                                        </label>
                                        <input
                                            type="number"
                                            id="roomSize"
                                            class="form-control"
                                            min="1"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    onclick="saveRoom()">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Save Room
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- SUBJECT MANAGEMENT -->
                <div id="subjectManagement" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Subject Management</h3>
                        <button class="btn btn-primary" onclick="openSubjectModal()">
                            <i class="bi bi-plus-lg"></i>
                            Add Subject
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Program</th>
                                    <th>Year</th>
                                    <th>Semester</th>
                                    <th>Lecture Hours</th>
                                    <th>Laboratory Hours</th>
                                    <th>Total Hours</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="subjectTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- ADD SUBJECT MODAL -->
                <div class="modal fade" id="subjectModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="subjectModalTitle">
                                    Add Subject
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                                </button>
                            </div>
                            <div class="modal-body">
                                <input
                                    type="hidden"
                                    id="subjectId">
                                <!-- SUBJECT CODE -->
                                <div class="mb-3">
                                    <label for="subjectCode" class="form-label">
                                        Subject Code
                                    </label>
                                    <input
                                        type="text"
                                        id="subjectCode"
                                        class="form-control"
                                        required>
                                </div>
                                <!-- SUBJECT NAME -->
                                <div class="mb-3">
                                    <label for="subjectName" class="form-label">
                                        Subject Name
                                    </label>
                                    <input
                                        type="text"
                                        id="subjectName"
                                        class="form-control"
                                        required>
                                </div>
                                <!-- PROGRAM -->
                                <div class="mb-3">
                                    <label for="subjectProgram" class="form-label">
                                        Program
                                    </label>
                                    <select
                                        id="subjectProgram"
                                        class="form-select"
                                        required>
                                        <option value="">Select Program</option>
                                        <option value="BSIT">BSIT - Information Technology</option>
                                        <option value="BSInT">BSInT - Industrial Technology</option>
                                    </select>
                                </div>
                                <!-- YEAR AND SEMESTER -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="subjectYear" class="form-label">
                                            Year
                                        </label>
                                        <select
                                            id="subjectYear"
                                            class="form-select"
                                            required>
                                            <option value="">
                                                Select Year
                                            </option>
                                            <option value="1">
                                                1st Year
                                            </option>
                                            <option value="2">
                                                2nd Year
                                            </option>
                                            <option value="3">
                                                3rd Year
                                            </option>
                                            <option value="4">
                                                4th Year
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="subjectSem" class="form-label">
                                            Semester
                                        </label>
                                        <select
                                            id="subjectSem"
                                            class="form-select"
                                            required>
                                            <option value="">
                                                Select Semester
                                            </option>
                                            <option value="1">
                                                1st Semester
                                            </option>
                                            <option value="2">
                                                2nd Semester
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <!-- HOURS -->
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="subjectLecHours" class="form-label">
                                            Lecture Hours
                                        </label>
                                        <input
                                            type="number"
                                            id="subjectLecHours"
                                            class="form-control"
                                            min="0"
                                            step="0.5"
                                            value="0"
                                            required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="subjectLabHours" class="form-label">
                                            Laboratory Hours
                                        </label>
                                        <input
                                            type="number"
                                            id="subjectLabHours"
                                            class="form-control"
                                            min="0"
                                            step="0.5"
                                            value="0"
                                            required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="subjectTotalHours" class="form-label">
                                            Total Hours
                                        </label>
                                        <input
                                            type="number"
                                            id="subjectTotalHours"
                                            class="form-control"
                                            min="0"
                                            step="0.5"
                                            value="0"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    onclick="saveSubject()">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Save Subject
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- SECTION MANAGEMENT -->
                <div id="sectionManagement" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>
                            <i class="bi bi-diagram-3 me-2"></i>
                            Section Management
                        </h3>
                        <button
                            class="btn btn-primary"
                            type="button"
                            onclick="openSectionModal()">
                            <i class="bi bi-plus-lg me-1"></i>
                            Add Section
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Section Code</th>
                                    <th>Section Name</th>
                                    <th>Program</th>
                                    <th>Section Size</th>
                                    <th>Section Year</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="sectionTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- ADD SECTION MODAL -->
                <div
                    class="modal fade"
                    id="sectionModal"
                    tabindex="-1"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5
                                    class="modal-title"
                                    id="sectionModalTitle">
                                    Add Section
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                                </button>
                            </div>
                            <div class="modal-body">
                                <input
                                    type="hidden"
                                    id="sectionId">
                                <!-- SECTION CODE -->
                                <div class="mb-3">
                                    <label
                                        for="sectionCode"
                                        class="form-label">
                                        Section Code
                                    </label>
                                    <input
                                        type="text"
                                        id="sectionCode"
                                        class="form-control"
                                        placeholder="Enter section code">
                                </div>
                                <!-- SECTION NAME -->
                                <div class="mb-3">
                                    <label
                                        for="sectionName"
                                        class="form-label">
                                        Section Name
                                    </label>
                                    <input
                                        type="text"
                                        id="sectionName"
                                        class="form-control"
                                        placeholder="Enter section name">
                                </div>
                                <!-- PROGRAM -->
                                <div class="mb-3">
                                    <label
                                        for="sectionProgram"
                                        class="form-label">
                                        Program
                                    </label>
                                    <select
                                        id="sectionProgram"
                                        class="form-select"
                                        required>
                                        <option value="">Select Program</option>
                                        <option value="BSIT">BSIT - Information Technology</option>
                                        <option value="BSInT">BSInT - Industrial Technology</option>
                                    </select>
                                </div>
                                <!-- SECTION SIZE -->
                                <div class="mb-3">
                                    <label
                                        for="sectionSize"
                                        class="form-label">
                                        Section Size
                                    </label>
                                    <input
                                        type="number"
                                        id="sectionSize"
                                        class="form-control"
                                        min="1"
                                        placeholder="Enter number of students">
                                </div>
                                <div class="mb-3">
                                    <label for="sectionYear" class="form-label">
                                        Year
                                    </label>
                                    <select id="sectionYear" class="form-select" required>
                                        <option value="">Select Year</option>
                                        <option value="1">1st Year</option>
                                        <option value="2">2nd Year</option>
                                        <option value="3">3rd Year</option>
                                        <option value="4">4th Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    onclick="saveSection()">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Save Section
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- Footer -->
        <footer class="bg-white border-top p-3 text-center text-muted small">
            &copy; Hello.
        </footer>
    </div>
    <!-- Bootstrap 5 JavaScript Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
// Global Variables
    let facultyList = [];
    let roomList = [];
    let sectionList = [];
    let subjectList = [];

    let selectedSubject = null;
    let SessionModal = null;
    let editingSessionId = null;
    let scheduledSubjectHours = { lab: 0, lecture: 0 };
    let scheduledSubjectHoursLoaded = true;
    let subjectHoursRequestId = 0;

    let searchResult = null;
    let searchFilter = null;

    // Palette of soft colors for schedule sessions
    const SESSION_COLORS = [
        '#FFC0CB', // pink
        '#FFD9A0', // peach
        '#FFF3A0', // light yellow
        '#C8F0C8', // light green
        '#A0E7E5', // aqua
        '#B4D4FF', // light blue
        '#D6C6F0', // lavender
        '#F5B7D0', // rose
        '#F7C6A3', // apricot
        '#B5EAD7', // mint
        '#FFB3BA', // salmon pink
        '#C7CEEA'  // periwinkle
    ];

    // Cache so each session ID keeps the same color across re-renders
    const sessionColorCache = new Map();

    function getSessionColor(sessionId) {
        const key = String(sessionId);
        if (sessionColorCache.has(key)) {
            return sessionColorCache.get(key);
        }
        const color =
            SESSION_COLORS[
                Math.floor(Math.random() * SESSION_COLORS.length)
            ];
        sessionColorCache.set(key, color);
        return color;
    }

    const csrfToken = <?= json_encode(service('security')->getHash()) ?>;
    const csrfHeaderName = <?= json_encode(service('security')->getHeaderName()) ?>;
    const nativeFetch = window.fetch.bind(window);
    window.fetch = (resource, options = {}) => {
        const method = String(options.method || 'GET').toUpperCase();
        if (['POST', 'PUT', 'DELETE', 'PATCH'].includes(method)) {
            const headers = new Headers(options.headers || {});
            headers.set(csrfHeaderName, csrfToken);
            options = { ...options, headers };
        }
        return nativeFetch(resource, options);
    };

// Initialization 
    document.addEventListener('DOMContentLoaded', function () {
        changeManagementFilter();
        document
            .getElementById('sidebarToggle')
            .addEventListener('click', function () {
                document
                    .getElementById('sidebar')
                    .classList.toggle('show');
            });
        document
            .getElementById('sessionStart')
            .addEventListener(
                'change',
                updateSessionHours
            );
        document
            .getElementById('sessionEnd')
            .addEventListener(
                'change',
                updateSessionHours
            );
        document
            .getElementById('subjectLecHours')
            .addEventListener('input', calculateSubjectTotalHours);
        document
            .getElementById('subjectLabHours')
            .addEventListener('input', calculateSubjectTotalHours);
        });

// Management Filter
    function changeManagementFilter() {
        searchResult = null;
        hideSessionButton();
        searchFilter = document.getElementById('managementFilter').value;
        console.log('Management filter selected:',searchFilter);
        hideAllManagementAreas();
        if (searchFilter === 'faculty') {
            document.getElementById(
                'searchArea'
            ).style.display = 'block';
            document.getElementById(
                'searchButton'
            ).style.display = 'block';
            loadFacultyList();
            return;
        }
        if (searchFilter === 'room') {
            document.getElementById(
                'searchArea'
            ).style.display = 'block';
            document.getElementById(
                'searchButton'
            ).style.display = 'block';
            loadRoomList();
            return;
        }
        if (searchFilter === 'section') {
            document.getElementById(
                'searchArea'
            ).style.display = 'block';
            document.getElementById(
                'searchButton'
            ).style.display = 'block';
            loadSectionList();
            return;
        }
    }

    function hideAllManagementAreas() {
    const areas = [
        'searchArea',
        'searchButton',
        'sessionButton',
        'scheduleTable',
        'subjectManagement',
        'sectionManagement',
        'facultyManagement',
        'roomManagement',
    ];
    areas.forEach(id => {
        const element =
            document.getElementById(id);
        if (element) {
            element.style.display = 'none';
        }
    });
}

    function showSessionButton() {
        const button =
            document.getElementById('sessionButton');
        if (button) {
            button.style.display = 'block';
        }
    }

    function hideSessionButton() {
        const button =
            document.getElementById('sessionButton');
        if (button) {
            button.style.display = 'none';
        }
    }

    function showSchedule() {
        hideAllManagementAreas();
        const scheduleCard =
            document.getElementById('scheduleManagement');
        if (scheduleCard) {
            scheduleCard.style.display = 'block';
        }
        const scheduleTable =
            document.getElementById('scheduleTable');
        if (scheduleTable) {
            scheduleTable.style.display = 'none';
        }
        searchResult = null;
        searchFilter = null;
        const managementFilter =
            document.getElementById('managementFilter');
        if (managementFilter) {
            managementFilter.value = 'faculty';
        }
        changeManagementFilter();
    }

    function showFaculty() {
        hideAllManagementAreas();
        const scheduleCard =
            document.getElementById('scheduleManagement');
        if (scheduleCard) {
            scheduleCard.style.display = 'none';
        }
        document.getElementById('facultyManagement').style.display = 'block';
        loadFacultyManagementList();
    }

    function showSubjects() {
        hideAllManagementAreas()
        const scheduleCard =
            document.getElementById('scheduleManagement');
        if (scheduleCard) {
            scheduleCard.style.display = 'none';
        }
        document.getElementById('subjectManagement').style.display = 'block';
        loadSubjectList();
    }

    function showSections() {
        hideAllManagementAreas();
        const scheduleCard =
            document.getElementById('scheduleManagement');
        if (scheduleCard) {
            scheduleCard.style.display = 'none';
        }
        document.getElementById('sectionManagement').style.display = 'block';
        loadSectionManagementList();
    }

    function showRooms() {
        hideAllManagementAreas();
        const scheduleCard =
            document.getElementById('scheduleManagement');
        if (scheduleCard) {
            scheduleCard.style.display = 'none';
        }
        document.getElementById('roomManagement').style.display = 'block';
        loadRoomManagementList();
    }


// Load Management Data
    function loadFacultyList() {
        console.log('Loading faculty list...');
        const url = '<?= base_url('show_faculty') ?>';
        fetch(url, {method: 'GET',headers: {'Accept': 'application/json'}
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load faculty list. HTTP status: ' +response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Faculty data received:', data);
            if (!Array.isArray(data)) {
                console.error('Faculty endpoint did not return an array:',data);
                facultyList = [];
                alert('Invalid faculty data returned by the server.');
                return;
            }
            facultyList = data;
            console.log('Faculty list successfully loaded:',facultyList);
            console.log('Number of faculty:',facultyList.length);
        })
        .catch(error => {
            console.error('Error loading faculty list:',error);
            facultyList = [];
            alert('Unable to load the faculty list.');
        });
    }

    function loadRoomList() {
        console.log('Loading room list...');
        const url = '<?= base_url('show_room') ?>';
        fetch(url, {method: 'GET',headers: {'Accept': 'application/json'}
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load room list. HTTP status: ' +response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Room data received:', data);
            if (!Array.isArray(data)) {
                console.error('Room endpoint did not return an array:',data);
                roomList = [];
                alert('Invalid room data returned by the server.');
                return;
            }
            roomList = data;
            console.log('Room list successfully loaded:',roomList);
            console.log('Number of rooms:',roomList.length);
        })
        .catch(error => {
            console.error('Error loading room list:',error);
            roomList = [];
            alert('Unable to load the room list.');
        });
    }

    function loadSectionList() {
        console.log('Loading section list...');
        const url = '<?= base_url('show_sections') ?>';
        fetch(url, {method: 'GET',headers: {'Accept': 'application/json'}
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load section list. HTTP status: ' +response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Section data received:', data);
            if (!Array.isArray(data)) {
                console.error('Section endpoint did not return an array:',data);
                sectionList = [];
                alert('Invalid section data returned by the server.');
                return;
            }
            sectionList = data;
            console.log('Section list successfully loaded:',sectionList);
            console.log('Number of sections:',sectionList.length);
        })
        .catch(error => {
            console.error('Error loading section list:',error);
            sectionList = [];
            alert('Unable to load the section list.');
        });
    }

    function loadSubjectList() {
        fetch('<?= base_url('show_subjects') ?>')
            .then(response => {
                if (!response.ok) {
                    throw new Error(
                        'Failed to load subjects.'
                    );
                }
                return response.json();
            })
            .then(subjects => {
                const tbody =
                    document.getElementById(
                        'subjectTableBody'
                    );
                tbody.innerHTML = '';
                if (!Array.isArray(subjects)) {
                    console.error(
                        'Invalid subject data:',
                        subjects
                    );
                    return;
                }
                subjects.forEach(subject => {
                    tbody.innerHTML += `
                        <tr>
                            <td>
                                ${escapeHtml(subject.sub_code)}
                            </td>
                            <td>
                                ${escapeHtml(subject.sub_name)}
                            </td>
                            <td>
                                ${escapeHtml(subject.sub_program)}
                            </td>
                            <td>
                                ${escapeHtml(subject.sub_year)}
                            </td>
                            <td>
                                ${escapeHtml(subject.sub_sem)}
                            </td>
                            <td>
                                ${escapeHtml(subject.sub_lec_hours)}
                            </td>
                            <td>
                                ${escapeHtml(subject.sub_lab_hours)}
                            </td>
                            <td>
                                ${escapeHtml(subject.sub_total_hours)}
                            </td>
                            <td>
                                <button
                                    class="btn btn-warning btn-sm me-1"
                                    onclick="editSubject(${subject.id})">
                                    <i class="bi bi-pencil"></i>
                                    Edit
                                </button>
                                <button
                                    class="btn btn-danger btn-sm"
                                    onclick="deleteSubject(${subject.id})">
                                    <i class="bi bi-trash"></i>
                                    Delete
                                </button>
                            </td>
                        </tr>
                    `;
                });
            })
            .catch(error => {
                console.error(
                    'Error loading subjects:',
                    error
                );
            });
    }

    function loadSectionManagementList() {
        fetch('<?= base_url('show_sections') ?>', {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(
                    'Failed to load sections. HTTP status: ' +
                    response.status
                );
            }
            return response.json();
        })
        .then(sections => {
            console.log('Sections received:', sections);
            sectionList = sections;
            const tbody =
                document.getElementById('sectionTableBody');
            tbody.innerHTML = '';
            if (!Array.isArray(sections) || sections.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No sections found.
                        </td>
                    </tr>
                `;
                return;
            }
            sections.forEach(section => {
                tbody.innerHTML += `
                    <tr>
                        <td>
                            ${escapeHtml(section.sec_code)}
                        </td>
                        <td>
                            ${escapeHtml(section.sec_name)}
                        </td>
                        <td>
                            ${escapeHtml(section.sec_prog)}
                        </td>
                        <td>
                            ${escapeHtml(section.sec_size)}
                        </td>
                        <td>
                            ${escapeHtml(section.sec_year)}
                        </td>
                        <td>
                            <button
                                type="button"
                                class="btn btn-warning btn-sm me-1"
                                onclick="editSection(${section.id})">
                                <i class="bi bi-pencil"></i>
                                Edit
                            </button>
                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                onclick="deleteSection(${section.id})">
                                <i class="bi bi-trash"></i>
                                Delete
                            </button>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => {
            console.error(
                'Error loading sections:',
                error
            );
            alert('Unable to load sections.');
        });
    }

    function loadFacultyManagementList() {
        fetch('<?= base_url('show_faculty') ?>', {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load faculty.');
            }
            return response.json();
        })
        .then(faculty => {
            const tbody = document.getElementById('facultyTableBody');
            tbody.innerHTML = '';
            if (!Array.isArray(faculty) || faculty.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="11"
                            class="text-center text-muted py-4">
                            No faculty found.
                        </td>
                    </tr>
                `;
                return;
            }
            faculty.forEach(user => {
                const assignedLabHours =
                    Number(user.assigned_lab_hours) || 0;
                const assignedLectureHours =
                    Number(user.assigned_lecture_hours) || 0;
                const extraUnits =
                    Number(user.total_extra_units) || 0;
                tbody.innerHTML += `
                    <tr>
                        <td>${escapeHtml(user.login_id ?? '')}</td>
                        <td>${escapeHtml(user.username ?? '')}</td>
                        <td>${escapeHtml(user.email ?? '')}</td>
                        <td>${escapeHtml(user.department ?? '')}</td>
                        <td>${escapeHtml(user.college ?? '')}</td>
                        <td>${escapeHtml(user.academic_rank ?? '')}</td>
                        <td>${escapeHtml(assignedLabHours)}</td>
                        <td>${escapeHtml(assignedLectureHours)}</td>
                        <td>${escapeHtml(extraUnits)}</td>
                        <td>${escapeHtml(
                            Number((
                                assignedLabHours +
                                assignedLectureHours +
                                extraUnits
                            ).toFixed(2))
                        )}</td>
                        <td>
                            <button
                                type="button"
                                class="btn btn-warning btn-sm me-1"
                                onclick="editFaculty(${user.id})">
                                <i class="bi bi-pencil"></i>
                                Edit
                            </button>
                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                onclick="deleteFaculty(${user.id})">
                                <i class="bi bi-trash"></i>
                                Delete
                            </button>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => {
            console.error('Error loading faculty:', error);
            document.getElementById('facultyTableBody').innerHTML = `
                <tr>
                    <td colspan="11"
                        class="text-center text-danger py-4">
                        Unable to load faculty.
                    </td>
                </tr>
            `;
        });
    }

    function loadRoomManagementList() {
        fetch('<?= base_url('show_room') ?>', {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })

        .then(response => {

            if (!response.ok) {
                throw new Error('Failed to load rooms.');
            }

            return response.json();

        })

        .then(rooms => {

            const tbody =
                document.getElementById('roomTableBody');

            tbody.innerHTML = '';

            if (!Array.isArray(rooms) || rooms.length === 0) {

                tbody.innerHTML = `
                    <tr>
                        <td
                            colspan="6"
                            class="text-center text-muted py-4">

                            No rooms found.

                        </td>
                    </tr>
                `;

                return;
            }

            rooms.forEach(room => {

                tbody.innerHTML += `

                    <tr>

                        <td>
                            ${escapeHtml(room.room_code ?? '')}
                        </td>

                        <td>
                            ${escapeHtml(room.room_name ?? '')}
                        </td>

                        <td>
                            ${escapeHtml(room.room_type ?? '')}
                        </td>

                        <td>
                            ${escapeHtml(room.room_time ?? '')}
                        </td>

                        <td>
                            ${escapeHtml(room.room_size ?? '')}
                        </td>

                        <td>

                            <button
                                type="button"
                                class="btn btn-warning btn-sm me-1"
                                onclick="editRoom(${room.id})">

                                <i class="bi bi-pencil"></i>
                                Edit

                            </button>

                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                onclick="deleteRoom(${room.id})">

                                <i class="bi bi-trash"></i>
                                Delete

                            </button>

                        </td>

                    </tr>

                `;
            });

        })

        .catch(error => {

            console.error('Error loading rooms:', error);

            document.getElementById('roomTableBody').innerHTML = `

                <tr>
                    <td
                        colspan="6"
                        class="text-center text-danger py-4">

                        Unable to load rooms.

                    </td>
                </tr>

            `;
        });
    }
    // Search Functions
    function searchSchedule() {
        hideSessionButton();
        const searchInput = document.getElementById('searchInput');
        const searchValue = searchInput.value.trim().toLowerCase();
        if (!searchValue) {
            alert('Please enter an appropriate value');
            return;
        }
        if (searchFilter === 'faculty') {
            searchFaculty(searchValue);
        }
        if (searchFilter === 'room') {
            searchRoom(searchValue);
        }
        if (searchFilter === 'section') {
            searchSection(searchValue);
        }
    }
    
    function searchFaculty(searchValue) {
        const faculty =
            facultyList.find(user => {
                const username = String(user.username ?? '').trim().toLowerCase();
                const login_id = String(user.login_id ?? '').trim().toLowerCase();
                return (username === searchValue || login_id === searchValue);});
        if (!faculty) {
            alert('Faculty member not found.');
            return;
        }
        searchResult = faculty;
        showSessionButton();
        const scheduleTable = document.getElementById('scheduleTable');
        if (scheduleTable) {
            scheduleTable.style.display = 'block';
        }
        loadSchedule(faculty.id);
    }

    function searchRoom(searchValue) {
        const room =
            roomList.find(room => {
                const room_name = String(room.room_name ?? '').trim().toLowerCase();
                const room_code = String(room.room_code ?? '').trim().toLowerCase();
                return (room_name === searchValue || room_code === searchValue);});
        if (!room) {
            alert('Room not found');
            return;
        }
        searchResult = room;
        showSessionButton();
        const scheduleTable = document.getElementById('scheduleTable');
        if (scheduleTable) {
            scheduleTable.style.display = 'block';
        }
        loadSchedule(room.id);
    }

    function searchSection(searchValue) {
        const section =
            sectionList.find(section => {
                const sec_name = String(section.sec_name ?? '').trim().toLowerCase();
                const sec_code = String(section.sec_code ?? '').trim().toLowerCase();
                return (sec_name === searchValue || sec_code === searchValue);});
        if (!section) {
            alert('Section not found.');
            return;
        }
        searchResult = section;
        showSessionButton();
        const scheduleTable = document.getElementById('scheduleTable');
        if (scheduleTable) {
            scheduleTable.style.display = 'block';
        }
        loadSchedule(section.id);
    }

// Schedule Functions
    function loadSchedule(id) {
        const filter = document.getElementById('managementFilter').value;
        let url = '';
        if (filter === 'faculty') {
            url ='<?= base_url('show_faculty_schedule') ?>/' +encodeURIComponent(id);
        } else if (filter === 'room') {
            url ='<?= base_url('show_room_schedule') ?>/' + encodeURIComponent(id); 
        } else if (filter === 'section') {
            url ='<?= base_url('show_section_schedule') ?>/' + encodeURIComponent(id); 
        }   
        fetch(url, {method: 'GET',headers: {'Accept': 'application/json'}
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load schedule. HTTP status: ' +response.status);
            }
            return response.json();
        })
        .then(schedule => {
            console.log('Schedule loaded:',schedule);
            if (!Array.isArray(schedule)) {
                console.error('Invalid schedule response:',schedule);
                generateTimetable([]);
                alert('The server returned an invalid schedule.');
                return;
            } else {generateTimetable(schedule);}
        })
        .catch(error => {
            console.error('Error loading schedule:',error);
            generateTimetable([]);
            alert('Unable to load the schedule.');
        });
    }

    function generateTimetable(schedule) {
        const filter = document.getElementById('managementFilter').value;
        const tbody = document.getElementById('scheduleBody');
        if (!tbody) {
            console.error('Schedule Body element was not found.');
            return;
        }
        tbody.innerHTML = '';
        const startMinutes = 7 * 60;
        const endMinutes = 20 * 60 + 30;
        const days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        for (
            let currentMinutes = startMinutes;
            currentMinutes < endMinutes;
            currentMinutes += 30
        ) {
            const row = document.createElement('tr');
            const timeCell = document.createElement('td');
            timeCell.className ='fw-semibold bg-light';
            timeCell.textContent = minutesToTime(currentMinutes) +' - ' +minutesToTime(currentMinutes + 30);
            row.appendChild(timeCell);
            days.forEach(day => {
                const cell = document.createElement('td');
                cell.dataset.day = day;
                cell.dataset.time =String(currentMinutes);
                cell.className ='schedule-empty';
                cell.innerHTML = `
                    <span class="text-muted small">
                        —
                    </span>
                `;
                row.appendChild(cell);
            });
            tbody.appendChild(row);
        }
        if (!Array.isArray(schedule) ||schedule.length === 0) {
            console.log('No sessions found. Empty timetable displayed.');
            return;
        }
        schedule.forEach(session => {
            const sessionDay = session.ses_day
            const sessionStart = timeToMinutes(session.ses_start)
            const sessionEnd = timeToMinutes(session.ses_end)
            const dayIndex = days.indexOf(sessionDay);
            const rows = tbody.querySelectorAll('tr');
            let targetCell = null;
            let targetRow = null;
            rows.forEach(row => {
                if (targetCell) {
                    return;
                }
                const cells =
                    row.querySelectorAll(
                        'td'
                    );
                if (cells.length <days.length + 1) {
                    return;
                }
                const cell = cells[dayIndex + 1];
                if (!cell) {
                    return;
                }
                const cellTime = parseInt(cell.dataset.time,10);
                if (cellTime === sessionStart) {
                    targetCell = cell;
                    targetRow = row;
                }
            });
            if (!targetCell || !targetRow) {
                console.warn('Could not find timetable cell for session:',session);
                return;
            }
            const duration = sessionEnd - sessionStart;
            const rowSpan = Math.max(1,Math.ceil(duration / 30));
            const totalRows = rows.length;
            const startRowIndex = Array.from(rows).indexOf(targetRow);
            const availableRows = totalRows - startRowIndex;
            const safeRowSpan = Math.min(rowSpan,availableRows);
            targetCell.rowSpan =safeRowSpan;
            targetCell.className = 'schedule-cell';
            // Assign a stable random color per session
            const sessionColor = getSessionColor(session.id);
            targetCell.style.backgroundColor = sessionColor;
            targetCell.innerHTML = `
                <div class="schedule-subject">
                    <strong>Subject:</strong>
                    ${escapeHtml(session.sub_name)}
                </div>
                <div class="schedule-section">
                    <strong>Section:</strong>
                    ${escapeHtml(session.sec_name)}
                </div>
                <div class="schedule-room">
                    <strong>Room:</strong>
                    ${escapeHtml(session.room_name)}
                </div>
                <div class="small mt-1">
                    <i class="bi bi-clock me-1"></i>
                    ${escapeHtml(session.ses_start)}
                    -
                    ${escapeHtml(session.ses_end)}
                </div>
                <div class="small text-primary mt-2">
                    <i class="bi bi-pencil-square me-1"></i>
                    Click to edit
                </div>
            `;
            targetCell.style.cursor = 'pointer';
            targetCell.title = 'Click to edit this session';
            targetCell.onclick = function () {
                editSession(session.id);
            };
            let currentRow =targetRow;
            for (let i = 1; i < safeRowSpan;i++) {
                const nextRow = currentRow.nextElementSibling;
                if (!nextRow) {
                    break;
                }
                const nextCells =nextRow.querySelectorAll('td');
                let cellToRemove =
                    null;
                nextCells.forEach(cell => {
                    if (cell.dataset && cell.dataset.day ===sessionDay) {
                        cellToRemove = cell;
                    }
                });
                if (cellToRemove) {
                    cellToRemove.remove();
                }
                currentRow = nextRow;
            }
        });
    }

// Minutes / Time Functions
    function timeToMinutes(time) {
        time = String(time).trim().toUpperCase();
        const match = time.match(/^(\d{1,2}):(\d{2})(?::(\d{2}))?\s*(AM|PM)?$/);
        if (!match) {
            console.warn('Unable to parse time:',time);
            return null;
        }
        let hour = parseInt(match[1],10);
        const minute = parseInt(match[2],10);
        const period =
            match[4];
        if (period === 'PM' && hour !== 12) {
            hour += 12;
        }
        if (period === 'AM' && hour === 12) {
            hour = 0;
        }
        return (hour * 60) + minute;
    }

    function minutesToTime(minutes) {
        let hour = Math.floor(minutes / 60);
        const minute = minutes % 60;
        const period = hour >= 12 ? 'PM' : 'AM';
        let displayHour = hour % 12;
        if (displayHour === 0) {
            displayHour = 12;
        }
        return (displayHour + ':' + String(minute).padStart(2, '0') +' ' +period);
    }

// Add Modals
    function openSessionModal() {
        editingSessionId = null;
        document.getElementById('sessionModalTitle').innerHTML =
            '<i class="bi bi-calendar-plus me-2"></i>Add Session';
        document.getElementById('saveSessionButton').innerHTML =
            '<i class="bi bi-check-circle me-1"></i>Create Session';
        document.getElementById('deleteSessionButton').style.display =
            'none';
        if (!searchResult) {
            alert(
                'Please search for a Faculty, Room or Section first.'
            );
            return;
        }
        const modalElement =
            document.getElementById(
                'addSessionModal'
            );
        if (!modalElement) {
            console.error(
                'Add Session modal was not found.'
            );
            return;
        }
        SessionModal =
            bootstrap.Modal.getOrCreateInstance(
                modalElement
            );
        loadSessionFormData()
            .then(() => {
                prepareSessionForm();
                SessionModal.show();
            })
            .catch(error => {
                console.error(error);
                alert(
                    'Unable to prepare the Add Session form.'
                );
            });
    }

    async function editSession(id) {
        editingSessionId = id;
        const modalElement =
            document.getElementById('addSessionModal');
        SessionModal =
            bootstrap.Modal.getOrCreateInstance(modalElement);
        try {
            // Load Faculty / Subject / Section / Room dropdowns
            await loadSessionFormData();
            // Get the existing session
            const response = await fetch(
                '<?= base_url('get_session') ?>/' +
                encodeURIComponent(id),
                {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );
            if (!response.ok) {
                throw new Error(
                    'Unable to retrieve session.'
                );
            }
            const session = await response.json();
            console.log('Session to edit:', session);
            // Change modal to EDIT mode
            document.getElementById('sessionModalTitle').innerHTML =
                '<i class="bi bi-pencil-square me-2"></i>Edit Session';
            document.getElementById('saveSessionButton').innerHTML =
                '<i class="bi bi-save me-1"></i>Save Changes';
            document.getElementById('deleteSessionButton').style.display =
                'block';
            // Enable all fields first
            document.getElementById('sessionFaculty').disabled = false;
            document.getElementById('sessionSubject').disabled = false;
            document.getElementById('sessionSection').disabled = false;
            document.getElementById('sessionRoom').disabled = false;
            // Populate values
            document.getElementById('sessionFaculty').value =
                session.faculty_id;
            document.getElementById('sessionSubject').value =
                session.subject_id;
            document.getElementById('sessionSection').value =
                session.section_id;
            document.getElementById('sessionRoom').value =
                session.room_id;
            document.getElementById('sessionType').value =
                session.ses_type;
            document.getElementById('sessionDay').value =
                session.ses_day;
            document.getElementById('sessionStart').value =
                session.ses_start.substring(0, 5);
            document.getElementById('sessionEnd').value =
                session.ses_end.substring(0, 5);
            // Set selected subject
            selectedSubject =
                subjectList.find(
                    subject =>
                        String(subject.id) ===
                        String(session.subject_id)
                );
            // Update displayed hour information
            updateSubjectInformation();
            updateSessionHours();
            clearSessionError();
            SessionModal.show();
        } catch (error) {
            console.error(
                'Error loading session:',
                error
            );
            alert(
                'Unable to load session information.'
            );
        }
    }
    
    async function deleteSession() {
        if (!editingSessionId) {
            return;
        }
        const confirmed = confirm(
            'Are you sure you want to delete this session?'
        );
        if (!confirmed) {
            return;
        }
        try {
            const response = await fetch(
                '<?= base_url('delete_session') ?>/' +
                encodeURIComponent(editingSessionId),
                {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );
            const result = await response.json();
            if (!response.ok || !result.success) {
                alert(
                    result.message ||
                    'Unable to delete session.'
                );
                return;
            }
            alert(
                'Session successfully deleted.'
            );
            editingSessionId = null;
            selectedSubject = null;
            if (SessionModal) {
                SessionModal.hide();
            }
            if (searchResult) {
                loadSchedule(searchResult.id);
            }
        } catch (error) {
            console.error(
                'Delete session error:',
                error
            );
            alert(
                'A server error occurred while deleting the session.'
            );
        }
    }

    async function loadSessionFormData() {
        try {
            const [
                facultyResponse,
                subjectResponse,
                sectionResponse,
                roomResponse
            ] = await Promise.all([
                fetch('<?= base_url('show_faculty') ?>'),
                fetch('<?= base_url('show_subjects') ?>'),
                fetch('<?= base_url('show_sections') ?>'),
                fetch('<?= base_url('show_room') ?>')
            ]);
            if (
                !facultyResponse.ok ||
                !subjectResponse.ok ||
                !sectionResponse.ok ||
                !roomResponse.ok
            ) {
                throw new Error(
                    'Unable to load session data.'
                );
            }
            facultyList =
                await facultyResponse.json();
            subjectList =
                await subjectResponse.json();
            sectionList =
                await sectionResponse.json();
            roomList =
                await roomResponse.json();
            populateFacultySelect();
            populateSubjectSelect();
            populateSectionSelect();
            populateRoomSelect();
        } catch (error) {
            console.error(
                'Session form loading error:',
                error
            );
            alert(
                'Unable to load faculty, subject, section, or room information.'
            );
        }
    }

    function prepareSessionForm() {
        const facultySelect =
            document.getElementById(
                'sessionFaculty'
            );
        const subjectSelect =
            document.getElementById(
                'sessionSubject'
            );
        const sectionSelect =
            document.getElementById(
                'sessionSection'
            );
        const roomSelect =
            document.getElementById(
                'sessionRoom'
            );
        facultySelect.disabled = false;
        subjectSelect.disabled = false;
        sectionSelect.disabled = false;
        roomSelect.disabled = false;
        if (searchFilter === 'faculty') {
            facultySelect.value =
                searchResult.id;
            facultySelect.disabled = true;
        }
        else if (searchFilter === 'room') {
            roomSelect.value =
                searchResult.id;
            roomSelect.disabled = true;
        }
        else if (searchFilter === 'section') {
            sectionSelect.value =
                searchResult.id;
            sectionSelect.disabled = true;
            filterSubjectsBySection();
        }
        selectedSubject = null;
        document.getElementById(
            'subjectHours'
        ).textContent = '0';
        document.getElementById(
            'sessionUnits'
        ).textContent = '0';
        document.getElementById(
            'remainingUnits'
        ).textContent = '0';
        document.getElementById(
            'subjectInformation'
        ).textContent = '';
        clearSessionError();
    }

    function openSubjectModal() {
        document.getElementById('subjectModalTitle').textContent =
            'Add Subject';
        document.getElementById('subjectId').value = '';
        document.getElementById('subjectCode').value = '';
        document.getElementById('subjectName').value = '';
        document.getElementById('subjectProgram').value = '';
        document.getElementById('subjectYear').value = '';
        document.getElementById('subjectSem').value = '';
        document.getElementById('subjectLecHours').value = '';
        document.getElementById('subjectLabHours').value = '';
        document.getElementById('subjectTotalHours').value = '';
        const modal = new bootstrap.Modal(
            document.getElementById('subjectModal')
        );
        modal.show();
    }

    function editSubject(id) {
        fetch(`<?= base_url('get_subject') ?>/${id}`)
            .then(response => response.json())
            .then(subject => {
                document.getElementById('subjectModalTitle').textContent =
                    'Edit Subject';
                document.getElementById('subjectId').value =
                    subject.id;
                document.getElementById('subjectCode').value =
                    subject.sub_code;
                document.getElementById('subjectName').value =
                    subject.sub_name;
                document.getElementById('subjectProgram').value =
                    subject.sub_program;
                document.getElementById('subjectYear').value =
                    subject.sub_year;
                document.getElementById('subjectSem').value =
                    subject.sub_sem;
                document.getElementById('subjectLecHours').value =
                    subject.sub_lec_hours;
                document.getElementById('subjectLabHours').value =
                    subject.sub_lab_hours;
                document.getElementById('subjectTotalHours').value =
                    subject.sub_total_hours;
                const modal = new bootstrap.Modal(
                    document.getElementById('subjectModal')
                );
                modal.show();
            });
    }

    function saveSubject() {
        const id =
            document.getElementById('subjectId').value;
        const formData = new FormData();
        formData.append(
            'sub_code',
            document.getElementById('subjectCode').value
        );
        formData.append(
            'sub_name',
            document.getElementById('subjectName').value
        );
        formData.append(
            'sub_program',
            document.getElementById('subjectProgram').value
        );
        formData.append(
            'sub_year',
            document.getElementById('subjectYear').value
        );
        formData.append(
            'sub_sem',
            document.getElementById('subjectSem').value
        );
        formData.append(
            'sub_lec_hours',
            document.getElementById('subjectLecHours').value
        );
        formData.append(
            'sub_lab_hours',
            document.getElementById('subjectLabHours').value
        );
        formData.append(
            'sub_total_hours',
            document.getElementById('subjectTotalHours').value
        )
        let url;
        if (id) {
            url = `<?= base_url('update_subject') ?>/${id}`;
        } else {
            url = `<?= base_url('create_subject') ?>`;
        }
        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.message);
                bootstrap.Modal
                    .getInstance(
                        document.getElementById('subjectModal')
                    )
                    .hide();
                loadSubjectList();
            } else {
                alert(
                    result.message ||
                    'Unable to save subject.'
                );
            }
        })
        .catch(error => {
            console.error(error);
            alert('An error occurred while saving the subject.');
        });
    }

    function deleteSubject(id) {
        if (!confirm('Are you sure you want to delete this subject?')) {
            return;
        }
        fetch(`<?= base_url('delete_subject') ?>/${id}`, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.message);
                loadSubjectList();
            } else {
                alert(
                    result.message ||
                    'Unable to delete subject.'
                );
            }
        })
        .catch(error => {
            console.error(error);
            alert('An error occurred while deleting the subject.');
        });
    }
    
    function openSectionModal() {
        document.getElementById(
            'sectionModalTitle'
        ).textContent = 'Add Section';
        document.getElementById(
            'sectionId'
        ).value = '';
        document.getElementById(
            'sectionCode'
        ).value = '';
        document.getElementById(
            'sectionName'
        ).value = '';
        document.getElementById(
            'sectionProgram'
        ).value = '';
        document.getElementById(
            'sectionSize'
        ).value = '';
        document.getElementById(
            'sectionYear'
        ).value = '';
        const modal =
            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('sectionModal')
            );
        modal.show();
    }


    function editSection(id) {
        fetch(
            '<?= base_url('get_section') ?>/' +
            encodeURIComponent(id),
            {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            }
        )
        .then(response => {
            if (!response.ok) {
                throw new Error(
                    'Failed to retrieve section.'
                );
            }
            return response.json();
        })
        .then(section => {
            document.getElementById('sectionId').value =
                section.id ?? '';
            document.getElementById('sectionCode').value =
                section.sec_code ?? '';
            document.getElementById('sectionName').value =
                section.sec_name ?? '';
            document.getElementById('sectionProgram').value =
                section.sec_prog ?? '';
            document.getElementById('sectionYear').value =
                section.sec_year ?? '';
            document.getElementById('sectionSize').value =
                section.sec_size ?? '';
            document.getElementById('sectionModalTitle').textContent =
                'Edit Section';
            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('sectionModal')
            ).show();
        })
        .catch(error => {
            console.error(
                'Error loading section:',
                error
            );
            alert(
                'Unable to load section information.'
            );
        });
    }

    function saveSection() {
        const id =
            document.getElementById('sectionId').value;
        const formData = new FormData();
        formData.append(
            'sec_code',
            document.getElementById('sectionCode').value.trim()
        );
        formData.append(
            'sec_name',
            document.getElementById('sectionName').value.trim()
        );
        formData.append(
            'sec_prog',
            document.getElementById('sectionProgram').value.trim()
        );
        formData.append(
            'sec_size',
            document.getElementById('sectionSize').value
        );
        formData.append(
            'sec_year',
            document.getElementById('sectionYear').value
        );
        let url;
        if (id) {
            url =
                `<?= base_url('update_section') ?>/${id}`;
        } else {
            url =
                `<?= base_url('create_section') ?>`;
        }
        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            console.log(
                'Save section result:',
                result
            );
            if (result.success) {
                alert(
                    result.message ||
                    'Section saved successfully.'
                );
                const modal =
                    bootstrap.Modal.getInstance(
                        document.getElementById('sectionModal')
                    );
                if (modal) {
                    modal.hide();
                }
                loadSectionManagementList();
                // Also refresh the section list
                // used by Schedule Management.
                loadSectionList();
            } else {
                alert(
                    result.message ||
                    'Unable to save section.'
                );
            }
        })
        .catch(error => {
            console.error(
                'Error saving section:',
                error
            );
            alert(
                'An error occurred while saving the section.'
            );
        });
    }

    function deleteSection(id) {
        if (
            !confirm(
                'Are you sure you want to delete this section?'
            )
        ) {
            return;
        }
        fetch(
            `<?= base_url('delete_section') ?>/${id}`,
            {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                }
            }
        )
        .then(response => {
            if (!response.ok) {
                throw new Error(
                    'Delete request failed. HTTP status: ' +
                    response.status
                );
            }
            return response.json();
        })
        .then(result => {
            if (result.success) {
                alert(
                    result.message ||
                    'Section deleted successfully.'
                );
                loadSectionManagementList();
                // Refresh schedule-management section data
                loadSectionList();
            } else {
                alert(
                    result.message ||
                    'Unable to delete section.'
                );
            }
        })
        .catch(error => {
            console.error(
                'Error deleting section:',
                error
            );
            alert(
                'An error occurred while deleting the section.'
            );
        });
    }

    function openFacultyModal() {
        clearFacultyForm();
        document.getElementById('facultyModalTitle').textContent =
            'Add Faculty';
        const modal = bootstrap.Modal.getOrCreateInstance(
            document.getElementById('facultyModal')
        );
        modal.show();
    }

    function clearFacultyForm() {
        document.getElementById('facultyId').value = '';
        document.getElementById('loginId').value = '';
        document.getElementById('username').value = '';
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';
        document.getElementById('college').value = '';
        document.getElementById('department').value = '';
        document.getElementById('academicRank').value = '';
        document.getElementById('labUnits').value = '0';
        document.getElementById('lecUnits').value = '0';
        document.getElementById('extraUnits').value = '0';
    }

    function saveFaculty() {
        const facultyId = document.getElementById('facultyId').value.trim();
        const formData = new FormData();
        formData.append(
            'login_id',
            document.getElementById('loginId').value.trim()
        );
        formData.append(
            'username',
            document.getElementById('username').value.trim()
        );
        formData.append(
            'email',
            document.getElementById('email').value.trim()
        );
        formData.append(
            'college',
            document.getElementById('college').value
        );
        formData.append(
            'department',
            document.getElementById('department').value
        );
        formData.append(
            'academic_rank',
            document.getElementById('academicRank').value
        );
        formData.append(
            'total_lab_units',
            document.getElementById('labUnits').value || '0'
        );
        formData.append(
            'total_lec_units',
            document.getElementById('lecUnits').value || '0'
        );
        formData.append(
            'total_extra_units',
            document.getElementById('extraUnits').value || '0'
        );
        const password = document.getElementById('password').value;
        if (password !== '') {
            formData.append('password', password);
        }
        let url;
        if (facultyId !== '') {
            url = '<?= base_url('update_faculty') ?>/' + facultyId;
        } else {
            url = '<?= base_url('create_faculty') ?>';
        }
        fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async response => {
            const result = await response.json();
            console.log('Server response:', result);
            if (!response.ok) {
                throw new Error(
                    result.message || 'Server returned an error.'
                );
            }
            return result;
        })
        .then(result => {
            if (result.success) {
                alert(
                    facultyId !== ''
                        ? 'Faculty updated successfully.'
                        : 'Faculty added successfully.'
                );
                const modalElement =
                    document.getElementById('facultyModal');
                const modal =
                    bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }
                loadFacultyManagementList();
            } else {
                alert(
                    result.message ||
                    'Unable to save faculty.'
                );
                console.error('Save faculty errors:', result.errors);
            }
        })
        .catch(error => {
            console.error('Error saving faculty:', error);
            alert(error.message || 'An error occurred while saving faculty.');
        });
    }

    function editFaculty(id) {
        fetch(
            '<?= base_url('get_faculty') ?>/' + encodeURIComponent(id),
            {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            }
        )
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to retrieve faculty.');
            }
            return response.json();
        })
        .then(faculty => {
            document.getElementById('facultyId').value =
                faculty.id ?? '';
            document.getElementById('loginId').value =
                faculty.login_id ?? '';
            document.getElementById('username').value =
                faculty.username ?? '';
            document.getElementById('email').value =
                faculty.email ?? '';
            // Password is intentionally blank when editing
            document.getElementById('password').value = '';
            document.getElementById('college').value =
                faculty.college ?? '';
            document.getElementById('department').value =
                faculty.department ?? '';
            document.getElementById('academicRank').value =
                faculty.academic_rank ?? '';
            document.getElementById('labUnits').value =
                faculty.total_lab_units ?? 0;
            document.getElementById('lecUnits').value =
                faculty.total_lec_units ?? 0;
            document.getElementById('extraUnits').value =
                faculty.total_extra_units ?? 0;
            document.getElementById('facultyModalTitle').textContent =
                'Edit Faculty';
            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('facultyModal')
            ).show();
        })
        .catch(error => {
            console.error('Error loading faculty:', error);
            alert('Unable to load faculty information.');
        });
    }

    function deleteFaculty(id) {
        if (!confirm(
            'Are you sure you want to delete this faculty member?'
        )) {
            return;
        }
        fetch(
            '<?= base_url('delete_faculty') ?>/' +
            encodeURIComponent(id),
            {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                }
            }
        )
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Faculty deleted successfully.');
                loadFacultyManagementList();
            } else {
                alert(
                    result.message ||
                    'Unable to delete faculty.'
                );
            }
        })
        .catch(error => {
            console.error('Error deleting faculty:', error);
            alert('An error occurred while deleting faculty.');
        });
    }

    function openRoomModal() {
        clearRoomForm();
        document.getElementById('roomModalTitle').textContent =
            'Add Room';
        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('roomModal')
        ).show();
    }

    function clearRoomForm() {

        document.getElementById('roomId').value = '';

        document.getElementById('roomCode').value = '';

        document.getElementById('roomName').value = '';

        document.getElementById('roomType').value = '';

        document.getElementById('roomTime').value = '';

        document.getElementById('roomSize').value = '';
    }

    function saveRoom() {

        const roomId =
            document.getElementById('roomId').value.trim();

        const roomCode =
            document.getElementById('roomCode').value.trim();

        const roomName =
            document.getElementById('roomName').value.trim();

        const roomType =
            document.getElementById('roomType').value;

        const roomTime =
            document.getElementById('roomTime').value.trim();

        const roomSize =
            document.getElementById('roomSize').value;

        /*
        * Client-side validation
        */

        if (
            roomCode === '' ||
            roomName === '' ||
            roomType === '' ||
            roomTime === '' ||
            roomSize === ''
        ) {

            alert('Please complete all required room fields.');

            return;
        }

        const formData = new FormData();

        formData.append('room_code', roomCode);

        formData.append('room_name', roomName);

        formData.append('room_type', roomType);

        formData.append('room_time', roomTime);

        formData.append('room_size', roomSize);

        let url;

        if (roomId !== '') {

            url =
                '<?= base_url('update_room') ?>/' +
                encodeURIComponent(roomId);

        } else {

            url =
                '<?= base_url('create_room') ?>';
        }

        fetch(url, {

            method: 'POST',

            headers: {
                'Accept': 'application/json'
            },

            body: formData

        })

        .then(async response => {

            const result = await response.json();

            console.log('Room save result:', result);

            if (!response.ok) {

                throw new Error(
                    result.message ||
                    'Unable to save room.'
                );
            }

            return result;

        })

        .then(result => {

            if (result.success) {

                alert(
                    roomId !== ''
                        ? 'Room updated successfully.'
                        : 'Room added successfully.'
                );

                const modalElement =
                    document.getElementById('roomModal');

                const modal =
                    bootstrap.Modal.getInstance(modalElement);

                if (modal) {
                    modal.hide();
                }

                loadRoomManagementList();

            } else {

                alert(
                    result.message ||
                    'Unable to save room.'
                );

                console.error(result.errors);
            }

        })

        .catch(error => {

            console.error('Error saving room:', error);

            alert(error.message);
        });
    }

    function editRoom(id) {

        fetch(
            '<?= base_url('get_room') ?>/' +
            encodeURIComponent(id),
            {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            }
        )

        .then(response => {

            if (!response.ok) {
                throw new Error('Failed to retrieve room.');
            }

            return response.json();

        })

        .then(room => {

            document.getElementById('roomId').value =
                room.id ?? '';

            document.getElementById('roomCode').value =
                room.room_code ?? '';

            document.getElementById('roomName').value =
                room.room_name ?? '';

            document.getElementById('roomType').value =
                room.room_type ?? '';

            document.getElementById('roomTime').value =
                room.room_time ?? '';

            document.getElementById('roomSize').value =
                room.room_size ?? '';

            document.getElementById('roomModalTitle').textContent =
                'Edit Room';

            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('roomModal')
            ).show();

        })

        .catch(error => {

            console.error('Error loading room:', error);

            alert('Unable to load room information.');

        });
    }

    function deleteRoom(id) {
        if (!id) {

            alert('Invalid room ID.');

            return;
        }

        if (!confirm(
            'Are you sure you want to delete this room?'
        )) {

            return;
        }

        fetch(
            '<?= base_url('delete_room') ?>/' +
            encodeURIComponent(id),
            {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                }
            }
        )

        .then(async response => {

            const result = await response.json();

            if (!response.ok) {

                throw new Error(
                    result.message ||
                    'Unable to delete room.'
                );
            }

            return result;

        })

        .then(result => {

            if (result.success) {

                alert('Room deleted successfully.');

                loadRoomManagementList();

            } else {

                alert(
                    result.message ||
                    'Unable to delete room.'
                );
            }

        })

        .catch(error => {

            console.error('Error deleting room:', error);

            alert(error.message);
        });
    }
    
    // Faculty / Load / Room Form Data
    function populateFacultySelect() {
        const select = document.getElementById('sessionFaculty');
        select.innerHTML = '<option value="">Select Faculty</option>';
        facultyList.forEach(faculty => {
            const option = document.createElement('option');
            option.value = faculty.id;
            option.textContent =
                `${faculty.username} (${faculty.login_id})`;
            select.appendChild(option);
        });
    }

    function populateRoomSelect() {
        const select =
            document.getElementById('sessionRoom');
        select.innerHTML =
            '<option value="">Select Room</option>';
        roomList.forEach(room => {
            const option =
                document.createElement('option');
            option.value =
                room.id;
            option.textContent =
                `${room.room_code} - ${room.room_name}`;
            select.appendChild(option);
        });
    }

    function populateSubjectSelect(
        subjects = subjectList,
        selectedSubjectId = ''
    ) {
        const select = document.getElementById('sessionSubject');
        select.innerHTML =
            '<option value="">Select Subject</option>';
        subjects.forEach(subject => {
            const option = document.createElement('option');
            option.value = subject.id;
            option.textContent =
                `${subject.sub_code} - ${subject.sub_name}`;
            // Store program and year for filtering
            option.dataset.program =
                subject.sub_program;
            option.dataset.year =
                subject.sub_year;
            select.appendChild(option);
        });
        if (subjects.some(subject =>
            String(subject.id) === String(selectedSubjectId)
        )) {
            select.value = String(selectedSubjectId);
        }
    }

    function populateSectionSelect(
        sections = sectionList,
        selectedSectionId = ''
    ) {
        const select =
            document.getElementById('sessionSection');
        select.innerHTML =
            '<option value="">Select Section</option>';
        sections.forEach(section => {
            const option =
                document.createElement('option');
            option.value =
                section.id;
            option.textContent =
                `${section.sec_code} - ${section.sec_name}`;
            // Store program and year for filtering
            option.dataset.program =
                section.sec_prog;
            option.dataset.year =
                section.sec_year;
            select.appendChild(option);
        });
        if (sections.some(section =>
            String(section.id) === String(selectedSectionId)
        )) {
            select.value = String(selectedSectionId);
        }
    }

    function filterSectionsBySubject() {
        const subjectId =
            document.getElementById('sessionSubject').value;
        const sectionSelect =
            document.getElementById('sessionSection');
        const selectedSectionId = sectionSelect.value;
        // Nothing selected
        if (!subjectId) {
            populateSectionSelect(sectionList, selectedSectionId);
            return;
        }
        const selectedSubject =
            subjectList.find(subject =>
                String(subject.id) ===
                String(subjectId)
            );
        if (!selectedSubject) {
            populateSectionSelect(sectionList, selectedSectionId);
            return;
        }
        const subjectProgram =
            String(selectedSubject.sub_program)
                .trim()
                .toLowerCase();
        const subjectYear =
            String(selectedSubject.sub_year)
                .trim();
        const matchingSections =
            sectionList.filter(section => {
                const sectionProgram =
                    String(section.sec_prog)
                        .trim()
                        .toLowerCase();
                const sectionYear =
                    String(section.sec_year)
                        .trim();
                return (
                    sectionProgram === subjectProgram &&
                    sectionYear === subjectYear
                );
            });
        populateSectionSelect(matchingSections, selectedSectionId);
    }

    function filterSubjectsBySection() {
        const sectionId =
            document.getElementById('sessionSection').value;
        const selectedSubjectId =
            document.getElementById('sessionSubject').value;
        if (!sectionId) {
            populateSubjectSelect(subjectList, selectedSubjectId);
            return;
        }
        const selectedSection =
            sectionList.find(section =>
                String(section.id) ===
                String(sectionId)
            );
        if (!selectedSection) {
            populateSubjectSelect(subjectList, selectedSubjectId);
            return;
        }
        const sectionProgram =
            String(selectedSection.sec_prog)
                .trim()
                .toLowerCase();
        const sectionYear =
            String(selectedSection.sec_year)
                .trim();
        const matchingSubjects =
            subjectList.filter(subject => {
                const subjectProgram =
                    String(subject.sub_program)
                        .trim()
                        .toLowerCase();
                const subjectYear =
                    String(subject.sub_year)
                        .trim();
                return (
                    subjectProgram === sectionProgram &&
                    subjectYear === sectionYear
                );
            });
        populateSubjectSelect(matchingSubjects, selectedSubjectId);
    }

    function updateSubjectInformation() {
    const subjectId =
        document.getElementById(
            'sessionSubject'
        ).value;
    selectedSubject =
        subjectList.find(subject =>
            String(subject.id) ===
            String(subjectId)
        );
    const information =
        document.getElementById(
            'subjectInformation'
        );
    if (!selectedSubject) {
        information.textContent = '';
        document.getElementById(
            'subjectHours'
        ).textContent = '0';
        document.getElementById(
            'remainingUnits'
        ).textContent = '0';
        refreshScheduledSubjectHours();
        return;
    }
    information.textContent =
        `Lecture: ${selectedSubject.sub_lec_hours ?? 0} hours | ` +
        `Laboratory: ${selectedSubject.sub_lab_hours ?? 0} hours | ` +
        `Total: ${selectedSubject.sub_total_hours ?? 0} hours`;
    updateSessionHours();
    refreshScheduledSubjectHours();
}

    function getSubjectHours(subject) {
    if (!subject) {
        return 0;
    }
    const type =
        document.getElementById(
            'sessionType'
        ).value;
    if (type === 'Lab') {
        return Number(
            subject.sub_lab_hours ?? 0
        );
    }
    return Number(
        subject.sub_lec_hours ?? 0
    );
}

    async function refreshScheduledSubjectHours() {
        const requestId = ++subjectHoursRequestId;
        const subjectId =
            document.getElementById('sessionSubject').value;
        const sectionId =
            document.getElementById('sessionSection').value;

        if (!subjectId || !sectionId) {
            scheduledSubjectHours = { lab: 0, lecture: 0 };
            scheduledSubjectHoursLoaded = true;
            updateSessionHours();
            return;
        }

        scheduledSubjectHoursLoaded = false;
        updateSessionHours();

        const url =
            '<?= base_url('get_subject_session_hours') ?>/' +
            encodeURIComponent(subjectId) +
            '/' +
            encodeURIComponent(sectionId) +
            (editingSessionId
                ? '?exclude_session_id=' +
                    encodeURIComponent(editingSessionId)
                : '');

        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            if (!response.ok || !result.success) {
                throw new Error(
                    result.message ||
                    'Unable to load previously scheduled subject hours.'
                );
            }

            const labHours = Number(result.hours?.lab);
            const lectureHours = Number(result.hours?.lecture);
            if (!Number.isFinite(labHours) || !Number.isFinite(lectureHours)) {
                throw new Error(
                    'The server returned invalid scheduled subject hours.'
                );
            }
            if (requestId !== subjectHoursRequestId) {
                return;
            }

            scheduledSubjectHours = {
                lab: labHours,
                lecture: lectureHours
            };
            scheduledSubjectHoursLoaded = true;
            updateSessionHours();
        } catch (error) {
            if (requestId !== subjectHoursRequestId) {
                return;
            }
            scheduledSubjectHoursLoaded = false;
            updateSessionHours();
            console.error(
                'Error loading scheduled subject hours:',
                error
            );
            showSessionError(
                error.message ||
                'Unable to load previously scheduled subject hours.'
            );
        }
    }

    function calculateSubjectTotalHours() {
        const lectureHours =
            Number(
                document.getElementById(
                    'subjectLecHours'
                ).value
            ) || 0;
        const laboratoryHours =
            Number(
                document.getElementById(
                    'subjectLabHours'
                ).value
            ) || 0;
        document.getElementById(
            'subjectTotalHours'
        ).value =
            lectureHours + laboratoryHours;
    }

    // Add Session Validation
    function updateSessionHours() {
    const start =
        document.getElementById(
            'sessionStart'
        ).value;
    const end =
        document.getElementById(
            'sessionEnd'
        ).value;
    const sessionUnitsElement =
        document.getElementById(
            'sessionUnits'
        );
    const remainingUnitsElement =
        document.getElementById(
            'remainingUnits'
        );
    const subjectHoursElement =
        document.getElementById(
            'subjectHours'
        );
    if (!selectedSubject) {
        subjectHoursElement.textContent = '0';
        sessionUnitsElement.textContent = '0';
        remainingUnitsElement.textContent = '0';
        clearSessionError();
        return;
    }
    const subjectHours =
        getSubjectHours(selectedSubject);
    subjectHoursElement.textContent =
        subjectHours;
    if (!scheduledSubjectHoursLoaded) {
        sessionUnitsElement.textContent = '—';
        remainingUnitsElement.textContent = 'Loading...';
        return;
    }
    const sessionType =
        document.getElementById('sessionType').value;
    const previouslyScheduledHours =
        sessionType === 'Lab'
            ? scheduledSubjectHours.lab
            : scheduledSubjectHours.lecture;
    const availableHours =
        Math.max(0, subjectHours - previouslyScheduledHours);
    if (!start || !end) {
        sessionUnitsElement.textContent = '0';
        remainingUnitsElement.textContent =
            Number(availableHours.toFixed(2));
        clearSessionError();
        return;
    }
    const startMinutes =
        timeToMinutes(start);
    const endMinutes =
        timeToMinutes(end);
    if (
        startMinutes === null ||
        endMinutes === null ||
        endMinutes <= startMinutes
    ) {
        sessionUnitsElement.textContent =
            '0';
        remainingUnitsElement.textContent =
            Number(availableHours.toFixed(2));
        showSessionError(
            'End time must be later than start time.'
        );
        return;
    }
    const durationMinutes =
        endMinutes - startMinutes;
    const sessionHours =
        durationMinutes / 60;
    sessionUnitsElement.textContent =
        Number.isInteger(sessionHours)
            ? sessionHours
            : sessionHours.toFixed(2);
    const remaining =
        availableHours - sessionHours;
    remainingUnitsElement.textContent =
        remaining >= 0
            ? Number(remaining.toFixed(2))
            : '0';
    if (sessionHours > availableHours) {
        showSessionError(
            `This subject and section already have ${previouslyScheduledHours} hours scheduled; only ${availableHours} hours remain.`
        );
    } else {
        clearSessionError();
    }
}

    function validateSessionUnits() {
        if (!selectedSubject) {
            showSessionError(
                'Please select a subject.'
            );
            return false;
        }
        if (!scheduledSubjectHoursLoaded) {
            showSessionError(
                'Previously scheduled subject hours are still loading or unavailable. Please try again.'
            );
            return false;
        }
        const start =
            document.getElementById(
                'sessionStart'
            ).value;
        const end =
            document.getElementById(
                'sessionEnd'
            ).value;
        const startMinutes =
            timeToMinutes(start);
        const endMinutes =
            timeToMinutes(end);
        if (
            startMinutes === null ||
            endMinutes === null
        ) {
            showSessionError(
                'Please enter a valid start and end time.'
            );
            return false;
        }
        if (endMinutes <= startMinutes) {
            showSessionError(
                'End time must be later than start time.'
            );
            return false;
        }
        if (startMinutes % 30 !== 0 || endMinutes % 30 !== 0) {
            showSessionError(
                'Start and end times must use 30-minute intervals.'
            );
            return false;
        }
        const sessionHours =
            (endMinutes - startMinutes) / 60;
        const subjectHours =
            getSubjectHours(selectedSubject);
        const sessionType =
            document.getElementById('sessionType').value;
        const previouslyScheduledHours =
            sessionType === 'Lab'
                ? scheduledSubjectHours.lab
                : scheduledSubjectHours.lecture;
        const availableHours =
            Math.max(0, subjectHours - previouslyScheduledHours);
        if (sessionHours > availableHours) {
            showSessionError(
                `This subject and section already have ${previouslyScheduledHours} hours scheduled; only ${availableHours} hours remain.`
            );
            return false;
        }
        return true;
    }

// Create Session
    document
    .getElementById('addSessionForm')
    .addEventListener(
        'submit',
        async function(event) {
            event.preventDefault();
            if (!validateSessionUnits()) {
                return;
            }
            const facultyId =
                document.getElementById(
                    'sessionFaculty'
                ).value;
            const subjectId =
                document.getElementById(
                    'sessionSubject'
                ).value;
            const sectionId =
                document.getElementById(
                    'sessionSection'
                ).value;
            const roomId =
                document.getElementById(
                    'sessionRoom'
                ).value;
            const sessionType =
                document.getElementById(
                    'sessionType'
                ).value;
            const day =
                document.getElementById(
                    'sessionDay'
                ).value;
            const start =
                document.getElementById(
                    'sessionStart'
                ).value;
            const end =
                document.getElementById(
                    'sessionEnd'
                ).value;
            const sessionUnits =
                (
                    timeToMinutes(end) -
                    timeToMinutes(start)
                ) / 60;
            const data = {
                faculty_id: facultyId,
                subject_id: subjectId,
                section_id: sectionId,
                room_id: roomId,
                ses_type: sessionType,
                ses_units: sessionUnits,
                ses_day: day,
                ses_start: start,
                ses_end: end
            };
            try {
                const url = editingSessionId
                    ? '<?= base_url('update_session') ?>/' +
                    encodeURIComponent(editingSessionId): 
                    '<?= base_url('create_session') ?>';
                const response = await fetch(
                    url,
                    {
                        method: 'POST',
                            headers: {
                                'Content-Type':
                                    'application/json',
                                'Accept':
                                    'application/json'
                            },
                            body:
                                JSON.stringify(data)
                        }
                    );
                const result =
                    await response.json();
                if (
                    !response.ok ||
                    !result.success
                ) {
                    alert(
                        result.message ||
                        'Unable to create session.'
                    );
                    return;
                }
                alert(
                    editingSessionId
                        ? 'Session successfully updated.'
                        : 'Session successfully created.'
                );
                document
                    .getElementById(
                        'addSessionForm'
                    )
                    .reset();
                selectedSubject = null;
                document.getElementById(
                    'subjectHours'
                ).textContent = '0';
                document.getElementById(
                    'sessionUnits'
                ).textContent = '0';
                document.getElementById(
                    'remainingUnits'
                ).textContent = '0';
                document.getElementById(
                    'subjectInformation'
                ).textContent = '';
                clearSessionError();
                if (SessionModal) {
                    SessionModal.hide();
                }
                // Reload the current schedule
                if (searchResult) {
                    loadSchedule(
                        searchResult.id
                    );
                }
            } catch (error) {
                console.error(
                    'Create session error:',
                    error
                );
                alert(
                    'A server error occurred while creating the session.'
                );
            }
        }
    );

// General Helpers
    function escapeHtml(value) {
        if (
            value === null ||
            value === undefined
        ) {
            return '';
        }
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function showSessionError(message) {
        const element = document.getElementById('sessionValidation');
        if (element) {
            element.innerHTML = `
                <div class="alert alert-danger mb-0">
                    ${escapeHtml(message)}
                </div>
            `;
        }
    }

    function clearSessionError() {
        const element = document.getElementById('sessionValidation');
        if (element) {
            element.innerHTML = '';
        }
    }

</script>
</body>
</html>