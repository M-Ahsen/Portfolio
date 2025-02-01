<?php
require("includes/config.php");
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form data and insert into database (personal_info table)
    $fullName = $_POST['full-name'];
    $profession = $_POST['profession'];
    $linkedin = $_POST['linkedin'];
    $github = $_POST['github'];
    $resume = $_FILES['resume']['name'];
    $uploadsDir = $_SESSION['user_dir'];

    $resumePath = "";
    if (!empty($resume)) {
        $resumePath = $uploadsDir . $resume;
        move_uploaded_file($_FILES['resume']['tmp_name'], $resumePath);
    }

    $user_id = $_SESSION['user_id'];

    if (empty($fullName) || empty($profession)) {
        echo "Please fill in all required fields.";
    } elseif (empty($user_id)) {
        echo 'Login Issue';
    } else {
        $sql = "INSERT INTO personal_info (full_name, profession, linkedin, github, resumePath, user_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssi', $fullName, $profession, $linkedin, $github, $resumePath, $user_id);
        $stmt->execute();
        $stmt->close();

        // Redirect to next section (About Me)
        header("Location: dashboard.php");
        exit();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="CSS/add-personal_info.css">
    <?php require('includes/head.php'); ?>
    <title>Personal Information</title>
</head>
<body>
    <form action="add-personal_info.php" method="POST" enctype="multipart/form-data">
        <h2>Personal Information</h2>
        <label for="full-name">Full Name:</label>
        <input type="text" id="full-name" name="full-name" required>
        <label for="profession">Profession:</label>
        <input type="text" id="profession" name="profession" required>
        <label for="linkedin">LinkedIn URL:</label>
        <input type="url" id="linkedin" name="linkedin">
        <label for="github">GitHub URL:</label>
        <input type="url" id="github" name="github">
        <label for="resume">Resume:</label>
        <input type="file" id="resume" name="resume" accept=".pdf">
        <button type="submit">Next</button>
    </form>
</body>
</html>
