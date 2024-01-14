<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $notAdded = '';


    if (isset($_POST['addStudent'])) {

        $std_name   = $_POST['std_name'];
        $std_fname  = $_POST['std_fname'];
        $std_ins    = $_POST['std_ins'];
        $std_tech   = $_POST['std_tech'];

        

            date_default_timezone_set("Asia/Karachi");
            $currentDateWithYear = date("Y/m");
            $currentDate = date("d");
            $monthIs = date("m");
            $month = (int)$monthIs;

            $checkRosterDBTbl = mysqli_query($connect, "SELECT COUNT(*) AS countedRosters FROM `roster_db` WHERE month_of = '$currentDateWithYear' AND std_ins = '$std_ins'");
            $fetch_checkRosterDBTbl = mysqli_fetch_assoc($checkRosterDBTbl);
            $check = $fetch_checkRosterDBTbl['countedRosters'];
            


            if ($currentDate > 12) {
                $queryAddStock = mysqli_query($connect, 
                "INSERT INTO `students`(
                    `std_name`,
                    `std_fname`,
                    `std_ins`,
                    `std_tech`
                    ) VALUES (
                        '$std_name',
                        '$std_fname',
                        '$std_ins',
                        '$std_tech'
                    )
                ");

                if (!$queryAddStock) {
                    $notAdded = 'Not added';
                }else {
                    header("LOCATION: student_list.php");
                }
            }else {
                if ($check > 0) {
                    $queryAddStock = mysqli_query($connect, 
                    "INSERT INTO `students`(
                        `std_name`,
                        `std_fname`,
                        `std_ins`,
                        `std_tech`
                        ) VALUES (
                            '$std_name',
                            '$std_fname',
                            '$std_ins',
                            '$std_tech'
                        )
                    ");

                    $getId = mysqli_query($connect, "SELECT MAX(std_id) As std_id FROM `students`");
                    $fetch_getId = mysqli_fetch_assoc($getId);
                    $stdID = $fetch_getId['std_id'];

                    header("LOCATION: roster_single.php?ins=".$std_ins."&month=".$month."&std_id=".$stdID."");
                }else {
                    if (!$queryAddStock) {
                        $notAdded = 'Not added';
                    }else {
                        header("LOCATION: student_list.php");
                    }
                }
                
            }



            
    }


    include('../_partials/header.php') 
?>
<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datetimepicker.css">
<!-- Top Bar End -->
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Add Student</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                        <h4 class="mb-4 page-title"><u>Student Details</u></h4>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="std_name" placeholder="Student Name" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Father Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="std_fname" placeholder="Father Name" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Institute</label>
                                <div class="col-sm-4">
                                    <?php
                                        $getInstitutes = mysqli_query($connect, "SELECT * FROM institutes");
                                        
                                        echo '<select class="form-control comp" name="std_ins" required>';
                                        while ($row = mysqli_fetch_assoc($getInstitutes)) {
                                            echo '<option value="'.$row['i_id'].'">'.$row['institutes_name'].'</option>';
                                        }

                                        echo '</select>';
                                    ?>
                                </div>

                                <label class="col-sm-2 col-form-label">Technology</label>
                                <div class="col-sm-4">
                                    <?php
                                        $getTechnologies = mysqli_query($connect, "SELECT * FROM technology");
                                        
                                        echo '<select class="form-control comp" name="std_tech" required>';
                                        while ($row = mysqli_fetch_assoc($getTechnologies)) {
                                            echo '<option value="'.$row['t_id'].'">'.$row['technology_name'].'</option>';
                                        }

                                        echo '</select>';
                                    ?>
                                </div>
                            </div>

                            

                            <div class="form-group row">
                                <!-- <label class="col-sm-2 col-form-label">Ward</label>
                                <div class="col-sm-4">
                                    <?php
                                        // $getWards = mysqli_query($connect, "SELECT * FROM wards");
                                        
                                        // echo '<select class="form-control comp" name="std_ward" required>';
                                        // while ($row = mysqli_fetch_assoc($getWards)) {
                                        //     echo '<option value="'.$row['w_id'].'">'.$row['ward_name'].'</option>';
                                        // }

                                        // echo '</select>';
                                    ?>
                                </div> -->

                                <!-- <label class="col-sm-2 col-form-label">Month</label>
                                <div class="col-sm-4">
                                    <?php
                                        // $getMonths = mysqli_query($connect, "SELECT * FROM months");
                                        
                                        // echo '<select class="form-control comp" name="std_month" required>';
                                        // while ($row = mysqli_fetch_assoc($getMonths)) {
                                        //     echo '<option value="'.$row['m_id'].'">'.$row['month_name'].'</option>';
                                        // }

                                        // echo '</select>';
                                        
                                    ?>
                                    
                                </div> -->


                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-12"  align="right">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="addStudent" class="btn btn-primary waves-effect waves-light">Add Student</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <h3>
                        <?php echo $notAdded; ?>
                    </h3>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div><!-- container fluid -->
</div> <!-- Page content Wrapper -->
</div> <!-- content -->
<?php include('../_partials/footer.php') ?>

</div>
<!-- End Right content here -->
</div>
<!-- END wrapper -->
<!-- jQuery  -->
 <?php include('../_partials/jquery.php') ?>
<!-- App js -->
        <?php include('../_partials/app.php') ?>
        <?php include('../_partials/datetimepicker.php') ?>

<script type="text/javascript">
    $(".form_datetime").datetimepicker({
        format: "yyyy-mm-dd hh:ii"
    });
</script>
        
<script type="text/javascript" src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
$('.comp').select2({
  placeholder: 'Select an option',
  allowClear:true
  
});
</script>
</body>

</html>