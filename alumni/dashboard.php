<?php include("sidebar.php"); ?>

<h3>Welcome Alumni 👋</h3>

<div class="row g-4 mt-3">
    <div class="col-md-4">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <h5>Events</h5>
                <h2><?php echo mysqli_num_rows(mysqli_query($conn,"SELECT id FROM events")); ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <h5>Jobs</h5>
                <h2><?php echo mysqli_num_rows(mysqli_query($conn,"SELECT id FROM jobs WHERE status='approved'")); ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-danger text-white shadow">
            <div class="card-body">
                <h5>My Donations</h5>
                <h2><?php echo mysqli_num_rows(mysqli_query($conn,"SELECT id FROM donations WHERE user_id=".$_SESSION['user_id'])); ?></h2>
            </div>
        </div>
    </div>
</div>

</div></body></html>
