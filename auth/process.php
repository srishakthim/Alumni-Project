<?php
session_start();
include("../config/db.php");

/* ================= REGISTER ================= */
if (isset($_POST['register'])) {

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    // check email exists
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Email already exists'); window.location='register.php';</script>";
        exit;
    }

    mysqli_query($conn,"
        INSERT INTO users (name,email,password,role)
        VALUES ('$name','$email','$password','$role')
    ");

    echo "<script>
        alert('Registration successful');
        window.location='login.php';
    </script>";
}


/* ================= LOGIN ================= */
if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = md5($_POST['password']);

    $query = mysqli_query($conn,"
        SELECT * FROM users 
        WHERE email='$email' AND password='$password'
    ");

    if (mysqli_num_rows($query) == 1) {

        $user = mysqli_fetch_assoc($query);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // redirect based on role
        if ($user['role'] == 'admin') {
            header("Location: ../admin/dashboard.php");
        } elseif ($user['role'] == 'alumni') {
            header("Location: ../alumni/dashboard.php");
        } else {
            header("Location: ../student/dashboard.php");
        }

    } else {
        echo "<script>alert('Invalid login credentials'); window.location='login.php';</script>";
    }
}


/* ================= LOGOUT ================= */
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
}
?>
