<?php
include("sidebar.php"); // sidebar + db + session

// Fetch counts
$totalUsers       = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users"));
$pendingUsers     = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE status='pending'"));
$approvedAlumni   = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE role='alumni' AND status='approved'"));
$totalDepartments = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM departments"));
$totalEvents      = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM events"));
$totalJobs        = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM jobs"));
$totalDonations   = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM donations"));
?>

<div class="container-fluid">
    <h3 class="mb-4">📊 Admin Dashboard</h3>

    <div class="row g-4">
        <!-- Total Users -->
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5>Total Users</h5>
                    <h2><?php echo $totalUsers; ?></h2>
                </div>
            </div>
        </div>

        <!-- Pending Alumni -->
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h5>Pending Alumni</h5>
                    <h2><?php echo $pendingUsers; ?></h2>
                </div>
            </div>
        </div>

        <!-- Approved Alumni -->
        <div class="col-md-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5>Approved Alumni</h5>
                    <h2><?php echo $approvedAlumni; ?></h2>
                </div>
            </div>
        </div>

        <!-- Departments -->
        <div class="col-md-3">
            <div class="card text-white bg-dark shadow">
                <div class="card-body">
                    <h5>Departments</h5>
                    <h2><?php echo $totalDepartments; ?></h2>
                </div>
            </div>
        </div>

        <!-- Events -->
        <div class="col-md-4">
            <div class="card text-white bg-info shadow">
                <div class="card-body">
                    <h5>Events</h5>
                    <h2><?php echo $totalEvents; ?></h2>
                </div>
            </div>
        </div>

        <!-- Jobs -->
        <div class="col-md-4">
            <div class="card text-white bg-secondary shadow">
                <div class="card-body">
                    <h5>Jobs</h5>
                    <h2><?php echo $totalJobs; ?></h2>
                </div>
            </div>
        </div>

        <!-- Donations -->
        <div class="col-md-4">
            <div class="card text-white bg-danger shadow">
                <div class="card-body">
                    <h5>Donations</h5>
                    <h2><?php echo $totalDonations; ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

</div> <!-- content -->
</body>
</html>
