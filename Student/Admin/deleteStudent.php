<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('Location: ../Login.php');
}
else{
include('../includes/dbconnection.php');
$user=$_SESSION['username'];
$result = mysqli_query($con, "SELECT * FROM `employees` WHERE username = '$user'");
$row = mysqli_fetch_array($result);
if($row['role'] != "Admin" )
{
    header('Location: logout.php');
}


if(isset($_GET['id'])) {
    $id = (int) mysqli_real_escape_string($con, $_GET['id']);
    $id = is_numeric($id) ? $id : NULL;
    $checkAssignedQuery = mysqli_query($con, "SELECT * FROM `student_course_association` WHERE `student_ID` = '$id'");
        if (mysqli_num_rows($checkAssignedQuery) > 0) {
            header("Location: viewStudent.php?delete=assigned");
            exit();
        }
        else
        {
    $query = "DELETE FROM `students` WHERE `student_ID`= $id";
    $result = mysqli_query($con, $query);
    
    if ($result == true) {
        header("Location: viewStudent.php?delete=success");
        exit();
    } else {
        header("Location: viewStudent.php?delete=fail");
        exit();
    }
}
} else {
    header("Location: viewStudent.php");
    exit();
}
}
?>
