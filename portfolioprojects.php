<?php
require("includes/config.php");
session_start();

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']); // Ensures user_id is an integer

    // Prepare statements for fetching user data
    $sqlHome = "SELECT * FROM personal_info WHERE user_id = ? LIMIT 1";
    $stmtHome = $conn->prepare($sqlHome);
    $stmtHome->bind_param('i', $user_id);
    $stmtHome->execute();
    $resultHome = $stmtHome->get_result();
    $homeData = $resultHome ? $resultHome->fetch_assoc() : [];

    // About Section
    $sqlAbout = "SELECT * FROM about WHERE user_id = ? LIMIT 1";
    $stmtAbout = $conn->prepare($sqlAbout);
    $stmtAbout->bind_param('i', $user_id);
    $stmtAbout->execute();
    $resultAbout = $stmtAbout->get_result();
    $aboutData = $resultAbout ? $resultAbout->fetch_assoc() : [];

    // Education Section
    $sqlEducation = "SELECT * FROM education WHERE user_id = ? ORDER BY id DESC";
    $stmtEducation = $conn->prepare($sqlEducation);
    $stmtEducation->bind_param('i', $user_id);
    $stmtEducation->execute();
    $resultEducation = $stmtEducation->get_result();

    // Work Experience Section
	$sqlExperience = "SELECT * FROM work_experience WHERE user_id = ? ORDER BY id DESC";
    $stmtExperience = $conn->prepare($sqlExperience);
    $stmtExperience->bind_param('i', $user_id);
    $stmtExperience->execute();
    $resultExperience = $stmtExperience->get_result();

    // Portfolio Section
    $sqlProjects = "SELECT * FROM portfolio_projects WHERE user_id = ? ORDER BY id DESC";
    $stmtProjects = $conn->prepare($sqlProjects);
    $stmtProjects->bind_param('i', $user_id);
    $stmtProjects->execute();
    $resultProjects = $stmtProjects->get_result();

    // Contact Section
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
	<title>Portfolio</title>
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
		/*======================================
//--//-->   ABOUT
======================================*/
		html, body {
		    overflow-x: hidden;
		    width: 100vw;
		}


		.about-mf .box-shadow-full {
			padding-top: 4rem;
			padding-bottom: 4rem;
		}

		.about-mf .about-img {
			margin-bottom: 2rem;
			width: 350px;
			height: 350px;
		}

		.about-mf .about-img img {
			margin-left: 10px;
			width: 100%;
			height: 100%;
			object-fit: cover;
			object-position: center;
		}


		.skill-mf .progress {
			/* background-color: #cde1f8; */
			margin: .5rem 0 1.2rem 0;
			border-radius: 0;
			height: .7rem;
		}

		.skill-mf .progress .progress-bar {
			height: .7rem;
			background-color: #ffbd39;
		}


		/* Animation styles */
		#typing-animation {
			position: relative;
			font-size: 30px;
			font-weight: bold;
			color: rgb(255, 255, 255);
			overflow: hidden;
			white-space: nowrap;
			animation: typing 3s steps(20, end) infinite;
		}

		#typing-animation:before {
			content: "";
			/* position: absolute; */
			top: 0;
			left: 0;
			width: 0;
			height: 100%;
			background-color: #ccc;
			animation: typing-cursor 0.5s ease-in-out infinite;
		}

		@keyframes typing {
			from {
				width: 0;
			}

			to {
				width: 100%;
			}
		}

		@keyframes typing-cursor {
			from {
				width: 5px;
			}

			to {
				width: 0;
			}
		}


		/* project image zoom effect */
        .zoom-effect {
        transition: transform 0.3s ease-in-out;
        border-radius: 15px;
        }

        .zoom-effect:hover {
        transform: scale(1.02); /* Small zoom effect */
        }
	</style>


</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">


	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar ftco-navbar-light site-navbar-target" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>"><?= htmlspecialchars($homeData['full_name'] ?? 'Your Name') ?></a>
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
				</ul>
			</div>
		</div>
	</nav>
	<section id="home-section" class="hero">
		<div class="home-slider  owl-carousel">
			<div class="slider-item ">
				<div class="overlay"></div>
				<div class="container">
					<div class="row d-md-flex no-gutters slider-text align-items-end justify-content-end"
						data-scrollax-parent="true">
						<div class="one-third js-fullheight order-md-last img" style="background-image:url();">
							<div class="overlay"></div>
						</div>
						<div class="one-forth d-flex  align-items-center ftco-animate"
							data-scrollax=" properties: { translateY: '70%' }">
							<div class="text">
								<span class="subheading">Hello!</span>
								<h1 class="mb-4 mt-3">I'm <span><?= htmlspecialchars($homeData['full_name'] ?? 'Your Name') ?></span></h1>

                                <h2><?= htmlspecialchars($homeData['profession'] ?? 'Your Profession') ?></h2>

								<!-- Element to contain animated typing -->
								<span id="typing-animation"></span>

								

								<br>
								<br>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>



	<section class="ftco-section ftco-no-pb " id="about-section">
		<div class="container about-mf ">
			<h2 style="text-align: center;"><b>About Me</b></h2>
			<div class="row justify-content-center box-shadow-full">



				<div class="about-img">
					<img src="<?= htmlspecialchars($aboutData['about_photo_path']) ?>" class="img-fluid rounded b-shadow-a" alt="profile-pic">
				</div>



				<div class="col-md-6 col-lg-7 pl-lg-5 pb-5" style="text-align: justify; line-height: 42px;">


					<p>
                        <?= nl2br($aboutData['about_text'] ?? 'No details available.') ?>
					</p>

				</div>


			</div>
		</div>
	</section>




	<section class="ftco-section ftco-no-pb" id="resume-section">
    	<div class="container">
    	    <!-- Resume Heading -->
    	    <div class="row justify-content-center pb-5">
    	        <div class="col-md-10 heading-section text-center ftco-animate" style="text-align: justify;">
    	            <h2 class="mb-4">Resume</h2>
    	            <p style="line-height: 42px; text-align: justify;">
    	                <?= nl2br($homeData['resume_text'] ?? 'No details available.') ?>
    	            </p>
    	        </div>
    	    </div>

    	    <!-- Experience Section -->
    	    <div class="row">
    	        <h1 class="big-4">Experience</h1>
    	        <div class="underline"></div>
    	    </div>
    	    <br>

    	    <div class="row">
    	        <?php while ($experience = $resultExperience->fetch_assoc()): ?>
    	            <div class="col-md-6">
    	                <div class="resume-wrap ftco-animate">
    	                    <span class="date"><?= htmlspecialchars($experience['employment_dates']) ?></span>
    	                    <h2><?= htmlspecialchars($experience['job_title']) ?></h2>
    	                    <span class="position"><?= htmlspecialchars($experience['company_name']) ?></span>
    	                    <p class="mt-4"><?= nl2br(htmlspecialchars($experience['job_description'])) ?></p>
    	                </div>
    	            </div>
    	        <?php endwhile; ?>
    	    </div>

    	    <br><br>

    	    <!-- Education Section -->
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
    	                    <p class="mt-4"><?= htmlspecialchars($education['marks']) ?></p>
    	                </div>
    	            </div>
    	        <?php endwhile; ?>
    	    </div>

    	</div>
	</section>



	<section class="ftco-section" id="project-section">
    	<div class="container">
        	<div class="row justify-content-center pb-2">
            	<div class="col-md-7 heading-section text-center ftco-animate">
               	 <h1 class="big-4">Portfolio</h1>
                	<div class="underline"></div>
                	<p>A showcase of my recent projects</p>
            	</div>
			</div>
        </div>

        <div class="row justify-content-center">
            <?php if ($resultProjects->num_rows > 0): ?>
                <div class="row g-4 justify-content-center w-100 
                    <?php echo ($resultProjects->num_rows == 1) ? 'd-flex flex-column align-items-center text-center' : ''; ?>">
                    
                    <?php while ($project = $resultProjects->fetch_assoc()): ?>
                        <?php
                        $project_id = $project['id'];
                        $title = htmlspecialchars($project['project_name'] ?? 'Untitled Project');
                        $projectImagePaths = unserialize($project['project_images_path'] ?? 'default-thumbnail.jpg');
                        $imagePath = htmlspecialchars($projectImagePaths[0] ?? '');
                        $description = htmlspecialchars($project['project_short_description'] ?? 'No description available.');
                        ?>
                        <div class="col-md-4 col-sm-12 d-flex justify-content-center">
                            <div class="blog-entry w-100 mx-auto ftco-animate" 
                                style="max-width: 340px; min-width: 340px; border-radius: 15px; overflow: hidden;">
                                <a target="_blank" href="project.php?user_id=<?= $user_id ?>&project_id=<?= $project_id ?>" 
                                    class="block-20 zoom-effect"
                                    style="background-image: url('<?= $imagePath ?>'); width: 340px; height: 280px; background-size: cover; background-position: center; border-radius: 15px;">
                                </a>
                                <div class="text mt-3 float-right d-block" style="text-align: left;">
                                    <h3 class="heading">
                                        <a target="_blank" href="project.php?user_id=<?= $user_id ?>&project_id=<?= $project_id ?>"><?= $title ?></a>
                                    </h3>
                                    <p><?= $description ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            	<?php else: ?>
                	<div class="col-12 text-center">
                    	<p>No projects available.</p>
                	</div>
            	<?php endif; ?>
        	</div>
    	</div>
	</section>




	<section id="projects-section"
	    style="position: relative; z-index: 10; overflow: hidden; min-height: 100vh; background-color: transparent;">
					
	    <div class="ftco-section ftco-hireme img d-flex align-items-center justify-content-center text-center"
	        style="
	        background-image: url(images/bg_1.jpg); 
	        background-size: cover; 
	        background-position: center; 
	        background-attachment: fixed;
	        position: relative; 
	        width: 100%; 
	        min-height: 100vh;
	        padding: 50px 15px;
	    ">
	        <!-- Transparent Overlay -->
	        <div class="overlay" style="
	            position: absolute; 
	            top: 0; 
	            left: 0; 
	            width: 100%; 
	            height: 100%; 
	            background: rgba(0, 0, 0, 0.5); 
	            z-index: 1;">
	        </div>
					
	        <!-- Content -->
	        <div class="row justify-content-center w-100" style="position: relative; z-index: 2;">
	            <div class="col-md-7 ftco-animate text-center">
	                <h2 style="color: white; font-size: 2rem;">
	                    More projects on <span>GitHub</span>
	                </h2>
	                <div class="heading">
	                    <h4 style="color: white; font-weight: 400; margin-bottom: 20px;">
	                        Solving business problems &amp; creating innovative solutions.
	                    </h4>
	                    <!-- Button -->
	                    <a target="_blank" rel="noopener noreferrer" 
	                        href="<?= htmlspecialchars($homeData['github'] ?? '#') ?>"
	                        class="btn btn-primary py-3 px-5" style="z-index: 3; position: relative;">
	                        Visit GitHub
	                    </a>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>
					
					
					
	<div class="d-flex flex-column vh-20">
	    <div class="flex-grow-1">
	        <!-- Your page content here -->
	    </div>
					
	    <footer class="ftco-footer ftco-section py-3">
	        <div class="container">
	            <div class="row">
	                <div class="col-md-12 text-center">
	                    <p class="mb-0">
	                        Copyright &copy;
	                        <script>document.write(new Date().getFullYear());</script> All rights reserved | This
	                        template is made with <i class="icon-heart text-danger" aria-hidden="true"></i> by 
	                        <a href="https://colorlib.com" target="_blank">Ahsen</a>
	                    </p>
	                </div>
	            </div>
	        </div>
	    </footer>
	</div>




		<!-- loader -->
		<div id="ftco-loader" class="show fullscreen">
			<svg class="circular" width="48px" height="48px">
				<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
				<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
					stroke="#F96D00" />
			</svg>
		</div>


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
		<script>
    		// Get the typing animation element
    		const typingAnimationElement = document.getElementById('typing-animation');

    		// Parse the PHP JSON-encoded skills array into JavaScript
    		let skillsArray = <?= json_encode(json_decode($homeData['skills'] ?? '[]', true)) ?>;

    		// Provide fallback if no skills exist
    		if (skillsArray.length === 0) {
    		    skillsArray = ['Your Profession'];
    		}
		
    		let skillIndex = 0;
    		let charIndex = 0;
		
    		function playTypingAnimation() {
    		    if (charIndex < skillsArray[skillIndex].length) {
    		        typingAnimationElement.textContent += skillsArray[skillIndex].charAt(charIndex);
    		        charIndex++;
    		        setTimeout(playTypingAnimation, 150); // Typing speed
    		    } else {
    		        setTimeout(() => {
    		            typingAnimationElement.textContent = ''; // Clear text
    		            charIndex = 0;
    		            skillIndex = (skillIndex + 1) % skillsArray.length; // Cycle to the next skill
    		            playTypingAnimation();
    		        }, 2000); // Delay before switching
    		    }
    		}
		
    		// Start the animation
    		playTypingAnimation();
		</script>

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

<?php
}
?>