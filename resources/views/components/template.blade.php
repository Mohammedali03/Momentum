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
    </style>

    <script>
        // Theme Toggle Utility
        const ThemeToggle = {
            init() {
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme) {
                    this.applyTheme(savedTheme === 'dark');
                }

                document.getElementById('darkModeToggle').addEventListener('click', () => {
                    const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                    this.applyTheme(!isDark);
                });
            },

            applyTheme(isDark) {
                document.documentElement.setAttribute('data-bs-theme', isDark ? 'dark' : 'light');
                document.body.classList.toggle('dark-mode', isDark);
                localStorage.setItem('theme', isDark ? 'dark' : 'light');

                // Update calendar if it exists
                if (window.calendar) {
                    window.calendar.render();
                }

                // Update chart if it exists
                if (window.taskChart) {
                    const colors = this.getChartColors(isDark);
                    this.updateChartColors(window.taskChart, colors);
                    window.taskChart.update();
                }

                // Dispatch theme change event
                window.dispatchEvent(new CustomEvent('themeChange', { detail: { isDark } }));
            },

            getChartColors(isDark) {
                return {
                    text: isDark ? '#fff' : '#666',
                    grid: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                    background: isDark ? '#2c3040' : '#fff'
                };
            },

            updateChartColors(chart, colors) {
                if (!chart?.options?.scales) return;
                
                const scales = chart.options.scales;
                if (scales.y) {
                    scales.y.ticks.color = colors.text;
                    scales.y.grid.color = colors.grid;
                }
                if (scales.x) {
                    scales.x.ticks.color = colors.text;
                    scales.x.grid.color = colors.grid;
                }
                if (chart.options.plugins?.legend) {
                    chart.options.plugins.legend.labels.color = colors.text;
                }
            }
        };

        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', () => ThemeToggle.init());
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

                <!-- Theme Toggle Button -->
                <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-2" id="themeToggle">
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

    <!-- Theme Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const icon = themeToggle.querySelector('i');
            const html = document.documentElement;
            const body = document.body;

            // Load saved theme
            const savedTheme = localStorage.getItem('theme') === 'dark';
            applyTheme(savedTheme);

            // Toggle theme on click
            themeToggle.addEventListener('click', () => {
                const isDark = html.getAttribute('data-bs-theme') === 'dark';
                applyTheme(!isDark);
            });

            function applyTheme(isDark) {
                // Update DOM
                html.setAttribute('data-bs-theme', isDark ? 'dark' : 'light');
                body.classList.toggle('dark-mode', isDark);
                
                // Update icon
                icon.classList.remove('fa-sun', 'fa-moon');
                icon.classList.add(isDark ? 'fa-sun' : 'fa-moon');
                
                // Save preference
                localStorage.setItem('theme', isDark ? 'dark' : 'light');

                // Update components
                if (window.calendar) {
                    window.calendar.render();
                }
                if (window.taskChart) {
                    const colors = {
                        text: isDark ? '#fff' : '#666',
                        grid: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                    };
                    updateChartColors(window.taskChart, colors);
                    window.taskChart.update();
                }
            }

            function updateChartColors(chart, colors) {
                if (!chart?.options?.scales) return;
                
                const scales = chart.options.scales;
                if (scales.y) {
                    scales.y.ticks.color = colors.text;
                    scales.y.grid.color = colors.grid;
                }
                if (scales.x) {
                    scales.x.ticks.color = colors.text;
                    scales.x.grid.color = colors.grid;
                }
                if (chart.options.plugins?.legend) {
                    chart.options.plugins.legend.labels.color = colors.text;
                }
            }
        });
    </script>
</body>
</html>
