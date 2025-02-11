<?php
require("includes/config.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Login Issue.";
    exit();
}

$user_id = $_SESSION['user_id'];
$userDir = rtrim($_SESSION['user_dir'], '/') . '/';
$formSubmitted = false;

// Function to delete files
function deleteFiles($files) {
    if (!empty($files)) {
        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file); // Delete file
            }
        }
    }
}

// Function to delete folder recursively
function deleteFolder($folder) {
    if (is_dir($folder)) {
        $files = array_diff(scandir($folder), ['.', '..']);
        foreach ($files as $file) {
            $path = $folder . DIRECTORY_SEPARATOR . $file;
            is_dir($path) ? deleteFolder($path) : unlink($path);
        }
        rmdir($folder); // Remove the directory itself
    }
}

// Handle project deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Fetch project details from the database
    $fetch_sql = "SELECT project_images_path, desktop_images_paths, mobile_images_paths FROM portfolio_projects WHERE id = ? AND user_id = ?";
    $fetch_stmt = $conn->prepare($fetch_sql);
    $fetch_stmt->bind_param('ii', $delete_id, $user_id);
    $fetch_stmt->execute();
    $fetch_stmt->store_result();

    if ($fetch_stmt->num_rows > 0) {
        $fetch_stmt->bind_result($projectImagesPath, $desktopImagesPaths, $mobileImagesPaths);
        $fetch_stmt->fetch();

        // Unserialize paths
        $projectImages = unserialize($projectImagesPath);
        $desktopImages = unserialize($desktopImagesPaths);
        $mobileImages = unserialize($mobileImagesPaths);

        // Delete all images
        deleteFiles($projectImages);
        deleteFiles($desktopImages);
        deleteFiles($mobileImages);

        // Extract folder path and delete it
        $projectFolder = dirname(reset($projectImages));
        deleteFolder($projectFolder);
    }

    $fetch_stmt->close();

    // Now delete project from database
    $delete_sql = "DELETE FROM portfolio_projects WHERE id = ? AND user_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param('ii', $delete_id, $user_id);
    $delete_stmt->execute();
    $delete_stmt->close();

    header("Location: add-projects.php");
    exit();
}

// Handle new project submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['project-name'])) {
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

    // Upload project image
    $projectImagePath = "";
    if (!empty($_FILES['project-image']['name'])) {
        $projectImage = basename($_FILES['project-image']['name']);
        $projectImagePath = $projectFolder . $projectImage;
        move_uploaded_file($_FILES['project-image']['tmp_name'], $projectImagePath);
    }

    // Upload desktop screenshots
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

    // Upload mobile screenshots
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

    // Store project in database
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
        header("Location: add-projects.php"); 
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch previously added projects
$sql = "SELECT * FROM portfolio_projects WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$projects = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Portfolio Projects</title>
    <link rel="stylesheet" href="css/add-projects.css">
    <?php require('includes/head.php'); ?>
</head>
<body>
    <div class="cv-builder-container">
        <h1>Portfolio Projects</h1>
        
        <!-- Display previously added projects -->
        <?php if (!empty($projects)): ?>
            <table>
                <tr>
                    <th>Project Name</th>
                    <th>Short Description</th>
                    <th class='action' >Actions</th>
                </tr>
                <?php foreach ($projects as $project): ?>
                    <tr>
                        <td><?= htmlspecialchars($project['project_name']) ?></td>
                        <td><?= htmlspecialchars($project['project_short_description']) ?></td>
                        <td>
                            <form action="add-projects.php" method="POST" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?= $project['id'] ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No projects added yet.</p>
        <?php endif; ?>
        <!-- Form to add new project -->
        <form action="add-projects.php" method="POST" class="cv-form" enctype="multipart/form-data">
                    <h2>Add New Project</h2>
                    <label for="project-name">Project Name:</label>
                    <input type="text" id="project-name" name="project-name" required>
        
                    <label for="project-image">Upload Project Title Image:</label>
                    <input type="file" id="project-image" name="project-image" accept="image/*">
        
                    <label for="project-short-description">Short Description:</label>
                    <textarea id="project-short-description" name="project-short-description" rows="2" required></textarea>
        
                    <label for="dv-project-ss">Upload Desktop Screenshots:</label>
                    <input type="file" id="dv-project-ss" name="dv-project-ss[]" accept="image/*" multiple>
        
                    <label for="mv-project-ss">Upload Mobile Screenshots:</label>
                    <input type="file" id="mv-project-ss" name="mv-project-ss[]" accept="image/*" multiple>
        
                    <label for="project-long-description">Long Description:</label>
                    <textarea id="project-long-description" name="project-long-description" rows="5" required></textarea>
        
                    <label for="project-link">Project Link:</label>
                    <input type="url" id="project-link" name="project-link" placeholder="https://projectlink.com">
        
                    <button type="submit" class="submit-btn">Create Portfolio</button>
                </form>
    </div>
</body>
</html>


