<?php include("sidebar.php"); ?>

<h3>📊 Dashboard</h3>

<div class="row mt-4">
<?php
$alumni = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM users WHERE role='alumni'"));
$jobs = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM jobs WHERE status='approved'"));
$events = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM events"));
?>

<div class="col-md-4">
    <div class="card shadow text-center">
        <div class="card-body">
            <h4><?= $alumni ?></h4>
            <p>Total Alumni</p>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card shadow text-center">
        <div class="card-body">
            <h4><?= $jobs ?></h4>
            <p>Available Jobs</p>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card shadow text-center">
        <div class="card-body">
            <h4><?= $events ?></h4>
            <p>Upcoming Events</p>
        </div>
    </div>
</div>
</div>

</div></body></html>
