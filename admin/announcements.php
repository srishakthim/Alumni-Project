<?php
include("sidebar.php"); // sidebar + db + session

// Handle announcement submit or edit
if (isset($_POST['save_announcement'])) {

    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);

    if ($id > 0) {
        // UPDATE existing announcement
        $sql = "UPDATE announcements 
                SET title='$title', message='$message', event_date='$event_date' 
                WHERE id=$id";
        $action = "updated";
    } else {
        // INSERT new announcement
        $sql = "INSERT INTO announcements (title, message, event_date, created_at) 
                VALUES ('$title', '$message', '$event_date', NOW())";
        $action = "added";
    }

    if (mysqli_query($conn, $sql)) {
        $success = "Announcement $action successfully!";
    } else {
        $error = "Failed to $action announcement!";
    }
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM announcements WHERE id=$delete_id");
    $success = "Announcement deleted successfully!";
}
?>

<div class="container-fluid">
    <h3 class="mb-4">📢 Announcements</h3>

    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <div class="row">
        <!-- Add/Edit Announcement -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <button id="addNewBtn" class="btn btn-success w-100 mb-3">Add New Announcement</button>
                <div class="card-header bg-dark text-white">Add / Edit Announcement</div>
                <div class="card-body">
                    <form method="POST" id="announcementForm">
                        <input type="hidden" name="id" id="announcement_id">

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" id="message" class="form-control" rows="4" required disabled></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Event Date</label>
                            <input type="date" name="event_date" id="event_date" class="form-control" required disabled>
                        </div>

                        <button type="submit" name="save_announcement" class="btn btn-primary w-100" id="saveBtn" disabled>Save</button>
                        <button type="button" class="btn btn-secondary w-100 mt-2" id="cancelBtn">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Announcement List -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    Announcement List
                    <input type="text" id="search" class="form-control mt-2" placeholder="Search by title...">
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="announcementTable">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Message</th>
                                <th>Event Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM announcements ORDER BY created_at DESC";
                            $result = mysqli_query($conn, $query);
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr data-title='" . htmlspecialchars($row['title'], ENT_QUOTES) . "'>
                                    <td>{$i}</td>
                                    <td>" . htmlspecialchars($row['title']) . "</td>
                                    <td>" . htmlspecialchars($row['message']) . "</td>
                                    <td>{$row['event_date']}</td>
                                    <td>
                                        <button class='btn btn-sm btn-info editBtn' 
                                                data-id='{$row['id']}' 
                                                data-title='" . htmlspecialchars($row['title'], ENT_QUOTES) . "' 
                                                data-message='" . htmlspecialchars($row['message'], ENT_QUOTES) . "'
                                                data-date='{$row['event_date']}'>Edit</button>
                                        <a href='?delete_id={$row['id']}' class='btn btn-sm btn-danger deleteBtn'>Delete</a>
                                    </td>
                                </tr>";
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Pagination placeholder -->
                    <nav>
                        <ul class="pagination" id="pagination"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Enable Add New
    document.getElementById("addNewBtn").addEventListener("click", function() {
        ["announcement_id", "title", "message", "event_date"].forEach(id => {
            document.getElementById(id).value = "";
        });
        ["title", "message", "event_date", "saveBtn"].forEach(id => {
            document.getElementById(id).disabled = false;
        });
    });

    // Enable Edit
    document.querySelectorAll(".editBtn").forEach(btn => {
        btn.addEventListener("click", function() {
            document.getElementById("announcement_id").value = this.dataset.id;
            document.getElementById("title").value = this.dataset.title;
            document.getElementById("message").value = this.dataset.message;
            document.getElementById("event_date").value = this.dataset.date;

            ["title", "message", "event_date", "saveBtn"].forEach(id => {
                document.getElementById(id).disabled = false;
            });
        });
    });

    // Cancel
    document.getElementById("cancelBtn").addEventListener("click", function() {
        ["announcement_id", "title", "message", "event_date"].forEach(id => {
            document.getElementById(id).value = "";
        });
        ["title", "message", "event_date", "saveBtn"].forEach(id => {
            document.getElementById(id).disabled = true;
        });
    });

    // Confirm delete
    document.querySelectorAll(".deleteBtn").forEach(btn => {
        btn.addEventListener("click", function(e) {
            if (!confirm("Are you sure you want to delete this announcement?")) e.preventDefault();
        });
    });

    // Search
    document.getElementById("search").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        document.querySelectorAll("#announcementTable tbody tr").forEach(row => {
            row.style.display = row.dataset.title.toLowerCase().includes(filter) ? "" : "none";
        });
    });

    // Pagination
    const rowsPerPage = 10;
    const table = document.getElementById("announcementTable");
    const pagination = document.getElementById("pagination");
    const rows = Array.from(table.querySelectorAll("tbody tr"));
    let currentPage = 1;

    function showPage(page) {
        currentPage = page;
        let start = (page - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        rows.forEach((row, i) => row.style.display = (i >= start && i < end) ? "" : "none");
        renderPagination();
    }

    function renderPagination() {
        let pageCount = Math.ceil(rows.length / rowsPerPage);
        let html = "";

        if (currentPage > 1) {
            html += `<li class="page-item"><a class="page-link" href="#" onclick="showPage(${currentPage-1});return false;">&lt;</a></li>`;
        }

        for (let i = 1; i <= pageCount; i++) {
            html += `<li class="page-item ${i===currentPage?'active':''}">
                    <a class="page-link" href="#" onclick="showPage(${i});return false;">${i}</a>
                 </li>`;
        }

        if (currentPage < pageCount) {
            html += `<li class="page-item"><a class="page-link" href="#" onclick="showPage(${currentPage+1});return false;">&gt;</a></li>`;
        }

        pagination.innerHTML = html;
    }

    showPage(1);
</script>