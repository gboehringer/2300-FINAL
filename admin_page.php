<?php
	session_start();
	if(!isset($_SESSION['logged_user'])){
		header("location: index.php");
        exit();
	}
	if(isset($_SESSION['login_message'])){
		unset($_SESSION['login_message']);
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width = device-width, initial-scale = 1">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="styling/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="styling/stylesheet2.css?v=1999">
		<link rel="icon" href="images/browser_icon.ico">
		<title>GCC - Admin</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="nav_bar">
			<div id="icon">
				<a href="index.php"><img id="gcc_icon" src="images/gcc_gen.png" alt="gcc_icon"></a>
			</div>
					<div id="tabs1">
						<ul>
						<li><a href='logout.php'>Logout</a></li>
						<li><a href="#contact_us">Contact Us</a></li>
						<li><a href="#apply">Apply</a></li>
						<li><a href="#companies">Companies</a></li>
						<li><a href="#our_members">Our Members</a></li>
						<li><a href="#about_us">About Us</a></li>
						<li><a href='index.php'>Home Page</a></li>
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

			<div class="container-fluid section" id="about_us">
				<div class="row">
					<form method="POST">
						<?php
							require_once 'config.php';
	                        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	                        if($mysqli -> connect_error){
	                            die("Connection failed: " . $mysqli->connect_error);
	                        }
						?>
						<div class="col-lg-6">
							<h2>Who we are</h2>
							<p><textarea class="edit_input" name="who_we_are_edit" rows="6" maxlength="800"><?php
									$who_we_are = $mysqli->query("SELECT * FROM Site_content WHERE content_name = 'who_we_are'");
	                        		$who_content = $who_we_are->fetch_assoc();
	                        		$text = $who_content['Content'];
	                        		echo $text;
	                        		?></textarea></p>
						</div>
						<div class="col-lg-6">
							<h2>What we do</h2>
							<p><textarea class="edit_input" name="what_we_do_edit" rows="6" maxlength="800"><?php
									$what_we_do = $mysqli->query("SELECT * FROM Site_content WHERE content_name = 'what_we_do'");
	                        		$what_content = $what_we_do->fetch_assoc();
	                        		$text = $what_content['Content'];
	                        		echo $text;
	                        		$mysqli->close();
								?></textarea></p>
						</div>
						<div>
							<input class="check_box" type="checkbox" name="about_us_check" required><label class="check_box_label">Confirm Changes</label>
							<input type="submit" name="about_us_submit" value="Submit Changes" id="subm">
						</div>
						<?php
							if(isset($_SESSION['about_us_edit_message'])){
								$about_us_message = $_SESSION['about_us_edit_message'];
								echo ("<p class='changes_message'>$about_us_message</p>");
								unset($_SESSION['about_us_edit_message']);
							}
						?>
					</form>
				</div>
			</div>
			<?php
				if(isset($_POST['about_us_submit']) && isset($_POST['about_us_check'])){
					require_once 'config.php';
	                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	                if($mysqli -> connect_error){
	                    die("Connection failed: " . $mysqli->connect_error);
	                }

	                $stmt = $mysqli->prepare("UPDATE Site_content SET Content = ? WHERE content_name = 'who_we_are'");
	                $stmt->bind_param("s", $new_who_we_are);

					// set parameters and execute
					$new_who_we_are = filter_input(INPUT_POST, "who_we_are_edit", FILTER_SANITIZE_STRING);
					$stmt->execute();
					$st1 = $stmt->close();

	                $stmt = $mysqli->prepare("UPDATE Site_content SET Content = ? WHERE content_name = 'what_we_do'");
	                $stmt->bind_param("s", $new_what_we_do);

	                $new_what_we_do = filter_input(INPUT_POST, "what_we_do_edit", FILTER_SANITIZE_STRING);
	                $stmt->execute();
					$st2 = $stmt->close();

	               	unset($_SESSION['about_us_edit_message']);
	                if($st1 && $st2){
	                	$_SESSION['about_us_edit_message'] = "Succesfully edited 'About Us' section(s)";
	                	header("location: admin_page.php");
                		exit();
	                }
	                else{
	                	$_SESSION['about_us_edit_message'] = "Failed to edit 'About Us' section(s)";
	                	header("location: admin_page.php");
                		exit();
	                }
	                $mysqli->close();
				}
			?>
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

				<div class="container-fluid section" id="new_member">

					<h2>Add New Member</h2>
					<form method = "post" enctype = 'multipart/form-data'  id = "application">
					<input type = "text" name = "firstname" placeholder = "First Name" required>
					<input type = "text" name = "middlename" placeholder = "Middle Name - Optional">
					<input type = "text" name = "lastname" placeholder = "Last Name" required>
					<input type = "text" name = "major" placeholder = "Major" required>
					<input type = "text" name = "net_id" placeholder = "Net ID" required>
					<input type = "text" name = "year" placeholder = "Graduation Year" required>
					<input type = "text" name = "bio" placeholder = "Short Bio">
					<input type = "text" name = "linkedin" placeholder = "LinkedIn URL" required>
					<h3>Resume Upload (.pdf or .doc)</h3>
					<input type = 'file' name = 'resume' required>
					<h3>Headshot Upload</h3>
					<input type = 'file' name = 'headshot' ><br><br>
					<input type = "submit" value = "Add New Member" name="submit" >
					</form>
				</div>
				<?php include 'add_member.php'; ?>
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
						<form method="post">
							<?php
								require_once 'config.php';
				                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

				                if($mysqli -> connect_error){
				                    die("Connection failed: " . $mysqli->connect_error);
				                }

				                $become_content = $mysqli->query("SELECT * FROM Site_content WHERE content_name = 'become_a_member'");
				                $content = $become_content->fetch_assoc();
			            		$text = $content['Content'];
							?>
							
							<p>
								<label>New Message:</label>
								<textarea class="edit_input" name="new_member_message" rows="1" maxlength="2000" required><?php echo $text;?></textarea>
							</p>
							<p>
								<input class="check_box" type="checkbox" name="become_member_check" required><label class="check_box_label black_text">Confirm Changes</label>
								<input type="submit" name="become_member_submit" value="Submit Changes" id="subm">
							</p>
							<p>
								<?php echo $_SESSION['become_member_edit_message']; unset($_SESSION['become_member_edit_message']);?>
							</p>
							<br/>
						</form>
						<div id="apply_now_sec">
								<a href = "app_form.php"><input type = "submit"  value="Apply Now" id="subm"></a>
						</div>

						<?php
							if(isset($_POST['become_member_submit']) && isset($_POST['become_member_check'])){
				                $new_message = filter_input(INPUT_POST, "new_member_message", FILTER_SANITIZE_STRING);

				                $stmt = $mysqli->prepare("UPDATE Site_content SET Content = ? WHERE content_name = 'become_a_member'");
				                $stmt->bind_param("s", $new_message);

								// set parameters and execute
								$new_message = filter_input(INPUT_POST, "new_member_message", FILTER_SANITIZE_STRING);
								$stmt->execute();
								$st1 = $stmt->close();
								$mysqli->close();

				               	unset($_SESSION['become_member_edit_message']);
				                if($st1){
				                	$_SESSION['become_member_edit_message'] = "Succesfully Updated Message";
				                	header("location: admin_page.php");
			                		exit();
				                }
				                else{
				                	$_SESSION['become_member_edit_message'] = "Failed to edit 'Become A Member' content";
				                	header("location: admin_page.php");
			                		exit();
								}	
							}
						?>
					</div>
				</div>
			</div>

			<div class="container-fluid section" id="contact_us">
				<div class="row">
					<div class="col-lg-12" id="new_contact_us_info">
						<h2>Contact Us</h2>
							<form method="POST">
								<?php
									require_once 'config.php';
			                        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

			                        if($mysqli -> connect_error){
			                            die("Connection failed: " . $mysqli->connect_error);
			                        }
			                        $content = $mysqli->query("SELECT * FROM Site_content WHERE content_name = 'contact_email_recipient'");
	                        		$entry = $content->fetch_assoc();
	                        		$email = $entry['Content'];

	                        		$mysqli->close();
								?>
								<div id='contact_us_current'>
									<p>Current Email Receiving Messages: <?php echo $email;?></p>
								</div>	
								<div>
									<p><label>New Email Address:</label><input type="text" name="new_address" placeholder="example@cornell.edu" maxlength="100" required></p>
									<input class="check_box" type="checkbox" name="contact_us_check" required><label class="check_box_label">Confirm Changes</label>
									<input type="submit" name="contact_us_submit" value="Submit Changes" id="subm">
								</div>
								<?php
									if(isset($_SESSION['contact_us_edit_message'])){
										$contact_us_message = $_SESSION['contact_us_edit_message'];
										echo ("<p class='changes_message'>$contact_us_message</p>");
										unset($_SESSION['contact_us_edit_message']);
									}
								?>
							</form>
							<?php
								if(isset($_POST['contact_us_submit']) && isset($_POST['contact_us_check'])){
									require_once 'config.php';
					                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

					                if($mysqli -> connect_error){
					                    die("Connection failed: " . $mysqli->connect_error);
					                }

					                $new_email = filter_input(INPUT_POST, "new_address", FILTER_SANITIZE_STRING);

					                $validEmail = filter_var($new_email, FILTER_VALIDATE_EMAIL);

					                if($validEmail){
						                $stmt = $mysqli->prepare("UPDATE Site_content SET Content = ? WHERE content_name = 'contact_email_recipient'");
						                $stmt->bind_param("s", $new_email);

										// set parameters and execute
										$new_email = filter_input(INPUT_POST, "new_address", FILTER_SANITIZE_STRING);
										$stmt->execute();
										$st1 = $stmt->close();
										$mysqli->close();

						               	unset($_SESSION['contact_us_edit_message']);
						                if($st1){
						                	$_SESSION['contact_us_edit_message'] = "Succesfully Updated Email Recipient";
						                	header("location: admin_page.php");
					                		exit();
						                }
						                else{
						                	$_SESSION['contact_us_edit_message'] = "Failed to edit 'About Us' section(s)";
						                	header("location: admin_page.php");
					                		exit();
						                }
						            }
						            else{
						            	$mysqli->close();
						            	unset($_SESSION['contact_us_edit_message']);
					                	$_SESSION['contact_us_edit_message'] = "Invalid Email Address";
					                	header("location: admin_page.php");
				                		exit();
						            }
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
