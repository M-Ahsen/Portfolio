<?php
require("includes/config.php");
session_start();

if (isset($_GET['user_id']) && isset($_GET['project_id'])) {
    $user_id = intval($_GET['user_id']);
    $project_id = intval($_GET['project_id']);
    
    // Using prepared statements to prevent SQL injection
    $sql = "SELECT * FROM portfolio_projects WHERE user_id = ? AND id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $project_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $project = $result->fetch_assoc();
        $projectName = htmlspecialchars($project['project_name']);
        $projectDescription = htmlspecialchars($project['project_long_description']);
        $desktopImagePaths = unserialize($project['desktop_images_paths']);
        $mobileImagePaths = unserialize($project['mobile_images_paths']);
        $projectLink = !empty($project['project_link']) ? htmlspecialchars($project['project_link']) : null;
    } else {
        // Redirect or display an error page
        header("Location: error.php?msg=Project not found");
        exit();
    }

    $stmt->close();
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $projectName; ?> - Project</title>
    <link rel="stylesheet" href="css/project.css">
    <?php require('includes/head.php'); ?>
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

            <?php if (!empty($mobileImagePaths) && array_filter($mobileImagePaths, 'file_exists')): ?>
                <h3>Mobile-View</h3>
                <div class="gallery-container">
                    <button class="nav-btn left-btn" id="mobilePrevButton" disabled>&lt;</button>
                    <div class="gallery mobile-gallery">
                        <?php foreach ($mobileImagePaths as $path): ?>
                            <?php if (file_exists($path)): ?>
                                <img src="<?php echo $path; ?>" alt="Mobile Screenshot" width="200px">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <button class="nav-btn right-btn" id="mobileNextButton">&gt;</button>
                </div>
            <?php endif; ?>

            <?php if (!empty($desktopImagePaths) && array_filter($desktopImagePaths, 'file_exists')): ?>
                <h3>Desktop-View</h3>
                <div class="gallery-container">
                    <button class="nav-btn left-btn" id="desktopPrevButton" disabled>&lt;</button>
                    <div class="gallery desktop-gallery">
                        <?php foreach ($desktopImagePaths as $path): ?>
                            <?php if (file_exists($path)): ?>
                                <img src="<?php echo $path; ?>" alt="Desktop Screenshot" width="800px">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <button class="nav-btn right-btn" id="desktopNextButton">&gt;</button>
                </div>
            <?php endif; ?>
        </section>

        <?php if (!empty($projectLink)): ?>
        <section class="project-link">
            <h2>Project Link</h2>
            <a href="<?php echo $projectLink; ?>" target="_blank"><?php echo $projectLink; ?></a>
        </section>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
    const setupGallery = (gallerySelector, prevButtonId, nextButtonId, imgWidth) => {
        const gallery = document.querySelector(gallerySelector);
        const prevButton = document.getElementById(prevButtonId);
        const nextButton = document.getElementById(nextButtonId);

        if (!gallery || !prevButton || !nextButton) return; // Prevent errors if elements don't exist

        // Ensure gallery has smooth scrolling
        gallery.style.overflowX = "auto"; // Changed from "scroll" to "auto"
        gallery.style.scrollBehavior = "smooth";
        gallery.style.display = "flex";
        gallery.style.scrollSnapType = "x mandatory"; // Helps with smooth scrolling

        const updateButtons = () => {
            prevButton.disabled = gallery.scrollLeft <= 0;
            nextButton.disabled = gallery.scrollLeft + gallery.clientWidth > gallery.scrollWidth - 5;
        };

        nextButton.addEventListener("click", () => {
            gallery.scrollBy({ left: imgWidth, behavior: "smooth" });
            setTimeout(updateButtons, 300); // Reduced timeout for smoother experience
        });

        prevButton.addEventListener("click", () => {
            gallery.scrollBy({ left: -imgWidth, behavior: "smooth" });
            setTimeout(updateButtons, 300);
        });

        // Update buttons on manual scroll
        gallery.addEventListener("scroll", updateButtons);

        updateButtons(); // Initial button state update
    };

    // Setup galleries only if they exist
    if (document.querySelector(".desktop-gallery")) {
        setupGallery(".desktop-gallery", "desktopPrevButton", "desktopNextButton", 400);
    }

    if (document.querySelector(".mobile-gallery")) {
        setupGallery(".mobile-gallery", "mobilePrevButton", "mobileNextButton", 200);
    }
});

    </script>
</body>
</html>

<?php
}
?>
