<?php
require("includes/config.php");
session_start();

$formSubmitted = false;
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    $user_id = $_SESSION['user_id'] ?? null;

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $errorMessage = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email format.";
    } elseif (!$user_id) {
        $errorMessage = "Login issue. Please log in before submitting a request.";
    } else {
        $sql = "INSERT INTO contact_support (name, email, subject, message, user_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('ssssi', $name, $email, $subject, $message, $user_id);
            if ($stmt->execute()) {
                $formSubmitted = true;
            } else {
                $errorMessage = "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errorMessage = "Database error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Contact Support - Online CV Builder</title>
    <link rel="stylesheet" href="css/contact.css">
    <?php require('includes/head.php'); ?>
</head>

<body>

    <div class="contact-container">
        <h2>Contact Support</h2>
        <p>If you have any questions or need assistance, please fill out the form below. Our support team will get back
            to you shortly.</p>

        <?php if ($formSubmitted): ?>
            <p class="success-message">Thank you for your message! We will get back to you shortly.</p>
        <?php elseif ($errorMessage): ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <form action="contact.php" method="POST" class="contact-form">
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

</body>

</html>
