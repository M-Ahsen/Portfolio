<?php require("includes/config.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Homepage - Online CV Builder</title>
    <link rel="stylesheet" href="CSS/homepage.css">
    <?php require('includes/head.php'); ?>
</head>

<body>
    <div id="header">
        <nav>
            <h1>Online CV Builder</h1>
            <ul>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign Up</a></li>
                <li><a href="#features">Features</a></li>
            </ul>
        </nav>
    </div>


    <section class="main">
        <h2>Create Your Professional CV Effortlessly</h2>
        <p>
            Build, customize, and share your CV with ease using our online CV builder. Choose from professional
            templates and share your resume securely with a unique link.
        </p>
        <div>
            <a href="signup.php" class="btn">Get Started</a>
        </div>
    </section>

    <section id="features">
        <h2>Our Key Features</h2>
        <div class="feature-item">
            <h4>Easy CV Builder</h4>
            <p>Simple, form-based CV creation with sections for work experience, education, skills, and more.</p>
        </div>
        <div class="feature-item">
            <h4>Professional Templates</h4>
            <p>Choose from a range of stylish and modern templates to make your CV stand out.</p>
        </div>
        <div class="feature-item">
            <h4>Unique "Ceiling" Sharing</h4>
            <p>Share your CV securely with a unique link or QR code. Control who can view your information.</p>
        </div>
        <div class="feature-item">
            <h4>PDF Download</h4>
            <p>Download your CV in PDF format for easy sharing and printing.</p>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Online CV Builder. All rights reserved.</p>
        <ul>
            <li><a href="#privacy">Privacy Policy</a></li>
            <li><a href="#terms">Terms of Service</a></li>
            <li><a href="contact.php" target="_blank">Contact Us</a></li>
        </ul>
    </footer>
    <?php $conn->close(); ?>
</body>

</html>