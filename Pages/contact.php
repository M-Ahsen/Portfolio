<?php
require("../includes/config.php");
session_start();
$formSubmitted = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "Please fill in all required fields.";
    } elseif (empty($user_id)) {
        echo 'Login Issue';
    } else {
        $sql = "INSERT INTO contact_support (name, email, subject, message, user_id) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('ssssi', $name, $email, $subject, $message, $user_id);
            if ($stmt->execute()) {
                $formSubmitted = true;
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

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