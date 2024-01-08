<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $alreadyAdded = '';
    $added = '';
    $error= '';

    $client = $_GET['client'];
    $getClientData = mysqli_query($connect, "SELECT * FROM customer_add WHERE c_id = '$client'");
    $fetch_getClientData = mysqli_fetch_assoc($getClientData);


    $imei = $_GET['imei'];
    $allImei = explode(",", $imei);

    if (isset($_POST['sellMobile'])) {
        $customer_name = $_POST['customer_name'];
        $customer_cell = $_POST['customer_cell'];
        $customer_cnic = $_POST['customer_cnic'];
        $customer_date = $_POST['customer_date'];
        $customer_address = $_POST['customer_address'];
        
        // About Money
        $Nettotal = $_POST['Ntotal'];
        $Paidtotal = $_POST['Ptotal'];
        $Remainingtotal = $_POST['Rtotal'];

        
        $countInvoiceNumber = mysqli_query($connect, "SELECT MAX(invoice_no) AS invoiceNo FROM sell_product");
        $fetch_countInvoiceNumber = mysqli_fetch_assoc($countInvoiceNumber);
        
        $invoice = $fetch_countInvoiceNumber['invoiceNo'];

        if ($invoice < '1') {
            $invoice_no = $invoice + 1;
        }else {
            $invoice_no = $invoice + 1;
        }


        // Array
        $sell = $_POST['sell_price'];
        $stock  = $_POST['st_id'];

        for ($i=0; $i < sizeof($sell); $i++) { 
            $stock_id = $stock[$i];
            $sell_price = $sell[$i];

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
            }

        }

            if ($updateStockList) {
                $client_id = $_GET['client'];
                    $insertSummary = mysqli_query($connect, "INSERT INTO customer_summary(
                        `c_id`,
                         `invoice_id`,
                          `net_amount`,
                           `paid_amount`,
                            `remaining_amount`,
                             `custom_date`
                             )VALUES(
                              '$client_id',
                               '$invoice_no',
                                '$Nettotal',
                                 '$Paidtotal',
                                  '$Remainingtotal',
                                   '$customer_date'
                             )");

                if ($insertSummary) {
                    $updateCustomerData = mysqli_query($connect, "UPDATE customer_add SET 
                    total_sale = (total_sale + $Nettotal), 
                    total_paid = (total_paid + $Paidtotal), 
                    total_dues = (total_dues + $Remainingtotal)
                    WHERE c_id = '$client_id'
                    ");

                    if ($updateCustomerData) {
                        header("LOCATION: sell_mobile_miltiple_list.php");
                    }
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
                <h5 class="page-title">Multiple IMEI Info</h5>
                <h5 class="page-title">Customer Info: <?php echo $fetch_getClientData['customer_name'].", Shop: ".$fetch_getClientData['customer_shop'] ?></h5>
            </div>
        </div>
        <!-- end row -->
        
        <form method="POST">
        <div class="row">
            <?php
            
                $sum = 0;
                for ($i=0; $i < sizeof($allImei); $i++) { 

                    $imei = $allImei[$i];
                    $getMobileByImei = mysqli_query($connect, "SELECT stock_add.*, companies.company_name, company_model.model_name FROM `stock_add`
                                INNER JOIN companies ON companies.id = stock_add.comp_id
                                INNER JOIN company_model ON company_model.mod_id = stock_add.mod_id
                                WHERE stock_add.mobile_imeione = '$imei'");

                    $fetch_getMobileByImei = mysqli_fetch_assoc($getMobileByImei);
                
            ?>
            <div class="col-4">
                <div class="card m-b-30">
                    <div class="card-body">
                        <table class="table dt-responsive nowrap">
                            <tbody>
                                <tr>
                                    <td>Mobile</td>
                                    <td><?php echo  $fetch_getMobileByImei['company_name']. ' - '.$fetch_getMobileByImei['model_name'] ?></td>
                                </tr>

                                <tr>
                                    <td>Purchased</td>
                                    <td><?php echo  $fetch_getMobileByImei['purchase_price'] ?></td>
                                </tr>

                                <tr>
                                    <td>Sell Price</td>
                                    <td><input type="number" class="form-control singleSum" onkeyup="calcSub(this)" name="sell_price[]"  value="<?php echo  $fetch_getMobileByImei['sell_price'] ?>" required></td>
                                </tr>

                                    <input type="hidden" class="form-control" name="st_id[]" value="<?php echo  $fetch_getMobileByImei['st_id'] ?>">

                                <tr>
                                    <td>P Date</td>
                                    <td><?php echo  $fetch_getMobileByImei['purchase_date'] ?></td>
                                </tr>

                                <tr>
                                    <td>Color</td>
                                    <td><?php echo  $fetch_getMobileByImei['mobile_color'] ?></td>
                                </tr>

                                <tr>
                                    <td>Specs</td>
                                    <td><?php echo  $fetch_getMobileByImei['mobile_ram'].'GB - '.$fetch_getMobileByImei['mobile_space'] ?>GB</td>
                                </tr>

                                <tr>
                                    <td>IMEI: 01</td>
                                    <td><?php echo  $fetch_getMobileByImei['mobile_imeione'] ?></td>
                                </tr>

                                <tr>
                                    <td>IMEI: 02</td>
                                    <td><?php echo  $fetch_getMobileByImei['mobile_imeitwo'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->

            <?php
                $sum = $sum + $fetch_getMobileByImei['sell_price'];
            }
            ?>

            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <!-- <form method="POST"> -->
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Customer Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="<?php echo  $fetch_getClientData['customer_name'] ?>" readonly name="customer_name" placeholder="Customer Name" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Cell #</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="customer_cell"  value="<?php echo  "0".$fetch_getClientData['customer_contact']; ?>" readonly placeholder="03xxxxxxxxx" required="">
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
                                    <input type="text" class="form-control" name="customer_address"  value="<?php echo  $fetch_getClientData['customer_shop'].", ".$fetch_getClientData['customer_address']; ?>" readonly  placeholder="Address" required="">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label totalSum">Net Amount</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="Ntotal" name="Ntotal"  value="<?php echo $sum ?>" readonly placeholder="Price" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label totalSum">Paid Amount</label>
                                <div class="col-sm-8">
                                    <input type="number" value="0" class="form-control" id="Ptotal" name="Ptotal" onkeyup="calcAmount(this)" placeholder="Price" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label totalSum">Remaing Amount</label>
                                <div class="col-sm-8">
                                    <input type="number" value="0" class="form-control" id="Rtotal" readonly name="Rtotal" placeholder="Price" required="">
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="sellMobile" class="btn btn-primary waves-effect waves-light">Sell Mobile!</button>
                                </div>
                            </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>

        </div> <!-- end row -->
    </div><!-- container fluid -->
</form>
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

<script>
    // function Calc(v) {
    //     var index = $(v).parent().parent().index();

    //     var sell = document.getElementsByName("sell_price[]")[index].value;
    //     console.log(sell)
    // }

    function calcSub(){
    var totalPrice = 0;
        $(".singleSum").each(function(){
            totalPrice += parseInt($(this).val());
            $("#Ntotal").val(totalPrice);
        });
    }


    function calcAmount(e){
    var netAmount = $("#Ntotal").val();
    var sum = netAmount - e.value;

    console.log($(this))
    $("#Rtotal").val(sum);

        // $("#Ntotal").each(function(){
        //     netAmount += parseInt($(this).val());
        //     console.log(netAmount)
        //     $("#Rtotal").val(netAmount);
        // });
    }



</script>

</body>

</html>