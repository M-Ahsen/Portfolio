<?php
require("includes/config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form fields
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if (strlen($password) < 8) {
        die("Password must be at least 8 characters long.");
    }

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Check if the email already exists
    $sql = "SELECT id FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            die("Please use a different email. This email is already in use.");
        }
        $stmt->close();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert new user
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sss', $name, $email, $hashed_password);
        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;
            $user_dir = "uploads/projects/userid_" . $user_id . "/";

            // Create user directory
            if (!file_exists($user_dir)) {
                if (!mkdir($user_dir, 0777, true)) {
                    die("Failed to create project folder. Check folder permissions.");
                }
            }

            // Redirect to login page
            header('Location: login.php');
            exit;
        } else {
            die("Error creating account.");
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign Up - Online CV Builder</title>
    <link rel="stylesheet" href="css/login&signup.css">
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
</body>

</html>
