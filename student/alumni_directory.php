<?php include("sidebar.php"); ?>

<h3>👥 Alumni Directory</h3>

<table class="table table-bordered table-hover mt-3">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>Department</th>
            <th>Graduation Year</th>
            <th>Company</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $res = mysqli_query($conn,"SELECT name,department,graduation_year,company FROM users WHERE role='alumni'");
        while($row=mysqli_fetch_assoc($res)){
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['department']}</td>
                    <td>{$row['graduation_year']}</td>
                    <td>{$row['company']}</td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

</div></body></html>
