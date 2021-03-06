<!DOCTYPE html>
<?php session_start();?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width = device-width, initial-scale = 1">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="styling/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="styling/stylesheet.css?v=19998235432678152">
		<link rel="icon" href="images/browser_icon.ico">
		<title>GCC</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
	</head>
	<body>
		<nav>
			<div id="icon">
				<a href="index.php"><img id="gcc_icon_nav" src="images/gcc_gen.png" alt="gcc_icon"></a>
			</div>
			<div id="tabs">
				<a href="index.php">Return to Homepage</a>
			</div>
		</nav>
		<div class="container-fluid" id="content">

            <?php
                if(isset($_SESSION['logged_user'])){
                    echo("<div class = 'container-fluid section' id = 'view_app'>");
                    echo("<h2>Current Applicants: Click on Profile Picture to view resume</h2>");
                        echo("<div class='row' id='app_list'>");
                        require_once 'config.php';
                        $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
                        $allapps = $mysqli->query("SELECT * FROM Applicants");
                        while($row = $allapps->fetch_assoc()){
                            print("<div class='col-lg-3 col-md-3 col-sm-4 col-xs-6 member_profile'>");
                            $img_src = $row['headshot_path'];
                            $first_name = $row['firstName'];
                            $last_name = $row['lastName'];
                            $class = $row['grad_year'];
                            $major = $row['major'];
                            $href = $row['resume_path'];
                            print("<a href='$href' title='resume'><img src='$img_src' alt='profile picture' class='member_headshot'></a>");
                            print("<p><b>$first_name $last_name</b></p>");
                            print("<p>Class of $class</p>");
                            print("<p>Major: $major</p>");
                            print( '</div>' );
                            }
                            print( '</div>' );
                        print( '</div>' );
                    }
                ?>


            <?php
                if(isset($_SESSION['logged_user'])){
                    echo("<h3>Delete Applicant Data</h3>");
                    echo('<form method="post">
                    <input type="submit" name = "Delete" value="Delete">
                    </form');
                    if (isset($_POST['Delete'])) {
                        require_once 'config.php';
                        $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
                        $del = "TRUNCATE TABLE Applicants";
                        echo("<h3>Applicants Deleted</h3>");

                        }
                    }
                ?>
            </div>
			<div class="container-fluid section" id="app_form">
				<!--This application form will be used during the GCC recruitment season. We will allow logged in Admin
				users to either display the form during their recruitment season or hide the form when they are no longer
				recruiting. When the form is active we will use mysqli to add the information to the Applicants table.
				Admins will also be able to display and sort the applicant data from the database-->

				<h2>GCC Application Form</h2>
				<form method = "post" enctype = 'multipart/form-data'  id = "application">
				<input type = "text" name = "firstname" placeholder = "First Name" required>
				<input type = "text" name = "middlename" placeholder = "Middle Name - Optional">
				<input type = "text" name = "lastname" placeholder = "Last Name" required>
				<input type = "text" name = "major" placeholder = "Major" required>
				<input type = "text" name = "net_id" placeholder = "Net ID" required>
				<input type = "text" name = "year" placeholder = "Graduation Year" required>
				<h4>Resume Upload (.pdf or .doc)</h4>
				<input type = 'file' name = 'resume' required>
				<h4>Headshot Upload</h4>
				<input type = 'file' name = 'headshot' >
				<h4>Submit Application</h4>
				<input type = "submit" value = "Apply" name="submit" >
				</form>
			</div>
		</div>

		<?php
			require_once 'config.php';
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            if($mysqli -> connect_error){
                die("Connection failed: " . $mysqli->connect_error);
                }

			function validate($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}

		// Checks if form was submitted
 		if (isset($_POST['submit'])) {
 			//Validates that file is an image
 			if (!empty($_FILES['headshot']['tmp_name']) && !($_FILES['headshot']['error'] >0) && ($_FILES['headshot']['size'] < 5242880)) {

            	if (@getimagesize($_FILES['headshot']['tmp_name']) ===FALSE){
                	die("Invalid File Type");
                	return;
            	}
            	else{
    		    	$newImage = $_FILES['headshot'];
                	$tmp = $newImage['tmp_name'];
    		    	$headshotName = $newImage['name'];
    		    	$headshotName = filter_var($headshotName, FILTER_SANITIZE_URL);
			    	move_uploaded_file($tmp, "applicants/headshots/$headshotName");
				}
            }
            else{
                $headshotName = 'default.png';
            }

			//Validates that file is a pdf or doc
 			if (!empty($_FILES['resume']['tmp_name']) && !($_FILES['resume']['error'] >0) && ($_FILES['resume']['size'] < 5242880)) {
 					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					$mime = finfo_file($finfo, $_FILES['resume']['tmp_name']);
					switch ($mime) {
						case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
							break;
   						case 'application/doc':
   							break;
   						case 'application/pdf':
   							break;
               			default:
                			die("Invalid File Type");
                			return;
            	}
    		    	$newImage = $_FILES['resume'];
               		$tmp = $newImage['tmp_name'];
    		    	$resumeName = $newImage['name'];
    		    	$resumeName = filter_var($resumeName, FILTER_SANITIZE_URL);
			    	move_uploaded_file($tmp, "applicants/resumes/$resumeName");

			//Validation for net_id
            if (!empty($_POST['net_id'])){
    			if (ctype_alnum($_POST['net_id'])){
                	$net = validate($_POST['net_id']);
            	}
                else{
                    echo ("Please enter a valid net id");
                    return;
                }
       		}

       		//validation for first name
            if (!empty($_POST['firstname'])){
    			if (ctype_alpha($_POST['firstname'])){
                	$firstname = validate($_POST['firstname']);
            	}
            	else{
            		echo ("Please enter a valid first name");
            		return;
            	}
       		}

       		//validation for middle name
            if (!empty($_POST['middlename'])){
    			if (ctype_alpha($_POST['middlename'])){
                	$middlename = validate($_POST['middlename']);
            	}
        	}
        		else{
            		$middlename = "N/A";
            	}
			//validation for major
            if (!empty($_POST['major'])){
    			if (preg_match('/^[a-zA-Z\s]+$/', $_POST['major'])){
                	$major = validate($_POST['major']);
            }
             	else{
            		echo ("Please enter a valid major or 'Undecided'");
            		return;
            	}
        	}

        	//validation for last name
            if (!empty($_POST['lastname'])){
    			if (ctype_alpha($_POST['lastname'])){
                	$lastname = validate($_POST['lastname']);
            	}
            	else{
            		echo ("Please enter a valid last name");
            		return;
            	}
        	}
        	//validation for year
            if (!empty($_POST['year'])){
    			if (ctype_digit($_POST['year'])){
                	$year = validate($_POST['year']);
            	}
            	else{
            		echo ("Invalid graduation year entered");
            		return;
            	}
        	}

        	$date = date('Y-m-d H:i:s');
        	$pathheadshot = "applicants/headshots/$headshotName";
        	$pathresume = "applicants/resumes/$resumeName";
        	$add = "INSERT INTO Applicants (net_id,firstName,lastName,middleName,grad_year,major,date_applied,headshot_path,resume_path) VALUES('$net','$firstname','$lastname','$middlename','$year','$major','$date','$pathheadshot','$pathresume')";
        	//Inserts data into Applicants Database
        	if($mysqli->query($add)){
        		$app = mysqli_insert_id($mysqli);
        		echo ("<h3>Application Submitted</h3>");
        	}
        	else{
        		echo("Invalid Entry. Please resubmit your application.");
        	}
        }


	   }





		?>



	</body>
</html>
