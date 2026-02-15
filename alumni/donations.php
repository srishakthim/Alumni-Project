<?php
include("sidebar.php");

$user_id = $_SESSION['user_id'];

if (isset($_POST['donate'])) {
    $amount = $_POST['amount'];
    $purpose = $_POST['purpose'] ?? '';

    // Insert donation into database
    mysqli_query($conn, "INSERT INTO donations (user_id, amount, purpose) 
        VALUES ($user_id, '$amount', '" . mysqli_real_escape_string($conn, $purpose) . "')"
    );

    echo "<div class='alert alert-success mt-2'>Thank you for your donation ❤️</div>";
}
?>

<h3>💰 Donations</h3>

<div class="card p-4 shadow mt-3">
    <form method="post">
        <label>Donation Amount</label>
        <input type="number" name="amount" class="form-control mb-2" required>

        <label>Purpose</label>
        <input type="text" name="purpose" class="form-control mb-2" placeholder="Optional">

        <button name="donate" class="btn btn-danger">Donate</button>
    </form>
</div>

<h5 class="mt-4">My Donation History</h5>

<table class="table table-bordered mt-2">
    <thead class="table-dark">
        <tr>
            <th>Amount (₹)</th>
            <th>Purpose</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $res = mysqli_query($conn, "SELECT * FROM donations WHERE user_id=$user_id ORDER BY donated_at DESC");
        while ($row = mysqli_fetch_assoc($res)) {
            $purpose = htmlspecialchars($row['purpose'] ?? '-');
            $date = isset($row['donated_at']) ? date("d M Y", strtotime($row['donated_at'])) : '-';
            echo "<tr>
                    <td>₹ " . htmlspecialchars($row['amount']) . "</td>
                    <td>{$purpose}</td>
                    <td>{$date}</td>
                  </tr>";
        }
        ?>
    </tbody>
</table>
