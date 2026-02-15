<?php include("sidebar.php"); ?>

<h3>📅 Events</h3>

<div class="row mt-3">
<?php
$res = mysqli_query($conn,"SELECT * FROM events ORDER BY event_date ASC");
while($row=mysqli_fetch_assoc($res)){
?>
<div class="col-md-4 mb-3">
    <div class="card shadow">
        <div class="card-body">
            <h5><?= $row['title'] ?></h5>
            <p><?= $row['description'] ?></p>
            <span class="badge bg-info"><?= $row['event_date'] ?></span>
        </div>
    </div>
</div>
<?php } ?>
</div>

</div></body></html>
