<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('Location: ../Login.php');
}
else{
include('../includes/dbconnection.php');
error_reporting(0);
//ini_set('display_errors', 1);
$user=$_SESSION['username'];
$result = mysqli_query($con, "SELECT * FROM `employees` WHERE username = '$user'");
$row = mysqli_fetch_array($result);
if($row['role'] != "Admin" )
{
    header('Location: logout.php');
}
$firstname = "";
$lastname = "";
$course_ID = "";
$session_ID = "";



if (isset($_GET['id'])) {
    $id = (int) mysqli_real_escape_string($con, $_GET['id']);
    $id = is_numeric($id) ? $id : NULL;
    $eid = (int) mysqli_real_escape_string($con, $_GET['eid']);
    $eid = is_numeric($eid) ? $eid : NULL;
    $cid = (int) mysqli_real_escape_string($con, $_GET['cid']);
    $cid = is_numeric($cid) ? $cid : NULL;
    $query1 = "SELECT e.student_association_ID ,e.course_ID, e.session_ID, s.first_name, s.last_name, c.course_name, sess.start_date,
    sess.end_date 
       from student_course_association e
       INNER JOIN students s ON s.student_ID = e.student_ID
       INNER JOIN courses c ON c.course_ID = e.course_ID
       INNER JOIN courses_session sess ON sess.session_ID = e.session_ID WHERE e.student_ID = $id AND  e.student_association_ID = $eid";
    $result1 = mysqli_query($con, $query1);

    if (mysqli_num_rows($result1) == 1) {
        $row = mysqli_fetch_array($result1, MYSQLI_BOTH);
        $firstname = $row['first_name'];
        $lastname = $row['last_name'];
        
    }
    mysqli_free_result($result1);
}
else{
    header("Location: viewEnroll.php");
}

if (isset($_POST['submit'])) {
    $alertStyle = "";
    $statusMsg = "";



    // Server-side validation
    $errors = array();

    if (empty($_POST['course_ID'])) {
        $errors[] = "Course is required.";
    } else {
        $course_ID = mysqli_real_escape_string($con, trim($_POST['course_ID']));
    }

    if (empty($_POST['session_ID'])) {
        $errors[] = "Session is required.";
    } else {
        $session_ID = mysqli_real_escape_string($con, trim($_POST['session_ID']));
    }

    // Check if the student already has the same course with the same session
    $checkQuery = mysqli_query($con, "SELECT * FROM `student_course_association` WHERE `student_ID` = '$id' AND `course_ID` = '$course_ID' AND `session_ID` = '$session_ID'");
    if (mysqli_num_rows($checkQuery) > 0) {
        $errors[] = "This student already has the same course with the same session.";

        header("refresh:4; url=editEnroll.php");
    }
    // Check if the session is assigned to any student in student_course table
    $checkAssignedQuery = mysqli_query($con, "SELECT * FROM `marks` WHERE course_ID = $cid AND student_ID= $id");
    if (mysqli_num_rows($checkAssignedQuery) > 0) {
        $alertStyle = "alert alert-danger";
        $statusMsg = "The student's course is already have mark.";

        header("refresh:4; url=editEnroll.php");
    } else {
        if (empty($errors)) {

            // Update the student's course and session
            $query = mysqli_query($con, "UPDATE student_course_association SET `course_ID` = '$course_ID', `session_ID` = '$session_ID' where `student_association_ID` = '$eid'");

            if ($query) {
                $alertStyle = "alert alert-success";
                $statusMsg = "Course Enrollment Updated Successfully!";

                header("refresh:4; url=editEnroll.php");
            } else {
                $alertStyle = "alert alert-danger";
                $statusMsg = "An error occurred while updating the Course enrollment.";

                header("refresh:4; url=editEnroll.php");
            }
        } else {
            // If there are validation errors, set the appropriate message
            $alertStyle = "alert alert-danger";
            $statusMsg = implode("<br>", $errors);
        }
    }
}
}
?>



<!doctype html>
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Student Management Club System</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="../assets/img/student-grade.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../assets/css/lib/datatable/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style23.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>
    <!-- Left Panel -->
    <?php $page = "studentcourses";
    include 'includes/leftMenu.php'; ?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php include 'includes/header.php'; ?>

        <!-- /#header -->
        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Enroll Course</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="index.php">Dashboard</a></li>

                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">
                                    <h2 align="center">Edit Course of Student</h2>
                                </strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                        <div class="<?php echo $alertStyle; ?>" role="alert"><?php echo $statusMsg; ?></div>
                                        <form method="Post" action="">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">

                                                        <label for="cc-exp" class="control-label mb-1">Student Name</label>
                                                        <input id="id" name="id" type="text" class="form-control cc-exp" value="<?php echo $firstname . ' ' . $lastname; ?>" Required data-val="true" data-val-required="Please enter the card expiration" data-val-cc-exp="Please enter a valid month and year" placeholder="Student Name">
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="x_card_code" class="control-label mb-1">courses</label>

                                                        <?php
                                                        $query = mysqli_query($con, "select * from courses");
                                                        $count = mysqli_num_rows($query);
                                                        if ($count > 0) {
                                                            echo ' <select name="course_ID" id="course_ID" onchange="showValues(this.value)" class="custom-select form-control">';
                                                            echo '<option value="">--Course--</option>';
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                echo '<option value="' . $row['course_ID'] . '" >' . $row['course_name'] . '</option>';
                                                            }
                                                            echo '</select>';
                                                        }
                                                        ?>


                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="x_card_code" class="control-label mb-1" style="padding-left:20px; padding-bottom:20px;">session</label>
                                                            <?php

                                                            echo ' <select name="session_ID" id="session_ID"  class="custom-select form-control"  >';
                                                            echo '<option value="">session of selected course</option>';
                                                            echo '</select>';

                                                            ?>
                                                        </div>


                                                    </div>

                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <?php
                                                            echo "<div id='txtHint'></div>";
                                                            ?>
                                                        </div>

                                                    </div>
                                                </div>


                                            </div>
                                            <button type="submit" name="submit" class="btn btn-success">Update </button>




                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- .card -->
                    </div><!--/.col-->

                    <br><br>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">
                                    <h2 align="center">All Enroll</h2>
                                </strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>

                                            <th>EnrollmentID</th>
                                            <th>studentID</th>
                                            <th>FullName</th>
                                            <th>courseName</th>
                                            <th>startDate</th>
                                            <th>endDate</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $ret = mysqli_query($con, "SELECT e.student_association_ID, s.first_name, s.last_name, c.course_name, sess.start_date,
                 sess.end_date,e.student_ID, e.course_ID
                    from student_course_association e
                    INNER JOIN students s ON s.student_ID = e.student_ID
                    INNER JOIN courses c ON c.course_ID = e.course_ID
                    INNER JOIN courses_session sess ON sess.session_ID = e.session_ID");

                                        while ($row = mysqli_fetch_array($ret)) {
                                        ?>
                                            <tr>

                                                <td><?php echo $row['student_association_ID']; ?></td>
                                                <td><?php echo $row['student_ID']; ?></td>
                                                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                                <td><?php echo $row['course_name']; ?></td>
                                                <td><?php echo $row['start_date']; ?></td>
                                                <td><?php echo $row['end_date']; ?></td>
                                                <td><a href="editEnroll.php?id=<?= $row['student_ID']; ?>&eid=<?= $row['student_association_ID']; ?>&cid=<?= $row['course_ID']; ?>" title="Edit Enrollment"><i class="fa fa-edit fa-1x"></i></a>
                                                    <a onclick="return confirm('Are you sure you want to delete?')" href="deleteEnroll?id=<?= $row['student_ID']; ?>&eid=<?= $row['student_association_ID']; ?>&cid=<?= $row['course_ID']; ?>" title="Delete Enrollment"><i class="fa fa-trash fa-1x"></i></a>
                                                </td>
                                            </tr>

                                            <?php

                                        } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end of datatable -->

                </div>
            </div><!-- .animated -->
        </div><!-- .content -->

        <div class="clearfix"></div>

        <footer class="site-footer">
            <div class="footer-inner bg-white">
                <div class="row">
                    <div class="col-sm-6">
                        &copy; <strong><span>Student Management Club System</span></strong> - - Developed By Idea Soft Team
                    </div>
                    <div class="col-sm-6 text-right">

                    </div>
                </div>
            </div>
        </footer>


    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <script src="../assets/js/lib/data-table/datatables.min.js"></script>
    <script src="../assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="../assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="../assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="../assets/js/lib/data-table/jszip.min.js"></script>
    <script src="../assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="../assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="../assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="../assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="../assets/js/init/datatables-init.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#bootstrap-data-table-export').DataTable();
        });

        // Menu Trigger
        $('#menuToggle').on('click', function(event) {
            var windowWidth = $(window).width();
            if (windowWidth < 1010) {
                $('body').removeClass('open');
                if (windowWidth < 760) {
                    $('#left-panel').slideToggle();
                } else {
                    $('#left-panel').toggleClass('open-menu');
                }
            } else {
                $('body').toggleClass('open');
                $('#left-panel').removeClass('open-menu');
            }

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#course_ID').change(function() {
                var courseID = $(this).val();
                $.ajax({
                    url: 'gete.php',
                    type: 'post',
                    data: {
                        course_ID: courseID
                    },
                    dataType: 'json',
                    success: function(response) {
                        var len = response.length;
                        $("#session_ID").empty();
                        // if(len==0){  $("#session_ID").append("<option value='" "'>"+  " no session "+ "</option>");}
                        // else{
                        for (var i = 0; i < len; i++) {

                            var id = response[i]['session_ID'];
                            var start_date = response[i]['start_date'];
                            var end_date = response[i]['end_date'];
                            $("#session_ID").append("<option value='" + id + "'>" + start_date + " - " + end_date + "</option>");
                        }
                        //  }
                    }
                });
            });
        });
    </script>


</body>

</html>