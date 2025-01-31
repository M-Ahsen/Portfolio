<?php require("includes/config.php");
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "Email & Password are required";
    } else {

        $sql = "SELECT `id`, `name`, `password` FROM `users` WHERE `email` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['logged_in'] = 'T';
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_dir'] = "uploads/projects/" . "userid_" . $user['id'] . "/";
                echo "Login successful";
                header("Location: dashboard.php");
            } else {
                echo "Invalid password!";
            }
        } else {
            echo "No user found with this email!";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login - Online CV Builder</title>
    <link rel="stylesheet" href="CSS/login&signup.css">
    <?php require('includes/head.php'); ?>
</head>

<body>

    <div class="auth-container">
        <h2>Login to Your Account</h2>
        <form action="#" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="auth-btn">Login</button>
        </form>
        <p>Don’t have an account? <a href="signup.php">Sign Up</a></p>
    </div>
    <?php $conn->close(); ?>
</body>

</html>


