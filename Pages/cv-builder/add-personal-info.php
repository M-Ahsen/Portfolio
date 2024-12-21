<?php
require("../../includes/config.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $fullName = $_POST['full-name'];
    $profession = $_POST['profession'];
    $linkedin = $_POST['linkedin'];
    $github = $_POST['github'];
    $resume = $_FILES['resume']['name'];
    $aboutPhoto = $_FILES['about-photo']['name'];
    $aboutText = $_POST['about'];
    $degree = $_POST['degree'];
    $institute = $_POST['institute'];
    $educationYear = $_POST['education-year'];
    $jobTitle = $_POST['job-title'];
    $companyName = $_POST['company-name'];
    $employmentDates = $_POST['employment-dates'];
    $jobDescription = $_POST['job-description'];
    $contactAddress = $_POST['contact-address'];
    $contactPhone = $_POST['contact-phone'];
    $contactEmail = $_POST['contact-email'];
    $user_id = $_SESSION['user_id'];

    // Required fields check
    if (
        empty($fullName) ||
        empty($profession) ||
        empty($aboutText) ||
        empty($degree) ||
        empty($institute) ||
        empty($contactAddress) ||
        empty($contactPhone) ||
        empty($contactEmail)
    ) {
        echo "Please fill in all required fields.";
    } elseif (empty($user_id)) {
        echo 'Login Issue';
    } else {
        // Handle file uploads
        $uploadsDir = "../../uploads/";

        // Handle resume upload
        if (!empty($resume)) {
            move_uploaded_file($_FILES['resume']['tmp_name'], $uploadsDir . $resume);
        }

        // Handle about photo upload
        $aboutPhotoPath = "";
        if (!empty($aboutPhoto)) {
            $aboutPhotoPath = $uploadsDir . $aboutPhoto;
            move_uploaded_file($_FILES['about-photo']['tmp_name'], $aboutPhotoPath);
        }

        // Insert Personal Information
        $sqlPersonal = "INSERT INTO personal_info (full_name, profession, linkedin, github, resume, user_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtPersonal = $conn->prepare($sqlPersonal);
        $stmtPersonal->bind_param('sssssi', $fullName, $profession, $linkedin, $github, $resume, $user_id);
        $stmtPersonal->execute();

        // Insert About Section
        $sqlAbout = "INSERT INTO about (about_photo, about_text, about_photo_path, user_id) VALUES (?, ?, ?, ?)";
        $stmtAbout = $conn->prepare($sqlAbout);
        $stmtAbout->bind_param('sssi', $aboutPhoto, $aboutText, $aboutPhotoPath, $user_id);
        $stmtAbout->execute();

        // Insert Education
        $sqlEducation = "INSERT INTO education (degree, institute, education_year, user_id) VALUES (?, ?, ?, ?)";
        $stmtEducation = $conn->prepare($sqlEducation);
        $stmtEducation->bind_param('sssi', $degree, $institute, $educationYear, $user_id);
        $stmtEducation->execute();

        // Insert Work Experience
        $sqlWork = "INSERT INTO work_experience (job_title, company_name, employment_dates, job_description, user_id) VALUES (?, ?, ?, ?, ?)";
        $stmtWork = $conn->prepare($sqlWork);
        $stmtWork->bind_param('ssssi', $jobTitle, $companyName, $employmentDates, $jobDescription, $user_id);
        $stmtWork->execute();

        // Insert Contact Information
        $sqlContact = "INSERT INTO contact_info (contact_address, contact_phone, contact_email, user_id) VALUES (?, ?, ?, ?)";
        $stmtContact = $conn->prepare($sqlContact);
        $stmtContact->bind_param('sssi', $contactAddress, $contactPhone, $contactEmail, $user_id);
        $stmtContact->execute();

        // Close Statements
        $stmtPersonal->close();
        $stmtAbout->close();
        $stmtEducation->close();
        $stmtWork->close();
        $stmtContact->close();

        echo "Your details have been successfully submitted!";

        // Set success flag and redirect
        $formSubmitted = true;
        header("Location: ../dashboard.php");
        exit();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Personal Info</title>
    <link rel="stylesheet" href="../../CSS/cv-builder.css">
    <?php require('../../includes/head.php'); ?>
</head>

<body>
    <div class="cv-builder-container">
        <h1>Add Your Personal Details</h1>
        <p>Fill out each section to build your online CV.</p>

        <form action="#" method="POST" class="cv-form" enctype="multipart/form-data">
            <section>
                <h2>Personal Information</h2>
                <label for="full-name">Full Name:</label>
                <input type="text" id="full-name" name="full-name" placeholder="Enter your name" required>

                <label for="profession">Profession:</label>
                <input type="text" id="profession" name="profession" placeholder="e.g., Web Developer" required>

                <label for="linkedin">LinkedIn URL:</label>
                <input type="url" id="linkedin" name="linkedin" placeholder="https://linkedin.com/in/username">

                <label for="github">GitHub URL:</label>
                <input type="url" id="github" name="github" placeholder="https://github.com/username">

                <label for="resume">Upload Resume (PDF):</label>
                <input type="file" id="resume" name="resume" accept=".pdf">

            </section>

            <section>
                <h2>About Me</h2>
                <label for="about-photo">Upload Profile Photo:</label>
                <input type="file" id="about-photo" name="about-photo" accept="image/*">

                <label for="about">About Text:</label>
                <textarea id="about" name="about" rows="4" placeholder="Write a brief introduction about yourself"
                    required></textarea>
            </section>

            <section>
                <h2>Education</h2>
                <label for="degree">Degree:</label>
                <input type="text" id="degree" name="degree" placeholder="Bachelor of Information Technology" required>

                <label for="institute">Institute:</label>
                <input type="text" id="institute" name="institute" placeholder="e.g., KFUEIT" required>

                <label for="education-year">Year:</label>
                <input type="text" id="education-year" name="education-year" placeholder="e.g., 2020 - 2024">
            </section>

            <section>
                <h2>Work Experience</h2>
                <label for="job-title">Job Title:</label>
                <input type="text" id="job-title" name="job-title" placeholder="e.g., Web Developer">

                <label for="company-name">Company Name:</label>
                <input type="text" id="company-name" name="company-name" placeholder="e.g., XYZ Company">

                <label for="employment-dates">Employment Dates:</label>
                <input type="text" id="employment-dates" name="employment-dates" placeholder="e.g., May 2024 - Present">

                <label for="job-description">Job Description:</label>
                <textarea id="job-description" name="job-description" rows="3"
                    placeholder="Describe your responsibilities"></textarea>
            </section>

            <section>
                <h2>Contact Information</h2>
                <label for="contact-address">Address:</label>
                <input type="text" id="contact-address" name="contact-address" placeholder="e.g., Lahore, Pakistan"
                    required>

                <label for="contact-phone">Contact Number:</label>
                <input type="tel" id="contact-phone" name="contact-phone" placeholder="e.g., +92 304 345567891"
                    required>

                <label for="contact-email">Email:</label>
                <input type="email" id="contact-email" name="contact-email" placeholder="e.g., example@gmail.com"
                    required>
            </section>

            <button type="submit" class="submit-btn">Create Portfolio</button>
        </form>
    </div>
</body>

</html>