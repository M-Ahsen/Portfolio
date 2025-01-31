<?php
require("includes/config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form fields
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "All fields are required.";
    } else if ($password != $confirm_password) {
        echo "Passwords do not match.";
    } else {
        // Check if the email already exists
        $sql = "SELECT id FROM `users` WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($result->num_rows > 0) {
            echo "Please use a different email. This email is already in use.";
        } else {

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO `users` (`name`, `email`, `password`) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sss', $name, $email, $hashed_password);
            $stmt->execute();

            // Fetch the last inserted ID
            $user_id = $conn->insert_id;
            $user_dir = "uploads/projects";

            // Create user directory
            if (!file_exists($user_dir)) {
                if (mkdir($user_dir, 0777, true)) {
                    echo "Account created successfully.";
                    header('Location: login.php');
                    exit();
                } else {
                    echo "Failed to create project folder. Check folder permissions.";
                    exit();
                }
            } else {
                echo "Directory already exists.";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign Up - Online CV Builder</title>
    <link rel="stylesheet" href="CSS/login&signup.css">
    <?php require('includes/head.php'); ?>
</head>

<body>
    <div class="auth-container">
        <h2>Create Your Account</h2>
        <form action="signup.php" method="POST">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit" class="auth-btn">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>

    <?php $conn->close(); ?>
</body>

</html>
