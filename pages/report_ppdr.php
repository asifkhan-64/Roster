<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $notAdded = '';


    if (isset($_POST['roster'])) {
        $month    = $_POST['month'];

        date_default_timezone_set("Asia/Karachi");
        $currentYear = date("Y");

        header("LOCATION: report_ppdr_print.php?month=".$month."&date=".$currentYear."");        
    }


    include('../_partials/header.php') 
?>
<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datetimepicker.css">
<!-- Top Bar End -->
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">(PPD Report) PRIVATE PARAMEDICAL INSTITUTES STUDENTS DISTRIBUTION, SAIDU GROUP OF TEACHING HOSPITALS SWAT.</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">

                            <div class="form-group row">
                                
                                <label class="col-sm-2 col-form-label">PPDR Month</label>
                                <div class="col-sm-10">
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
                                    <button type="submit" name="roster" class="btn btn-primary waves-effect waves-light">Generate Report</button>
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