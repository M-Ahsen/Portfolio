<?php
require("includes/config.php");
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    die('Login Issue');
}

// Handle Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM work_experience WHERE id = ? AND user_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param('ii', $delete_id, $user_id);
    $delete_stmt->execute();
    $delete_stmt->close();
    header("Location: add-work_experience.php");
    exit();
}

// Handle New Entry
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job-title'])) {
    $jobTitle = $_POST['job-title'];
    $companyName = $_POST['company-name'];
    $employmentDates = $_POST['employment-dates'];
    $jobDescription = $_POST['job-description'];

    if (!empty($jobTitle) && !empty($companyName)) {
        $sql = "INSERT INTO work_experience (job_title, company_name, employment_dates, job_description, user_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssi', $jobTitle, $companyName, $employmentDates, $jobDescription, $user_id);
        $stmt->execute();
        $stmt->close();
        header("Location: add-work_experience.php");
        exit();
    } else {
        echo "Please fill in all required fields.";
    }
}

// Fetch Existing Records
$sql = "SELECT * FROM work_experience WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$workExperiences = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
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

<div class="container">
    <h2>Work Experience</h2>

    <!-- Display Previous Work Experience Records -->
    <?php if (!empty($workExperiences)): ?>
        <table>
            <tr>
                <th>Job Title</th>
                <th>Company Name</th>
                <th>Employment Dates</th>
                <th class='action' >Actions</th>
            </tr>
            <?php foreach ($workExperiences as $experience): ?>
                <tr>
                    <td><?= htmlspecialchars($experience['job_title']) ?></td>
                    <td><?= htmlspecialchars($experience['company_name']) ?></td>
                    <td><?= htmlspecialchars($experience['employment_dates']) ?></td>
                    <td>
                        <form action="add-work_experience.php" method="POST" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?= $experience['id'] ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No work experience added yet.</p>
    <?php endif; ?>

    <!-- Add New Work Experience Form -->
    <form action="add-work_experience.php" method="POST">
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
</div>

</body>
</html>
