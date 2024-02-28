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
if($row['role'] != "Registration" )
{
    header('Location: logout.php');
}



if(isset($_GET['id'])) {
    $id = (int) mysqli_real_escape_string($con, $_GET['id']);
    $id = is_numeric($id) ? $id : NULL;


    $eid = (int) mysqli_real_escape_string($con, $_GET['eid']);
    $eid = is_numeric($eid) ? $eid : NULL;

    $cid = (int) mysqli_real_escape_string($con, $_GET['cid']);
    $cid = is_numeric($cid) ? $cid : NULL;

    $checkAssignedQuery = mysqli_query($con, "SELECT * FROM marks WHERE   course_ID = $cid AND student_ID = $id");
        if (mysqli_num_rows($checkAssignedQuery) > 0) {
            header("Location: viewEnroll.php?delete=assigned");
            exit();
        }
        else{
    
    $query = "DELETE FROM `student_course_association` WHERE `student_association_ID`= $eid";
    $result = mysqli_query($con, $query);
    
    if ($result == true) {
        header("Location: viewEnroll.php?delete=success");
        exit();
    } else {
        header("Location: viewEnroll.php?delete=fail");
        exit();
    }
}
} else {
    header("Location: viewEnroll.php");
    exit();
}
}
?>
