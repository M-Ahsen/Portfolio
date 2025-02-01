<?php
require("includes/config.php");
session_start();
$formSubmitted = false;

if (!isset($_SESSION['user_id'])) {
    echo "Login Issue.";
    exit();
}

$user_id = $_SESSION['user_id'];
$userDir = rtrim($_SESSION['user_dir'], '/') . '/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectName = htmlspecialchars($_POST['project-name']);
    $projectShortDescription = htmlspecialchars($_POST['project-short-description']);
    $projectLongDescription = htmlspecialchars($_POST['project-long-description']);
    $projectLink = filter_var($_POST['project-link'], FILTER_SANITIZE_URL);

    if (empty($projectName) || empty($projectShortDescription) || empty($projectLongDescription)) {
        echo "Please fill in all required fields.";
        exit();
    }

    $projectFolder = $userDir . preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower($projectName)) . "_" . time() . "/";
    
    if (!mkdir($projectFolder, 0777, true)) {
        echo "Failed to create project folder.";
        exit();
    }

    $desktopFolder = $projectFolder . "desktop/";
    $mobileFolder = $projectFolder . "mobile/";
    mkdir($desktopFolder, 0777);
    mkdir($mobileFolder, 0777);

    $projectImagePath = "";
    if (!empty($_FILES['project-image']['name'])) {
        $projectImage = basename($_FILES['project-image']['name']);
        $projectImagePath = $projectFolder . $projectImage;
        move_uploaded_file($_FILES['project-image']['tmp_name'], $projectImagePath);
    }

    $desktopScreenshots = [];
    $desktopImagePaths = [];
    if (!empty($_FILES['dv-project-ss']['name'][0])) {
        foreach ($_FILES['dv-project-ss']['name'] as $key => $name) {
            $safeName = basename($name);
            $desktopImagePath = $desktopFolder . $safeName;
            $desktopScreenshots[] = $safeName;
            $desktopImagePaths[] = $desktopImagePath;
            move_uploaded_file($_FILES['dv-project-ss']['tmp_name'][$key], $desktopImagePath);
        }
    }

    $mobileScreenshots = [];
    $mobileImagePaths = [];
    if (!empty($_FILES['mv-project-ss']['name'][0])) {
        foreach ($_FILES['mv-project-ss']['name'] as $key => $name) {
            $safeName = basename($name);
            $mobileImagePath = $mobileFolder . $safeName;
            $mobileScreenshots[] = $safeName;
            $mobileImagePaths[] = $mobileImagePath;
            move_uploaded_file($_FILES['mv-project-ss']['tmp_name'][$key], $mobileImagePath);
        }
    }

    $stmt = $conn->prepare("INSERT INTO portfolio_projects 
        (project_name, project_image, project_short_description, 
        project_desktop_screenshots, project_mobile_screenshots, project_long_description, 
        project_link, desktop_images_paths, mobile_images_paths, project_images_path, user_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        'ssssssssssi',
        $projectName,
        $projectImage,
        $projectShortDescription,
        serialize($desktopScreenshots),
        serialize($mobileScreenshots),
        $projectLongDescription,
        $projectLink,
        serialize($desktopImagePaths),
        serialize($mobileImagePaths),
        serialize([$projectImagePath]),
        $user_id
    );

    if ($stmt->execute()) {
        $formSubmitted = true;
        header("Location: dashboard.php"); 
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Portfolio Project</title>
    <link rel="stylesheet" href="CSS/cv-builder.css">
    <?php require('includes/head.php'); ?>
</head>

<body>
    <div class="cv-builder-container">
        <h1>Add Portfolio Projects</h1>

        <?php if ($formSubmitted): ?>
            <p>Your project has been successfully added to your portfolio!</p>
        <?php endif; ?>

        <form action="#" method="POST" class="cv-form" enctype="multipart/form-data">
            <section>
                <h2>Portfolio Projects</h2>
                <label for="project-name">Project Name:</label>
                <input type="text" id="project-name" name="project-name" placeholder="Project Name" required>

                <label for="project-image">Upload Project Title Image:</label>
                <input type="file" id="project-image" name="project-image" accept="image/*">

                <label for="project-short-description">Project Small Description:</label>
                <textarea id="project-short-description" name="project-short-description" rows="2"
                    placeholder="Shortly Describe this project" required></textarea>

                <label for="dv-project-ss">Upload Project Desktop-View ScreenShots:</label>
                <input type="file" id="dv-project-ss" name="dv-project-ss[]" accept="image/*" multiple>

                <label for="mv-project-ss">Upload Project Mobile-View ScreenShots:</label>
                <input type="file" id="mv-project-ss" name="mv-project-ss[]" accept="image/*" multiple>

                <label for="project-long-description">Project Long Description:</label>
                <textarea id="project-long-description" name="project-long-description" rows="5"
                    placeholder="Detailed Description" required></textarea>

                <label for="project-link">Project Link:</label>
                <input type="url" id="project-link" name="project-link" placeholder="https://projectlink.com">
            </section>

            <button type="submit" class="submit-btn">Create Portfolio</button>
        </form>
    </div>
</body>

</html>