<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $alreadyAdded = '';
    $added = '';
    $error= '';

    $id = $_GET['id'];
    $get = mysqli_query($connect, "SELECT * FROM company_model WHERE mod_id = '$id'");
    $fetch_get = mysqli_fetch_assoc($get);

    if (isset($_POST['updateModel'])) {
        $id = $_POST['id'];
        $comp_id = $_POST['comp_id'];
        $companyModel = $_POST['companyModel'];

        $countQuery = mysqli_query($connect, "SELECT COUNT(*)AS countedModels FROM company_model WHERE model_name LIKE '%$companyModel%' AND comp_id = '$comp_id'");
        $fetch_countQuery = mysqli_fetch_assoc($countQuery);


        if ($fetch_countQuery['countedModels'] == 0) {

            $insertQuery = mysqli_query($connect, "UPDATE company_model SET model_name = '$companyModel', comp_id = '$comp_id' WHERE mod_id = '$id'");
            if (!$insertQuery) {
                $error = 'Not Added! Try again!';
            }else {
                header("LOCATION: model_list.php");
            }
        }else {
            $alreadyAdded = '<div class="alert alert-dark" role="alert">
                                Company Model Already Added!
                             </div>';
        }
    }


    include('../_partials/header.php');
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Companies Model</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Company</label>
                                <div class="col-sm-8">
                                    <?php
                                        $getCompanies = mysqli_query($connect, "SELECT * FROM companies");
                                        
                                        echo '<select class="form-control comp" name="comp_id" required>';
                                        while ($row = mysqli_fetch_assoc($getCompanies)) {
                                            if ($row['id'] === $fetch_get['comp_id']) {
                                                echo '<option value="'.$row['id'].'" selected>'.$row['company_name'].'</option>';
                                            }else {
                                                echo '<option value="'.$row['id'].'">'.$row['company_name'].'</option>';
                                            }
                                        }

                                        echo '</select>';
                                    ?>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Model</label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="Company Model" type="text" value="<?php echo $fetch_get['model_name'] ?>" id="example-text-input" name="companyModel" required="">
                                </div>
                            </div><hr>

                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <div class="form-group row">
                                <!-- <label for="example-password-input" class="col-sm-2 col-form-label"></label> -->
                                <div class="col-sm-12" align="right">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="updateModel">Update Model</button>
                                </div>
                            </div>
                        </form>
                        <h5 align="center"><?php echo $error ?></h5>
                        <h5 align="center"><?php echo $added ?></h5>
                        <h5 align="center"><?php echo $alreadyAdded ?></h5>
                    </div>
                </div>
            </div>
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
  placeholder: 'Select an option',
  allowClear:true
  
});
</script>
</body>

</html>