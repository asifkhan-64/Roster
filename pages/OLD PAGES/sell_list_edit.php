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

    $getMobileByImei = mysqli_query($connect, "SELECT stock_add.*, companies.company_name, company_model.model_name, sell_product.*  FROM `sell_product`
    INNER JOIN stock_add ON stock_add.st_id = sell_product.st_id
    INNER JOIN companies ON companies.id = stock_add.comp_id
    INNER JOIN company_model ON company_model.mod_id = stock_add.mod_id
    WHERE sell_product.sell_id = '$id'");

    $fetch_getMobileByImei = mysqli_fetch_assoc($getMobileByImei);

    if (isset($_POST['sellMobile'])) {
        $customer_name = $_POST['customer_name'];
        $customer_cell = $_POST['customer_cell'];
        $customer_cnic = $_POST['customer_cnic'];
        $customer_date = $_POST['customer_date'];
        $customer_address = $_POST['customer_address'];
        $sell_price = $_POST['sell_price'];

        $sell_id  = $_POST['sell_id'];

        $updateQuery = mysqli_query($connect,"UPDATE `sell_product` SET 
            `customer_name` = '$customer_name',
             `customer_cell` = '$customer_cell',
              `customer_cnic` = '$customer_cnic',
               `customer_date` = '$customer_date',
                `customer_address` = '$customer_address',
                  `sell_price` = '$sell_price'
                    WHERE sell_id = '$sell_id'               
            ");



        if ($updateQuery) {
            header("LOCATION: sell_list.php");
        }
    }


    include('../_partials/header.php');
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Mobile Info Edit</h5>
            </div>
        </div>
        <!-- end row -->
        
        <div class="row">
            <div class="col-5">
                <div class="card m-b-30">
                    <div class="card-body">

                        <table class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                    <td><?php echo  $fetch_getMobileByImei['mobile_ram'].' - '.$fetch_getMobileByImei['mobile_space'] ?></td>
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
                                    <input type="text" value="<?php echo $fetch_getMobileByImei['customer_name'] ?>"  class="form-control" name="customer_name" placeholder="Customer Name" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Cell #</label>
                                <div class="col-sm-8">
                                    <input type="number" value="<?php echo "0".$fetch_getMobileByImei['customer_cell'] ?>"  class="form-control" name="customer_cell" placeholder="03xxxxxxxxx" required="">
                                </div>
                            </div>

                                    <input type="hidden" value="<?php echo $fetch_getMobileByImei['customer_cnic'] ?>"  class="form-control" name="customer_cnic" placeholder="15602xxxxxxxx" required="">
                            

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Date</label>
                                <div class="col-sm-8">
                                    <input type="date" value="<?php echo $fetch_getMobileByImei['customer_date'] ?>"  class="form-control" name="customer_date"  required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Address</label>
                                <div class="col-sm-8">
                                    <input type="text" value="<?php echo $fetch_getMobileByImei['customer_address'] ?>"  class="form-control" name="customer_address" placeholder="Address" required="">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Sell Price</label>
                                <div class="col-sm-8">
                                    <input type="number" value="<?php echo $fetch_getMobileByImei['sell_price'] ?>"  class="form-control" name="sell_price" value="<?php echo $fetch_getMobileByImei['sell_price'] ?>" placeholder="Price" required="">
                                </div>
                            </div>
                            
                            <hr>
                            <input type="hidden" name="sell_id" value="<?php echo $fetch_getMobileByImei['sell_id']; ?>">
                            
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="sellMobile" class="btn btn-primary waves-effect waves-light">Update Invoice!</button>
                                </div>
                            </div>
                        </form>
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