<?php
require("includes/config.php");
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobTitle = $_POST['job-title'];
    $companyName = $_POST['company-name'];
    $employmentDates = $_POST['employment-dates'];
    $jobDescription = $_POST['job-description'];
    $user_id = $_SESSION['user_id'];

    if (empty($jobTitle) || empty($companyName)) {
        echo "Please fill in all required fields.";
    } elseif (empty($user_id)) {
        echo 'Login Issue';
    } else {
        $sql = "INSERT INTO work_experience (job_title, company_name, employment_dates, job_description, user_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssi', $jobTitle, $companyName, $employmentDates, $jobDescription, $user_id);
        $stmt->execute();
        $stmt->close();

        // Redirect to next section (Contact Info)
        header("Location: contact_info.php");
        exit();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="CSS/add-work_experience.css">
    <?php require('includes/head.php'); ?>
    <title>Work Experience</title>
</head>
<body>
    <form action="add-work_experience.php" method="POST">
        <h2>Work Experience</h2>
        <label for="job-title">Job Title:</label>
        <input type="text" id="job-title" name="job-title" placeholder="e.g., Web Developer" required>

        <label for="company-name">Company Name:</label>
        <input type="text" id="company-name" name="company-name" placeholder="e.g., XYZ Company" required>

        <label for="employment-dates">Employment Dates:</label>
        <input type="text" id="employment-dates" name="employment-dates" placeholder="e.g., May 2024 - Present">

        <label for="job-description">Job Description:</label>
        <textarea id="job-description" name="job-description" rows="3" placeholder="Describe your responsibilities"></textarea>

        <button type="submit">Next</button>
    </form>
</body>
</html>