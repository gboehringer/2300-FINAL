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
          move_uploaded_file($tmp, "members/headshots/$headshotName");
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
        move_uploaded_file($tmp, "members/resumes/$resumeName");

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
      if (!empty($_POST['bio'])){
          if (ctype_alnum($_POST['bio'])){
            $bio = validate($_POST['bio']);
          }
          else{
            echo ("Please enter a valid net id");
            return;
              }    
      }
      else{
        $bio = " ";
          }         

      if (!empty($_POST['linkedin'])){
          $link = validate($_POST['linkedin']);
          
      }      

      $pathheadshot = "$headshotName";
      $pathresume = "$resumeName";
      $add = "INSERT INTO Members (net_id,firstName,lastName,middleName,grad_year,major,headshot_path,resume_path,bio,linkedin_path) VALUES('$net','$firstname','$lastname','$middlename','$year','$major','$pathheadshot','$pathresume','$bio','$link')";
      //Inserts data into Applicants Database
      if($mysqli->query($add)){
        $app = mysqli_insert_id($mysqli);
        echo ("<h3>New Member Added</h3>");
      }
      else{
        echo("Invalid Entry. Please resubmit your new member's information.");
      }
    }
    



}



?>
