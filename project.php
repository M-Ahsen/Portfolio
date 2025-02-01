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
        $projectLink = htmlspecialchars($project['project_link']);
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
    <link rel="stylesheet" href="CSS/project.css">
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

            <!-- Desktop-View Screenshots -->
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

            <!-- Mobile-View Screenshots -->
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
        </section>

        <section class="project-link">
            <h2>Project Link</h2>
            <a href="<?php echo $projectLink; ?>" target="_blank"><?php echo $projectLink; ?></a>
        </section>
    </div>

    <script src="JS/script.js"></script>
    <script>
        // JavaScript to handle the navigation between the desktop and mobile galleries
        let desktopIndex = 0;
        let mobileIndex = 0;

        const desktopImages = document.querySelectorAll('.desktop-gallery img');
        const mobileImages = document.querySelectorAll('.mobile-gallery img');

        const desktopPrevButton = document.getElementById('desktopPrevButton');
        const desktopNextButton = document.getElementById('desktopNextButton');
        const mobilePrevButton = document.getElementById('mobilePrevButton');
        const mobileNextButton = document.getElementById('mobileNextButton');

        // Update gallery view based on index
        function updateGallery() {
            desktopPrevButton.disabled = desktopIndex === 0;
            desktopNextButton.disabled = desktopIndex === desktopImages.length - 1;
            mobilePrevButton.disabled = mobileIndex === 0;
            mobileNextButton.disabled = mobileIndex === mobileImages.length - 1;
        }

        desktopPrevButton.addEventListener('click', () => {
            if (desktopIndex > 0) {
                desktopIndex--;
                desktopImages[desktopIndex].scrollIntoView({ behavior: 'smooth' });
                updateGallery();
            }
        });

        desktopNextButton.addEventListener('click', () => {
            if (desktopIndex < desktopImages.length - 1) {
                desktopIndex++;
                desktopImages[desktopIndex].scrollIntoView({ behavior: 'smooth' });
                updateGallery();
            }
        });

        mobilePrevButton.addEventListener('click', () => {
            if (mobileIndex > 0) {
                mobileIndex--;
                mobileImages[mobileIndex].scrollIntoView({ behavior: 'smooth' });
                updateGallery();
            }
        });

        mobileNextButton.addEventListener('click', () => {
            if (mobileIndex < mobileImages.length - 1) {
                mobileIndex++;
                mobileImages[mobileIndex].scrollIntoView({ behavior: 'smooth' });
                updateGallery();
            }
        });

        // Initialize gallery state
        updateGallery();
    </script>
</body>

</html>

<?php
}
?>
