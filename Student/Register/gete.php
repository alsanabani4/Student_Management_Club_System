<?php
// Database connection
$conn=mysqli_connect("localhost", "root", "", "student_db");
if(mysqli_connect_errno()){
    echo "Connection Fail".mysqli_connect_error(); 
}


// Check if course ID is sent via POST
if (isset($_POST['course_ID'])) {
    $courseID = $_POST['course_ID'];

    // Retrieve sessions for the selected course
    $query = "SELECT session_ID, start_date, end_date FROM courses_session WHERE course_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $courseID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch results and encode as JSON
    $courses_session = array();
    while ($row = $result->fetch_assoc()) {
        $courses_session[] = $row;
    }
    echo json_encode($courses_session);
}

?>