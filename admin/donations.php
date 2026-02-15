<?php
include("sidebar.php"); // sidebar + db + session

// ===============================
// Handle approve via POST (AJAX)
// ===============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'approve') {
    $donation_id = intval($_POST['id']);
    mysqli_query($conn, "UPDATE donations SET status='completed' WHERE id=$donation_id");
    echo 'success';
    exit;
}

// ===============================
// Pagination Setup
// ===============================
$perPage = 8;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Count total donations
$totalResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM donations");
$totalRow = mysqli_fetch_assoc($totalResult);
$totalDonations = $totalRow['total'];
$totalPages = ceil($totalDonations / $perPage);
$start = ($page - 1) * $perPage;

// Fetch donations
$query = "
    SELECT d.*, u.name, u.email
    FROM donations d
    JOIN users u ON d.user_id = u.id
    ORDER BY d.donated_at DESC
    LIMIT $start, $perPage
";
$result = mysqli_query($conn, $query);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid">
    <h3 class="mb-4">💰 Donation Approvals</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Alumni Name</th>
                        <th>Email</th>
                        <th>Amount (₹)</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = $start + 1;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $statusBadge = $row['status'] === 'completed'
                                ? "<span class='badge bg-success'>Completed</span>"
                                : "<span class='badge bg-warning'>Pending</span>";

                            $btnDisabled = $row['status'] === 'completed' ? 'disabled' : '';
                            echo "<tr data-id='{$row['id']}'>
                                <td>{$i}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['amount']}</td>
<td>" . htmlspecialchars($row['purpose'] ?? '-') . "</td>
                                <td class='status-cell'>{$statusBadge}</td>
                                <td>" . date("d M Y", strtotime($row['donated_at'])) . "</td>
                                <td>
                                    <button class='btn btn-success btn-sm approve-btn' $btnDisabled>Approve</button>
                                </td>
                            </tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center text-muted'>No donations found</td></tr>";
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

<script>
    // AJAX Approve
    document.querySelectorAll('.approve-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!confirm('Approve this donation?')) return;

            const tr = btn.closest('tr');
            const donationId = tr.dataset.id;

            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'action=approve&id=' + donationId
            }).then(res => res.text()).then(data => {
                if (data.trim() === 'success') {
                    tr.querySelector('.status-cell').innerHTML = '<span class="badge bg-success">Completed</span>';
                    btn.disabled = true;
                }
            });
        });
    });
</script>