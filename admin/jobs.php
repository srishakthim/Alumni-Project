<?php
include("sidebar.php"); // sidebar + db + session

// ===============================
// Handle approve/delete via POST (AJAX)
// ===============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $id = intval($_POST['id']);
    if ($_POST['action'] === 'approve') {
        mysqli_query($conn, "UPDATE jobs SET status='approved' WHERE id=$id");
        echo 'success';
        exit;
    } elseif ($_POST['action'] === 'delete') {
        mysqli_query($conn, "DELETE FROM jobs WHERE id=$id");
        echo 'success';
        exit;
    }
}

// ===============================
// Pagination Setup
// ===============================
$perPage = 8;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Count total jobs
$totalJobsResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM jobs");
$totalJobsRow = mysqli_fetch_assoc($totalJobsResult);
$totalJobs = $totalJobsRow['total'];
$totalPages = ceil($totalJobs / $perPage);
$start = ($page - 1) * $perPage;

// Fetch jobs for current page
$query = "SELECT j.*, u.name 
          FROM jobs j 
          JOIN users u ON j.posted_by = u.id
          ORDER BY j.created_at DESC
          LIMIT $start, $perPage";
$result = mysqli_query($conn, $query);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid">
    <h3 class="mb-4">💼 Job Management</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Posted By</th>
                        <th>Company</th>
                        <th>Position</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = $start + 1;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $statusBadge = strtolower($row['status']) === 'approved'
                                ? "<span class='badge bg-success'>Approved</span>"
                                : "<span class='badge bg-warning'>Pending</span>";

                            // Buttons
                            $approveDisabled = strtolower($row['status']) === 'approved' ? 'disabled' : '';
                            echo "<tr>
                                <td>{$i}</td>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['company']) . "</td>
                                <td>" . htmlspecialchars($row['position']) . "</td>
                                <td>" . htmlspecialchars($row['location']) . "</td>
                                <td>{$statusBadge}</td>
                                <td>
                                    <button class='btn btn-success btn-sm approve-btn' data-id='{$row['id']}' $approveDisabled>Approve</button>
                                    <button class='btn btn-danger btn-sm delete-btn' data-id='{$row['id']}'>Delete</button>
                                </td>
                            </tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center text-muted'>No job postings found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <nav>
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">«</a>
                        </li>

                        <?php
                        $visiblePages = 5;
                        $startPage = max(1, $page - floor($visiblePages / 2));
                        $endPage = min($totalPages, $startPage + $visiblePages - 1);
                        if ($endPage - $startPage + 1 < $visiblePages) {
                            $startPage = max(1, $endPage - $visiblePages + 1);
                        }
                        if ($startPage > 1) echo '<li class="page-item disabled"><span class="page-link">…</span></li>';

                        for ($p = $startPage; $p <= $endPage; $p++):
                        ?>
                            <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($endPage < $totalPages) echo '<li class="page-item disabled"><span class="page-link">…</span></li>'; ?>

                        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">»</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    // Approve
    document.querySelectorAll('.approve-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!confirm('Are you sure you want to approve this job?')) return;
            const id = btn.dataset.id;
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body: 'action=approve&id=' + id
            }).then(res => res.text())
            .then(data => {
                if (data.trim() === 'success') {
                    btn.disabled = true; // disable button immediately
                    btn.closest('tr').querySelector('td:nth-child(6)').innerHTML = '<span class="badge bg-success">Approved</span>';
                }
            });
        });
    });

    // Delete
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!confirm('Are you sure you want to delete this job?')) return;
            const id = btn.dataset.id;
            fetch(window.location.href, {
                method: 'POST',
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body: 'action=delete&id=' + id
            }).then(res => res.text())
            .then(data => {
                if (data.trim() === 'success') {
                    btn.closest('tr').remove(); // remove row immediately
                }
            });
        });
    });

});
</script>
