<?php
require("includes/config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        die("Email & Password are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    $sql = "SELECT id, name, email, password FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Set session variables securely
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_dir'] = "uploads/projects/userid_" . $user['id'] . "/";

                // Redirect to dashboard
                header("Location: dashboard.php");
                exit;
            } else {
                die("Invalid password.");
            }
        } else {
            die("No user found with this email.");
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login - Online CV Builder</title>
    <link rel="stylesheet" href="css/login&signup.css">
    <?php require('includes/head.php'); ?>
</head>

<body>

    <div class="auth-container">
        <h2>Login to Your Account</h2>
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="auth-btn">Login</button>
        </form>
        <p>Don’t have an account? <a href="signup.php">Sign Up</a></p>
    </div>
</body>

</html>
