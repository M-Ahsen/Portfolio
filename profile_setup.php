<?php
require("includes/config.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Login Issue. Please log in.";
    exit();
}

$user_id = $_SESSION['user_id'];
$uploadsDir = $_SESSION['user_dir'] ?? 'uploads/';

// Fetch existing data
$sql = "SELECT * FROM personal_info WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$personal_info = $stmt->get_result()->fetch_assoc();
$stmt->close();

$sql = "SELECT * FROM about WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$about_info = $stmt->get_result()->fetch_assoc();
$stmt->close();

$sql = "SELECT * FROM contact_info WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$contact_info = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch Resume Text & Skills
$resumeText = $personal_info['resume_text'] ?? '';
$skills = json_decode($personal_info['skills'] ?? '[]', true);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['full-name'] ?? '';
    $profession = $_POST['profession'] ?? '';
    $linkedin = $_POST['linkedin'] ?? '';
    $github = $_POST['github'] ?? '';
    $resumeText = $_POST['resume-text'] ?? '';
    $skills = isset($_POST['skills']) ? explode(',', $_POST['skills']) : [];

    // Convert skills array to JSON format
    $skillsJson = json_encode($skills);

    // Resume Handling
    $resumePath = $personal_info['resumePath'] ?? '';

    if (!empty($_FILES['resume']['name'])) {
        if (!empty($resumePath) && file_exists($resumePath)) {
            unlink($resumePath);
        }
        $resumeName = time() . '_' . $_FILES['resume']['name'];
        $resumePath = $uploadsDir . $resumeName;
        move_uploaded_file($_FILES['resume']['tmp_name'], $resumePath);
    }

    // About Section
    $aboutText = $_POST['about'] ?? '';
    $aboutPhotoPath = $about_info['about_photo_path'] ?? '';

    if (!empty($_FILES['about-photo']['name'])) {
        if (!empty($aboutPhotoPath) && file_exists($aboutPhotoPath)) {
            unlink($aboutPhotoPath);
        }
        $aboutPhotoName = time() . '_' . $_FILES['about-photo']['name'];
        $aboutPhotoPath = $uploadsDir . $aboutPhotoName;
        move_uploaded_file($_FILES['about-photo']['tmp_name'], $aboutPhotoPath);
    }

    // Contact Info
    $contactAddress = $_POST['contact-address'] ?? '';
    $contactPhone = $_POST['contact-phone'] ?? '';
    $contactEmail = $_POST['contact-email'] ?? '';

    // Validate required fields
    if (empty($fullName) || empty($profession) || empty($aboutText) || empty($contactAddress) || empty($contactPhone) || empty($contactEmail)) {
        echo "Please fill in all required fields.";
        exit();
    }

    // Update or insert data
    if ($personal_info) {
        $sql = "UPDATE personal_info SET full_name = ?, profession = ?, linkedin = ?, github = ?, resumePath = ?, resume_text = ?, skills = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssssi', $fullName, $profession, $linkedin, $github, $resumePath, $resumeText, $skillsJson, $user_id);
        $stmt->execute();
        $stmt->close();
    } else {
        $sql = "INSERT INTO personal_info (full_name, profession, linkedin, github, resumePath, resume_text, skills, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssssi', $fullName, $profession, $linkedin, $github, $resumePath, $resumeText, $skillsJson, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    if ($about_info) {
        $sql = "UPDATE about SET about_text = ?, about_photo_path = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $aboutText, $aboutPhotoPath, $user_id);
        $stmt->execute();
        $stmt->close();
    } else {
        $sql = "INSERT INTO about (about_text, about_photo_path, user_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $aboutText, $aboutPhotoPath, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    if ($contact_info) {
        $sql = "UPDATE contact_info SET contact_address = ?, contact_phone = ?, contact_email = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $contactAddress, $contactPhone, $contactEmail, $user_id);
        $stmt->execute();
        $stmt->close();
    } else {
        $sql = "INSERT INTO contact_info (contact_address, contact_phone, contact_email, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $contactAddress, $contactPhone, $contactEmail, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect to dashboard
    header("Location: dashboard.php");
    exit();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/profile_setup.css">
    <?php require('includes/head.php'); ?>
    <title>Profile</title>
</head>
<body>
    <div class="container">
    <form action="profile_setup.php" method="POST" enctype="multipart/form-data">
        <h2>Your Profile</h2>

        <!-- Personal Information -->
        <div class="section">
            <h3>Personal Information</h3>
            <label for="full-name">Full Name:</label>
            <input type="text" id="full-name" name="full-name"
                value="<?= htmlspecialchars($personal_info['full_name'] ?? '') ?>" required>
            <label for="profession">Profession:</label>
            <input type="text" id="profession" name="profession"
                value="<?= htmlspecialchars($personal_info['profession'] ?? '') ?>" required>
            <label for="tag-input">Skills:</label>
            <div class="tags-container">
                <input type="text" id="tag-input" placeholder="Type and press Enter">
                <input type="hidden" name="skills" id="skills-input">
            </div>
            <label for="linkedin">LinkedIn URL:</label>
            <input type="url" id="linkedin" name="linkedin"
                value="<?= htmlspecialchars($personal_info['linkedin'] ?? '') ?>">
            <label for="github">GitHub URL:</label>
            <input type="url" id="github" name="github"
                value="<?= htmlspecialchars($personal_info['github'] ?? '') ?>">
            <label for="resume">Resume (PDF):</label>
            <input type="file" id="resume" name="resume" accept=".pdf">
            <label for="resume-text">Resume Text:</label>
            <textarea id="resume-text" name="resume-text" rows="4" required><?= htmlspecialchars($resumeText) ?></textarea>
        </div>

        <!-- About Me -->
        <div class="section">
            <h3>About Me</h3>
            <label for="about-photo">Upload Profile Photo:</label>
            <input type="file" id="about-photo" name="about-photo" accept="image/*">

            <label for="about">About Text:</label>
            <textarea id="about" name="about" rows="4" required><?= htmlspecialchars($about_info['about_text'] ?? '') ?></textarea>
        </div>

        <!-- Contact Information -->
        <div class="section">
            <h3>Contact Information</h3>
            <label for="contact-address">Address:</label>
            <input type="text" id="contact-address" name="contact-address" value="<?= htmlspecialchars($contact_info['contact_address'] ?? '') ?>" required>

            <label for="contact-phone">Contact Number:</label>
            <input type="tel" id="contact-phone" name="contact-phone" value="<?= htmlspecialchars($contact_info['contact_phone'] ?? '') ?>" required>

            <label for="contact-email">Email:</label>
            <input type="email" id="contact-email" name="contact-email" value="<?= htmlspecialchars($contact_info['contact_email'] ?? '') ?>" required>
        </div>

        <button type="submit">Submit</button>
    </form>
    </div>
    <script>
        const input = document.getElementById("tag-input");
        const container = document.querySelector(".tags-container");
        const skillsInput = document.getElementById("skills-input");
        let skillsArray = <?= json_encode($skills) ?>;

        function updateSkillsInput() {
            skillsInput.value = skillsArray.join(",");
        }

        input.addEventListener("keypress", function (event) {
            if (event.key === "Enter" && input.value.trim() !== "") {
                event.preventDefault();
                let skill = input.value.trim();
                if (!skillsArray.includes(skill)) {
                    skillsArray.push(skill);
                    addTag(skill);
                    updateSkillsInput();
                }
                input.value = "";
            }
        });

        function addTag(text) {
            const tag = document.createElement("div");
            tag.classList.add("tag");
            tag.innerHTML = `${text} <button onclick="removeTag(this, '${text}')">×</button>`;
            container.insertBefore(tag, input);
        }

        function removeTag(button, text) {
            skillsArray = skillsArray.filter(skill => skill !== text);
            button.parentElement.remove();
            updateSkillsInput();
        }

        skillsArray.forEach(skill => addTag(skill));
        updateSkillsInput();
    </script>

</body>
</html>
