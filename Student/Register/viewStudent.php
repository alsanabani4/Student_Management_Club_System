<?php
session_start();
if(!isset($_SESSION['username']))
{
    header('Location: ../Login.php');
}
else
{
include('../includes/dbconnection.php');
error_reporting(0);
$user=$_SESSION['username'];
$result = mysqli_query($con, "SELECT * FROM `employees` WHERE username = '$user'");
$row = mysqli_fetch_array($result);
if($row['role'] != "Registration" )
{
    header('Location: logout.php');
}
// Check if delete parameter exists and its value
$delete = isset($_GET['delete']) ? $_GET['delete'] : '';

// Display message based on delete parameter
if ($delete == 'success') {
    $alertStyle = "alert alert-success";
    $statusMsg = "Student deleted successfully.";
    header("refresh:2; url=viewStudent.php");
} elseif ($delete == 'fail') {
    $alertStyle = "alert alert-danger";
    $statusMsg = "Failed to delete student. Please try again.";
}
elseif ($delete == 'assigned') {
    $alertStyle ="alert alert-danger";
    $statusMsg = "This student is already assigned to a course.";
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
    <?php $page="student"; include 'includes/leftMenu.php';?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
    <?php include 'includes/header.php';?>
        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Students</h1>
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
                <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"><h2 align="center">All Students</h2></strong>
                            </div>
                            <div class="card-body">
                            <div  class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>

                                <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>FullName</th>
                                            <th>PhoneNo</th>
                                            <th>ParentPhone</th>
                                            <th>DOB</th>
                                            <th>Gender</th>
                                            <th>Address</th>
                                            <th>Actions</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                $result=mysqli_query($con,"SELECT * FROM `students`");
                                while ($row=mysqli_fetch_array($result))
                                {
                                ?>
                                <tr>
                                    <td><?= $row['student_ID'];?></td>
                                    <td><?= $row['first_name'].' '.$row['last_name'];?></td>
                                    <td><?= $row['phone'];?></td>
                                    <td><?= $row['parentNumber'];?></td>
                                    <td><?= $row['birthdate'];?></td>
                                    <td><?= $row['gender'];?></td>
                                    <td><?= $row['address'];?></td>
                                    <td><a href="editStudent.php?id=<?=$row['student_ID'];?>" title="Edit Student"><i class="fa fa-edit fa-1x"></i></a>
                    <a onclick="return confirm('Are you sure you want to delete?')" href="deleteStudent?id=<?= $row['student_ID'];?>" title="Delete Student "><i class="fa fa-trash fa-1x"></i></a></td>
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

    <footer class="site-footer">
        <div class="footer-inner bg-white">
            <div class="row">
                <div class="col-sm-6">
                    &copy; <strong><span>Student Management Club System</span></strong> -  - Developed By Idea Soft Team
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
      } );

      // Menu Trigger
      $('#menuToggle').on('click', function(event) {
            var windowWidth = $(window).width();   		 
            if (windowWidth<1010) { 
                $('body').removeClass('open'); 
                if (windowWidth<760){ 
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
