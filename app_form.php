<!DOCTYPE html>
<html>
	<head lang = "en">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width = device-width, initial-scale = 1">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="styling/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="styling/stylesheet.css?v=11198765678152">
		<title>GCC</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script> 
	</head>
	<body>
		<nav>
			<div id="icon">
				<a href="index.php"><img id="gcc_icon" src="images/gcc_gen.png" alt="gcc_icon"></a>
			</div>
			<div id="tabs">
				<a href="index.php">Return to Homepage</a>
			</div>
		</nav>
		<div class="container-fluid" id="content">
			<div class="container-fluid section" id="app_form">
			<h2>GCC Application Form</h2>
			<form method = "post" id = "application">
			<input type = "text" name = "firstname" placeholder = "First Name" required>
			<input type = "text" name = "firstname" placeholder = "Middle Name - Optional">
			<input type = "text" name = "lastname" placeholder = "Last Name" required>
			<select name="year">
  				<option value="Freshman">Freshman</option>
 				<option value="Sophomore">Sophomore</option>
  				<option value="Junior">Junior</option>
  				<option value="Senior">Senior</option>
			</select>
			<h3>Resume Upload</h3>
			<input type = 'file' name = 'Resume' required>
			<h3>Cover Letter Upload - Optional</h3>
			<input type = 'file' name = 'Optional Cover Letter'>
			<h3>Headshot Upload</h3>
			<input type = 'file' name = 'Headshot' >
			<h3>Submit Application</h3>
			<input type = "submit" name = "Submit Application">
			</form>
			</div>
		</div>
			
		
	</body>
</html>