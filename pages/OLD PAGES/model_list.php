<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $alreadyAdded = '';
    $added = '';
    $error= '';

    if (isset($_POST['addModel'])) {
        $comp_id = $_POST['comp_id'];
        $companyModel = $_POST['companyModel'];

        $countQuery = mysqli_query($connect, "SELECT COUNT(*)AS countedModels FROM company_model WHERE model_name LIKE '%$companyModel%' AND comp_id = '$comp_id'");
        $fetch_countQuery = mysqli_fetch_assoc($countQuery);


        if ($fetch_countQuery['countedModels'] == 0) {
            $insertQuery = mysqli_query($connect, "INSERT INTO company_model(model_name, comp_id)VALUES('$companyModel', '$comp_id')");
            if (!$insertQuery) {
                $error = 'Not Added! Try agian!';
            }else {
                $added = '
                <div class="alert alert-primary" role="alert">
                                Company Model Added!
                             </div>';
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
            <div class="col-5">
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
                                            echo '<option value="'.$row['id'].'">'.$row['company_name'].'</option>';
                                        }

                                        echo '</select>';
                                    ?>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Model</label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="Company Model" type="text" value="" id="example-text-input" name="companyModel" required="">
                                </div>
                            </div><hr>
                            <div class="form-group row">
                                <!-- <label for="example-password-input" class="col-sm-2 col-form-label"></label> -->
                                <div class="col-sm-12" align="right">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="addModel">Add Model</button>
                                </div>
                            </div>
                        </form>
                        <h5 align="center"><?php echo $error ?></h5>
                        <h5 align="center"><?php echo $added ?></h5>
                        <h5 align="center"><?php echo $alreadyAdded ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-7">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Companies Model List</h4>
                       
                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Model</th>
                                    <th>Company</th>
                                    <th class="text-center"> <i class="fa fa-edit"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $retCompanies = mysqli_query($connect, "SELECT company_model.*, companies.company_name FROM company_model
                                INNER JOIN companies ON companies.id = company_model.comp_id;");
                                $iteration = 1;

                                while ($rowCompanies = mysqli_fetch_assoc($retCompanies)) {
                                    echo '
                                    <tr>
                                        <td>'.$iteration++.'</td>
                                        <td>'.$rowCompanies['company_name'].'</td>
                                        <td>'.$rowCompanies['model_name'].'</td>
                                        <td class="text-center"><a href="model_edit.php?id='.$rowCompanies['mod_id'].'" type="button" class="btn text-white btn-warning waves-effect waves-light">Edit</a></td>
                                    </tr>
                                    ';
                                }
                                ?>
                            </tbody>
                        </table>
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
  placeholder: 'Select an option',
  allowClear:true
  
});
</script>

</body>

</html>