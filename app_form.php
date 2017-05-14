<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width = device-width, initial-scale = 1">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="styling/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="styling/stylesheet.css?v=11198765678152">
		<link rel="icon" href="images/browser_icon.ico">
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
				<!--This application form will be used during the GCC recruitment season. We will allow logged in Admin
				users to either display the form during their recruitment season or hide the form when they are no longer
				recruiting. When the form is active we will use mysqli to add the information to the Applicants table.
				Admins will also be able to display and sort the applicant data from the database-->
				
				<h2>GCC Application Form</h2>
				<form method = "post" id = "application">
				<input type = "text" name = "firstname" placeholder = "First Name" required>
				<input type = "text" name = "middlename" placeholder = "Middle Name - Optional">
				<input type = "text" name = "lastname" placeholder = "Last Name" required>
				<input type = "text" name = "major" placeholder = "Major" >
				<input type = "text" name = "net_id" placeholder = "Net ID" required>
				<select name="year" required="">
	  				<option value="Freshman">Freshman</option>
	 				<option value="Sophomore">Sophomore</option>
	  				<option value="Junior">Junior</option>
	  				<option value="Senior">Senior</option>
				</select>
				<h3>Resume Upload</h3>
				<input type = 'file' name = 'Resume' required>
				<h3>Headshot Upload</h3>
				<input type = 'file' name = 'Headshot' >
				<h3>Submit Application</h3>
				<input type = "submit" name="submit" >
				</form>
			</div>
		</div>
			
		<?php
			require_once 'config.php';
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            if($mysqli -> connect_error){
                die("Connection failed: " . $mysqli->connect_error);
                }

 		if (isset($_POST['submit'])) {
 			if (!empty($_FILES['Headshot']) && !($_FILES['Headshot']['error'] >0) && ($_FILES['Headshot']['size'] < 5242880)) {
            	$info = getimagesize($_FILES['Headshot']['tmp_name']);
            	if ($info ===FALSE){
                	echo "Invalid File Type";
            	}	
            	else{
    		    $newImage = $_FILES['Headshot'];
                $tmp = $newImage['tmp_name'];
    		    $headshotName = $newImage['name'];
    		    $headshotName = filter_var($headshotName, FILTER_SANITIZE_URL);
			    move_uploaded_file($tmp, "applicants/headshots/$headshotName");
			}

 			if (!empty($_FILES['Resume']) && !($_FILES['Resume']['error'] >0) && ($_FILES['Resume']['size'] < 5242880)) {
            	$info = getimagesize($_FILES['Resume']['tmp_name']);
            	if ($info ===FALSE){
                	echo "Invalid File Type";
            	}	
            	else{
    		    $newImage = $_FILES['Resume'];
                $tmp = $newImage['tmp_name'];
    		    $resumeName = $newImage['name'];
    		    $resumeName = filter_var($resumeName, FILTER_SANITIZE_URL);
			    move_uploaded_file($tmp, "applicants/resumes/$resumeName");
			}


            if (!empty($_POST['net_id'])){
    			if (ctype_alnum($_POST['net_id'])){
                	$net = $_POST['net_id'];
            	}
       		}

            if (!empty($_POST['firstname'])){
    			if (ctype_alpha($_POST['firstname'])){
                	$firstname = $_POST['firstname'];
            	}
       		}

            if (!empty($_POST['middlename'])){
    			if (ctype_alpha($_POST['middlename'])){
                	$middlename = $_POST['middlename'];
            }
            else{
            	$middlename = "";
            	}
        	}

            if (!empty($_POST['major'])){
    			if (ctype_alpha($_POST['major'])){
                	$major = $_POST['major'];
            }
            else{
            	$major = "No Major Listed";
            	}
        	}        	

            if (!empty($_POST['lastname'])){
    			if (ctype_alpha($_POST['lastname'])){
                	$lastname = $_POST['lastname'];
            	}
        	}

        	if(isset($_POST['year'])){
        		$year = $_POST['year'];
        	}
        }
        }
        	$date = date('Y-m-d H:i:s');
        	$pathheadshot = "applicants/headshots/$headshotName";	
        	$pathresume = "applicants/resumes/$resumeNamee";	
        	$add = "INSERT INTO Applicants (net_id,firstName,lastName,middleName,grad_year,major,date_applied,headshot_path,resume_path) VALUES($net,'$firstname','$lastname','$middlename','$year','$date','$pathheadshot','$pathresume')";
        	if($mysqli->query($add)){
        		$app = mysqli_insert_id($mysqli);
        		echo ("<h3>Application Submitted</h3>");
        	}

			function validate($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}        	

		}


    		
		?>


		
	</body>
</html>
