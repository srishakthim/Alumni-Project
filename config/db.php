<?php
/* ================================
   Database Configuration File
   College Alumni Management System
   ================================ */

/* Database Credentials */
$host = "localhost";
$user = "root";
$password = "";
$database = "alumni_system";

/* Create Connection */
$conn = mysqli_connect($host, $user, $password, $database);

/* Check Connection */
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

/* Start Session */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Set Timezone (Optional but Recommended) */
date_default_timezone_set("Asia/Kolkata");

/* Error Reporting (Disable in Production) */
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
