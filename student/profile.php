<?php
include("sidebar.php");
$user_id = $_SESSION['user_id'];

if(isset($_POST['update'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dept = mysqli_real_escape_string($conn, $_POST['department']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);

    mysqli_query($conn,"UPDATE users SET 
        name='$name',
        department='$dept',
        graduation_year='$year'
        WHERE id=$user_id
    ");

    echo "<div class='alert alert-success mt-2'>Profile updated ✅</div>";
}

$user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id=$user_id"));
?>

<h3>👤 My Profile</h3>

<form method="post" class="card p-4 shadow mt-3" id="profileForm">
    <label>Name</label>
    <input type="text" name="name" class="form-control mb-2" value="<?= htmlspecialchars($user['name']) ?>" disabled required>

    <label>Department</label>
    <input type="text" name="department" class="form-control mb-2" value="<?= htmlspecialchars($user['department']) ?>" disabled>

    <label>Year</label>
    <input type="text" name="year" class="form-control mb-2" value="<?= htmlspecialchars($user['graduation_year']) ?>" disabled>

    <label>Email</label>
    <input type="email" class="form-control mb-3" value="<?= htmlspecialchars($user['email']) ?>" readonly>

    <button type="button" id="editBtn" class="btn btn-warning">Edit</button>
    <button type="submit" name="update" id="updateBtn" class="btn btn-primary d-none">Update</button>
    <br>
    <button type="button" id="cancelBtn" class="btn btn-secondary d-none">Cancel</button>
</form>

<script>
const editBtn = document.getElementById('editBtn');
const updateBtn = document.getElementById('updateBtn');
const cancelBtn = document.getElementById('cancelBtn');
const form = document.getElementById('profileForm');

// Enable fields for editing
editBtn.addEventListener('click', () => {
    form.querySelectorAll('input[type=text]').forEach(input => input.disabled = false);
    editBtn.classList.add('d-none');
    updateBtn.classList.remove('d-none');
    cancelBtn.classList.remove('d-none');
});

// Cancel editing
cancelBtn.addEventListener('click', () => {
    form.querySelectorAll('input[type=text]').forEach(input => {
        input.disabled = true;
        // Reset values to original
        input.value = input.defaultValue;
    });
    editBtn.classList.remove('d-none');
    updateBtn.classList.add('d-none');
    cancelBtn.classList.add('d-none');
});
</script>
