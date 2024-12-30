<?php
require("../includes/config.php");
session_start();
if (isset($_GET['user_id']) && isset($_GET['project_id'])) {
    $user_id = intval($_GET['user_id']);
    $project_id = intval($_GET['project_id']);
    $sql = "SELECT * FROM portfolio_projects WHERE user_id = $user_id AND id = $project_id ";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $project = $result->fetch_assoc();
        $projectName = $project['project_name'];
        $projectDescription = $project['project_long_description'];
        $desktopImagePaths = unserialize($project['desktop_images_paths']); 
        $mobileImagePaths = unserialize($project['mobile_images_paths']);  

        $projectLink = $project['project_link'];
    } else {
        die("No projects found or query error: " . $conn->error);
    }


    $conn->close();
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title><?php echo $projectName; ?> - project</title>
        <link rel="stylesheet" href="../CSS/project.css">
        <?php require('../includes/head.php'); ?>
    </head>

    <body>
        <div class="project-container">
            <h1 class="project-title"><?php echo $projectName; ?></h1>

            <section class="project-detail">
                <h2>Project Overview</h2>
                <p>
                    <?php echo nl2br($projectDescription); ?>
                </p>
            </section>



            <section class="project-gallery">
                <h2>Project Screenshots</h2>

                <!-- Desktop-View Screenshots -->
                <h3>Desktop-View</h3>
                <div class="gallery-container">
                    <button class="nav-btn left-btn" id="desktopPrevButton" disabled>&lt;</button>
                    <div class="gallery desktop-gallery">
                        <?php foreach ($desktopImagePaths as $path): ?>
                            <img src="<?php echo $path; ?>" alt="Desktop Screenshot" width="800px">
                        <?php endforeach; ?>
                    </div>
                    <button class="nav-btn right-btn" id="desktopNextButton">&gt;</button>
                </div>

                <!-- Mobile-View Screenshots -->
                <h3>Mobile-View</h3>
                <div class="gallery-container">
                    <button class="nav-btn left-btn" id="mobilePrevButton" disabled>&lt;</button>
                    <div class="gallery mobile-gallery">
                        <?php foreach ($mobileImagePaths as $path): ?>
                            <img src="<?php echo $path; ?>" alt="Mobile Screenshot" width="200px">
                        <?php endforeach; ?>
                    </div>
                    <button class="nav-btn right-btn" id="mobileNextButton">&gt;</button>
                </div>
            </section>

            <section class="project-link">
                <h2>Project Link</h2>
                <a href="<?php echo $projectLink; ?>"
                    target="_blank"><?php echo $projectLink; ?></a>
            </section>
        </div>

        <script src="../JS/script.js"></script>
    </body>

    </html>
    <?php
}
?>