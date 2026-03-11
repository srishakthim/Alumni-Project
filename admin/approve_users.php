<?php
include("sidebar.php"); // sidebar + db + session

// Delete User
if (isset($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM users WHERE id=$user_id");
    header("Location: approve_users.php");
    exit;
}
?>

<div class="container-fluid">
    <h3 class="mb-4">👤 Alumni Management</h3>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            Registered Alumni & Students
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover" id="userTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Role</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = "SELECT * FROM users WHERE role IN ('alumni','student')";
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
                            <td>
                                <a href='approve_users.php?delete={$row['id']}'
                                   class='btn btn-danger btn-sm'
                                   onclick=\"return confirm('Delete this user?')\">
                                   Delete
                                </a>
                            </td>
                        </tr>";

                        $i++;
                    }
                    ?>
                </tbody>
            </table>

            <nav>
                <ul class="pagination" id="pagination"></ul>
            </nav>

        </div>
    </div>
</div>


<script>
// Pagination
function paginateTable(tableId, paginationId, rowsPerPage = 8) {

    const table = document.getElementById(tableId);
    const rows = Array.from(table.querySelectorAll("tbody tr"));
    const pagination = document.getElementById(paginationId);

    let currentPage = 1;

    function showPage(page) {

        currentPage = page;

        const start = (page-1) * rowsPerPage;
        const end = start + rowsPerPage;

        rows.forEach((row, i) => {
            row.style.display = (i >= start && i < end) ? "" : "none";
        });

        renderPagination();
    }

    function renderPagination() {

        const pageCount = Math.ceil(rows.length / rowsPerPage);

        let html = "";

        if(currentPage > 1){
            html += `<li class="page-item">
                        <a class="page-link" href="#" onclick="changePage(${currentPage-1})">&lt;</a>
                     </li>`;
        }

        for(let i=1;i<=pageCount;i++){
            html += `<li class="page-item ${i===currentPage?'active':''}">
                        <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                     </li>`;
        }

        if(currentPage < pageCount){
            html += `<li class="page-item">
                        <a class="page-link" href="#" onclick="changePage(${currentPage+1})">&gt;</a>
                     </li>`;
        }

        pagination.innerHTML = html;
    }

    window.changePage = function(page){
        showPage(page);
    }

    showPage(1);
}

paginateTable("userTable","pagination",8);
</script>
