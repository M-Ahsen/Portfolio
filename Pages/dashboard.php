<?php require("../includes/config.php");
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === 'T') {
    $user_id = $_SESSION['user_id'];
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <link rel="stylesheet" href="../CSS/dashboard.css">
        <title>Dashboard - Portfolio Builder</title>
        <?php require('../includes/head.php'); ?>
    </head>

    <body>

        <main class="main-content">
            <header class="top-bar">
                <div class="welcome">Welcome, <?php echo $_SESSION['user_name'] ?? "Your Name"; ?>!</div>
                <div class="user-options">
                    <a href="#profile">Profile</a>
                    <a href="#notifications">Notifications</a>
                    &nbsp;&nbsp;&nbsp;<a href="../includes/logout.php">Log out</a>
                </div>
            </header>


            <section id="create-cv" class="content-section">
                <h2>Create CV</h2>
                <p>Start building a new CV with our templates and easy-to-use tools.</p>
                <p class="btn"><a href="add-personal-info.php">Personal Info</a></p>
                <p class="btn"><a href="add-projects.php">Add Projects</a></p>
            </section>

            <section id="my-cvs" class="content-section">
                <h2>Portfolio Link</h2>
                <div>
                    <p>http://localhost/OnlinePortfolioWebsite/pages/portfolio.php?user_id=<?php echo $user_id ?>
                    </p>
                </div>
                <p class="btn"><a
                        href="http://localhost/OnlinePortfolioWebsite/pages/portfolio.php?user_id=<?php echo $user_id ?>">Open</a>
                </p>
            </section>
        </main>
        <?php $conn->close(); ?>
    </body>

    </html>
    <?php
} else {
    header('location: login.php');
}
?>