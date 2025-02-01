<?php
require("includes/config.php");
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $degree = $_POST['degree'];
    $institute = $_POST['institute'];
    $educationYear = $_POST['education-year'];
    $user_id = $_SESSION['user_id'];

    if (empty($degree) || empty($institute)) {
        echo "Please fill in all required fields.";
    } elseif (empty($user_id)) {
        echo 'Login Issue';
    } else {
        $sql = "INSERT INTO education (degree, institute, education_year, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $degree, $institute, $educationYear, $user_id);
        $stmt->execute();
        $stmt->close();

        // Redirect to next section (Work Experience)
        header("Location: work_experience.php");
        exit();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="CSS/add-education.css">
    <?php require('includes/head.php'); ?>
    <title>Education</title>
</head>
<body>
    <form action="add-education.php" method="POST">
        <h2>Education</h2>
        <label for="degree">Degree:</label>
        <input type="text" id="degree" name="degree" placeholder="e.g., Bachelor of Information Technology" required>
        
        <label for="institute">Institute:</label>
        <input type="text" id="institute" name="institute" placeholder="e.g., KFUEIT" required>
        
        <label for="education-year">Year:</label>
        <input type="text" id="education-year" name="education-year" placeholder="e.g., 2020 - 2024">

        <button type="submit">Next</button>
    </form>
</body>
</html>
