<?php
include("sidebar.php"); // sidebar + db + session

// Report Queries
$totalUsers       = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users"));
$totalAlumni      = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE role='alumni'"));
$totalStudents    = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE role='student'"));
$totalEvents      = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM events"));
$totalJobs        = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM jobs"));
$totalDonations   = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM donations"));
$approvedJobs     = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM jobs WHERE status='approved'"));
$pendingJobs      = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM jobs WHERE status='pending'"));
?>

<div class="container-fluid">
    <h3 class="mb-4">📑 System Reports</h3>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h6>Total Users</h6>
                    <h2><?php echo $totalUsers; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h6>Total Alumni</h6>
                    <h2><?php echo $totalAlumni; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-secondary text-white shadow">
                <div class="card-body">
                    <h6>Total Students</h6>
                    <h2><?php echo $totalStudents; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-dark text-white shadow">
                <div class="card-body">
                    <h6>Total Events</h6>
                    <h2><?php echo $totalEvents; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <h6>Total Jobs</h6>
                    <h2><?php echo $totalJobs; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    <h6>Total Donations</h6>
                    <h2><?php echo $totalDonations; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h6>Approved Jobs</h6>
                    <h2><?php echo $approvedJobs; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <h6>Pending Jobs</h6>
                    <h2><?php echo $pendingJobs; ?></h2>
                </div>
            </div>
        </div>

    </div>
</div>

</div> <!-- content -->
</body>
</html>
