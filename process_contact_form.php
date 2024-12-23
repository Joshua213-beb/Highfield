<?php
// Include database connection
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Insert data into the database
    $query = "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        if ($stmt->execute()) {
            // Send email (confirmation to both admin and user)
            $to = "admin@example.com"; // Admin email
            $userMessage = "Thank you for contacting us, $name. We have received your message and will respond shortly.";
            $headers = "From: no-reply@example.com";

            // Email to user
            mail($email, "Thank you for your message", $userMessage, $headers);

            // Email to admin
            $adminMessage = "New contact form submission:\n\nName: $name\nEmail: $email\nSubject: $subject\nMessage: $message";
            mail($to, "New Contact Form Submission", $adminMessage, $headers);

            // Show notification using JavaScript
            echo "<script>
                    alert('Your message has been sent successfully!');
                    window.location.href = 'index.html'; // Redirect to the contact page after submission
                  </script>";
        } else {
            // Error handling
            echo "<script>
                    alert('Error: " . $stmt->error . "');
                    window.location.href = 'index.html'; // Redirect to the contact page if there's an error
                  </script>";
        }
        $stmt->close();
    } else {
        // Error handling
        echo "<script>
                alert('Error: Could not prepare the statement.');
                window.location.href = 'index.html'; // Redirect to the contact page if there's an error
              </script>";
    }

    $conn->close();
}
?>
