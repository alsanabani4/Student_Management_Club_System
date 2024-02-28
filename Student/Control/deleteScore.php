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
if($row['role'] != "Controller" )
{
    header('Location: logout.php');
}


if (isset($_GET['id'])) {
    $id = (int) mysqli_real_escape_string($con, $_GET['id']);
    $id = is_numeric($id) ? $id : NULL;



    $query = "DELETE FROM `marks` WHERE `mark_ID`= $id";
    $result = mysqli_query($con, $query);

    if ($result == true) {
        header("Location: viewScore.php?delete=success");
        exit();
    } else {
        header("Location: viewScore.php?delete=fail");
        exit();
    }
} else {
    header("Location: viewScore.php");
    exit();
}
}
?>