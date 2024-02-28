<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('Location: ../Login.php');
}
else{
error_reporting(0);
include('../includes/dbconnection.php');
$user=$_SESSION['username'];
$result = mysqli_query($con, "SELECT * FROM `employees` WHERE username = '$user'");
$row = mysqli_fetch_array($result);
if($row['role'] != "Controller" )
{
    header('Location: logout.php');
}

$firstname = "";
$lastname = "";
$course_name =  "";
$descriptionn = "";
$mark = "";
if (isset($_GET['id'])) {
    $id = (int) mysqli_real_escape_string($con, $_GET['id']);
    $id = is_numeric($id) ? $id : NULL;
    $query1 = "SELECT m.mark_ID, m.mark, m.description, m.course_ID, s.first_name,m.student_ID, s.last_name, c.course_name
    from marks m
    INNER JOIN students s ON s.student_ID = m.student_ID
    INNER JOIN courses c ON c.course_ID = m.course_ID where m.mark_ID = $id";
    $result1 = mysqli_query($con, $query1);
    if (mysqli_num_rows($result1) == 1) {
        $row = mysqli_fetch_array($result1, MYSQLI_BOTH);
        $firstname = $row['first_name'];
        $lastname = $row['last_name'];
        $course_name =  $row['course_name'];
        $descriptionn = $row['description'];
        $mark = $row['mark'];
    }

    mysqli_free_result($result1);
}
if (isset($_POST['submit'])) {
    $alertStyle = "";
    $statusMsg = "";

    // Server-side validation
    $errors = array();



    if (empty($_POST['descriptionn'])) {
        $errors[] = "Description is required.";
    } else {
        $descriptionn = mysqli_real_escape_string($con, trim($_POST['descriptionn']));
    }

    if (empty($_POST['mark'])) {
        $errors[] = "Mark is required.";
    } else {
        $mark = mysqli_real_escape_string($con, trim($_POST['mark']));
    }



    if (empty($errors)) {
        $query = mysqli_query($con, "UPDATE `marks` SET `mark`='$mark',`description`='$descriptionn' WHERE mark_ID = $id ");

        if ($query) {
            $alertStyle = "alert alert-success";
            $statusMsg = "Mark Update Successfully!";
            $descriptionn = "";
            $mark = "";
            $firstname = "";
            $lastname = "";
            $course_name = "";
        } else {
            $alertStyle = "alert alert-danger";
            $statusMsg = "An error occurred while updating the student mark.";
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


</head>

<body>
    <!-- Left Panel -->
    <?php $page = "result";
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
                                <h1>Score</h1>
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
                                    <h2 align="center">Update Score</h2>
                                </strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                        <div class="<?php echo $alertStyle; ?>" role="alert"><?php echo $statusMsg; ?><div>
                                                <form method="Post" action="">
                                                    <div class="row">




                                                        <div class="col-6">


                                                            <div class="form-group">
                                                                <label for="x_card_code" class="control-label mb-1">student Name</label>
                                                                <input id="student_name" name="student_name" type="text" class="form-control cc-exp" value="<?php echo $firstname . ' ' . $lastname; ?>" placeholder="Firstname">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="x_card_code" class="control-label mb-1">course Name</label>
                                                                <input id="student_name" name="student_name" type="text" class="form-control cc-exp" value="<?php echo $course_name; ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">




                                                        <div class="col-6">

                                                            <div class="form-group">

                                                                <label for="x_card_code" class="control-label mb-1">Score</label>
                                                                <input id="mark" name="mark" type="text" class="form-control cc-cvc" value="<?php echo $mark; ?>" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-cvc="Please enter a valid security code" placeholder="score">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">

                                                            <div class="form-group">
                                                                <label for="x_card_code" class="control-label mb-1" style="padding-top:15px;">Description</label>
                                                                <textarea id="" name="descriptionn" type="text" class="form-control cc-cvc" value="" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-cvc="Please enter a valid security code" placeholder="Description"><?= $descriptionn ?></textarea>
                                                            </div>
                                                        </div>



                                                    </div>




                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <div id='txtHint'></div>
                                                        </div>

                                                    </div>
                                            </div>
                                            <button type="submit" name="submit" class="btn btn-success">Update Score</button>
                                        </div>
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
                                    <h2 align="center">All Score</h2>
                                </strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>

                                            <th>ScoreID</th>
                                            <th>FullName</th>

                                            <th>courseName</th>
                                            <th>Mark</th>
                                            <th>Description</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $ret = mysqli_query($con, "SELECT m.mark_ID,m.mark,m.description, s.first_name, s.last_name, c.course_name
                    from marks m
                    INNER JOIN students s ON s.student_ID = m.student_ID
                    INNER JOIN courses c ON c.course_ID = m.course_ID");

                                        while ($row = mysqli_fetch_array($ret)) {
                                        ?>
                                            <tr>

                                                <td><?php echo $row['mark_ID']; ?></td>
                                                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>

                                                <td><?php echo $row['course_name']; ?></td>
                                                <td><?php echo $row['mark']; ?></td>
                                                <td><?php echo $row['description']; ?></td>
                                                <td><a href="editScore.php?id=<?= $row['mark_ID']; ?>" title="Edit mark"><i class="fa fa-edit fa-1x"></i></a>
                                                    <a onclick="return confirm('Are you sure you want to delete?')" href="deleteScore?id=<?= $row['mark_ID']; ?>" title="Delete mark"><i class="fa fa-trash fa-1x"></i></a>
                                                </td>


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

</body>

</html>