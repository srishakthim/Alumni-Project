<?php
include("sidebar.php"); // sidebar + db + session

if (isset($_POST['post_job'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $position = mysqli_real_escape_string($conn, $_POST['position'] ?? '');
    $location = mysqli_real_escape_string($conn, $_POST['location'] ?? '');
    $user_id = $_SESSION['user_id'];

    mysqli_query($conn, "INSERT INTO jobs (posted_by, title, company, description, position, location, status)
        VALUES ($user_id, '$title', '$company', '$description', '$position', '$location', 'pending')
    ");

    echo "<div class='alert alert-success'>Job posted successfully (waiting for admin approval)</div>";
}
?>

<h3>💼 Jobs</h3>

<div class="card p-4 shadow mt-3">
    <h5>Post a Job</h5>
    <form method="post">
        <input type="text" name="title" class="form-control mb-2" placeholder="Job Title" required>
        <input type="text" name="company" class="form-control mb-2" placeholder="Company Name" required>
        <input type="text" name="position" class="form-control mb-2" placeholder="Position (optional)">
        <input type="text" name="location" class="form-control mb-2" placeholder="Location (optional)">
        <textarea name="description" class="form-control mb-2" placeholder="Job Description" required></textarea>
        <button name="post_job" class="btn btn-success">Post Job</button>
    </form>
</div>

<h5 class="mt-4">Approved Jobs</h5>

<table class="table table-bordered mt-2">
    <thead class="table-dark">
        <tr>
            <th>Title</th>
            <th>Company</th>
            <th>Position</th>
            <th>Location</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $res = mysqli_query($conn, "SELECT j.*, u.name FROM jobs j JOIN users u ON j.posted_by=u.id WHERE j.status='approved' ORDER BY j.created_at DESC");
    while($row = mysqli_fetch_assoc($res)){
        echo "<tr>
                <td>".htmlspecialchars($row['title'])."</td>
                <td>".htmlspecialchars($row['company'])."</td>
                <td>".htmlspecialchars($row['position'])."</td>
                <td>".htmlspecialchars($row['location'])."</td>
                <td>".htmlspecialchars($row['description'])."</td>
              </tr>";
    }
    ?>
    </tbody>
</table>
