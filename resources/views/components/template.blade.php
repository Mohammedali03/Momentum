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
            
            <div class="d-flex align-items-center">
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6 me-3">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-bleu-500 dark:text-bleu-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name  }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
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
