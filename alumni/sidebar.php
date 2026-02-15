<?php
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'alumni') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Alumni Panel</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background:#f4f6f9; }
        .sidebar {
            width:260px;
            height:100vh;
            position:fixed;
            background:#0f172a;
            color:#fff;
        }
        .sidebar h4 {
            padding:15px;
            text-align:center;
            border-bottom:1px solid #334155;
        }
        .sidebar a {
            display:block;
            padding:12px 20px;
            color:#cbd5f5;
            text-decoration:none;
        }
        .sidebar a:hover {
            background:#1e293b;
            color:#fff;
        }
        .content {
            margin-left:260px;
            padding:20px;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h4>🎓 Alumni Panel</h4>

    <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="profile.php"><i class="bi bi-person"></i> My Profile</a>
    <a href="directory.php"><i class="bi bi-people"></i> Alumni Directory</a>
    <a href="events.php"><i class="bi bi-calendar"></i> Events</a>
    <a href="jobs.php"><i class="bi bi-briefcase"></i> Jobs</a>
    <a href="donations.php"><i class="bi bi-cash"></i> Donations</a>
    <a href="announcements.php"><i class="bi bi-megaphone"></i> Announcements</a>
    <a href="../auth/logout.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="content">
