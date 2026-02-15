<?php
include("sidebar.php"); // sidebar + db + session

// Approve User
if (isset($_GET['approve'])) {
    $user_id = intval($_GET['approve']);
    mysqli_query($conn, "UPDATE users SET status='approved' WHERE id=$user_id");
    header("Location: approve_users.php");
    exit;
}

// Reject / Delete User
if (isset($_GET['reject'])) {
    $user_id = intval($_GET['reject']);
    mysqli_query($conn, "DELETE FROM users WHERE id=$user_id");
    header("Location: approve_users.php");
    exit;
}
?>

<div class="container-fluid">
    <h3 class="mb-4">👤 Alumni Management</h3>

    <!-- Pending Users -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning text-dark">Pending Alumni Registrations</div>
        <div class="card-body">
            <table class="table table-bordered table-hover" id="pendingTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM users WHERE status='pending'";
                    $result = mysqli_query($conn, $query);
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $department = isset($row['department']) ? $row['department'] : '';
                        echo "<tr>
                            <td>{$i}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$department}</td>
                            <td class='text-capitalize'>{$row['role']}</td>
                            <td><span class='badge bg-warning'>Pending</span></td>
                            <td>
                                <a href='approve_users.php?approve={$row['id']}' class='btn btn-success btn-sm' 
                                   onclick=\"return confirm('Approve this user?')\">Approve</a>
                                <a href='approve_users.php?reject={$row['id']}' class='btn btn-danger btn-sm' 
                                   onclick=\"return confirm('Reject this user?')\">Reject</a>
                            </td>
                        </tr>";
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination" id="pendingPagination"></ul>
            </nav>
        </div>
    </div>

    <!-- Approved Alumni Users Only -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">Approved Alumni</div>
        <div class="card-body">
            <table class="table table-bordered table-hover" id="approvedTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM users WHERE status='approved' AND (role='alumni' OR role='student')";
                    $result = mysqli_query($conn, $query);
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $department = isset($row['department']) ? $row['department'] : '';
                        echo "<tr>
                            <td>{$i}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$department}</td>
                            <td class='text-capitalize'>{$row['role']}</td>
                            <td><span class='badge bg-success'>Approved</span></td>
                        </tr>";
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination" id="approvedPagination"></ul>
            </nav>
        </div>
    </div>
</div>

<script>
// Generic Pagination Function
function paginateTable(tableId, paginationId, rowsPerPage = 8) {
    const table = document.getElementById(tableId);
    const rows = Array.from(table.querySelectorAll("tbody tr"));
    const pagination = document.getElementById(paginationId);
    let currentPage = 1;

    function showPage(page) {
        currentPage = page;
        const start = (page-1)*rowsPerPage;
        const end = start + rowsPerPage;
        rows.forEach((row, i) => row.style.display = (i>=start && i<end) ? "" : "none");
        renderPagination();
    }

    function renderPagination() {
        const pageCount = Math.ceil(rows.length / rowsPerPage);
        let html = "";

        if(currentPage > 1){
            html += `<li class="page-item"><a class="page-link" href="#" onclick="paginateTableShow('${tableId}','${paginationId}',${currentPage-1});return false;">&lt;</a></li>`;
        }

        for(let i=1;i<=pageCount;i++){
            html += `<li class="page-item ${i===currentPage?'active':''}">
                        <a class="page-link" href="#" onclick="paginateTableShow('${tableId}','${paginationId}',${i});return false;">${i}</a>
                     </li>`;
        }

        if(currentPage < pageCount){
            html += `<li class="page-item"><a class="page-link" href="#" onclick="paginateTableShow('${tableId}','${paginationId}',${currentPage+1});return false;">&gt;</a></li>`;
        }

        pagination.innerHTML = html;
    }

    showPage(1);

    window.paginateTableShow = function(tId, pId, page){
        if(tId === tableId && pId === paginationId){
            showPage(page);
        }
    }
}

// Initialize both tables
paginateTable("pendingTable", "pendingPagination", 8);
paginateTable("approvedTable", "approvedPagination", 8);
</script>
