<?php
require("includes/config.php");
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactAddress = $_POST['contact-address'];
    $contactPhone = $_POST['contact-phone'];
    $contactEmail = $_POST['contact-email'];
    $user_id = $_SESSION['user_id'];

    if (empty($contactAddress) || empty($contactPhone) || empty($contactEmail)) {
        echo "Please fill in all required fields.";
    } elseif (empty($user_id)) {
        echo 'Login Issue';
    } else {
        $sql = "INSERT INTO contact_info (contact_address, contact_phone, contact_email, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $contactAddress, $contactPhone, $contactEmail, $user_id);
        $stmt->execute();
        $stmt->close();

        // Redirect to a confirmation page or dashboard
        header("Location: dashboard.php");
        exit();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="CSS/add-contact_info.css">
    <?php require('includes/head.php'); ?>
    <title>Contact Information</title>
</head>
<body>
    <form action="add-contact_info.php" method="POST">
        <h2>Contact Information</h2>
        <label for="contact-address">Address:</label>
        <input type="text" id="contact-address" name="contact-address" placeholder="e.g., Lahore, Pakistan" required>

        <label for="contact-phone">Contact Number:</label>
        <input type="tel" id="contact-phone" name="contact-phone" placeholder="e.g., +92 304 345567891" required>

        <label for="contact-email">Email:</label>
        <input type="email" id="contact-email" name="contact-email" placeholder="e.g., example@gmail.com" required>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
