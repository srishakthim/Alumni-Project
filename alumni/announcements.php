<?php include("sidebar.php"); ?>

<h3>📢 Announcements</h3>

<div class="card mt-3">
    <div class="card-body">
        <?php
        $res = mysqli_query($conn,"SELECT * FROM announcements ORDER BY created_at DESC");
        while($row=mysqli_fetch_assoc($res)){
            echo "<div class='mb-3'>
                    <h5>{$row['title']}</h5>
                    <p>{$row['message']}</p>
                    <small class='text-muted'>{$row['created_at']}</small>
                  </div><hr>";
        }
        ?>
    </div>
</div>

</div></body></html>
