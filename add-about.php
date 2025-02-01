<?php
require("includes/config.php");
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aboutText = $_POST['about'];
    $aboutPhoto = $_FILES['about-photo']['name'];
    $uploadsDir = $_SESSION['user_dir'];
    $aboutPhotoPath = "";

    if (!empty($aboutPhoto)) {
        $aboutPhotoPath = $uploadsDir . $aboutPhoto;
        move_uploaded_file($_FILES['about-photo']['tmp_name'], $aboutPhotoPath);
    }

    $user_id = $_SESSION['user_id'];

    if (empty($aboutText)) {
        echo "Please fill in the About text.";
    } elseif (empty($user_id)) {
        echo 'Login Issue';
    } else {
        $sql = "INSERT INTO about (about_photo, about_text, about_photo_path, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $aboutPhoto, $aboutText, $aboutPhotoPath, $user_id);
        $stmt->execute();
        $stmt->close();

        // Redirect to next section (Education)
        header("Location: dashboard.php");
        exit();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="CSS/add-about.css">
    <?php require('includes/head.php'); ?>
    <title>About Me</title>
</head>
<body>
    <form action="add-about.php" method="POST" enctype="multipart/form-data">
        <h2>About Me</h2>
        <label for="about-photo">Upload Profile Photo:</label>
        <input type="file" id="about-photo" name="about-photo" accept="image/*">
        <label for="about">About Text:</label>
        <textarea id="about" name="about" rows="4" required></textarea>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
