<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            background: #212529;
            padding-top: 20px;
        }
        .sidebar a {
            display: block;
            color: #adb5bd;
            padding: 12px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #343a40;
            color: #fff;
        }
        .content {
            margin-left: 250px;
            padding: 25px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h5 class="text-white text-center">🎓 Student Panel</h5>
    <hr class="text-secondary">
    <a href="dashboard.php">Dashboard</a>
    <a href="alumni_directory.php">Alumni Directory</a>
    <a href="jobs.php">Jobs</a>
    <a href="events.php">Events</a>
    <a href="profile.php">Profile</a>
    <a href="../auth/logout.php" class="text-danger">Logout</a>
</div>

<div class="content">
