<!DOCTYPE html>
<html lang="en">

<head>
	<title>Ahsen Portfolio</title>
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
			overflow: hidden;
			transition: transform 0.3s ease-out;
		}

		.zoom-effect:hover {
			transform: scale(1.1);
		}
	</style>


</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">


	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar ftco-navbar-light site-navbar-target" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="index.html">Ahsen</a>
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
								<h1 class="mb-4 mt-3">I'm <span>Ahsen</span></h1>

								<!-- Element to contain animated typing -->
								<span id="typing-animation"></span>

								<script>

									// Initialize the typing animation
									const typingAnimationElement = document.getElementById('typing-animation');

									// Create an array of typing text
									const typingTexts = [
										'HTML/CSS/JS Developer',
										'React Developer',
										'PHP Developer',
									];

									// Create a function to display the typing animation for a given text
									function playTypingAnimation(text) {
										// Loop through each character and add it to the element
										for (let i = 0; i < text.length; i++) {
											setTimeout(() => {
												typingAnimationElement.textContent += text[i];
											}, i * 200); // Increase the delay to slow down the typing animation
										}

										// Once the animation is complete, reset the text and start over
										setTimeout(() => {
											typingAnimationElement.textContent = '';
											playTypingAnimation(typingTexts[(typingTexts.indexOf(text) + 1) % typingTexts.length]);
										}, text.length * 200);
									}

									// Start the typing animation loop
									playTypingAnimation(typingTexts[0]);

								</script>

								<br>
								<br>
								<h2>Web Developer</h2>
								<!-- <h2 class="d-flex" style="margin-bottom: 0">With over 5 years of experience</h2> -->
								<!-- <br> -->
								<p><a href="https://www.linkedin.com/in/ahsen987/" target="_blank"
										class="btn btn-primary py-3 px-4">LinkedIn</a>
									<a href="https://drive.google.com/file/d/1PC8Oz7dih86myO5BpxX-f8xWcVnp0WU6/view?usp=drive_link"
										target="_blank" class="btn btn-white btn-outline-white py-3 px-4">My Resume</a>
								</p>
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
					<img src="images/about-me.jpg" class="img-fluid rounded b-shadow-a" alt="profile-pic">
				</div>



				<div class="col-md-6 col-lg-7 pl-lg-5 pb-5" style="text-align: justify; line-height: 42px;">


					<p>
						Hi, I'm Muhammad Ahsen, a passionate and driven Full-Stack Web Developer currently pursuing my
						Bachelor's degree in Information Technology (BS-IT). I have a strong interest in creating
						dynamic and responsive websites that provide seamless user experiences.
						<br>
						I’m excited about collaborating with others, and I’m always looking to connect with like-minded
						individuals and opportunities to grow in the world of tech. Feel free to reach out if you want
						to chat or explore potential collaborations!
					</p>

				</div>


			</div>
		</div>
	</section>




	<section class="ftco-section ftco-no-pb" id="resume-section">
		<div class="container">
			<div class="row justify-content-center pb-5">
				<div class="col-md-10 heading-section text-center ftco-animate" style="text-align: justify;">
					<h2 class="mb-4">
						Resume
					</h2>
					<p style="line-height: 42px;">
						Aspiring full-stack web developer with a passion for building responsive and user-friendly
						websites.
						Currently pursuing a Bachelor's degree in Information Technology (BS-IT).
						Always eager to learn and grow in the field of web development and software engineering.
						A self-motivated problem-solver, I am eager to apply my skills and contribute to cutting-edge
						solutions.
					</p>
				</div>
			</div>

			<div class="row">
				<h1 class="big-4">
					Experience
				</h1>
				<div class="underline"></div>
			</div>
			<br>

			<div class="row" style="text-align: justify;">


				<div class="col-md-6 mx-auto">
					<div class="resume-wrap ftco-animate">
						<span class="date">
							Nov 2024 - Present
						</span>
						<h2>
							Web Developer (Intern)
						</h2>
						<span class="position">
							VirtualSoft
						</span>
						<p class="mt-4">
							VirtualSoft is a software house specializing in softwarre development.
						<ul>
							<li>
								Designed and implemented user-friendly, efficient, and innovative websites to meet
								client requirements.
							</li>
							<li>
								Gained hands-on experience in web development, including HTML, CSS, JavaScript, and
								React.
							</li>
							<li>
								Worked closely with cross-functional teams, including designers, product managers, and
								other developers, to ensure seamless project execution and deliver robust solutions.
							</li>
							<li>
								Learned how to build dynamic and responsive web applications using React and its
								component-based architecture.
							</li>
						</ul>
						</p>
					</div>
				</div>
			</div>

			<br>
			<br>

			<div class="row">
				<h1 class="big-4">Education</h1>
				<div class="underline"></div>
			</div>
			<br>

			<div class="row">
				<div class="col-md-6">
					<div class="resume-wrap ftco-animate">
						<span class="date">2022 - Present</span>
						<h2> Bachelor of Information Technology</h2>
						<span class="position">KFUEIT</span>
						<p class="mt-4">GPA: 3.83 / 4.0</p>
					</div>
				</div>

				<div class="col-md-6">
					<div class="resume-wrap ftco-animate">
						<span class="date">2019 - 2021</span>
						<h2>Intermediate</h2>
						<span class="position">Iqra College</span>
						<p class="mt-4">Grade: First class distinction.</p>
					</div>
				</div>
			</div>

		</div>
	</section>



	<section class="ftco-section" id="project-section">
		<div class="container">
			<div class="row justify-content-center mb-5 pb-5">
				<div class="col-md-7 heading-section text-center ftco-animate">
					<h1 class="big-4">Portfolio</h1>
					<div class="underline"></div>
					<p>Below are the web project</p>
				</div>
			</div>
			<div class="row d-flex justify-content-center">
				<div class="col-md-4 d-flex ftco-animate">
					<div class="blog-entry justify-content-end">
						<a target="_blank" href="Projects/project1.html" class="block-20 zoom-effect"
							style="background-image: url('images/Project1/AlarmApp.jpg'); width: 340px; height: 280px; background-size: cover; background-position: center;">
						</a>
						<div class="text mt-3 float-right d-block">

							<h3 class="heading"><a target="_blank" href="Projects/project1.html">Alarm
									Management and Maintenance App</a></h3>
							<p>Stay secure and organized with our Alarm Management and Maintenance app. Easily track
								alarms, schedule maintenance, and address issues, all through an intuitive interface.
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>



		<section id="projects-section"
			style="position: relative; z-index: 10; overflow: hidden; height: 100vh; background-color: transparent;">
			<div class="ftco-section ftco-hireme img margin-top" style="
      background-image: url(images/bg_1.jpg); 
      background-size: cover; 
      background-position: center; 
      position: relative; 
      width: 100%; 
      height: 100%;
    ">
				<!-- Transparent Overlay -->
				<div class="overlay" style="
        position: absolute; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
        background: rgba(0, 0, 0, 0.5); 
        z-index: 1;"></div>

				<!-- Content -->
				<div class="row justify-content-center" style="position: relative; z-index: 2; padding-top: 100px;">
					<div class="col-md-7 ftco-animate text-center">
						<h2 style="color: white; font-size: 2rem;">
							More projects on <span>GitHub</span>
						</h2>
						<div class="heading">
							<h4 style="color: white; font-weight: 400; margin-bottom: 20px;">
								Flutter developer solving business problems &amp; creating innovative solutions.
							</h4>
							<!-- Button -->
							<a target="_blank" rel="noopener noreferrer" href="https://github.com/M-Ahsen"
								class="btn btn-primary py-3 px-5" style="z-index: 3; position: relative;">
								Visit GitHub
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>



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
							<p style="color: #ffffff;">Sadiqabad, Punjab, Pakistan</p>
						</div>
					</div>
					<div class="col-md-6 col-lg-3 d-flex ftco-animate">
						<div class="align-self-stretch box p-4 text-center">
							<div class="icon d-flex align-items-center justify-content-center">
								<span class="icon-phone2"></span>
							</div>
							<h3 class="mb-4"><a href="tel:+923043455791">Contact Number</a></h3>
							<p><a href="tel:+923043455791">+92 304 3455793</a></p>
						</div>
					</div>
					<div class="col-md-6 col-lg-3 d-flex ftco-animate">
						<div class="align-self-stretch box p-4 text-center">
							<div class="icon d-flex align-items-center justify-content-center">
								<span class="icon-paper-plane"></span>
							</div>
							<h3 class="mb-4"><a href="mailto:muhammadahsen987@gmail.com">Email Address</a>
							</h3>
							<p><a href="mailto:muhammadahsen987@gmail.com">muhammadahsen987@gmail.com</a></p>
						</div>
					</div>
					<div class="col-md-6 col-lg-3 d-flex ftco-animate">
						<div class="align-self-stretch box p-4 text-center">
							<div class="icon d-flex align-items-center justify-content-center">
								<span class="icon-globe"></span>
							</div>
							<h3 class="mb-4"><a href="images/Resume.pdf">Download Resume</a></h3>
							<p><a href="images/Resume.pdf">resumelink</a>
							</p>
						</div>
					</div>
				</div>
		</section>




		<footer class="ftco-footer ftco-section">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">

						<p>
							Copyright &copy;
							<script>document.write(new Date().getFullYear());</script> All rights reserved | This
							template
							is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a
								href="https://colorlib.com" target="_blank">Ahsen</a>
						</p>
					</div>
				</div>
			</div>
		</footer>


		<!-- loader -->
		<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
				<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
				<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
					stroke="#F96D00" />
			</svg></div>


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