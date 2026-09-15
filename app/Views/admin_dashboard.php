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
            #facultytable table { min-width: 1000px; } 
            #facultytable th { vertical-align: middle; } 
            #facultytable td { height: 80px; min-width: 140px; vertical-align: middle; } 
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
                    <a href="#" onclick="showSections(); return false;" class="nav-link">
                        <i class="bi bi-folder me-2"></i>
                        Section Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" onclick="showRooms(); return false;" class="nav-link">
                        <i class="bi bi-folder me-2"></i>
                        Room Management
                    </a>
                </li>
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
                <!-- Content Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h4">Dashboard</h2>
                    <button class="btn btn-primary">Action Button</button>
                </div>

                <!-- Template Placeholder Grid -->
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm p-3">
                            <h6 class="text-muted">Widget Placeholder</h6>
                            <h3>--</h3>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm p-3">
                            <h6 class="text-muted">Widget Placeholder</h6>
                            <h3>--</h3>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm p-3">
                            <h6 class="text-muted">Widget Placeholder</h6>
                            <h3>--</h3>
                        </div>
                    </div>
                </div>
                <!-- MANAGEMENT FILTER -->
                <div class="card border-0 shadow-sm mb-4">
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
                                    <option value="rooms">Rooms</option>
                                    <option value="sections">Sections</option>
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
                            <div
                                class="col-md-2"
                                id="searchButton"
                                style="display: none;">
                                <button
                                    type="button"
                                    class="btn btn-primary w-100"
                                    onclick="searchSchedule()">
                                    <i class="bi bi-search me-1"></i>
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FACULTY TABLE -->
                <div
                    id="facultytable"
                    style="display: none;">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="mb-3">
                                <i class="bi bi-calendar-week me-2"></i>
                                Faculty Weekly Schedule
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
                                    <tbody id="facultyScheduleBody">
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
    let facultyList = [];
    function loadFacultyList() {
        console.log('Loading faculty list...');
        const url = '<?= base_url('show_faculty') ?>';
        fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(
                    'Failed to load faculty list. HTTP status: ' +
                    response.status
                );
            }
            return response.json();
        })
        .then(data => {
            console.log('Faculty data received:', data);
            if (!Array.isArray(data)) {
                console.error(
                    'Faculty endpoint did not return an array:',
                    data
                );
                facultyList = [];
                alert('Invalid faculty data returned by the server.');
                return;
            }
            facultyList = data;
            console.log(
                'Faculty list successfully loaded:',
                facultyList
            );
            console.log(
                'Number of faculty:',
                facultyList.length
            );
        })
        .catch(error => {
            console.error(
                'Error loading faculty list:',
                error
            );
            facultyList = [];
            alert(
                'Unable to load the faculty list.'
            );
        });
    }

    function changeManagementFilter() {
        const filter =
            document.getElementById('managementFilter').value;
        console.log(
            'Management filter selected:',
            filter
        );
        hideAllManagementAreas();
        if (filter === 'faculty') {
            document.getElementById(
                'searchArea'
            ).style.display = 'block';

            document.getElementById(
                'searchButton'
            ).style.display = 'block';
            loadFacultyList();
            return;
        }
    }

    function hideAllManagementAreas() {
        const areas = [
            'searchArea',
            'searchButton',
            'facultytable',
        ];
        areas.forEach(id => {
            const element =
                document.getElementById(id);
            if (element) {
                element.style.display = 'none';
            }
        });
    }

    function hideAllTables() {
        const facultyTable = document.getElementById('facultytable');
        if (facultyTable) {
            facultyTable.style.display = 'none';
        }
    }

    function searchSchedule() {
        const filter =
            document.getElementById('managementFilter').value;
        const searchInput =
            document.getElementById('searchInput');
        const searchValue = searchInput.value.trim().toLowerCase();
        if (!searchValue) {
            alert(
                'Please enter an appropriate value'
            );
            return;
        }
        if (filter === 'faculty') {
            searchFaculty(searchValue);
        } 
    }
    
    function searchFaculty(searchValue) {
        const faculty =
            facultyList.find(user => {
                const username =
                    String(
                        user.username ?? ''
                    ).trim().toLowerCase();
                const teacherId =
                    String(
                        user.login_id ?? ''
                    ).trim().toLowerCase();
                return (username === searchValue ||teacherId === searchValue);});
        if (!faculty) {
            alert(
                'Faculty member not found.'
            );
            return;
        }
        const facultyTable =
            document.getElementById('facultytable');
        if (facultyTable) {
            facultyTable.style.display = 'block';
        }
        loadFacultySchedule(faculty.id);
    }

    function loadFacultySchedule(userId) {
        const url =
            '<?= base_url('show_faculty_schedule') ?>/' +
            encodeURIComponent(userId);
        fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(
                    'Failed to load faculty schedule. HTTP status: ' +
                    response.status
                );
            }
            return response.json();
        })
        .then(schedule => {
            console.log(
                'Schedule loaded:',
                schedule
            );
            if (!Array.isArray(schedule)) {
                console.error(
                    'Invalid schedule response:',
                    schedule
                );
                generateFacultyTimetable([]);
                alert(
                    'The server returned an invalid schedule.'
                );
                return;
            } else {generateFacultyTimetable(schedule);}
        })
        .catch(error => {
            console.error(
                'Error loading faculty schedule:',
                error
            );
            generateFacultyTimetable([]);
            alert(
                'Unable to load the faculty schedule.'
            );
        });
    }

    function timeToMinutes(time) {
        time = String(time).trim().toUpperCase();
        const match =
            time.match(
                /^(\d{1,2}):(\d{2})(?::(\d{2}))?\s*(AM|PM)?$/
            );
        if (!match) {
            console.warn(
                'Unable to parse time:',
                time
            );
            return null;
        }
        let hour =
            parseInt(
                match[1],
                10
            );
        const minute =
            parseInt(
                match[2],
                10
            );
        const period =
            match[4];
        /*
         * Convert 12-hour format to 24-hour format.
         */
        if (
            period === 'PM' &&
            hour !== 12
        ) {
            hour += 12;
        }
        if (
            period === 'AM' &&
            hour === 12
        ) {
            hour = 0;
        }
        return (
            hour * 60
        ) + minute;
    }

    function minutesToTime(minutes) {
        let hour =
            Math.floor(
                minutes / 60
            );
        const minute =
            minutes % 60;
        const period =
            hour >= 12
                ? 'PM'
                : 'AM';
        let displayHour =
            hour % 12;
        if (displayHour === 0) {
            displayHour = 12;
        }
        return (
            displayHour +
            ':' +
            String(minute)
                .padStart(2, '0') +
            ' ' +
            period
        );
    }

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

    function generateFacultyTimetable(schedule) {
        const filter =
            document.getElementById('managementFilter').value;
        const tbody =
            document.getElementById(
                'facultyScheduleBody'
            );
        if (!tbody) {
            console.error(
                'facultyScheduleBody element was not found.'
            );
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
            const row =
                document.createElement('tr');
            const timeCell =
                document.createElement('td');
            timeCell.className =
                'fw-semibold bg-light';
            timeCell.textContent =
                minutesToTime(currentMinutes) +' - ' +minutesToTime(currentMinutes + 30);
            row.appendChild(
                timeCell
            );
            days.forEach(day => {
                const cell =
                    document.createElement('td');
                cell.dataset.day =
                    day;
                cell.dataset.time =String(currentMinutes);
                cell.className =
                    'schedule-empty';
                cell.innerHTML = `
                    <span class="text-muted small">
                        —
                    </span>
                `;
                row.appendChild(
                    cell
                );
            });
            tbody.appendChild(
                row
            );
        }
        if (
            !Array.isArray(schedule) ||
            schedule.length === 0
        ) {
            console.log(
                'No sessions found. Empty timetable displayed.'
            );
            return;
        }
        schedule.forEach(session => {
            const sessionDay = session.ses_day
            const sessionStart = timeToMinutes(session.ses_start)
            const sessionEnd = timeToMinutes(session.ses_end)
            const dayIndex =
                days.indexOf(
                    sessionDay
                );
            const rows =
                tbody.querySelectorAll('tr');
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
                if (
                    cells.length <
                    days.length + 1
                ) {
                    return;
                }
                const cell =
                    cells[dayIndex + 1];
                if (!cell) {
                    return;
                }
                const cellTime =
                    parseInt(
                        cell.dataset.time,
                        10
                    );
                if (!targetCell || !targetRow) {
                    console.warn('Could not find timetable cell for session:', session);
                    return;
                }
                if (
                    cellTime ===
                    sessionStart
                ) {
                    targetCell =
                        cell;
                    targetRow =
                        row;
                }
            });
            const duration =
                sessionEnd -
                sessionStart;
            const rowSpan =
                Math.max(
                    1,
                    Math.ceil(
                        duration / 30
                    )
                );
            const totalRows =
                rows.length;
            const startRowIndex =
                Array.from(rows)
                    .indexOf(targetRow);
            const availableRows =
                totalRows -
                startRowIndex;
            const safeRowSpan =
                Math.min(
                    rowSpan,
                    availableRows
                );
            targetCell.rowSpan =
                safeRowSpan;
            targetCell.className =
                'schedule-cell';
            targetCell.innerHTML = `
                <div class="schedule-subject">
                    <strong>Subject:</strong>
                    ${escapeHtml(
                        getSessionSubject(session)
                    )}
                </div>
                <div class="schedule-section">
                    <strong>Section:</strong>
                    ${escapeHtml(
                        getSessionSection(session)
                    )}
                </div>
                <div class="schedule-room">
                    <strong>Room:</strong>
                    ${escapeHtml(
                        getSessionRoom(session)
                    )}
                </div>
                <div class="small mt-1">
                    <i class="bi bi-clock me-1"></i>
                    ${escapeHtml(
                        getSessionStart(session)
                    )}
                    -
                    ${escapeHtml(
                        getSessionEnd(session)
                    )}
                </div>
            `;
            let currentRow =
                targetRow;
            for (
                let i = 1;
                i < safeRowSpan;
                i++
            ) {
                const nextRow =
                    currentRow.nextElementSibling;
                if (!nextRow) {
                    break;
                }
                const nextCells =
                    nextRow.querySelectorAll(
                        'td'
                    );
                /*
                 * Find the cell belonging to the
                 * same day.
                 */
                let cellToRemove =
                    null;
                nextCells.forEach(cell => {
                    if (
                        cell.dataset &&
                        cell.dataset.day ===
                        sessionDay
                    ) {
                        cellToRemove =
                            cell;
                    }
                });
                if (cellToRemove) {
                    cellToRemove.remove();
                }
                currentRow =
                    nextRow;
            } 
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
    changeManagementFilter();
});
</script>
</body>
</html>