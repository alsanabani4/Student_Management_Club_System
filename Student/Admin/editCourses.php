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
    if($row['role'] != "Admin" )
    {
        header('Location: logout.php');
    }
$courseName=$hour=$description="";

if (isset($_GET['id'])) {
    $id = (int) mysqli_real_escape_string($con, $_GET['id']);
    $id = is_numeric($id) ? $id : NULL;
    $query1 = "SELECT * FROM `courses` WHERE `course_ID` = $id";
    $result1 = mysqli_query($con, $query1);
    if (mysqli_num_rows($result1) == 1)
    {
        $row = mysqli_fetch_array($result1, MYSQLI_BOTH);
        $courseName=$row['course_name'];
        $hour=$row['course_hours'];
        $description=$row['course_description'];
        

    } 
    mysqli_free_result($result1);
}
else
{
    header('Location: viewCourses.php');
}

if(isset($_POST['submit'])){
    $alertStyle ="";
    $statusMsg="";

    // Server-side validation
    $errors = array();

    if(empty($_POST['courseName'])) {
        $errors[] = "Course name is required.";
    } else {
        $courseName = mysqli_real_escape_string($con, trim($_POST['courseName']));
    }

    if(empty($_POST['description'])) {
        $errors[] = "Description is required.";
    } else {
        $description = mysqli_real_escape_string($con, trim($_POST['description']));
    }
    if(empty($_POST['hour'])) {
        $errors[] = "Course hours is required.";
    } else {
        $hour = mysqli_real_escape_string($con, trim($_POST['hour']));
        if($hour<0)
        {
            $errors[] = "Course hours must be greater than 0."; 
        }
    }
    if(empty($errors)) {
        $query = mysqli_query($con, "UPDATE `courses` SET `course_name`='$courseName',`course_description`='$description',`course_hours`='$hour' WHERE `course_ID`=$id");
        
        if ($query) {
            $alertStyle ="alert alert-success";
            $statusMsg="Course updated Successfully!";
             // Clear form fields after successful submission
             $courseName=$hour=$description="";            
        } else {
            $alertStyle ="alert alert-danger";
            $statusMsg="An error occurred while adding the course.";
        }
    } else {
        // If there are validation errors, set the appropriate message
        $alertStyle ="alert alert-danger";
        $statusMsg = implode("<br>", $errors);
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
    <?php $page="courses"; include 'includes/leftMenu.php';?>
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
                                <h1>Course</h1>
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
                                <strong class="card-title"><h2 align="center">Edit Course</h2></strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?></div>                                     
                                    <form method="Post" action="">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Course Name</label>
                                                        <input id="" name="courseName" type="text" class="form-control cc-exp" value="<?= $courseName?>" Required  placeholder="Course Name">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                        <label for="x_card_code" class="control-label mb-1">Description</label>
                                                            <textarea id="" name="description" type="text" class="form-control cc-cvc" value="" Required  placeholder="Description"><?= $description?></textarea>
                                                            </div>
                                                <div class="col-6">
                                                    <label for="x_card_code" class="control-label mb-1">Hour</label>
                                                        <input id="" name="hour" type="number" class="form-control cc-cvc" value="<?= $hour?>" Required  placeholder="Hour">
                                                        </div>
                                                    </div>
                                                  
                                                 
                                           
                                      
                                        
                                                 <div class="col-6">
                                                    <div class="form-group">
                                                   <div id='txtHint'></div>                                   
                                                 </div>
                                                 
                                                </div>
                                             </div>
										
                                                <button type="submit" name="submit" class="btn btn-success">Update  Course</button>
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
                                <strong class="card-title"><h2 align="center">All course</h2></strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>CourseName</th>
                                            <th>Hour</th>
                                    
                                            <th>Description</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                $result=mysqli_query($con,"SELECT * FROM `courses`");
                                while ($row=mysqli_fetch_array($result))
                                {
                                ?>
                                <tr>
                                    <td><?= $row['course_ID'];?></td>
                                    <td><?= $row['course_name'];?></td>
                                    <td><?= $row['course_description'];?></td>
                                    <td><?= $row['course_hours'];?></td>
                                    <td><a href="editCourses.php?id=<?= $row['course_ID']; ?>" title="Edit Course"><i class="fa fa-edit fa-1x"></i></a>
                                            <a onclick="return confirm('Are you sure you want to delete?')" href="#?id=<?= $row['course_ID']; ?>" title="Delete Course"><i class="fa fa-trash fa-1x"></i></a>
                                        </td>
                                
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
