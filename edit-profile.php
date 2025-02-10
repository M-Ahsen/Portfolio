<?php
require("includes/config.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Login Issue. Please log in.";
    exit();
}

$user_id = $_SESSION['user_id'];
$uploadsDir = $_SESSION['user_dir'] ?? 'uploads/';

// Fetch user credentials from users table
$sql = "SELECT name, email, password FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user_info = $stmt->get_result()->fetch_assoc();
$stmt->close();


// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // User Credentials Update
    $newName = $_POST['name'] ?? '';
    $newEmail = $_POST['email'] ?? '';
    $newPassword = $_POST['password'] ?? '';

    // Validate email format
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Check if email already exists (excluding current user)
    $sql = "SELECT id FROM users WHERE email = ? AND id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newEmail, $user_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "Email is already in use.";
        exit();
    }
    $stmt->close();

    // Update user credentials
    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $newName, $newEmail, $hashedPassword, $user_id);
    } else {
        $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $newName, $newEmail, $user_id);
    }
    $stmt->execute();
    $stmt->close();

    // Update session variables
    $_SESSION['user_name'] = $newName;
    $_SESSION['email'] = $newEmail;

    echo "Profile updated successfully.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="CSS/profile_setup.css">
    <?php require('includes/head.php'); ?>
    <title>Profile Setup</title>
</head>
<body>
    <div class="container">

        <form action="edit-profile.php" method="POST">
            <h2>Update Your Profile</h2>
    
            <!-- User Credentials -->
            <div class="section">
                <h3>Account Information</h3>
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($user_info['name']) ?>" required>
    
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user_info['email']) ?>" required>
    
                <label for="password">New Password (Leave blank if unchanged):</label>
                <input type="password" id="password" name="password">
            </div>
    
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
