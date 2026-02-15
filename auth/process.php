<?php
include("../config/db.php");

/* ================= REGISTER ================= */
if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {
        echo "Email already exists";
        exit;
    }

    mysqli_query($conn, "
        INSERT INTO users (name,email,password,role)
        VALUES ('$name','$email','$password','$role')
    ");

    echo "Registration successful. Wait for admin approval.";
}

/* ================= LOGIN ================= */
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $query = mysqli_query($conn, "
        SELECT * FROM users 
        WHERE email='$email' AND password='$password'
    ");

    if (mysqli_num_rows($query) == 1) {

        $user = mysqli_fetch_assoc($query);

        if ($user['status'] == 'pending') {
            echo "Account not approved by admin";
            exit;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: ../admin/dashboard.php");
        } elseif ($user['role'] == 'alumni') {
            header("Location: ../alumni/dashboard.php");
        } else {
            header("Location: ../student/dashboard.php");
        }

    } else {
        echo "Invalid login credentials";
    }
}

/* ================= LOGOUT ================= */
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
}
?>
