<?php
require("includes/config.php");
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? "User";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard - Portfolio Builder</title>
    <link rel="stylesheet" href="CSS/dashboard.css">
    <?php require('includes/head.php'); ?>
</head>

<body>

    <main class="main-content">
        <header class="top-bar">
            <div class="welcome">Welcome, <?php echo htmlspecialchars($user_name); ?>!</div>
            <div class="user-options">
                <a href="#profile">Profile</a>
                <a href="#notifications">Notifications</a>
                <a href="includes/logout.php">Log out</a>
            </div>
        </header>

        <section id="create-cv" class="content-section">
            <h2>Create CV</h2>
            <p>Start building a new CV with our templates and easy-to-use tools.</p>
            <p class="btn"><a href="add-personal_info.php">Personal Info</a></p>
            <p class="btn"><a href="add-about.php">About Me</a></p>
            <p class="btn"><a href="add-education.php">Education</a></p>
            <p class="btn"><a href="add-work_experience.php">Work Experience</a></p>
            <p class="btn"><a href="add-contact_info.php">Contact Information</a></p>
            <p class="btn"><a href="add-projects.php">Add Projects</a></p>
        </section>

        <section id="my-cvs" class="content-section">
            <h2>Portfolio Link</h2>
            <div>
                <p>
                    <a href="http://localhost/OnlinePortfolioWebsite/portfolio.php?user_id=<?php echo urlencode($user_id); ?>">
                        http://localhost/OnlinePortfolioWebsite/portfolio.php?user_id=<?php echo htmlspecialchars($user_id); ?>
                    </a>
                </p>
            </div>
            <p class="btn">
                <a href="http://localhost/OnlinePortfolioWebsite/portfolio.php?user_id=<?php echo urlencode($user_id); ?>">Open</a>
            </p>
        </section>
    </main>

    <?php $conn->close(); ?>
</body>

</html>
