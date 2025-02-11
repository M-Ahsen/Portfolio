

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Portfolio</title>
    <link rel="stylesheet" href="css/portfolio.css">
    <?php require('includes/head.php'); ?>
</head>

<body>

    <nav class="navbar">
        <a href="index.html" class="brand-name"><?= htmlspecialchars($homeData['full_name'] ?? 'Your Name') ?></a>
        <ul class="nav-links">
            <li><a href="#home-section">Home</a></li>
            <li><a href="#about-section">About</a></li>
            <li><a href="#resume-section">Resume</a></li>
            <li><a href="#portfolio-section">Portfolio</a></li>
            <li><a href="#contact-section">Contact</a></li>
        </ul>
    </nav>

    <hr>

    <!-- Home Section -->
    <section id="home-section" class="home-section">
        <h1 class="intro-heading">Hello! I'm <?= htmlspecialchars($homeData['full_name'] ?? 'Your Name') ?></h1>
        <h2 class="sub-heading"><?= htmlspecialchars($homeData['profession'] ?? 'Your Profession') ?></h2>
        <p class="social-links">
            <a href="<?= htmlspecialchars($homeData['linkedin'] ?? '#') ?>" target="_blank">LinkedIn</a><br>
            <a href="<?= htmlspecialchars($homeData['github'] ?? '#') ?>" target="_blank">GitHub</a><br>
            <?php if (!empty($homeData['resumePath'])): ?>
                <a href="<?= htmlspecialchars($homeData['resumePath']) ?>" target="_blank">My Resume</a>
            <?php endif; ?>
        </p>
    </section>

    <hr>

    <!-- About Section -->
    <section id="about-section" class="about-section">
        <h2 class="section-heading">About Me</h2>
        <?php if (!empty($aboutData['about_photo_path'])): ?>
            <img src="<?= htmlspecialchars($aboutData['about_photo_path']) ?>" alt="profile-picture" width="20%" class="profile-picture">
        <?php endif; ?>
        <p class="about-description"><?= htmlspecialchars($aboutData['about_text'] ?? 'No details available.') ?></p>
    </section>

    <hr>

    <!-- Resume Section -->
    <section id="resume-section" class="resume-section">
        <h2 class="section-heading">Resume</h2>

        <h3 class="experience-heading">Experience</h3>
        <?php while ($experience = $resultExperience->fetch_assoc()): ?>
            <div class="job">
                <p class="job-date"><?= htmlspecialchars($experience['employment_dates']) ?></p>
                <h4 class="job-title"><?= htmlspecialchars($experience['job_title']) ?></h4>
                <p class="company"><?= htmlspecialchars($experience['company_name']) ?></p>
                <p class="job-description"><?= htmlspecialchars($experience['job_description']) ?></p>
            </div>
        <?php endwhile; ?>

        <h3 class="education-heading">Education</h3>
        <?php while ($education = $resultEducation->fetch_assoc()): ?>
            <div class="education">
                <p class="education-date"><?= htmlspecialchars($education['education_year']) ?></p>
                <h4 class="degree"><?= htmlspecialchars($education['degree']) ?></h4>
                <p class="institution"><?= htmlspecialchars($education['institute']) ?></p>
            </div>
        <?php endwhile; ?>
    </section>

    <hr>

    <!-- Portfolio Section -->
    <section id="portfolio-section" class="portfolio-section">
        <h1 class="section-heading">Portfolio</h1>
        <p class="portfolio-description">A showcase of my recent projects.</p>

        <?php while ($project = $resultProjects->fetch_assoc()): ?>
            <?php
            $project_id = $project['id'];
            $title = htmlspecialchars($project['project_name'] ?? 'Untitled Project');
            $projectImagePaths = unserialize($project['project_images_path'] ?? 'default-thumbnail.jpg');
            $imagePath = htmlspecialchars($projectImagePaths[0] ?? '');
            $description = htmlspecialchars($project['project_short_description'] ?? 'No description available.');
            ?>
            <div class="project">
                <h3 class="project-title"><?= $title ?></h3>
                <a href="project.php?user_id=<?= $user_id ?>&project_id=<?= $project_id ?>" target="_blank">
                    <img src="<?= $imagePath ?>" alt="<?= $title ?>-thumbnail" class="project-thumbnail" width="40%">
                </a>
                <p class="project-description"><?= $description ?></p>
            </div>
        <?php endwhile; ?>
    </section>

    <hr>

    <!-- Contact Section -->
    <section id="contact-section" class="contact-section">
        <h2 class="section-heading">Contact Me</h2>
        <div class="contact-details">
            <h3>Address</h3>
            <p><?= htmlspecialchars($contactData['contact_address'] ?? 'Not provided') ?></p>

            <h3>Contact Number</h3>
            <p><a href="tel:<?= htmlspecialchars($contactData['contact_phone'] ?? '#') ?>"><?= htmlspecialchars($contactData['contact_phone'] ?? 'Not provided') ?></a></p>

            <h3>Email Address</h3>
            <p><a href="mailto:<?= htmlspecialchars($contactData['contact_email'] ?? '#') ?>"><?= htmlspecialchars($contactData['contact_email'] ?? 'Not provided') ?></a></p>
        </div>
    </section>

    <hr>
    <p class="footer">&copy; 2024 <?= htmlspecialchars($homeData['full_name'] ?? 'Your Name') ?></p>

    <?php
    // Close database connection
    $stmtHome->close();
    $stmtAbout->close();
    $stmtEducation->close();
    $stmtExperience->close();
    $stmtProjects->close();
    $stmtContact->close();
    $conn->close();
    ?>

</body>
</html>


