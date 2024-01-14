<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $notAdded = '';


    if (isset($_POST['roster'])) {
        $std_ins    = $_POST['std_ins'];
        $month    = $_POST['month'];

        date_default_timezone_set("Asia/Karachi");
        $currentYear = date("Y/m");

        $checkRosterDBTbl = mysqli_query($connect, "SELECT COUNT(*) AS countedRosters FROM `roster_db` WHERE month_of = '$currentYear' AND std_ins = '$std_ins'");
        $fetch_checkRosterDBTbl = mysqli_fetch_assoc($checkRosterDBTbl);
        $check = $fetch_checkRosterDBTbl['countedRosters'];

        if ($check > 0) {
            $insName = mysqli_query($connect, "SELECT * FROM `institutes` WHERE i_id = '$std_ins'");
            $fetch_insName = mysqli_fetch_assoc($insName);
            $insNameIs = $fetch_insName['institutes_name'];
            $notAdded = '<div class="alert alert-danger">'.$insNameIs.' Institute Roster Already added for this month.</div>';
        }else {
            header("LOCATION: roster_college.php?ins=".$std_ins."&month=".$month."");
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
                <h5 class="page-title">Roster</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Select Institute</label>
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

                                <label class="col-sm-2 col-form-label">Select Month</label>
                                <div class="col-sm-4">
                                    <?php
                                        $getMonths = mysqli_query($connect, "SELECT * FROM months");
                                        
                                        echo '<select class="form-control comp" name="month" required>';
                                        while ($row = mysqli_fetch_assoc($getMonths)) {
                                            echo '<option value="'.$row['m_id'].'">'.$row['month_name'].'</option>';
                                        }

                                        echo '</select>';
                                    ?>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-12"  align="right">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="roster" class="btn btn-primary waves-effect waves-light">Roster</button>
                                </div>
                            </div>
                            
                        </form>
                        <h3 class="text-center">
                            <?php echo $notAdded; ?>
                        </h3>
                    </div>
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