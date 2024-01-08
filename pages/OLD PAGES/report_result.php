<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $alreadyAdded = '';
    $added = '';
    $error= '';

    $fromDate = $_GET['from'];
    $toDate = $_GET['to'];

    include('../_partials/header.php');


    $retMobiles = mysqli_query($connect, "SELECT stock_add.*, companies.company_name, company_model.model_name, sell_product.* FROM `sell_product`
                                INNER JOIN stock_add ON stock_add.st_id  = sell_product.st_id
                                INNER JOIN companies ON companies.id = stock_add.comp_id
                                INNER JOIN company_model ON company_model.mod_id = stock_add.mod_id
                                WHERE sell_product.customer_date BETWEEN '$fromDate' AND '$toDate'");

    $noOfRows = mysqli_num_rows($retMobiles);
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Report</h5>
            </div>
        </div>
        <!-- end row -->

        <?php
        if ($noOfRows > 0) {
        ?>
        
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Profilt &amp; Loss Report</h4>
                       
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
                                    <th>Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                $iteration = 1;

                                $sum = 0;

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

                                        $sold = $rowMobiles['sell_price'];

                                        

                                        if ($rowMobiles['box_status'] === '1') {
                                            echo '<td><i class="fa fa-check"></i></td>';
                                        }elseif ($rowMobiles['box_status'] === '0') {
                                            echo '<td><i class="fa fa-times"></i></td>';
                                        }

                                        $profit = $rowMobiles['sell_price'] - $rowMobiles['purchase_price'];

                                        $sum = $sum + $profit;
                                        echo '

                                        <td><b>'.$profit.' Pkr</b></td>
                                        
                                    </tr>
                                    ';
                                }
                                ?>

                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-right">Total:</th>
                                    <th><?php echo $sum ?> Pkr</th>
                                </tr>
                            </tfoot>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

        <?php
        }else {
        ?>

        <div class="row p-5 m-5">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body text-center">
                        <h4 class="mt-0 header-title">Profilt &amp; Loss Report</h4>
                        <hr>
                        <h2 class="p-5">No data found!</h2>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

        <?php
            
        }
        ?>
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