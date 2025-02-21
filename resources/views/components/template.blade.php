<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do App</title>
    
    <!-- Required Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- FullCalendar -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css','resources/js/app.js'])

    <!-- Include shared styles -->
    @include('components.shared-styles')

    <style>
        body {
            background-color: #f8f9fa;
        }
        .task-card {
            transition: transform 0.2s;
        }
        .task-card:hover {
            transform: translateY(-5px);
        }
        .dark-mode {
            background-color: #222;
            color: #fff;
        }
        .stats-card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .dark-mode .card {
            background-color: #333;
            color: #fff;
        }
        .dark-mode .table {
            color: #fff;
        }
        .dark-mode .navbar {
            background-color: #222 !important;
        }
        #calendar {
            margin: 20px auto;
            padding: 0 10px;
            max-width: 1200px;
            min-height: 500px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .tab-content {
            padding: 20px 0;
        }
        .fc-event {
            cursor: pointer;
        }
        #taskChart {
            max-height: 400px;
        }
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin: 20px 0;
        }

        /* Calendar Dark Mode Fixes */
        .dark-mode .fc-daygrid-day {
            background-color: #333 !important;
        }

        .dark-mode .fc-day-today {
            background-color: #444 !important;
        }

        .dark-mode .fc-daygrid-day-number,
        .dark-mode .fc-col-header-cell-cushion {
            color: #fff !important;
            text-decoration: none !important;
        }

        .dark-mode .fc-day-other .fc-daygrid-day-number {
            color: #888 !important;
        }

        .dark-mode .fc .fc-button-primary {
            background-color: #444;
            border-color: #555;
        }

        .dark-mode .fc .fc-button-primary:hover {
            background-color: #555;
            border-color: #666;
        }

        .dark-mode .fc .fc-button-active {
            background-color: #666 !important;
            border-color: #777 !important;
        }

        .dark-mode .fc-toolbar-title {
            color: #fff;
        }

        .dark-mode .fc {
            background-color: #2c3040;
        }

        .dark-mode .fc-theme-standard th {
            background-color: #363a4f !important;
            border-color: #444 !important;
        }

        .dark-mode .fc-scrollgrid-section-header {
            background-color: #363a4f !important;
        }

        .dark-mode .fc-col-header-cell {
            background-color: #363a4f !important;
        }

        .dark-mode .fc-daygrid-day {
            background-color: #2c3040 !important;
            border-color: #444 !important;
        }

        .dark-mode .fc-day-today {
            background-color: #3a3f55 !important;
        }

        .dark-mode .fc-daygrid-day-number,
        .dark-mode .fc-col-header-cell-cushion {
            color: #fff !important;
            text-decoration: none !important;
        }

        .dark-mode .fc-day-other {
            background-color: #272936 !important;
        }

        .dark-mode .fc-day-other .fc-daygrid-day-number {
            color: #888 !important;
        }

        .dark-mode .fc-toolbar-title {
            color: #fff !important;
        }

        .dark-mode .fc-button {
            background-color: #363a4f !important;
            border-color: #444 !important;
            color: #fff !important;
        }

        .dark-mode .fc-button:hover {
            background-color: #4a4f6b !important;
            border-color: #505573 !important;
        }

        .dark-mode .fc-button-active {
            background-color: #4e73df !important;
            border-color: #4e73df !important;
        }

        /* Dropdown Styles */
        .dropdown-menu {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: none;
            padding: 0.5rem;
        }

        .dropdown-item {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            color: #333;
        }

        .dropdown-item:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateX(5px);
        }

        .user-dropdown-button {
            background: white;
            border-radius: 50px !important;
            padding: 0.5rem 1.5rem !important;
            border: 1px solid #e0e0e0 !important;
            transition: all 0.3s ease;
            color: #333 !important;
        }

        .user-dropdown-button:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .dark-mode .user-dropdown-button {
            background: #363a4f !important;
            border-color: #4a4f6b !important;
            color: #fff !important;
        }

        .dark-mode .dropdown-menu {
            background-color: #2c3040;
            border: 1px solid #4a4f6b;
        }

        .dark-mode .dropdown-item {
            color: #fff;
        }

        .dark-mode .dropdown-item:hover {
            background-color: #4e73df;
        }
    </style>

    <script>
        // Simple Theme Toggle Function
        function toggleTheme() {
            const html = document.documentElement;
            const body = document.body;
            const isDark = html.getAttribute('data-bs-theme') === 'dark';
            
            // Toggle theme
            html.setAttribute('data-bs-theme', isDark ? 'light' : 'dark');
            body.classList.toggle('dark-mode');
            
            // Update icon
            const icon = document.querySelector('#themeToggle i');
            icon.classList.remove('fa-sun', 'fa-moon');
            icon.classList.add(isDark ? 'fa-moon' : 'fa-sun');
            
            // Save preference
            localStorage.setItem('theme', isDark ? 'light' : 'dark');
            
            // Update components
            if (window.calendar) {
                window.calendar.render();
            }
            if (window.taskChart) {
                updateChartTheme(!isDark);
            }
        }

        // Load saved theme
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                document.body.classList.add('dark-mode');
                const icon = document.querySelector('#themeToggle i');
                icon.classList.replace('fa-moon', 'fa-sun');
            }
        });
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fas fa-check-circle"></i> TaskMaster</a>
            
            <!-- Add Templates Link -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('templates.index') }}">
                            <i class="fas fa-clipboard-list"></i> Templates
                        </a>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center">
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6 me-3">
                    <div class="dropdown">
                        <button class="user-dropdown-button d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-2"></i>
                            <span>{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down ms-2"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-edit me-2"></i> Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Theme Toggle Button - Updated with onclick handler -->
                <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-2" 
                        id="themeToggle" 
                        onclick="toggleTheme()">
                    <i class="fas fa-moon"></i>
                    <span class="d-none d-md-inline">Theme</span>
                </button>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <div class="fade-in">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
