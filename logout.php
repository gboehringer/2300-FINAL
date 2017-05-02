<?php 
    session_start();
    if(isset($_SESSION['logged_user'])){
        $old_user = $_SESSION['logged_user'];
        unset($_SESSION['logged_user']);
        unset($_SESSION['login_message']);
        header("location: index.php");
        exit();
    }
    else{
        header("location: admin_login.php");
        exit();
    }
?>