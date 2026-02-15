<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>College Alumni Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            scroll-behavior: smooth;
        }
        .hero {
            background: linear-gradient(120deg, #0d6efd, #6610f2);
            color: white;
            padding: 100px 20px;
        }
        .hero h1 {
            font-weight: bold;
        }
        .feature-box {
            border-radius: 12px;
            transition: 0.3s;
        }
        .feature-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        footer {
            background: #212529;
            color: #adb5bd;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Alumni System</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                <li class="nav-item">
                    <a href="auth/login.php" class="btn btn-outline-light btn-sm ms-2">Login</a>
                </li>
                <li class="nav-item">
                    <a href="auth/register.php" class="btn btn-warning btn-sm ms-2">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO SECTION -->
<section class="hero text-center">
    <div class="container">
        <h1>College Alumni Management System</h1>
        <p class="lead mt-3">
            Connect alumni, students, and the college on a single platform
        </p>
        <a href="auth/register.php" class="btn btn-light btn-lg mt-4">
            Get Started
        </a>
    </div>
</section>

<!-- ABOUT -->
<section id="about" class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>About the Project</h2>
                <p class="text-muted mt-3">
                    The College Alumni Management System is a web-based application
                    developed using PHP and MySQL. It helps institutions maintain
                    alumni records, manage events, job postings, and donations,
                    and create a strong alumni network.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png" width="280">
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section id="features" class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-4">Key Features</h2>
        <div class="row g-4">

            <div class="col-md-4">
                <div class="card feature-box p-4 text-center">
                    <h5>👨‍🎓 Alumni Management</h5>
                    <p class="text-muted mt-2">
                        Maintain alumni profiles and graduation details.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-box p-4 text-center">
                    <h5>💼 Job Portal</h5>
                    <p class="text-muted mt-2">
                        Alumni can post jobs and students can apply.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-box p-4 text-center">
                    <h5>📅 Events & Reunions</h5>
                    <p class="text-muted mt-2">
                        Manage alumni meets and college events.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-box p-4 text-center">
                    <h5>💰 Donations</h5>
                    <p class="text-muted mt-2">
                        Alumni can contribute to college development.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-box p-4 text-center">
                    <h5>🔐 Secure Login</h5>
                    <p class="text-muted mt-2">
                        Role-based authentication system.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-box p-4 text-center">
                    <h5>📊 Admin Dashboard</h5>
                    <p class="text-muted mt-2">
                        Powerful admin controls and reports.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- CONTACT -->
<section id="contact" class="py-5">
    <div class="container text-center">
        <h2>Contact Us</h2>
        <p class="text-muted mt-2">
            Email: admin@collegealumni.com <br>
            Phone: +91 98765 43210
        </p>
    </div>
</section>

<!-- FOOTER -->
<footer class="py-3 text-center">
    <p class="mb-0">
        © <?= date("Y") ?> College Alumni Management System | PHP & MySQL Project
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
