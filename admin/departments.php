<?php
include("sidebar.php");

$error = "";

/* SEARCH */
$search = isset($_GET['search'])
    ? mysqli_real_escape_string($conn, $_GET['search'])
    : '';

/* ADD DEPARTMENT */
if (isset($_POST['add_department'])) {

    $dept_name = trim(mysqli_real_escape_string($conn, $_POST['department_name']));

    if (!empty($dept_name)) {

        // CHECK IF DEPARTMENT ALREADY EXISTS
        $check = mysqli_query(
            $conn,
            "SELECT * FROM departments WHERE dept_name='$dept_name'"
        );

        if (mysqli_num_rows($check) > 0) {
            $error = "Department already exists!";
        } else {

            mysqli_query(
                $conn,
                "INSERT INTO departments (dept_name) VALUES ('$dept_name')"
            );

            header("Location: departments.php");
            exit;
        }
    }
}

/* UPDATE DEPARTMENT */
if (isset($_POST['update_department'])) {

    $id = intval($_POST['dept_id']);
    $dept_name = trim(mysqli_real_escape_string($conn, $_POST['department_name']));

    // CHECK DUPLICATE EXCEPT CURRENT ROW
    $check = mysqli_query(
        $conn,
        "SELECT * FROM departments WHERE dept_name='$dept_name' AND id!=$id"
    );

    if (mysqli_num_rows($check) > 0) {
        $error = "Department already exists!";
    } else {

        mysqli_query(
            $conn,
            "UPDATE departments SET dept_name='$dept_name' WHERE id=$id"
        );

        header("Location: departments.php");
        exit;
    }
}

/* DELETE DEPARTMENT */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM departments WHERE id=$id");
    header("Location: departments.php");
    exit;
}

/* ===============================
   PAGINATION
   =============================== */
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

$totalResult = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM departments
     WHERE dept_name LIKE '%$search%'"
);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalPages = ceil($totalRow['total'] / $limit);

$result = mysqli_query(
    $conn,
    "SELECT *
     FROM departments
     WHERE dept_name LIKE '%$search%'
     ORDER BY id DESC
     LIMIT $offset, $limit"
);
?>

<div class="container-fluid">
    <h3 class="mb-4">🏫 Departments</h3>

    <div class="row">
        <!-- ADD DEPARTMENT -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">Add Department</div>
                <div class="card-body">

                    <?php if (!empty($error)) { ?>
                        <div class="alert alert-danger">
                            <?= $error ?>
                        </div>
                    <?php } ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Department Name</label>
                            <input type="text" name="department_name"
                                class="form-control" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button name="add_department" class="btn btn-primary w-100">
                                Add
                            </button>
                            <button type="reset" class="btn btn-outline-secondary w-100">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- DEPARTMENT LIST -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white d-flex justify-content-between">
                    Department List

                    <!-- SEARCH -->
                    <form class="d-flex" method="GET">
                        <input type="text"
                            name="search"
                            value="<?= htmlspecialchars($search); ?>"
                            class="form-control form-control-sm me-2"
                            placeholder="Search department">
                        <button class="btn btn-sm btn-light">Search</button>
                    </form>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="60">#</th>
                                <th>Department Name</th>
                                <th width="150" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = $offset + 1;
                            if (mysqli_num_rows($result)) {
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <tr>
                                        <td><?= $i++; ?></td>

                                        <td>
                                            <form method="POST" class="d-flex gap-2">
                                                <input type="hidden" name="dept_id"
                                                    value="<?= $row['id']; ?>">

                                                <input type="text"
                                                    id="dept_<?= $row['id']; ?>"
                                                    name="department_name"
                                                    value="<?= htmlspecialchars($row['dept_name']); ?>"
                                                    data-original="<?= htmlspecialchars($row['dept_name']); ?>"
                                                    class="form-control"
                                                    readonly required>

                                                <button type="button"
                                                    id="editBtn_<?= $row['id']; ?>"
                                                    class="btn btn-primary btn-sm"
                                                    onclick="enableEdit(<?= $row['id']; ?>)">
                                                    Edit
                                                </button>

                                                <button type="submit"
                                                    name="update_department"
                                                    id="updateBtn_<?= $row['id']; ?>"
                                                    class="btn btn-success btn-sm d-none">
                                                    Update
                                                </button>

                                                <button type="button"
                                                    id="cancelBtn_<?= $row['id']; ?>"
                                                    class="btn btn-secondary btn-sm d-none"
                                                    onclick="cancelEdit(<?= $row['id']; ?>)">
                                                    Cancel
                                                </button>
                                            </form>
                                        </td>

                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#delete<?= $row['id']; ?>">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- DELETE MODAL -->
                                    <div class="modal fade" id="delete<?= $row['id']; ?>">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Confirm Delete</h5>
                                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Delete <strong><?= htmlspecialchars($row['dept_name']); ?></strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="?delete=<?= $row['id']; ?>" class="btn btn-danger">
                                                        Yes, Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center text-muted'>No departments found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- PAGINATION -->
                    <nav>
                        <ul class="pagination justify-content-end">
                            <li class="page-item <?= $page <= 1 ? 'disabled' : ''; ?>">
                                <a class="page-link"
                                    href="?page=<?= $page - 1; ?>&search=<?= $search; ?>">&lt;</a>
                            </li>

                            <?php
                            $start = max(1, $page - 1);
                            $end = min($totalPages, $page + 1);

                            if ($start > 1) {
                                echo '<li class="page-item"><a class="page-link" href="?page=1&search=' . $search . '">1</a></li>';
                                if ($start > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }

                            for ($p = $start; $p <= $end; $p++) {
                                echo '<li class="page-item ' . ($p == $page ? 'active' : '') . '">
                                      <a class="page-link" href="?page=' . $p . '&search=' . $search . '">' . $p . '</a></li>';
                            }

                            if ($end < $totalPages) {
                                if ($end < $totalPages - 1)
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $totalPages . '&search=' . $search . '">' . $totalPages . '</a></li>';
                            }
                            ?>

                            <li class="page-item <?= $page >= $totalPages ? 'disabled' : ''; ?>">
                                <a class="page-link"
                                    href="?page=<?= $page + 1; ?>&search=<?= $search; ?>">&gt;</a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function enableEdit(id) {
        const input = document.getElementById('dept_' + id);
        input.removeAttribute('readonly');

        document.getElementById('editBtn_' + id).classList.add('d-none');
        document.getElementById('updateBtn_' + id).classList.remove('d-none');
        document.getElementById('cancelBtn_' + id).classList.remove('d-none');
    }

    function cancelEdit(id) {
        const input = document.getElementById('dept_' + id);
        input.value = input.getAttribute('data-original');
        input.setAttribute('readonly', true);

        document.getElementById('editBtn_' + id).classList.remove('d-none');
        document.getElementById('updateBtn_' + id).classList.add('d-none');
        document.getElementById('cancelBtn_' + id).classList.add('d-none');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>