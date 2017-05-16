<?php
	session_start();
	if(isset($_SESSION['login_message'])){
		unset($_SESSION['login_message']);
	}
	if(isset($_SESSION['message_submit'])){
		unset($_SESSION['message_submit']);
		header("location: index.php");
		exit();
	}
?>
<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width = device-width, initial-scale = 1">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="styling/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="styling/stylesheet.css?v=986876966923">
		<link rel="icon" href="images/browser_icon.ico">
		<title>GCC</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
	</head>
	<body>
<div id="nav_bar">
			<div id="icon">
				<a href="#top"><img id="gcc_icon" src="images/gcc_gen.png" alt="gcc_icon"></a>
			</div>
			<div id="tabs1">
				<ul>
				<?php
					if(isset($_SESSION['logged_user'])){
						echo "<a href='logout.php'>Logout</a>";
						echo "<a href='admin_page.php'>Admin Page</a>";
					}
				?>
				<li><a href="#contact_us">Contact Us</a></li>
				<li><a href="#apply">Apply</a></li>
				<li><a href="#companies">Companies</a></li>
				<li><a href="#our_members">Our Members</a></li>
				<li><a href="#about_us">About Us</a></li>
			</ul>
			</div>
		</div>

		<div class="container-fluid" id="content">
			<div class="container-fluid section" id="top">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
					<h2 id="main_title">GLOBAL CHINA CONNECTION:<br>CORNELL CHAPTER</h2>
					</div>
				</div>
			</div>

			<?php
				require_once 'config.php';
                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                if($mysqli -> connect_error){
                    die("Connection failed: " . $mysqli->connect_error);
                }
			?>
			<div class="container-fluid section" id="about_us">
				<div class="row">
					<div class="col-lg-6">
						<h2>Who we are</h2>
						<p><?php
							$who_we_are = $mysqli->query("SELECT * FROM Site_content WHERE content_name = 'who_we_are'");
		            		$who_content = $who_we_are->fetch_assoc();
		            		$text = $who_content['Content'];
		            		echo $text;
	            		?></p>
					</div>
					<div class="col-lg-6">
						<h2>What we do</h2>
						<p><?php
							$what_we_do = $mysqli->query("SELECT * FROM Site_content WHERE content_name = 'what_we_do'");
		            		$what_content = $what_we_do->fetch_assoc();
		            		$text = $what_content['Content'];
		            		echo $text;
		            		$mysqli->close();
	            		?></p>
					</div>
				</div>
			</div>

			<div class="container-fluid section" id="our_members">
				<h2>Our Members</h2><br/>
				<div class="row" id="member_list">
					<?php
						require_once 'config.php';
						$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
						$allMembers = $mysqli->query("SELECT * FROM Members");

						while($row = $allMembers->fetch_assoc()){
							print("<div class='col-lg-3 col-md-4 col-sm-4 col-xs-6 member_profile'>");
							$img_src = $row['headshot_path'];
							$first_name = $row['firstName'];
							$last_name = $row['lastName'];
							$class = $row['grad_year'];
							$major = $row['major'];
							$href = $row['linkedin_path'];
							print("<a href='$href' title='linkedin'><img src='members/headshots/$img_src' alt='profile picture' class='member_headshot'></a>");
							print("<p><b>$first_name $last_name</b></p>");
							print("<p>Class of $class</p>");
							print("<p>$major</p>");
							print( '</div>' );
						}
					?>
				</div>
			</div>

			<div class="container-fluid section" id="companies">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h2>Where We've Been</h2>
						<div id="placements_image"  class="col-lg-8 col-md-8 col-sm-12 hidden-xs">
							<img id="placement" src="images/placements.png" alt="placement">
						</div>
						<div id="placements_description" class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<p>Our members have gone to work or intern with these companies:</p>
							<ul>
								<li>Google</li>
								<li>Amazon</li>
								<li>Bloomberg</li>
								<li>J.P.Morgan</li>
								<li>Bank of China</li>
								<li>Wells Fargo</li>
								<li>RBC Royal Bank</li>
								<li>Optiver</li>
								<li>Barclays</li>
								<li>Accenture</li>
								<li>Deloitte</li>
								<li>Bain & Company</li>
								<li>Capital One</li>
								<li>Black Rock</li>
								<li>And many more</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="container-fluid section" id="apply">
				<div class="row">
					<div class="col-lg-12">
						<h2>Become A Member</h2>
						<a href = "app_form.php"><button id = "app_button">Apply</button></a>
						<p>Fall recruitment starts soon! Apply to become a member of our club and we'll get back to you as soon as we can.</p>
					</div>
				</div>
			</div>

			<div class="container-fluid section" id="contact_us">
				<div class="row">
					<div class="col-lg-12">
						<h2>Contact Us</h2>
						<p>Send us a message if you're interested in working with us or just want to find out more about who we are!</p>
					</div>
					<div id="contact_div" class="container-fluid section">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="contact_form">
							<p><label>Name</label>
							<input type = "text" name="sender_name" class="message_info" maxlength="45" required></p>
							<p><label>Email</label>
							<input type = "text" name="sender_email" class="message_info" maxlength="50" required></p>
							<p><label>Subject</label>
							<input type = "text" name="subject" class="message_info" maxlength="60" required></p>
							<p><label>Message</label>
							<textarea name="message_body" id="message_body" rows="8" maxlength="3500" required></textarea></p>
							<input type = "submit" name="submit_message" value="Send" id="send_message">
							<?php
								if(isset($_SESSION['message_status'])){
									$message_status = $_SESSION['message_status'];
									print "<p>$message_status</p>";
									unset($_SESSION['message_status']);
								}
							?>
						</form>
						<?php
							if(isset($_POST['submit_message'])){
								$sender_name = filter_input(INPUT_POST, "sender_name", FILTER_SANITIZE_STRING);
								$sender_email = filter_input(INPUT_POST, "sender_email", FILTER_SANITIZE_STRING);
								$subject = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_STRING);
								$raw_message = filter_input(INPUT_POST, "message_body", FILTER_SANITIZE_STRING);
								$info_message = "From: $sender_name\nEmail: $sender_email\n\nBody:\n".$raw_message;

								$message = wordwrap($info_message, 120, "\r\n");

								require_once 'config.php';
				                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

				                if($mysqli -> connect_error){
				                    die("Connection failed: " . $mysqli->connect_error);
				                }

				                $content = $mysqli->query("SELECT * FROM Site_content WHERE content_name = 'contact_email_recipient'");
				                $email_info = $content->fetch_assoc();

				                $recipient_email = $email_info['Content'];

								// Send
								$sent = mail($recipient_email, $subject, $message);
								$mysqli->close();
								if($sent){
									$_SESSION['message_status'] = "Message Sent";
								}
								else{
									$_SESSION['message_status'] = "Failed to Send Message";
								}
								$_SESSION['message_submit'] = "true";
								print "<script>window.location.hash = '#contact_us';window.location.reload(true);</script>";
							//	unset($_POST['submit_message']);
							}
						?>
					</div>
				</div>
			</div>

			<footer>
				<a href="https://www.facebook.com/GlobalChinaConnectionCornell/" target="_blank"><img class="footer_image" src="images/facebook.png" alt="fb"></a>
				<a href="https://www.linkedin.com/company-beta/356784/?pathWildcard=356784" target="_blank"><img class="footer_image" src="images/linkedin.png" alt="linkedin"></a>
				<a href="https://twitter.com/GCCglobal" target="_blank"><img class="footer_image" src="images/twitter.png" alt="twitter"></a>
				<a href="admin_login.php" id="admin_login"><img id="admin_image" class="footer_image" src="images/admin_settings.png" alt="admin settings" title="Admin Settings"></a>
			</footer>
		</div>
	</body>
</html>
