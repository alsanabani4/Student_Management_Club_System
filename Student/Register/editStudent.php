<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../Login.php');
} else {
    include('../includes/dbconnection.php');
    error_reporting(0);
    $user=$_SESSION['username'];
    $result = mysqli_query($con, "SELECT * FROM `employees` WHERE username = '$user'");
    $row = mysqli_fetch_array($result);
    if($row['role'] != "Registration" )
    {
        header('Location: logout.php');
    }
    // Initialize variables to store form data
    $firstname = $lastname = $dob = $address = $phone = $parentNo = $gender = "";
    if (isset($_GET['id'])) {
        $id = (int) mysqli_real_escape_string($con, $_GET['id']);
        $id = is_numeric($id) ? $id : NULL;
        $query1 = "SELECT * FROM `students` WHERE `student_ID` = $id";
        $result1 = mysqli_query($con, $query1);
        if (mysqli_num_rows($result1) == 1) {
            $row = mysqli_fetch_array($result1, MYSQLI_BOTH);
            $firstname = $row['first_name'];
            $lastname = $row['last_name'];
            $dob = $row['birthdate'];
            $address = $row['address'];
            $phone = $row['phone'];
            $parentNo = $row['parentNumber'];
            $gender = $row['gender'];
        }
        mysqli_free_result($result1);
    } else {
        header('Location: viewStudent.php');
    }
    if (isset($_POST['submit'])) {
        $alertStyle = "";
        $statusMsg = "";

        // Server-side validation
        $errors = array();

        if (empty($_POST['firstname'])) {
            $errors[] = "First name is required.";
        } else {
            $firstname = mysqli_real_escape_string($con, trim($_POST['firstname']));
        }

        if (empty($_POST['lastname'])) {
            $errors[] = "Last name is required.";
        } else {
            $lastname = mysqli_real_escape_string($con, trim($_POST['lastname']));
        }

        if (empty($_POST['dob'])) {
            $errors[] = "Date of birth is required.";
        } else {
            $dob = mysqli_real_escape_string($con, trim($_POST['dob']));
            // Validate age
            $dobDateTime = new DateTime($dob);
            $today = new DateTime();
            $age = $today->diff($dobDateTime)->y;
            if ($age < 11 || $age > 70) {
                $errors[] = "The student age must be between 11 and 70 years old.";
            }
        }

        if (empty($_POST['address'])) {
            $errors[] = "Address is required.";
        } else {
            $address = mysqli_real_escape_string($con, trim($_POST['address']));
        }


        if (empty($_POST['phone'])) {
            $errors[] = "Phone number is required.";
        } else {
            $phone = mysqli_real_escape_string($con, trim($_POST['phone']));
        }
        if (empty($_POST['parentNo'])) {
            $errors[] = "Parent number is required.";
        } else {
            $parentNo = mysqli_real_escape_string($con, trim($_POST['parentNo']));
        }

        if (empty($_POST['gender'])) {
            $errors[] = "Gender is required.";
        } else {
            $gender = mysqli_real_escape_string($con, trim($_POST['gender']));
        }
        // Populate form fields with submitted values
        // $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
        // $address = isset($_POST['address']) ? $_POST['address'] : '';
        // $role = isset($_POST['Role']) ? $_POST['Role'] : '';
        // $username = isset($_POST['username']) ? $_POST['username'] : '';
        // $password = isset($_POST['password']) ? $_POST['password'] : '';
        // $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        // $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

        // If there are no validation errors, proceed with inserting data into the database
        if (empty($errors)) {
            $query = mysqli_query($con, "UPDATE `students` SET `first_name`='$firstname',`last_name`='$lastname',`birthdate`='$dob',`gender`='$gender',`phone`='$phone',`parentNumber`='$parentNo',`address`='$address' WHERE student_ID = $id");

            if ($query) {
                $alertStyle = "alert alert-success";
                $statusMsg = "Student Updated Successfully!";
                // Clear form fields after successful submission
                $firstname = $lastname = $dob = $address = $phone = $parentNo = $gender = "";

                header("refresh:2; url=viewStudent.php");
            } else {
                $alertStyle = "alert alert-danger";
                $statusMsg = "An error occurred while updating the student.";
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
    <?php $page = "student";
    include 'includes/leftMenu.php'; ?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php include 'includes/header.php'; ?>

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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">
                                    <h2 align="center">Edit Student</h2>
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
                                                        <label for="cc-exp" class="control-label mb-1">Firstname</label>
                                                        <input id="" name="firstname" type="text" class="form-control cc-exp" value="<?php echo $firstname; ?>" placeholder="Firstname">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label for="x_card_code" class="control-label mb-1">Lastname</label>
                                                    <input id="" name="lastname" type="text" class="form-control cc-cvc" value="<?php echo $lastname; ?>" placeholder="Lastname">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Date of birth</label>
                                                        <input id="" name="dob" type="date" class="form-control cc-exp" value="<?php echo $dob; ?>" placeholder="Firstname">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Phone Number</label>
                                                        <input id="" name="phone" type="tel" class="form-control cc-exp" value="<?php echo $phone; ?>" placeholder="Phone NO">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="cc-exp" class="control-label mb-1">Parent Number</label>
                                                        <input id="" name="parentNo" type="tel" class="form-control cc-exp" value="<?php echo $parentNo; ?>" placeholder="Parent Phone">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label for="x_card_code" class="control-label mb-1">Address</label>
                                                    <textarea id="" name="address" type="text" class="form-control cc-cvc" value="" placeholder="Address"><?php echo $address; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="x_card_code" class="control-label mb-1">Gender: </label>


                                                        <input name="gender" type="radio" value="Male" <?php if ($gender == "Male") echo "checked"; ?>> Male
                                                        <input name="gender" type="radio" value="Female" <?php if ($gender == "Female") echo "checked"; ?>> Female

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <div id='txtHint'></div>
                                                </div>

                                            </div>
                                    </div>

                                    <button type="submit" name="submit" class="btn btn-success">Update Student</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- .card -->
            </div><!--/.col-->


            <br><br>
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