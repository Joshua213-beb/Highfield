<?php
// Include database connection
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $childName = $_POST['childName'];
    $dob = $_POST['dob'];
    $class = $_POST['class'];
    $formerSchool = $_POST['formerSchool'];
    $parentName = $_POST['parentName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $whatsapp = $_POST['whatsapp'];
    $residence = $_POST['residence'];
    $referral = isset($_POST['referral']) ? implode(", ", $_POST['referral']) : "";

    // Insert data into the database
    $query = "INSERT INTO applications (child_name, dob, class, former_school, parent_name, phone, email, whatsapp, residence, referral) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssss", $childName, $dob, $class, $formerSchool, $parentName, $phone, $email, $whatsapp, $residence, $referral);

    if ($stmt->execute()) {
        // Show success notification and redirect
        echo "<script>
                alert('Your application has been submitted successfully!');
                window.location.href = 'index.html'; // Redirect to the application form page
              </script>";
    } else {
        // Show error notification and redirect
        echo "<script>
                alert('Error: " . $stmt->error . "');
                window.location.href = 'index.html'; // Redirect back to the application form page
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
