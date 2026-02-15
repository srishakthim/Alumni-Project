<?php include("sidebar.php"); ?>

<h3>👥 Alumni Directory</h3>

<table class="table table-bordered mt-3">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Department</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $res = mysqli_query($conn,"SELECT * FROM users WHERE role='alumni' AND status='approved'");
        while($row=mysqli_fetch_assoc($res)){
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['department']}</td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

</div></body></html>
