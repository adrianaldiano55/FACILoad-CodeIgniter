<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FACILoad</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 250px;
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
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="sidebar p-3 d-flex flex-column justify-content-between" id="sidebar">
        <div>
            <!-- Brand / Logo Placeholder -->
            <a href="#" class="d-flex align-items-center mb-3 text-white text-decoration-none fs-4 fw-bold">
                <i class="bi bi-speedometer2 me-2"></i> FACILoad
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
                    <a href="#" class="nav-link">
                        <i class="bi bi-folder me-2"></i> Menu Item 1
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-bar-chart me-2"></i> Menu Item 2
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-gear me-2"></i> Settings
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
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
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
                
                <span class="navbar-brand mb-0 h1 fs-5">Page Title</span>
                
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

                <!-- Main Section Placeholder -->
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="card-title">Main Content Area</h5>
                    <p class="text-muted mb-0">Add components, data tables, or charts here.</p>
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
        // Toggle Sidebar on Mobile View
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>
</body>
</html>