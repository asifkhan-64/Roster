<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $alreadyAdded = '';
    $added = '';
    $error= '';

    $id = $_GET['imei'];

    $getMobileByImei = mysqli_query($connect, "SELECT stock_add.*, companies.company_name, company_model.model_name FROM `stock_add`
                                    INNER JOIN companies ON companies.id = stock_add.comp_id
                                    INNER JOIN company_model ON company_model.mod_id = stock_add.mod_id
                                    WHERE stock_add.mobile_imeione = '$id'");

    $fetch_getMobileByImei = mysqli_fetch_assoc($getMobileByImei);

    if (isset($_POST['sellMobile'])) {
        $customer_name = $_POST['customer_name'];
        $customer_cell = $_POST['customer_cell'];
        $customer_cnic = $_POST['customer_cnic'];
        $customer_date = $_POST['customer_date'];
        $customer_address = $_POST['customer_address'];
        $sell_price = $_POST['sell_price'];

        $stock_id  = $_POST['stock_id'];

        $countInvoiceNumber = mysqli_query($connect, "SELECT MAX(invoice_no) AS invoiceNo FROM sell_product");
        $fetch_countInvoiceNumber = mysqli_fetch_assoc($countInvoiceNumber);
        
        $invoice = $fetch_countInvoiceNumber['invoiceNo'];

        if ($invoice < '1') {
            $invoice_no = $invoice + 1;
        }else {
            $invoice_no = $invoice + 1;
        }

        $insertQuery = mysqli_query($connect,"INSERT INTO `sell_product`(
            `customer_name`,
             `customer_cell`,
              `customer_cnic`,
               `customer_date`,
                `customer_address`,
                 `st_id`,
                  `sell_price`,
                   `invoice_no`
            ) VALUES (
                '$customer_name',
                 '$customer_cell',
                  '$customer_cnic',
                   '$customer_date',
                    '$customer_address',
                     '$stock_id',
                      '$sell_price',
                       '$invoice_no'
            )");



        if ($insertQuery) {
            $updateStockList = mysqli_query($connect, "UPDATE stock_add SET mobile_status = '0' WHERE st_id = '$stock_id'");
            if ($updateStockList) {
                header("LOCATION: sell_list.php");
            }
        }
    }


    include('../_partials/header.php');
?>

<style>
    tr {
        line-height: 0.5;
    }
</style>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Mobile Info</h5>
            </div>
        </div>
        <!-- end row -->
        <?php
        $count = mysqli_num_rows($getMobileByImei);
        if ($count > 0) {
        ?>
        <div class="row">
            <div class="col-5">
                <div class="card m-b-30">
                    <div class="card-body">

                        <table class="table dt-responsive nowrap">
                            <tbody>
                                <tr>
                                    <td>Mobile</td>
                                    <td><?php echo  $fetch_getMobileByImei['company_name']. ' - '.$fetch_getMobileByImei['model_name'] ?></td>
                                </tr>

                                <tr>
                                    <td>Purchase Price</td>
                                    <td><?php echo  $fetch_getMobileByImei['purchase_price'] ?></td>
                                </tr>

                                <tr>
                                    <td>Sell Price</td>
                                    <td><?php echo  $fetch_getMobileByImei['sell_price'] ?></td>
                                </tr>

                                <tr>
                                    <td>Purchase Date</td>
                                    <td><?php echo  $fetch_getMobileByImei['purchase_date'] ?></td>
                                </tr>

                                <tr>
                                    <td>Mobile Color</td>
                                    <td><?php echo  $fetch_getMobileByImei['mobile_color'] ?></td>
                                </tr>

                                <tr>
                                    <td>Mobile Specs</td>
                                    <td><?php echo  $fetch_getMobileByImei['mobile_ram'].'GB - '.$fetch_getMobileByImei['mobile_space'] ?>GB</td>
                                </tr>

                                <tr>
                                    <td>Mobile IMEI. 01</td>
                                    <td><?php echo  $fetch_getMobileByImei['mobile_imeione'] ?></td>
                                </tr>

                                <tr>
                                    <td>Mobile IMEI. 02</td>
                                    <td><?php echo  $fetch_getMobileByImei['mobile_imeitwo'] ?></td>
                                </tr>

                                <tr>
                                    <td>Owner Name</td>
                                    <td><?php echo  $fetch_getMobileByImei['o_name'] ?></td>
                                </tr>

                                <tr>
                                    <td>Owner Contact</td>
                                    <td><?php echo  $fetch_getMobileByImei['o_contact'] ?></td>
                                </tr>

                                <tr>
                                    <td>Owner Address</td>
                                    <td><?php echo  $fetch_getMobileByImei['o_address'] ?></td>
                                </tr>

                                <tr>
                                    <td>Bill No</td>
                                    <td><?php echo  $fetch_getMobileByImei['o_bill'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->

            <div class="col-7">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Customer Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="customer_name" placeholder="Customer Name" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Cell #</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="customer_cell" placeholder="03xxxxxxxxx" required="">
                                </div>
                            </div>

                                    <input type="hidden" value="0" class="form-control" name="customer_cnic" placeholder="15602xxxxxxxx" required="">


                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Date</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" name="customer_date"  required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Address</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="customer_address" placeholder="Address" required="">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Sell Price</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="sell_price" value="<?php echo $fetch_getMobileByImei['sell_price'] ?>" placeholder="Price" required="">
                                </div>
                            </div>
                            
                            <hr>
                            <input type="hidden" name="stock_id" value="<?php echo $fetch_getMobileByImei['st_id']; ?>">
                            
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="sellMobile" class="btn btn-primary waves-effect waves-light">Sell Mobile!</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div> <!-- end row -->
        <?php
            }else {
            ?>
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h3 align="center" class="p-5">No Mobile Found!</h3>
                        </div>
                    </div>
                </div>
            </div>
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