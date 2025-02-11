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
    $delete_sql = "DELETE FROM education WHERE id = ? AND user_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param('ii', $delete_id, $user_id);
    $delete_stmt->execute();
    $delete_stmt->close();
    header("Location: add-education.php");
    exit();
}

// Handle New Entry
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['degree'])) {
    $degree = $_POST['degree'];
    $institute = $_POST['institute'];
    $educationYear = $_POST['education-year'];
    $marks = $_POST['marks'];

    if (!empty($degree) && !empty($institute) && !empty($marks)) {
        $sql = "INSERT INTO education (degree, institute, education_year, marks, user_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssi', $degree, $institute, $educationYear, $marks, $user_id);
        $stmt->execute();
        $stmt->close();
        header("Location: add-education.php");
        exit();
    } else {
        echo "Please fill in all required fields.";
    }
}

// Fetch Existing Records
$sql = "SELECT * FROM education WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$educations = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/add-education.css">
    <?php require('includes/head.php'); ?>
    <title>Education</title>
</head>
<body>

<div class="container">
    <h2>Education</h2>

    <!-- Display Previous Education Records -->
    <?php if (!empty($educations)): ?>
        <table>
            <tr>
                <th>Degree</th>
                <th>Institute</th>
                <th>Year</th>
                <th>Marks</th>
                <th class='action'>Actions</th>
            </tr>
            <?php foreach ($educations as $education): ?>
                <tr>
                    <td><?= htmlspecialchars($education['degree']) ?></td>
                    <td><?= htmlspecialchars($education['institute']) ?></td>
                    <td><?= htmlspecialchars($education['education_year']) ?></td>
                    <td><?= htmlspecialchars($education['marks']) ?></td>
                    <td>
                        <form action="add-education.php" method="POST" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?= $education['id'] ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No education records found.</p>
    <?php endif; ?>

    <!-- Add New Education Form -->
    <form action="add-education.php" method="POST">
        <label for="degree">Degree:</label>
        <input type="text" id="degree" name="degree" placeholder="e.g., Bachelor of IT" required>
        
        <label for="institute">Institute:</label>
        <input type="text" id="institute" name="institute" placeholder="e.g., KFUEIT" required>
        
        <label for="education-year">Year:</label>
        <input type="text" id="education-year" name="education-year" placeholder="e.g., 2020 - 2024">

        <label for="marks">Marks (CGPA or %):</label>
        <input type="text" id="marks" name="marks" placeholder="e.g., 3.5 / 4.0 CGPA or 85% Marks" required>

        <button type="submit">Add Education</button>
    </form>
</div>

</body>
</html>
