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
        }
        body {
            background-color: #f8f9fa;
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
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1rem;
            margin-bottom: 0.2rem;
            border-radius: 0.375rem;
        }
        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
        }
        /* Main Layout */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }
        /* Content Area */
        .content-area {
            flex: 1;
            padding: 1.5rem;
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
            #scheduleTable { min-width: 1000px; } 
            #scheduleTable th { vertical-align: middle; } 
            #scheduleTable td { height: 80px; min-width: 140px; vertical-align: middle; } 
            .schedule-cell { background-color: #e7f1ff; border-radius: 6px; padding: 8px; font-size: 13px; } 
            .schedule-subject { font-weight: bold; font-size: 14px; } 
            .schedule-section { font-size: 12px; } 
            .schedule-room { font-size: 12px; color: #6c757d; }
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
                    <a href="#" class="nav-link active">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" onclick="showSchedule();" class="nav-link">
                        <i class="bi bi-folder me-2"></i>
                        Schedule Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" onclick="showFaculty(); return false;" class="nav-link">
                        <i class="bi bi-folder me-2"></i>
                        Faculty Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" onclick="showRooms(); return false;" class="nav-link">
                        <i class="bi bi-folder me-2"></i>
                        Room Management
                    </a>
                </li>
                                <li class="nav-item">
                    <a href="#" onclick="showSections(); return false;" class="nav-link">
                        <i class="bi bi-folder me-2"></i>
                        Section Management
                    </a>
                </li>
                            <li class="nav-item">
                    <a href="#" onclick="showSubjects(); return false;" class="nav-link">
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
                    <span>Bai User</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="userMenu">
                    <li><a class="dropdown-item" href="<?php echo base_url('profile'); ?>">Profile</a></li>
                    <li><a class="dropdown-item" href="<?php echo base_url('settings'); ?>">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
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
                <div class="ms-auto d-flex align-items-center">
                    <!-- Right Navbar Actions Placeholder -->
                    <button class="btn btn-light rounded-circle me-2">
                        <i class="bi bi-bell"></i>
                    </button>
                </div>
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
                                <h5 class="modal-title">
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
                                        <select id="sessionFaculty" class="form-select" required onchange="filterLoadsByFaculty()">
                                            <option value="">
                                                Select Faculty
                                            </option>
                                        </select>
                                    </div>
                                    <!-- LOAD -->
                                    <div class="mb-3">
                                        <label for="sessionLoad" class="form-label">
                                            Load
                                        </label>
                                        <select id="sessionLoad" class="form-select" required onchange="updateLoadInformation()">
                                            <option value="">
                                                Select Load
                                            </option>
                                        </select>
                                        <div
                                            id="loadInformation"
                                            class="form-text">
                                        </div>
                                    </div>
                                    <!-- ROOM -->
                                    <div class="mb-3">
                                        <label for="sessionRoom" class="form-label">
                                            Room
                                        </label>
                                        <select id="sessionRoom" class="form-select" required>
                                            <option value="">
                                                Select Room
                                            </option>
                                        </select>
                                        <div id="roomInformation" class="form-text">
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
                                                onchange="updateLoadInformation()">
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
                                                required>
                                        </div>
                                    </div>
                                    <!-- UNIT INFORMATION -->
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <div class="row text-center">
                                                <div class="col-md-4">
                                                    <small class="text-muted">
                                                        Load Units
                                                    </small>
                                                    <h5 id="loadUnits">
                                                        0
                                                    </h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted">
                                                        Session Units
                                                    </small>
                                                    <h5 id="sessionUnits">
                                                        0
                                                    </h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted">
                                                        Remaining Units
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
    let loadList = [];
    let selectedLoad = null;
    let SessionModal = null;

    let searchResult = null;
    let searchFilter = null;

// Initialization 
    document.addEventListener('DOMContentLoaded', function () {
        changeManagementFilter();
        document
            .getElementById('sessionStart')
            .addEventListener(
                'change',
                calculateSessionUnits
            );
        document
            .getElementById('sessionEnd')
            .addEventListener(
                'change',
                calculateSessionUnits
            );
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
        ];
        areas.forEach(id => {
            const element = document.getElementById(id);
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
        hideSessionButton();
        const managementFilter =
            document.getElementById('managementFilter');
        if (managementFilter) {
            managementFilter.value = 'faculty';
        }
        changeManagementFilter();
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
        const url = '<?= base_url('show_section') ?>';
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
            targetCell.className ='schedule-cell';
            targetCell.innerHTML = `
                <div class="schedule-subject">
                    <strong>Subject:</strong>
                    ${escapeHtml(
                        session.sub_name
                    )}
                </div>
                <div class="schedule-section">
                    <strong>Section:</strong>
                    ${escapeHtml(
                        session.sec_name
                    )}
                </div>
                <div class="schedule-room">
                    <strong>Room:</strong>
                    ${escapeHtml(
                        session.room_name
                    )}
                </div>
                <div class="small mt-1">
                    <i class="bi bi-clock me-1"></i>
                    ${escapeHtml(
                        session.ses_start
                    )}
                    -
                    ${escapeHtml(
                        session.ses_end
                    )}
                </div>
            `;
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

// Add Session Modal

    function openSessionModal() {
        if (!searchResult) {
            alert('Please search for a Faculty, Room or Section');
            return;
        }
        const modalElement =
            document.getElementById('addSessionModal');
        SessionModal =
            bootstrap.Modal.getOrCreateInstance(modalElement);
        loadSessionFormData().then(() => {
            prepareSessionForm();
            SessionModal.show();
        });
    }

    async function loadSessionFormData() {
        try {
            const [
                facultyResponse,
                roomResponse,
                loadResponse
            ] = await Promise.all([
                fetch('<?= base_url('show_faculty') ?>'),
                fetch('<?= base_url('show_room') ?>'),
                fetch('<?= base_url('show_load') ?>')
            ]);
            if (!facultyResponse.ok ||!roomResponse.ok ||!loadResponse.ok) {
                throw new Error('Unable to load session data.');
            }
            facultyList = await facultyResponse.json();
            roomList = await roomResponse.json();
            loadList = await loadResponse.json();
            populateFacultySelect();
            populateRoomSelect();
        } catch (error) {
            console.error(error);
            alert('Unable to load faculty, load, or room information.');
        }
    }

    function prepareSessionForm() {
        const facultySelect =
            document.getElementById('sessionFaculty');
        const loadSelect =
            document.getElementById('sessionLoad');
        const roomSelect =
            document.getElementById('sessionRoom');
        facultySelect.disabled = false;
        loadSelect.disabled = false;
        roomSelect.disabled = false;
        loadSelect.innerHTML ='<option value="">Select Load</option>';
        if (searchFilter === 'faculty') {
            facultySelect.value =
                searchResult.id;
            facultySelect.disabled = true;
            loadSelect.disabled = false;
            filterLoadsByFaculty();
        }
        else if (searchFilter === 'room') {
            roomSelect.value =
                searchResult.id;
            roomSelect.disabled = true;
            facultySelect.disabled = false;
            loadSelect.disabled = false;
        }
        else if (searchFilter === 'section') {
            facultySelect.disabled = false;
            roomSelect.disabled = false;
            loadSelect.disabled = false;
            filterLoadsBySection();
        }
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
            option.value = room.id;
            option.textContent =
                room.room_name;
            select.appendChild(option);
        });
    }

    function filterLoadsByFaculty() {
        const facultyId =
            document.getElementById('sessionFaculty').value;
        const loadSelect =
            document.getElementById('sessionLoad');
        loadSelect.innerHTML =
            '<option value="">Select Load</option>';
        selectedLoad = null;
        document.getElementById('loadUnits').textContent = '0';
        document.getElementById('sessionUnits').textContent = '0';
        document.getElementById('remainingUnits').textContent = '0';
        if (!facultyId) {
            return;
        }
        const facultyLoads =
            loadList.filter(load =>
                String(load.user_id) === String(facultyId)
            );
        facultyLoads.forEach(load => {
            const option =
                document.createElement('option');
            option.value = load.id;
            option.textContent =
                `${load.sub_code} - ${load.sub_name} (${load.sec_code})`;
            option.dataset.units =
                getLoadUnits(load);
            loadSelect.appendChild(option);
        });
    }

    function filterLoadsBySection() {
        const loadSelect =
            document.getElementById('sessionLoad');
        loadSelect.innerHTML =
            '<option value="">Select Load</option>';
        if (
            searchFilter !== 'section' ||
            !searchResult
        ) {
            return;
        }
        const sectionId = searchResult.id;
        const sectionLoads =
            loadList.filter(load => {
                return String(load.section_id) ===
                    String(sectionId);
            });
        sectionLoads.forEach(load => {
            const option =
                document.createElement('option');
            option.value =
                load.id;
            option.textContent =
                `${load.sub_code} - ${load.sub_name}`;
            loadSelect.appendChild(option);
        });
    }

    function updateLoadInformation() {
        const loadId =
            document.getElementById('sessionLoad').value;
        selectedLoad =
            loadList.find(load =>
                String(load.id) === String(loadId)
            );
        if (!selectedLoad) {
            document.getElementById('loadUnits').textContent = '0';
            document.getElementById('loadInformation').textContent = '';
            calculateSessionUnits();
            return;
        }
        const units =
            getLoadUnits(selectedLoad);
        document.getElementById('loadUnits').textContent =
            units;
        document.getElementById('loadInformation').textContent =
            `Available units for this session type: ${units}`;
        calculateSessionUnits();
    }

    function getLoadUnits(load) {
        const type =
            document.getElementById('sessionType').value;
        if (type === 'Lab') {
            return Number(
                load.lab_units ??
                load.sub_lab_units ??
                0
            );
        }
        return Number(
            load.lec_units ??
            load.sub_lec_units ??
            0
        );
    }

    // Add Session Validation

    function calculateSessionUnits() {
        const start =
            document.getElementById('sessionStart').value;
        const end =
            document.getElementById('sessionEnd').value;
        const sessionUnitsElement =
            document.getElementById('sessionUnits');
        const remainingUnitsElement =
            document.getElementById('remainingUnits');
        if (!start || !end) {
            sessionUnitsElement.textContent = '0';
            remainingUnitsElement.textContent = '0';
            return;
        }
        const startMinutes =
            timeToMinutes(start);
        const endMinutes =
            timeToMinutes(end);
        if (endMinutes <= startMinutes) {
            sessionUnitsElement.textContent = '0';
            remainingUnitsElement.textContent = '0';
            showSessionError(
                'End time must be later than start time.'
            );
            return;
        }
        const durationMinutes =
            endMinutes - startMinutes;
        const units =
            durationMinutes / 60;
        sessionUnitsElement.textContent =
            Number.isInteger(units)
                ? units
                : units.toFixed(2);
        if (selectedLoad) {
            const loadUnits =
                getLoadUnits(selectedLoad);
            const remaining =
                loadUnits - units;
            remainingUnitsElement.textContent =
                remaining >= 0
                    ? remaining
                    : '0';
            if (units > loadUnits) {
                showSessionError(
                    `Session is ${units} units, but this load only has ${loadUnits} units.`
                );
            } else {
                clearSessionError();
            }
        }
    }

    function validateSessionUnits() {
        if (!selectedLoad) {
            showSessionError(
                'Please select a load.'
            );
            return false;
        }
        const start =
            document.getElementById('sessionStart').value;
        const end =
            document.getElementById('sessionEnd').value;
        const startMinutes =
            timeToMinutes(start);
        const endMinutes =
            timeToMinutes(end);
        if (endMinutes <= startMinutes) {
            showSessionError(
                'End time must be later than start time.'
            );
            return false;
        }
        const sessionUnits =
            (endMinutes - startMinutes) / 60;
        const loadUnits =
            getLoadUnits(selectedLoad);
        if (sessionUnits > loadUnits) {
            showSessionError(
                `Cannot create session. ${sessionUnits} units exceeds the load limit of ${loadUnits} units.`
            );
            return false;
        }
        return true;
    }

    async function checkRoomAvailability() {
        const roomId =
            document.getElementById('sessionRoom').value;
        const day =
            document.getElementById('sessionDay').value;
        const start =
            document.getElementById('sessionStart').value;
        const end =
            document.getElementById('sessionEnd').value;
        if (!roomId || !day || !start || !end) {
            return false;
        }
        const params = new URLSearchParams({
            room_id: roomId,
            day: day,
            start: start,
            end: end
        });
        try {
            const response =
                await fetch(
                    '<?= base_url('check_room_availability') ?>?' +
                    params.toString()
                );
            const result =
                await response.json();
            if (!result.available) {
                showSessionError(
                    result.message ||
                    'The selected room is unavailable during this time.'
                );
                return false;
            }
            return true;
        } catch (error) {
            console.error(
                'Room availability error:',
                error
            );
            showSessionError(
                'Unable to check room availability.'
            );
            return false;
        }
    }

// Create Session

    document.getElementById('addSessionForm').addEventListener('submit', async function (event) {
        event.preventDefault();
        if (!validateSessionUnits()) {
            return;
        }
        const roomAvailable =
            await checkRoomAvailability();
        if (!roomAvailable) {
            return;
        }
        const start =
            document.getElementById('sessionStart').value;
        const end =
            document.getElementById('sessionEnd').value;
        const sessionUnits =
            (
                timeToMinutes(end) -
                timeToMinutes(start)
            ) / 60;
        const data = {
            faculty_id:
                document.getElementById('sessionFaculty').value,
            load_id:
                document.getElementById('sessionLoad').value,
            room_id:
                document.getElementById('sessionRoom').value,
            ses_type:
                document.getElementById('sessionType').value,
            ses_units:
                sessionUnits,
            ses_day:
                document.getElementById('sessionDay').value,
            ses_start: start,
            ses_end: end
        };
        try {
            const response =
                await fetch(
                    '<?= base_url('create_session') ?>',
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
            if (!response.ok || !result.success) {
                alert(
                    result.message ||
                    'Unable to create session.'
                );
                return;
            }
            alert(
                'Session successfully created.'
            );
            document
                .getElementById('addSessionForm')
                .reset();
            document.getElementById('loadUnits')
                .textContent = '0';
            document.getElementById('sessionUnits')
                .textContent = '0';
            document.getElementById('remainingUnits')
                .textContent = '0';
            SessionModal.hide();
            const filter =
                document.getElementById(
                    'managementFilter'
                ).value;
            console.log(
                'Session created:',
                result
            );
        } catch (error) {
            console.error(
                'Create session error:',
                error
            );
            alert(
                'A server error occurred while creating the session.'
            );
        }
    });

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

    function hideAllTables() {
        const scheduleTable = document.getElementById('scheduleTable');
        if (scheduleTable) {
            scheduleTable.style.display = 'none';
        }
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