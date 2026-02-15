<?php include("sidebar.php"); ?>

<h3>💼 Job Opportunities</h3>

<div class="row mt-3">
<?php
$res = mysqli_query($conn,"SELECT * FROM jobs WHERE status='approved'");
while($row=mysqli_fetch_assoc($res)){
?>
<div class="col-md-4 mb-3">
    <div class="card shadow">
        <div class="card-body">
            <h5><?= $row['title'] ?></h5>
            <p><strong><?= $row['company'] ?></strong></p>
            <p><?= $row['description'] ?></p>
        </div>
    </div>
</div>
<?php } ?>
</div>

</div></body></html>
