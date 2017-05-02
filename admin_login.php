<!-- username: admin123
	 password: password -->

<?php session_start();?>
<!DOCTYPE html>
<html>
	<head lang = "en">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width = device-width, initial-scale = 1">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="styling/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="styling/stylesheet.css?v=11198765678152">
		<link rel="icon" href="images/browser_icon.ico">
		<title>GCC - Login</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script> 
	</head>
	<body>
		<nav>
			<div id="icon">
				<a href="index.php"><img id="gcc_icon" src="images/gcc_gen.png" alt="gcc_icon"></a>
			</div>
			<div id="tabs">
				<?php
					if(isset($_SESSION['logged_user'])){
						echo "<a href='logout.php'>Logout</a>";
						echo "<a href='admin_page.php'>Admin Page</a>";
					}
				?>
				<a href="index.php">Return to Homepage</a>
			</div>
		</nav>
		<div class="container-fluid" id="content">
			<div class="container-fluid section" id="login_form">
				<h2>GCC Administrator Login</h2>
				<form method = "post" id = "admin_login_form">
					<label>Username</label>
	                <input type="text" name="username" required>
	                <label>Password</label>
	                <input type="password" name="password" required>
					<input type="submit" name="login-submit" value="Sign in">
				</form>

				<div class='login_message'>
					<?php
						if(isset($_SESSION['login_message'])){
							echo $_SESSION['login_message'];
						}
					?>
				</div>
			</div>
		</div>
		<?php
			if(isset($_POST['login-submit'])){
				if(!(isset($_SESSION['logged_user']))){
					$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
                    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

                    if(!(empty($username) || empty($password))){
                    	require_once 'config.php';
                        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                                
                        if($mysqli -> connect_error){
                            die("Connection failed: " . $mysqli->connect_error);
                        }
                        $get_user = $mysqli->query("SELECT * FROM Admin_login WHERE username='$username'");

                        if(mysqli_num_rows($get_user) < 1){
                        	$_SESSION['login_message'] = "<p>Invalid Login Credentials</p>";
                        	header("location: admin_login.php");
                			exit();
                        }
                        else{
	                        $user = $get_user->fetch_assoc();
	                        $actual_pass = $user["hashpassword"];
	                        $user_name = $user["name"];

	                        $valid_pass = password_verify($password, $actual_pass);
	                        if($valid_pass){
	                            $_SESSION['login_message'] = "<p>Welcome, $user_name</p>";
	                            $_SESSION['logged_user'] = $username;
	                            header("location: admin_login.php");
                				exit();
	                        }
	                        else{
	                        	$_SESSION['login_message'] = "<p>Invalid Login Credentials</p>";
	                        	header("location: admin_login.php");
                				exit();
	                        }
	                    }
                        $mysqli->close();
                    }
                    else{
                    	$_SESSION['login_message'] = "<p>Invalid Login Credentials</p>";
                    	header("location: admin_login.php");
                				exit();
                    }
				}  
				else{
					$user = $_SESSION['logged_user'];
					$_SESSION['login_message'] = "<p>Signed in as $user</p>";
					header("location: admin_login.php");
					exit();
				}
			}
		?>
	</body>
</html>