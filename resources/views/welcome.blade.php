<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TaskMaster - Your Personal Task Manager</title>
    
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            overflow-x: hidden;
        }

        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(78, 115, 223, 0.1) 0%, rgba(28, 200, 138, 0.1) 100%);
            padding: 100px 0;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 30px;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .btn-gradient {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--success-color) 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
            color: white;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .footer {
            background: #2c3e50;
            color: white;
            padding: 50px 0;
            margin-top: 100px;
        }

        /* Dark Mode Welcome Page Styles */
        .dark-mode {
            background: linear-gradient(135deg, #1a1c23 0%, #242631 100%);
            color: #fff;
        }

        .dark-mode .navbar {
            background: rgba(44, 48, 64, 0.95) !important;
        }

        .dark-mode .feature-card {
            background: #2c3040;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .dark-mode .hero-section {
            background: linear-gradient(135deg, rgba(78, 115, 223, 0.05) 0%, rgba(28, 200, 138, 0.05) 100%);
        }

        .dark-mode .stats-number {
            color: #4e73df;
        }

        .dark-mode .testimonial-card {
            background: #2c3040;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-check-circle"></i> TaskMaster</a>
            <div class="ms-auto">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-gradient me-2">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-gradient me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary">Sign Up</a>
                @endauth
                <button class="btn btn-outline-light ms-2" id="darkModeToggle">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </div>
    </nav>

    <section class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-4 fw-bold mb-4">Organize Your Tasks Like Never Before</h1>
                    <p class="lead mb-4">TaskMaster helps you manage your tasks efficiently with powerful features, beautiful calendars, and insightful analytics.</p>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-gradient btn-lg">Get Started Free</a>
                    @endguest
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <img src="https://cdn.dribbble.com/userupload/10494492/file/original-839448b618ada17e1f29db5c803532d8.png?resize=752x" alt="Task Management" class="img-fluid floating">
                </div>
            </div>
        </div>
    </section>

    <section class="features py-5">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">Features That Make Us Special</h2>
            <div class="row">
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="feature-card">
                        <i class="fas fa-calendar-check feature-icon"></i>
                        <h4>Smart Calendar</h4>
                        <p>Visualize your tasks in an interactive calendar view with drag-and-drop functionality.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="feature-card">
                        <i class="fas fa-chart-line feature-icon"></i>
                        <h4>Analytics Dashboard</h4>
                        <p>Get insights into your productivity with beautiful charts and statistics.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
                    <div class="feature-card">
                        <i class="fas fa-users feature-icon"></i>
                        <h4>Team Collaboration</h4>
                        <p>Share tasks and collaborate with team members seamlessly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stats bg-light py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="stats-number">10K+</div>
                    <div class="stats-text">Active Users</div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="stats-number">1M+</</div>
                    <div class="stats-text">Tasks Completed</div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="stats-number">99%</div>
                    <div class="stats-text">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-check-circle"></i> TaskMaster</h5>
                    <p>Making task management simple and effective.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">About Us</a></li>
                        <li><a href="#" class="text-white">Features</a></li>
                        <li><a href="#" class="text-white">Pricing</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p><i class="fas fa-envelope"></i> support@taskmaster.com</p>
                    <div class="social-icons">
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });

        document.addEventListener('DOMContentLoaded', function() {
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'enabled') {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                document.body.classList.add('dark-mode');
            }

            document.getElementById('darkModeToggle').addEventListener('click', function() {
                const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                document.documentElement.setAttribute('data-bs-theme', isDark ? 'light' : 'dark');
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', isDark ? 'disabled' : 'enabled');
            });
        });
    </script>
</body>
</html>