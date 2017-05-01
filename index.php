<!DOCTYPE html>
<html>
	<head lang = "en">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width = device-width, initial-scale = 1">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="styling/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="styling/stylesheet.css?v=1119878765678152">
		<link rel="icon" href="images/browser_icon.ico">
		<title>GCC</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script> 
	</head>
	<body>
		<nav>
			<div id="icon">
				<a href="#top"><img id="gcc_icon" src="images/gcc_gen.png" alt="gcc_icon"></a>
			</div>
			<div id="tabs">
				<a href="#contact_us">Contact Us</a>
				<a href="#apply">Apply</a>
				<a href="#companies">Companies</a>
				<a href="#our_members">Our Members</a>
				<a href="#about_us">About Us</a>
			</div>
		</nav>
		<div class="container-fluid" id="content">
			<div class="container-fluid section" id="top">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
					<h2 id="main_title">GLOBAL CHINA<br>CONNECTION: CORNELL</h2>
					</div>
				</div>
			</div>

			<div class="container-fluid section" id="about_us">
				<div class="row">
					<div class="col-lg-6">
						<h2>Who we are</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>
					<div class="col-lg-6">
						<h2>What we do</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>
				</div>
			</div>

			<div class="container-fluid section" id="our_members">
				<h2>Our Members</h2><br/>
				<div class="row" id="member_list">
					<?php
						for($j = 0; $j < 13; $j++){
							echo "<div class='col-lg-3 col-md-3 col-sm-4 col-xs-6 member_profile'>
									<img src='images/no-image-profile.png' alt='profile picture' class='member_headshot'>
									<p><b>FirstName LastName</b></p>
									<p>Position: [list position]</p>
									<p>Class of 20XX</p>
									<p>Major: [list major]</p>
								</div>";
						}
					?>
				</div>
			</div>

			<div class="container-fluid section" id="companies">
				<div class="row">
					<div class="col-lg-12">
						<h2>Where We've Been</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>
				</div>
			</div>

			<div class="container-fluid section" id="apply">
				<div class="row">
					<div class="col-lg-12">
						<h2>Become A Member</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>
				</div>
			</div>

			<div class="container-fluid section" id="contact_us">
				<div class="row">
					<div class="col-lg-12">
						<h2>Contact Us</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>
				</div>
			</div>

			<footer>
				<a href="https://www.facebook.com/GlobalChinaConnectionCornell/" target="_blank"><img class="footer_image" src="images/facebook.png" alt="fb"></a>
				<a href="https://www.linkedin.com/company-beta/356784/?pathWildcard=356784" target="_blank"><img class="footer_image" src="images/linkedin.png" alt="linkedin"></a>
				<a href="https://twitter.com/GCCglobal" target="_blank"><img class="footer_image" src="images/twitter.png" alt="twitter"></a>
			</footer>
		</div>
	</body>
</html>