<?php
// Include the database connection
require("../includes/config.php");

$formSubmitted = false;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "Please fill in all required fields.";
    } elseif (empty($user_id)) {
        echo 'Login Issue';
    } else {
        // Prepare SQL query to insert form data into the database
        $sql = "INSERT INTO contact_support (name, email, subject, message, user_id) VALUES (?, ?, ?, ?, ?)";

        // Prepare the statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param('ssssi', $name, $email, $subject, $message, $user_id);

            // Execute the statement
            if ($stmt->execute()) {
                $formSubmitted = true;
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Contact Support - Online CV Builder</title>
    <link rel="stylesheet" href="../CSS/contact.css">
    <?php require('../includes/head.php'); ?>
</head>

<body>

    <div class="contact-container">
        <h2>Contact Support</h2>
        <p>If you have any questions or need assistance, please fill out the form below. Our support team will get back
            to you shortly.</p>

        <!-- Display success message if form is submitted -->
        <?php if ($formSubmitted): ?>
            <p>Thank you for your message! We will get back to you shortly.</p>
        <?php endif; ?>

        <form action="#" method="POST" class="contact-form">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit" class="contact-btn">Submit</button>
        </form>
    </div>

    <?php $conn->close(); ?>
</body>

</html>