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
                <h5 class="page-title">Report</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Current Stock Report</h4>
                       
                        <table class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mobile</th>
                                    <th>Purchase Price</th>
                                    <th>Sell Price</th>
                                    <th>Color</th>
                                    <th>Specs</th>
                                    <th>IMEI Status</th>
                                    <th>Box</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $retMobiles = mysqli_query($connect, "SELECT stock_add.*, companies.company_name, company_model.model_name FROM `stock_add`
                                INNER JOIN companies ON companies.id = stock_add.comp_id
                                INNER JOIN company_model ON company_model.mod_id = stock_add.mod_id
                                WHERE stock_add.mobile_status = '1' ORDER BY stock_add.comp_id");
                                $iteration = 1;

                                while ($rowMobiles = mysqli_fetch_assoc($retMobiles)) {
                                    echo '
                                    <tr>
                                        <td>'.$iteration++.'</td>
                                        <td>'.$rowMobiles['company_name'].' - '.$rowMobiles['model_name'].'</td>
                                        <td>'.$rowMobiles['purchase_price'].'</td>
                                        <td>'.$rowMobiles['sell_price'].'</td>
                                        <td>'.$rowMobiles['mobile_color'].'</td>
                                        <td>'.$rowMobiles['mobile_ram'].' - '.$rowMobiles['mobile_space'].'</td>';

                                        if ($rowMobiles['mobile_imei'] === '1') {
                                            echo '<td>PTA <i class="fa fa-check"></i></td>';
                                        }elseif ($rowMobiles['mobile_imei'] === '2') {
                                            echo '<td>PTA <i class="fa fa-times"></i></td>';
                                        }elseif ($rowMobiles['mobile_imei'] === '3') {
                                            echo '<td>Changed</td>';
                                        }

                                        if ($rowMobiles['box_status'] === '1') {
                                            echo '<td><i class="fa fa-check"></i></td>';
                                        }elseif ($rowMobiles['box_status'] === '0') {
                                            echo '<td><i class="fa fa-times"></i></td>';
                                        }
                                        echo '
                                        
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