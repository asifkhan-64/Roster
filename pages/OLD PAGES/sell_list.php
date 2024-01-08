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
                <h5 class="page-title">Sell List</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title text-center">Sell List</h4>
                        <table id="datatable" class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Cell #</th>
                                    <th>Sell Price</th>
                                    <th>Mobile</th>
                                    <th>Date</th>
                                    <th class="text-center"><i class='fa fa-edit'></i></th>
                                    <th class="text-center"><i class='fa fa-print'></i></th>
                                    <th class="text-center"><i class='fa fa-trash'></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $selectQuery = mysqli_query($connect, "SELECT sell_product.*, stock_add.comp_id, stock_add.mod_id, stock_add.mobile_imeione, companies.company_name, company_model.model_name FROM `sell_product`
                                INNER JOIN stock_add ON stock_add.st_id = sell_product.st_id
                                INNER JOIN companies ON companies.id = stock_add.comp_id
                                INNER JOIN company_model ON company_model.mod_id = stock_add.mod_id
                                ORDER BY sell_product.auto_date DESC");

                                $itr = 1;
                                
                                $sellPrice = 0;


                                while ($row = mysqli_fetch_assoc($selectQuery)) {

                                    $invoiceNumber = $row['invoice_no'];
                                    $checkInvoiceNumberQuery = mysqli_query($connect, "SELECT COUNT(invoice_no) AS invoiceToken FROM `sell_product` WHERE invoice_no = '$invoiceNumber'");
                                    $fetch_checkInvoiceNumberQuery = mysqli_fetch_assoc($checkInvoiceNumberQuery);


                                    if ($fetch_checkInvoiceNumberQuery['invoiceToken'] < 2) {
                                        echo '
                                            <tr>
                                                <td>'.$itr++.'</td>
                                                <td>'.$row['customer_name'].'</td>
                                                <td>0'.$row['customer_cell'].'</td>
                                                <td>'.$row['sell_price'].'</td>
                                                <td>'.$row['company_name'].' - '.$row['model_name'].'</td>
                                                <td>'.$row['customer_date'].'</td>
                                                
                                                <td class="text-center">
                                                    <a href="sell_list_edit.php?id='.$row['sell_id'].'" type="button" class="btn text-white btn-success waves-effect waves-light btn-sm"><i class="fa fa-edit"></i></a>
                                                </td>

                                                <td class="text-center">
                                                    <a href="print.php?refNo='.$row['sell_id'].'" type="button" class="btn text-white btn-primary waves-effect waves-light btn-sm"><i class="fa fa-print"></i></a>
                                                </td>

                                                <td class="text-center">
                                                    <a href="sell_delete.php?refNo='.$row['sell_id'].'" type="button" class="btn text-white btn-danger waves-effect waves-light btn-sm"><i class="fa fa-trash"></i></a>
                                                </td>';
                                                $SOLD = $row['sell_price'];
                                                $sellPrice = $sellPrice + $SOLD;
                                                echo '
                                            </tr>';
                                        }
                                    }
                                ?>

                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><b><?php echo "TOTAL: " ?></b></td>
                                        <td><b><?php echo $sellPrice ?></b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
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
<!-- jQuery  -->
        <?php include('../_partials/jquery.php') ?>

<!-- Required datatable js -->
        <?php include('../_partials/datatable.php') ?>

<!-- Buttons examples -->
        <?php include('../_partials/buttons.php') ?>

<!-- Responsive examples -->
        <?php include('../_partials/responsive.php') ?>

<!-- Datatable init js -->
        <?php include('../_partials/datatableInit.php') ?>


<!-- Sweet-Alert  -->
        <?php include('../_partials/sweetalert.php') ?>


<!-- App js -->
        <?php include('../_partials/app.php') ?>
</body>

</html>