<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $notAdded = '';

    $id = $_GET['id'];
    $getStdData = mysqli_query($connect, "SELECT * FROM students WHERE std_id  = '$id'");
    $fetch_getStdData = mysqli_fetch_assoc($getStdData);


    if (isset($_POST['editStudent'])) {

        $std_name   = $_POST['std_name'];
        $std_fname  = $_POST['std_fname'];
        $std_ins    = $_POST['std_ins'];
        $std_tech   = $_POST['std_tech'];
        $id         = $_POST['id'];

        $queryAddStock = mysqli_query($connect, 
            "UPDATE `students` SET
                `std_name` = '$std_name',
                 `std_fname` = '$std_fname',
                  `std_ins` = '$std_ins',
                   `std_tech` = '$std_tech'
                     WHERE std_id = '$id'
            ");

        if (!$queryAddStock) {
            $notAdded = 'Not Updated';
        }else {
            header("LOCATION: student_list.php");
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
                <h5 class="page-title">Edit Student</h5>
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
                                    <input type="text" class="form-control" value="<?php echo $fetch_getStdData['std_name'] ?>" name="std_name" placeholder="Student Name" required="">
                                </div>

                                <input type="hidden" name="id" value="<?php echo $id ?>">

                                <label class="col-sm-2 col-form-label">Father Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="<?php echo $fetch_getStdData['std_fname'] ?>" name="std_fname" placeholder="Father Name" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Institute</label>
                                <div class="col-sm-4">
                                    <?php
                                        $getInstitutes = mysqli_query($connect, "SELECT * FROM institutes");
                                        
                                        echo '<select class="form-control comp" name="std_ins" required>';
                                        while ($row = mysqli_fetch_assoc($getInstitutes)) {
                                            if ($row['i_id'] === $fetch_getStdData['std_ins']) {
                                                echo '<option value="'.$row['i_id'].'" selected>'.$row['institutes_name'].'</option>';
                                            }else {
                                                echo '<option value="'.$row['i_id'].'">'.$row['institutes_name'].'</option>';
                                            }
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
                                            if ($row['t_id'] === $fetch_getStdData['std_tech']) {
                                                echo '<option value="'.$row['t_id'].'" selected>'.$row['technology_name'].'</option>';
                                            }else {
                                                echo '<option value="'.$row['t_id'].'">'.$row['technology_name'].'</option>';
                                            }
                                        }
                                        echo '</select>';
                                    ?>
                                </div>
                            </div>

                            

                            <div class="form-group row">
                               

                                <!-- <label class="col-sm-2 col-form-label">Month</label>
                                <div class="col-sm-4">
                                    <?php
                                        // $getMonths = mysqli_query($connect, "SELECT * FROM months");
                                        
                                        // echo '<select class="form-control comp" name="std_month" required>';
                                        // while ($row = mysqli_fetch_assoc($getMonths)) {
                                        //     if ($row['m_id'] === $fetch_getStdData['std_month']) {
                                        //         echo '<option value="'.$row['m_id'].'" selected>'.$row['month_name'].'</option>';
                                        //     }else {
                                        //         echo '<option value="'.$row['m_id'].'">'.$row['month_name'].'</option>';
                                        //     }
                                        // }

                                        // echo '</select>';
                                    ?>
                                </div> -->


                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-12"  align="right">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="editStudent" class="btn btn-primary waves-effect waves-light">Edit Student</button>
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