<?php
$studentquery=mysqli_query($con,"SELECT * FROM `students`");
$totalStudents=mysqli_num_rows($studentquery);

$coursequery=mysqli_query($con,"SELECT * FROM `courses`");
$totalCourses=mysqli_num_rows($coursequery);

$employeequery=mysqli_query($con,"SELECT * FROM `employees`");
$totalEployees=mysqli_num_rows($employeequery);

$markquery=mysqli_query($con,"SELECT * FROM `marks`");
$totalStudentsMarks=mysqli_num_rows($markquery);

?>