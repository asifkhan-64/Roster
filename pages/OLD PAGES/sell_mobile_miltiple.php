<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $alreadyAdded = '';
    $added = '';
    $error= '';

    if (isset($_POST['nextPage'])) {
        $client = $_POST['client'];

        header("LOCATION: select_phone.php?client=".$client."");
    }


    include('../_partials/header.php');
?>

<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered  {
        font-size: 16px !important;
        font-weight: 600 !important;
    }

    .custom  {
        font-size: 16px !important;
        font-weight: 600 !important;
    }
</style>
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Sell Mobile Phones (Multiple)</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="custom col-sm-2 col-form-label">Select Customer</label>
                                <div class="col-sm-8">
                                    <?php
                                        $getCustomers = mysqli_query($connect, "SELECT * FROM `customer_add`");
                                        
                                        echo '<select class="form-control comp" name="client" required >';
                                        while ($rowgetCustomers = mysqli_fetch_assoc($getCustomers)) {
                                            echo '<option value="'.$rowgetCustomers['c_id'].'">'.$rowgetCustomers['customer_name'].', 0'.$rowgetCustomers['customer_contact'].' -  Shop: '.$rowgetCustomers['customer_shop'].'</option>';
                                        }

                                        echo '</select>';
                                    ?>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group row">
                                <label for="example-password-input" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-6">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="nextPage">Next</button>
                                </div>
                            </div>
                        </form>
                        <h5><?php echo $error ?></h5>
                        <h5><?php echo $added ?></h5>
                        <h5><?php echo $alreadyAdded ?></h5>
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
<!-- Required datatable js -->
<?php include('../_partials/datatable.php') ?>
<!-- Datatable init js -->
<?php include('../_partials/datatableInit.php') ?>
<!-- Buttons examples -->
<?php include('../_partials/buttons.php') ?>
<!-- App js -->
<?php include('../_partials/app.php') ?>
<!-- Responsive examples -->
<?php include('../_partials/responsive.php') ?>
<!-- Sweet-Alert  -->
<?php include('../_partials/sweetalert.php') ?>
<script type="text/javascript" src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
$('.comp').select2({
  placeholder: 'No Customer Selected',
  allowClear:true
  
});
</script>
</body>

</html>