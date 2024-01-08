<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }


    include('../_partials/header.php');
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Stock</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Stock List</h4>
                       
                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                    <th class="text-center"> <i class="fa fa-edit"></i></th>
                                    <th class="text-center"> <i class="fa fa-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $retMobiles = mysqli_query($connect, "SELECT stock_add.*, companies.company_name, company_model.model_name FROM `stock_add`
                                INNER JOIN companies ON companies.id = stock_add.comp_id
                                INNER JOIN company_model ON company_model.mod_id = stock_add.mod_id
                                WHERE stock_add.mobile_status = '1'");
                                $iteration = 1;

                                $price = 0;

                                while ($rowMobiles = mysqli_fetch_assoc($retMobiles)) {
                                    echo '
                                    <tr>
                                        <td>'.$iteration++.'</td>
                                        <td>'.$rowMobiles['company_name'].' - '.$rowMobiles['model_name'].'</td>
                                        <td>'.$rowMobiles['purchase_price'].'</td>
                                        <td>'.$rowMobiles['sell_price'].'</td>
                                        <td>'.$rowMobiles['mobile_color'].'</td>
                                        <td>'.$rowMobiles['mobile_ram'].'GB - '.$rowMobiles['mobile_space'].'GB</td>';

                                        if ($rowMobiles['mobile_imei'] === '1') {
                                            echo '<td>PTA <i class="fa fa-check"></i></td>';
                                        }elseif ($rowMobiles['mobile_imei'] === '2') {
                                            echo '<td>PTA <i class="fa fa-times"></i></td>';
                                        }elseif ($rowMobiles['mobile_imei'] === '3') {
                                            echo '<td>Changed</td>';
                                        }

                                        $orgPrice = $rowMobiles['purchase_price'];

                                        $price = $price + $orgPrice;

                                        if ($rowMobiles['box_status'] === '1') {
                                            echo '<td><i class="fa fa-check"></i></td>';
                                        }elseif ($rowMobiles['box_status'] === '0') {
                                            echo '<td><i class="fa fa-times"></i></td>';
                                        }
                                        echo '
                                        
                                        <td class="text-center"><a href="stock_edit.php?id='.$rowMobiles['st_id'].'" type="button" class="btn text-white btn-warning waves-effect waves-light">Edit</a></td>
                                        <td class="text-center"><a href="stock_delete.php?id='.$rowMobiles['st_id'].'" type="button" class="btn text-white btn-danger waves-effect waves-light">Delete</a></td>
                                    </tr>
                                    ';
                                }

                                
                                ?>

                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th class="text-right">Total: </th>
                                    <th><?php echo $price; ?> Pkr</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
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