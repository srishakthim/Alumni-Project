<?php
// admin/sidebar.php
// Include DB + Session
include("../config/db.php");

// Simple admin check (optional)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Alumni System</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: #1f2937;
            color: #fff;
        }
        .sidebar h4 {
            text-align: center;
            padding: 15px 0;
            border-bottom: 1px solid #374151;
        }
        .sidebar a {
            color: #d1d5db;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #374151;
            color: #fff;
        }
        .sidebar i {
            margin-right: 10px;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .logout {
            position: absolute;
            bottom: 20px;
            width: 100%;
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>🎓 Admin Panel</h4>

    <a href="dashboard.php">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="approve_users.php">
        <i class="bi bi-person-check"></i> Approve Alumni
    </a>

    <a href="departments.php">
        <i class="bi bi-diagram-3"></i> Departments
    </a>

    <a href="events.php">
        <i class="bi bi-calendar-event"></i> Events
    </a>

    <a href="jobs.php">
        <i class="bi bi-briefcase"></i> Jobs
    </a>

    <a href="donations.php">
        <i class="bi bi-cash-coin"></i> Donations
    </a>

    <a href="announcements.php">
        <i class="bi bi-megaphone"></i> Announcements
    </a>

    <a href="reports.php">
        <i class="bi bi-file-earmark-text"></i> Reports
    </a>

    <div class="logout">
        <a href="../auth/logout.php" class="text-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</div>

<!-- PAGE CONTENT START -->
<div class="content">
