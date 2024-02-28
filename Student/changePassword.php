<?php
include('includes/dbconnection.php');
error_reporting(0);

session_start(); // Start the session
if(!isset($_SESSION['changePass']) || !isset($_SESSION['checked']))
{
    header('Location: Login.php');
}

else{
if(isset($_POST['submit'])) {
    // Retrieve new password and confirm password from form
    $newPass = mysqli_real_escape_string($con,$_POST['newPass']);
    $confirmPass = mysqli_real_escape_string($con,$_POST['confirmPass']);
    
    // Validate new password and confirm password
    if($newPass != $confirmPass) {
        echo "<script>alert('New password and confirm password do not match.');</script>";
    } else {
        // Retrieve username from session
        $username = $_SESSION['changePass'];

        // Update password in the database
        $newPass=md5($newPass);
        $query = "UPDATE employees SET password = '$newPass' WHERE username = '$username'";
        $result = mysqli_query($con, $query);

        if($result) {
            // Password updated successfully, destroy the session
            $_SESSION[]=array();
            session_destroy();
            echo "<script>alert('Password updated successfully.');</script>";
            header("Location: Login.php");
        } else {
            echo "<script>alert('Error updating password. Please try again.');</script>";
        }
    }
}
}
?>



<!doctype html>
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Student Management Club System</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon">
    <!-- <link rel="shortcut icon" href="img/favicon2.jpeg" /> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style2.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
</head>
<body class="bg-light">

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.html">
                        <!-- <img class="align-content" src="images/adminGreen.jpg" alt=""> -->
                    </a>
                </div>
                <div class="login-form">
                    <form method="Post" Action="">
                               <strong><h2 align="center">Change Password</h2></strong><hr>
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="newPass" Required class="form-control" placeholder="New Password">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirmPass" Required class="form-control" placeholder="Confirm Password">
                        </div>
                        
                        <br>
                        <button type="submit" name="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Submit</button>
						
						
						
                        <!-- <div class="social-login-content">
                            <div class="social-button">
                                <button type="button" class="btn social facebook btn-flat btn-addon mb-3"><i class="ti-facebook"></i>Sign in with facebook</button>
                                <button type="button" class="btn social twitter btn-flat btn-addon mt-2"><i class="ti-twitter"></i>Sign in with twitter</button>
                            </div>
                        </div> -->
                        <!-- <div class="register-link m-t-15 text-center">
                            <p>Don't have account ? <a href="#"> Sign Up Here</a></p>
                        </div> -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>

</body>
</html>
