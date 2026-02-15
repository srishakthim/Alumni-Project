<!DOCTYPE html>
<html>
<head>
    <title>Register | Alumni System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 450px;">
        <h4 class="text-center mb-3">Register</h4>

        <form method="POST" action="process.php">
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Register As</label>
                <select name="role" class="form-select" required>
                    <option value="alumni">Alumni</option>
                    <option value="student">Student</option>
                </select>
            </div>

            <button type="submit" name="register" class="btn btn-success w-100">
                Register
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="login.php">Already have an account?</a>
        </div>
    </div>
</div>

</body>
</html>
