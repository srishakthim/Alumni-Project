<?php
include("sidebar.php"); // db + session
?>

<?php
/* ===============================
   CONFIG
   =============================== */
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

/* ===============================
   ADD EVENT
   =============================== */
if (isset($_POST['add_event'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $event_date = $_POST['event_date'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    mysqli_query($conn,
        "INSERT INTO events (title, event_date, description)
         VALUES ('$title','$event_date','$description')"
    );
    header("Location: events.php");
    exit;
}

/* ===============================
   UPDATE EVENT
   =============================== */
if (isset($_POST['update_event'])) {
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $event_date = $_POST['event_date'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    mysqli_query($conn,
        "UPDATE events SET
         title='$title',
         event_date='$event_date',
         description='$description'
         WHERE id=$id"
    );
    header("Location: events.php");
    exit;
}

/* ===============================
   DELETE EVENT
   =============================== */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM events WHERE id=$id");
    header("Location: events.php");
    exit;
}

/* ===============================
   EDIT FETCH
   =============================== */
$editData = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $editData = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT * FROM events WHERE id=$id")
    );
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container-fluid p-4">
    <h3 class="mb-4">📅 Events</h3>

    <div class="row">
        <!-- ADD / EDIT -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <?= $editData ? "Edit Event" : "Add Event"; ?>
                </div>

                <div class="card-body">
                    <form method="POST">
                        <?php if ($editData): ?>
                            <input type="hidden" name="id" value="<?= $editData['id']; ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label>Event Title</label>
                            <input type="text" name="title" class="form-control"
                                   value="<?= $editData['title'] ?? ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Event Date</label>
                            <input type="date" name="event_date" class="form-control"
                                   value="<?= $editData['event_date'] ?? ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control"><?= $editData['description'] ?? ''; ?></textarea>
                        </div>

                        <?php if ($editData): ?>
                            <button name="update_event" class="btn btn-success w-100 mb-2">Update</button>
                            <a href="events.php" class="btn btn-secondary w-100">Cancel</a>
                        <?php else: ?>
                            <button name="add_event" class="btn btn-primary w-100 mb-2">Add Event</button>
                            <button type="reset" class="btn btn-secondary w-100">Cancel</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

        <!-- LIST -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white d-flex justify-content-between">
                    Event List
                    <form class="d-flex" method="GET">
                        <input type="text" name="search" class="form-control form-control-sm me-2"
                               placeholder="Search event"
                               value="<?= htmlspecialchars($search); ?>">
                        <button class="btn btn-sm btn-light">Search</button>
                    </form>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th width="160">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = "SELECT * FROM events
                                  WHERE title LIKE '%$search%'
                                  ORDER BY event_date DESC
                                  LIMIT $limit OFFSET $offset";

                        $result = mysqli_query($conn, $query);
                        $i = $offset + 1;

                        if (mysqli_num_rows($result)) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= htmlspecialchars($row['title']); ?></td>
                                    <td><?= date('d M Y', strtotime($row['event_date'])); ?></td>
                                    <td><?= htmlspecialchars($row['description']); ?></td>
                                    <td>
                                        <a href="events.php?edit=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="events.php?delete=<?= $row['id']; ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Are you sure to delete?')">
                                           Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>No events found</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>

                    <!-- PAGINATION -->
                    <?php
                    $total = mysqli_fetch_row(
                        mysqli_query($conn, "SELECT COUNT(*) FROM events WHERE title LIKE '%$search%'")
                    )[0];
                    $pages = ceil($total / $limit);
                    ?>

                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item"><a class="page-link" href="?page=<?= $page-1; ?>&search=<?= $search; ?>">&lt;</a></li>
                            <?php endif; ?>

                            <?php for ($p = 1; $p <= $pages; $p++): ?>
                                <li class="page-item <?= $p == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?= $p; ?>&search=<?= $search; ?>"><?= $p; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $pages): ?>
                                <li class="page-item"><a class="page-link" href="?page=<?= $page+1; ?>&search=<?= $search; ?>">&gt;</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
