<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Include database connection
require 'db_connection.php';

// Fetch contact form submissions
$contactQuery = "SELECT * FROM contact_messages ORDER BY submitted_at DESC";
$contactResult = $conn->query($contactQuery);

// Fetch application form submissions
$applicationQuery = "SELECT * FROM applications ORDER BY submitted_at DESC";
$applicationResult = $conn->query($applicationQuery);

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php"); // Redirect to login page after logout
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - View Submissions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h1 class="mb-4">Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
    
    <!-- Logout Button -->
    <a href="?logout=true" class="btn btn-danger mb-3">Logout</a>

    <h2 class="mt-5">Contact Form Submissions</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($contactResult->num_rows > 0) {
                while ($row = $contactResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['submitted_at']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No contact form submissions found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2 class="mt-5">Application Form Submissions</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Child Name</th>
                <th>Date of Birth</th>
                <th>Class</th>
                <th>Former School</th>
                <th>Parent Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>WhatsApp</th>
                <th>Residence</th>
                <th>Referral</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($applicationResult->num_rows > 0) {
                while ($row = $applicationResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['child_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['dob']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['class']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['former_school']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['parent_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['whatsapp']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['residence']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['referral']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['submitted_at']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No application form submissions found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
