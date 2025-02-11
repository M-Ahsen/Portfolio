<?php
require("includes/config.php");
session_start();

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']); // Ensures user_id is an integer

    // Fetch Personal Info
    $sqlHome = "SELECT * FROM personal_info WHERE user_id = ? LIMIT 1";
    $stmtHome = $conn->prepare($sqlHome);
    $stmtHome->bind_param('i', $user_id);
    $stmtHome->execute();
    $resultHome = $stmtHome->get_result();
    $homeData = $resultHome ? $resultHome->fetch_assoc() : [];

    // Fetch About Section
    $sqlAbout = "SELECT * FROM about WHERE user_id = ? LIMIT 1";
    $stmtAbout = $conn->prepare($sqlAbout);
    $stmtAbout->bind_param('i', $user_id);
    $stmtAbout->execute();
    $resultAbout = $stmtAbout->get_result();
    $aboutData = $resultAbout ? $resultAbout->fetch_assoc() : [];

    // Fetch Education
    $sqlEducation = "SELECT * FROM education WHERE user_id = ? ORDER BY education_year DESC";
    $stmtEducation = $conn->prepare($sqlEducation);
    $stmtEducation->bind_param('i', $user_id);
    $stmtEducation->execute();
    $resultEducation = $stmtEducation->get_result();

    // Fetch Work Experience
    $sqlExperience = "SELECT * FROM work_experience WHERE user_id = ? ORDER BY employment_dates DESC";
    $stmtExperience = $conn->prepare($sqlExperience);
    $stmtExperience->bind_param('i', $user_id);
    $stmtExperience->execute();
    $resultExperience = $stmtExperience->get_result();

    // Fetch Portfolio Projects
    $sqlProjects = "SELECT * FROM portfolio_projects WHERE user_id = ?";
    $stmtProjects = $conn->prepare($sqlProjects);
    $stmtProjects->bind_param('i', $user_id);
    $stmtProjects->execute();
    $resultProjects = $stmtProjects->get_result();

    // Fetch Contact Info
    $sqlContact = "SELECT * FROM contact_info WHERE user_id = ? LIMIT 1";
    $stmtContact = $conn->prepare($sqlContact);
    $stmtContact->bind_param('i', $user_id);
    $stmtContact->execute();
    $resultContact = $stmtContact->get_result();
    $contactData = $resultContact ? $resultContact->fetch_assoc() : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= htmlspecialchars($homeData['full_name'] ?? 'Ahsen Portfolio') ?></title>
    <meta charset="utf-16">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Add your custom CSS here */
    </style>
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar ftco-navbar-light site-navbar-target" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.html"><?= htmlspecialchars($homeData['full_name'] ?? 'Ahsen') ?></a>
            <button class="navbar-toggler js-fh5co-nav-toggle fh5co-nav-toggle" type="button" data-toggle="collapse"
                data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav nav ml-auto">
                    <li class="nav-item"><a href="#home-section" class="nav-link"><span>Home</span></a></li>
                    <li class="nav-item"><a href="#about-section" class="nav-link"><span>About</span></a></li>
                    <li class="nav-item"><a href="#resume-section" class="nav-link"><span>Resume</span></a></li>
                    <li class="nav-item"><a href="#project-section" class="nav-link"><span>Portfolio</span></a></li>
                    <li class="nav-item"><a href="#contact-section" class="nav-link"><span>Contact</span></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Home Section -->
    <section id="home-section" class="hero">
        <div class="home-slider owl-carousel">
            <div class="slider-item">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row d-md-flex no-gutters slider-text align-items-end justify-content-end"
                        data-scrollax-parent="true">
                        <div class="one-third js-fullheight order-md-last img" style="background-image:url();">
                            <div class="overlay"></div>
                        </div>
                        <div class="one-forth d-flex align-items-center ftco-animate"
                            data-scrollax=" properties: { translateY: '70%' }">
                            <div class="text">
                                <span class="subheading">Hello!</span>
                                <h1 class="mb-4 mt-3">I'm <span><?= htmlspecialchars($homeData['full_name'] ?? 'Ahsen') ?></span></h1>
                                <span id="typing-animation"></span>
                                <script>
                                    const typingAnimationElement = document.getElementById('typing-animation');
                                    const typingTexts = [
                                        '<?= htmlspecialchars($homeData['profession'] ?? 'Web Developer') ?>',
                                        'React Developer',
                                        'PHP Developer',
                                    ];
                                    function playTypingAnimation(text) {
                                        for (let i = 0; i < text.length; i++) {
                                            setTimeout(() => {
                                                typingAnimationElement.textContent += text[i];
                                            }, i * 200);
                                        }
                                        setTimeout(() => {
                                            typingAnimationElement.textContent = '';
                                            playTypingAnimation(typingTexts[(typingTexts.indexOf(text) + 1) % typingTexts.length]);
                                        }, text.length * 200);
                                    }
                                    playTypingAnimation(typingTexts[0]);
                                </script>
                                <br><br>
                                <h2>Web Developer</h2>
                                <p>
                                    <a href="<?= htmlspecialchars($homeData['linkedin'] ?? '#') ?>" target="_blank" class="btn btn-primary py-3 px-4">LinkedIn</a>
                                    <a href="<?= htmlspecialchars($homeData['resumePath'] ?? '#') ?>" target="_blank" class="btn btn-white btn-outline-white py-3 px-4">My Resume</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="ftco-section ftco-no-pb" id="about-section">
        <div class="container about-mf">
            <h2 style="text-align: center;"><b>About Me</b></h2>
            <div class="row justify-content-center box-shadow-full">
                <?php if (!empty($aboutData['about_photo_path'])): ?>
                    <div class="about-img">
                        <img src="<?= htmlspecialchars($aboutData['about_photo_path']) ?>" class="img-fluid rounded b-shadow-a" alt="profile-pic">
                    </div>
                <?php endif; ?>
                <div class="col-md-6 col-lg-7 pl-lg-5 pb-5" style="text-align: justify; line-height: 42px;">
                    <p><?= htmlspecialchars($aboutData['about_text'] ?? 'No details available.') ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Resume Section -->
    <section class="ftco-section ftco-no-pb" id="resume-section">
        <div class="container">
            <div class="row justify-content-center pb-5">
                <div class="col-md-10 heading-section text-center ftco-animate" style="text-align: justify;">
                    <h2 class="mb-4">Resume</h2>
                    <p style="line-height: 42px;">
                        <?= htmlspecialchars($aboutData['resume_summary'] ?? 'No summary available.') ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <h1 class="big-4">Experience</h1>
                <div class="underline"></div>
            </div>
            <br>
            <div class="row" style="text-align: justify;">
                <?php while ($experience = $resultExperience->fetch_assoc()): ?>
                    <div class="col-md-6 mx-auto">
                        <div class="resume-wrap ftco-animate">
                            <span class="date"><?= htmlspecialchars($experience['employment_dates']) ?></span>
                            <h2><?= htmlspecialchars($experience['job_title']) ?></h2>
                            <span class="position"><?= htmlspecialchars($experience['company_name']) ?></span>
                            <p class="mt-4"><?= htmlspecialchars($experience['job_description']) ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <br><br>
            <div class="row">
                <h1 class="big-4">Education</h1>
                <div class="underline"></div>
            </div>
            <br>
            <div class="row">
                <?php while ($education = $resultEducation->fetch_assoc()): ?>
                    <div class="col-md-6">
                        <div class="resume-wrap ftco-animate">
                            <span class="date"><?= htmlspecialchars($education['education_year']) ?></span>
                            <h2><?= htmlspecialchars($education['degree']) ?></h2>
                            <span class="position"><?= htmlspecialchars($education['institute']) ?></span>
                            <p class="mt-4">GPA: <?= htmlspecialchars($education['gpa'] ?? 'N/A') ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section class="ftco-section" id="project-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-5">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <h1 class="big-4">Portfolio</h1>
                    <div class="underline"></div>
                    <p>Below are the web projects</p>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <?php while ($project = $resultProjects->fetch_assoc()): ?>
                    <div class="col-md-4 d-flex ftco-animate">
                        <div class="blog-entry justify-content-end">
                            <a target="_blank" href="Projects/project1.html" class="block-20 zoom-effect"
                                style="background-image: url('<?= htmlspecialchars($project['project_images_path']) ?>'); width: 340px; height: 280px; background-size: cover; background-position: center;">
                            </a>
                            <div class="text mt-3 float-right d-block">
                                <h3 class="heading"><a target="_blank" href="Projects/project1.html"><?= htmlspecialchars($project['project_name']) ?></a></h3>
                                <p><?= htmlspecialchars($project['project_short_description']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="ftco-section contact-section ftco-no-pb" id="contact-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <h2 class="mb-4">Contact Me</h2>
                    <p>Below are the details to reach out to me!</p>
                </div>
            </div>
            <div class="row d-flex contact-info mb-5">
                <div class="col-md-6 col-lg-3 d-flex ftco-animate">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="icon-map-signs"></span>
                        </div>
                        <h3 class="mb-4">Address</h3>
                        <p style="color: #ffffff;"><?= htmlspecialchars($contactData['contact_address'] ?? 'Not provided') ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex ftco-animate">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="icon-phone2"></span>
                        </div>
                        <h3 class="mb-4"><a href="tel:<?= htmlspecialchars($contactData['contact_phone'] ?? '#') ?>">Contact Number</a></h3>
                        <p><a href="tel:<?= htmlspecialchars($contactData['contact_phone'] ?? '#') ?>"><?= htmlspecialchars($contactData['contact_phone'] ?? 'Not provided') ?></a></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex ftco-animate">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="icon-paper-plane"></span>
                        </div>
                        <h3 class="mb-4"><a href="mailto:<?= htmlspecialchars($contactData['contact_email'] ?? '#') ?>">Email Address</a></h3>
                        <p><a href="mailto:<?= htmlspecialchars($contactData['contact_email'] ?? '#') ?>"><?= htmlspecialchars($contactData['contact_email'] ?? 'Not provided') ?></a></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex ftco-animate">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="icon-globe"></span>
                        </div>
                        <h3 class="mb-4"><a href="<?= htmlspecialchars($homeData['resumePath'] ?? '#') ?>">Download Resume</a></h3>
                        <p><a href="<?= htmlspecialchars($homeData['resumePath'] ?? '#') ?>">resumelink</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="ftco-footer ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>
                        Copyright &copy;
                        <script>document.write(new Date().getFullYear());</script> All rights reserved | This template
                        is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a
                            href="https://colorlib.com" target="_blank">Ahsen</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>

<?php
    // Close database connection
    $stmtHome->close();
    $stmtAbout->close();
    $stmtEducation->close();
    $stmtExperience->close();
    $stmtProjects->close();
    $stmtContact->close();
    $conn->close();
}
?>