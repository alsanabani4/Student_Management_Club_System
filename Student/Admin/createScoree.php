<?php

    include('../includes/dbconnection.php');
 
    error_reporting(0);
    
    if (isset($_GET['id'])) {
        $id = (int) mysqli_real_escape_string($con, $_GET['id']);
        $id = is_numeric($id) ? $id : NULL;
        $query1 = "SELECT e.student_association_ID,s.student_ID, s.first_name, s.last_name,c.course_ID, c.course_name
        from student_course_association e
        INNER JOIN students s ON s.student_ID = e.student_ID
        INNER JOIN courses c ON c.course_ID = e.course_ID where e.student_association_ID = $id";
        $result1 = mysqli_query($con, $query1);
        if (mysqli_num_rows($result1) == 1) {
            $row = mysqli_fetch_array($result1, MYSQLI_BOTH);
            $firstname = $row['first_name'];
            $lastname = $row['last_name'];
            $student_ID= $row['student_ID'];
            $course_ID=  $row['course_ID'];
            $course_name=  $row['course_name'];

        mysqli_free_result($result1);
    


 

    }
}
  
    $descriptionn="";
    $mark="";
    if(isset($_POST['submit'])){
        $alertStyle ="";
        $statusMsg="";
    
        // Server-side validation
        $errors = array();

        if(empty($_POST['student_ID'])) {
            $errors[] = "Student Id is required.";
        } else {
            $student_ID= mysqli_real_escape_string($con, trim($_POST['student_ID']));
        }
        if(empty($_POST['course_ID'])) {
            $errors[] = "course is required.";
        } else {
            $course_ID = mysqli_real_escape_string($con, trim($_POST['course_ID']));
        }
    
        if(empty($_POST['descriptionn'])) {
            $errors[] = "Description is required.";
        } else {
            $descriptionn = mysqli_real_escape_string($con, trim($_POST['descriptionn']));
        }
    
        if(empty($_POST['mark'])) {
            $errors[] = "Mark is required.";
        } else {
            $mark = mysqli_real_escape_string($con, trim($_POST['mark']));
        }
    
        
        $checkQuery = mysqli_query($con, "SELECT * FROM `marks` WHERE `student_ID` = '$student_ID' AND `course_ID` = '$course_ID'");
        if(mysqli_num_rows($checkQuery) > 0) {
            $errors[] = "This student already has the score in this course.";
        }
    
        if(empty($errors)) {
            $query = mysqli_query($con, "INSERT INTO `marks`(`student_ID`, `course_ID`, `descriptionn`, `mark`) VALUES ('$student_ID','$course_ID','$descriptionn' ,'$mark')");
            
            if ($query) {
                $alertStyle ="alert alert-success";
                $statusMsg="Mark Added Successfully!";
                $descriptionn="";
    $mark="";
            }
            else {
                $alertStyle ="alert alert-danger";
                $statusMsg="An error occurred while adding the student mark.";
            }
        } else {
            // If there are validation errors, set the appropriate message
            $alertStyle ="alert alert-danger";
            $statusMsg = implode("<br>", $errors);
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
    <link rel="stylesheet" href="../assets/css/style2.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
function showValues(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajaxCall2.php?fid="+str,true);
        xmlhttp.send();
    }
}
</script>


</head>
<body>
    <!-- Left Panel -->
    <?php $page="result"; include 'includes/leftMenu.php';?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
    <?php include 'includes/header.php';?>

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
								<!-- Log on to codeastro.com for more projects! -->
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
                                <strong class="card-title"><h2 align="center">Add New Score</h2></strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       <div class="<?php echo $alertStyle;?>" role="alert"><?php echo $statusMsg;?><div>
                                        <form method="Post" action="">
                                        <div class="row">
                                             
                                        
  
                                          
                                             <div class="col-6">
                                                 <div class="form-group">
                                                     <label for="x_card_code" class="control-label mb-1">student ID</label>
                                                     <input id="student_ID" name="student_ID" type="text" class="form-control cc-exp" value="<?php echo $student_ID?>" placeholder="select student from table"> 
                                                 </div>
                                             </div>
                                             <div class="col-6">
                                                 <div class="form-group">
                                                     <label for="x_card_code" class="control-label mb-1">student Name</label>
                                                     <input id="student_name" name="student_name" type="text" class="form-control cc-exp" value="<?php echo $firstname.' '.$lastname; ?>" placeholder="Firstname"> 
                                                 </div>
                                             </div>
                                         </div>
                                              
                                         <div class="row">
                                             
                                        
  
                                          
                                             <div class="col-6">
                                                 <div class="form-group">
                                                     <label for="x_card_code" class="control-label mb-1">course ID</label>
                                                     <input id="course_ID" name="course_ID" type="text" class="form-control cc-exp" value="<?php echo $course_ID;?>" placeholder="course"> 
                                                 </div>
                                             </div>
                                             <div class="col-6">
                                                 <div class="form-group">
                                                     <label for="x_card_code" class="control-label mb-1">course Name</label>
                                                     <input id="student_name" name="student_name" type="text" class="form-control cc-exp" value="<?php echo $course_name; ?>" placeholder="Firstname"> 
                                                 </div>
                                             </div>
                                         </div>
                                                    <div class="row">
                                                                <div class="col-6">

                                                                   
                                                                        <label for="x_card_code" class="control-label mb-1"  style="padding-top:15px;">Description</label>
                                                                            <textarea id="" name="descriptionn" type="text" class="form-control cc-cvc" value="" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-cvc="Please enter a valid security code" placeholder="Description"></textarea>
                                                                            </div>

                                                                            <div class="col-6">
												
                                                    <label for="x_card_code" class="control-label mb-1">Score</label>
                                                        <input id="mark" name="mark" type="text" class="form-control cc-cvc" value="" Required data-val="true" data-val-required="Please enter the security code" data-val-cc-cvc="Please enter a valid security code" placeholder="score">
                                                        </div>
                                                    </div>
                                                            </div>
                                                 
                                           
                                      
                                        
                                                 <div class="col-6">
                                                    <div class="form-group">
                                                   <div id='txtHint'></div>                                   
                                                 </div>
                                                 
                                                </div>
                                             </div>
										
                                                <button type="submit" name="submit" class="btn btn-success">Add Score</button>
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
                                <strong class="card-title"><h2 align="center">All Score</h2></strong>
                            </div>
                            <div class="card-body">
                            <table id="bootstrap-data-table" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                         
											<!-- Log on to codeastro.com for more projects! -->
                                            <th>ID</th>
                                            <th>StudentName</th>
                                            <th>courseName</th>
                                            <th>CourseID</th>
                                            <th>Actions</th>
                                           
                                            
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                $result=mysqli_query($con,"SELECT e.student_association_ID,e.student_ID, s.first_name, s.last_name,
                                e.course_ID, c.course_name
                                   from student_course_association e
                                   INNER JOIN students s ON s.student_ID = e.student_ID
                                   INNER JOIN courses c ON c.course_ID = e.course_ID");
                                while ($row=mysqli_fetch_array($result))
                                {
                                ?>
                                <tr>
                                    <td><?= $row['student_ID'];?></td>
                                    <td><?= $row['first_name'].' '.$row['last_name'];?></td>
                                    <td><?php  echo $row['course_name'];?></td>
                    <td><?php  echo $row['course_ID'];?></td>
                                    <td><a href="createScoree.php?id=<?= $row['student_association_ID']; ?>" title="Score"><i class="fa fa-edit fa-1x"></i></a>
                                           
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
