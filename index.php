<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>College Alumni Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
            background-color: #f4f7fb;
        }

        /* NAVBAR */
        .navbar {
            background: linear-gradient(90deg, #0f2027, #203a43, #2c5364);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
        }

        .nav-link {
            color: #ffffff !important;
            transition: 0.3s;
        }

        .nav-link:hover {
            color: #00d4ff !important;
        }

        /* HERO */
        .hero {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            padding: 130px 20px;
            text-align: center;
        }

        .hero h1 {
            font-weight: 700;
            font-size: 48px;
        }

        .hero p {
            font-size: 18px;
        }

        .hero .btn {
            background: #00d4ff;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            transition: 0.3s;
        }

        .hero .btn:hover {
            background: white;
            color: #1e3c72;
        }

        /* ABOUT */
        #about h2 {
            font-weight: 700;
            color: #1e3c72;
        }

        /* FEATURES */
        #features {
            background: #eef3f9;
        }

        .feature-box {
            border-radius: 15px;
            border: none;
            transition: 0.4s;
            background: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .feature-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
            background: linear-gradient(135deg, #2a5298, #1e3c72);
            color: white;
        }

        .feature-box:hover p {
            color: #f1f1f1 !important;
        }

        /* CONTACT */
        #contact h2 {
            color: #1e3c72;
            font-weight: 700;
        }

        #contact {
            background: #ffffff;
        }

        /* FOOTER */
        footer {
            background: #0f2027;
            color: #ccc;
        }

        footer p {
            margin: 0;
            font-size: 14px;
        }

        /* BUTTONS */
        .btn-warning {
            background-color: #00d4ff;
            border: none;
            border-radius: 20px;
            font-weight: 600;
        }

        .btn-warning:hover {
            background-color: #1e3c72;
        }

        .btn-outline-light:hover {
            background-color: #00d4ff;
            border-color: #00d4ff;
        }

    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Alumni System</a>
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

<!-- HERO -->
<section class="hero">
    <div class="container">
        <h1>College Alumni Management System</h1>
        <p class="lead mt-3">
            Connect alumni, students, and the college on a single platform
        </p>
        <a href="auth/register.php" class="btn btn-lg mt-4">
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
<section id="features" class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Key Features</h2>
        <div class="row g-4">

            <div class="col-md-4">
                <div class="card feature-box p-4 text-center">
                    <h5>👨‍🎓 Alumni Management</h5>
                    <p class="text-muted mt-2">Maintain alumni profiles & graduation details.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-box p-4 text-center">
                    <h5>💼 Job Portal</h5>
                    <p class="text-muted mt-2">Alumni can post jobs and students can apply.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-box p-4 text-center">
                    <h5>📅 Events & Reunions</h5>
                    <p class="text-muted mt-2">Manage alumni meets and college events.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-box p-4 text-center">
                    <h5>💰 Donations</h5>
                    <p class="text-muted mt-2">It contributes to college funds & scholarships.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-box p-4 text-center">
                    <h5>🔐 Secure Login</h5>
                    <p class="text-muted mt-2">Role-based authentication system.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-box p-4 text-center">
                    <h5>📊 Admin Dashboard</h5>
                    <p class="text-muted mt-2">Powerful admin controls and reports.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- CONTACT -->
<section id="contact" class="py-5 text-center">
    <div class="container">
        <h2>Contact Us</h2>
        <p class="text-muted mt-3">
            Email: admin@collegealumni.com <br>
            Phone: +91 98765 43210
        </p>
    </div>
</section>

<!-- FOOTER -->
<footer class="py-3 text-center">
    <p>
        © <?= date("Y") ?> College Alumni Management System | PHP & MySQL Project
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>