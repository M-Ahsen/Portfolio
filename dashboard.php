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
    <link rel="stylesheet" href="css/dashboard.css">
    <?php require('includes/head.php'); ?>
</head>

<body>

    <main class="main-content">
        <header class="top-bar">
            <div class="welcome">Welcome, <?php echo htmlspecialchars($user_name); ?>!</div>
            <div class="user-options">
                <a href="edit-profile.php?id=<?= $_SESSION['user_id'] ?>">Edit Profile</a>
                <a href="#notifications">Notifications</a>
                <a href="includes/logout.php">Log out</a>
            </div>
        </header>

        <section id="create-cv" class="content-section">
            <h2>Create CV</h2>
            <p>Start building a new CV with our templates and easy-to-use tools.</p>
            <p class="btn"><a href="profile_setup.php">Personal Info</a></p>
            <p class="btn"><a href="add-education.php">Education</a></p>
            <p class="btn"><a href="add-work_experience.php">Work Experience</a></p>
            <p class="btn"><a href="add-projects.php">Projects</a></p>
        </section>

        <section id="my-cvs" class="content-section">
            <h2>Portfolio</h2>
            <div>
                <p class="btn">
                    <a href="portfolio.php?user_id=<?php echo urlencode($user_id); ?>">Open</a>
                </p>
                <button id="copy-btn" class="btn" onclick="copyPortfolioLink()">Copy Portfolio Link</button>
            </div>
        </section>
    </main>

    <?php $conn->close(); ?>


    <script>
        function copyPortfolioLink() {
    var portfolioLink = "<?php echo 'portfolio.php?user_id=' . urlencode($user_id); ?>";
    
    navigator.clipboard.writeText(portfolioLink).then(function() {
        showMessage("Portfolio link copied to clipboard!");
    }, function(err) {
        showMessage("Failed to copy: " + err);
    });
}

function showMessage(message) {
    let messageDiv = document.createElement('div');
    messageDiv.innerText = message;
    messageDiv.style.position = 'fixed';
    messageDiv.style.top = '10px';
    messageDiv.style.left = '50%';
    messageDiv.style.transform = 'translateX(-50%)';
    messageDiv.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
    messageDiv.style.color = 'white';
    messageDiv.style.padding = '10px';
    messageDiv.style.borderRadius = '5px';
    document.body.appendChild(messageDiv);

    // Optional: Auto-remove the message after a few seconds
    setTimeout(() => {
        messageDiv.remove();
    }, 3000); // 3 seconds
}

    </script>
</body>

</html>
