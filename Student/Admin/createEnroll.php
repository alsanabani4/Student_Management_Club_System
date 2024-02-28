<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('Location: ../Login.php');
}
else{

    include('../includes/dbconnection.php');

    error_reporting(0);
    $user=$_SESSION['username'];
    $result = mysqli_query($con, "SELECT * FROM `employees` WHERE username = '$user'");
    $row = mysqli_fetch_array($result);
    if($row['role'] != "Admin" )
    {
        header('Location: logout.php');
    }

if (isset($_GET['id'])) {
    $id = (int) mysqli_real_escape_string($con, $_GET['id']);
    $id = is_numeric($id) ? $id : NULL;
    $query1 = "SELECT first_name, last_name FROM `students` WHERE `student_ID` = $id";
    $result1 = mysqli_query($con, $query1);
    if (mysqli_num_rows($result1) == 1) {
        $row = mysqli_fetch_array($result1, MYSQLI_BOTH);
        $firstname = $row['first_name'];
        $lastname = $row['last_name'];

        mysqli_free_result($result1);
    }
}


$course_ID = $_POST['course_ID'];
$session_ID = $_POST['session_ID'];

if (isset($_POST['submit'])) {
    $alertStyle = "";
    $statusMsg = "";

    // Server-side validation
    $errors = array();


    if (empty($_POST['course_ID'])) {
        $errors[] = "course is required.";
    } else {
        $course_ID = mysqli_real_escape_string($con, trim($_POST['course_ID']));
    }

    if (empty($_POST['session_ID'])) {
        $errors[] = "session is required.";
    } else {
        $session_ID = mysqli_real_escape_string($con, trim($_POST['session_ID']));
    }



    $checkQuery = mysqli_query($con, "SELECT * FROM `student_course_association` WHERE `student_ID` = '$id' AND `course_ID` = '$course_ID'");
    if (mysqli_num_rows($checkQuery) > 0) {
        $errors[] = "This Student already has the same Course.";
    }

    if (empty($errors)) {
        $query = mysqli_query($con, "INSERT INTO student_course_association (student_ID, course_ID, session_ID) VALUES ('$id','$course_ID','$session_ID')");

        if ($query) {

            $alertStyle = "alert alert-success";
            $statusMsg = "Course Enrollment Added Successfully!";


            $course_ID = "";
            $session_ID = "";
            $firstname = "";
            $lastname = "";
            header("refresh:4; url=createEnroll.php");
        } else {


            $alertStyle = "alert alert-danger";
            $statusMsg = "An error occurred while adding the Course enrollment.";
        }
    } else {
        // If there are validation errors, set the appropriate message
        $alertStyle = "alert alert-danger";
        $statusMsg = implode("<br>", $errors);
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
    <?php include 'includes/title.php'; ?>
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

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <script>
        function validate() {

            var session_ID = document.myform.session_ID.value;
            if (session_ID == "") {
                alert("There is no session for the selected course , please select another course ")
                document.myform.session_ID.focus();
                return false;
            } else {
                return true;
            }
        }
    </script>
</head>

<body>
    <!-- Left Panel -->
    <?php $page = "student";
    include 'includes/leftMenu.php'; ?>

    <!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <?php include 'includes/header.php'; ?>
        <!-- /header -->
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Dashboard</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Student</a></li>
                                    <li class="active">Add Student</li>
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
                                    <h2 align="center">Add New course for Student</h2>
                                </strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                        <div class="<?php echo $alertStyle; ?>" role="alert"><?php echo $statusMsg; ?></div>
                                        <form method="Post" action="" name="myform" onsubmit="return validate()">


                                            <div class="row">





                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="x_card_code" class="control-label mb-1">student Name</label>
                                                        <input id="student_name" name="student_name" type="text" class="form-control cc-exp" value="<?php echo $firstname . ' ' . $lastname; ?>" placeholder="Firstname">
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
                                                        <div class="form-group" style="padding-left:20px; padding-bottom:20px;">
                                                            <label for="x_card_code" class="control-label mb-1">session</label>
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
                                            <button type="submit" name="submit" class="btn btn-success">Add New Enrollment</button>
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
                                    <h2 align="center">All Student</h2>
                                </strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>

                                            <th>ID</th>
                                            <th>StudentName</th>
                                            <th>Actions</th>



                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result = mysqli_query($con, "SELECT * FROM `students`");
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <tr>
                                                <td><?= $row['student_ID']; ?></td>
                                                <td><?= $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                                <td><a href="createEnroll.php?id=<?= $row['student_ID']; ?>" title="Enrollment"><i class="fa fa-edit fa-1x"></i></a>

                                            </tr>
                                        <?php
                                        }
                                        ?>


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

        <?php include 'includes/footer.php'; ?>


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