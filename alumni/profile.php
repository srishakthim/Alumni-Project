<?php
include("sidebar.php");

$user_id = $_SESSION['user_id'];

// Handle profile update
if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $department = mysqli_real_escape_string($conn, $_POST['department'] ?? '');
    $year = mysqli_real_escape_string($conn, $_POST['year'] ?? '');
    $company = mysqli_real_escape_string($conn, $_POST['company'] ?? '');

    mysqli_query($conn, "UPDATE users SET 
        name='$name',
        department='$department',
        graduation_year='$year',
        company='$company'
        WHERE id=$user_id
    ");

    $success = "Profile updated successfully!";
}

// Fetch user details
$user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id=$user_id"));
$name = $user['name'] ?? '';
$department = $user['department'] ?? '';
$year = $user['graduation_year'] ?? '';
$company = $user['company'] ?? '';
?>

<h3>👤 My Profile</h3>

<?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

<form method="post" class="card p-4 mt-3 shadow" id="profileForm">
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" disabled>
    </div>

    <div class="mb-3">
        <label>Department</label>
        <input type="text" name="department" class="form-control" value="<?= htmlspecialchars($department) ?>" disabled>
    </div>

    <div class="mb-3">
        <label>Graduation Year</label>
        <input type="text" name="year" class="form-control" value="<?= htmlspecialchars($year) ?>" disabled>
    </div>

    <div class="mb-3">
        <label>Company</label>
        <input type="text" name="company" class="form-control" value="<?= htmlspecialchars($company) ?>" disabled>
    </div>

    <div class="d-flex gap-2">
        <button type="button" class="btn btn-primary" id="editBtn">Edit</button>
        <button type="button" class="btn btn-secondary" id="cancelBtn" disabled>Cancel</button>
        <button type="submit" name="update" class="btn btn-success" id="saveBtn" disabled>Update Profile</button>
    </div>
</form>

<script>
// Fields to enable/disable
const fields = ['name','department','year','company'];
const editBtn = document.getElementById('editBtn');
const cancelBtn = document.getElementById('cancelBtn');
const saveBtn = document.getElementById('saveBtn');

// Save original values
const originalValues = {
    name: '<?= addslashes($name) ?>',
    department: '<?= addslashes($department) ?>',
    year: '<?= addslashes($year) ?>',
    company: '<?= addslashes($company) ?>'
};

// Edit button click
editBtn.addEventListener('click', () => {
    fields.forEach(f => document.querySelector(`[name=${f}]`).disabled = false);
    saveBtn.disabled = false;
    cancelBtn.disabled = false;
    editBtn.disabled = true;
});

// Cancel button click
cancelBtn.addEventListener('click', () => {
    fields.forEach(f => {
        const field = document.querySelector(`[name=${f}]`);
        field.value = originalValues[f];
        field.disabled = true;
    });
    saveBtn.disabled = true;
    cancelBtn.disabled = true;
    editBtn.disabled = false;
});
</script>
