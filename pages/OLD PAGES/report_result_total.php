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

    $retSoldData = mysqli_query($connect, "SELECT COUNT(*) AS totalSoldPhones FROM `sell_product` WHERE customer_date BETWEEN '$fromDate' AND '$toDate'");
    $fetch_retSoldData = mysqli_fetch_assoc($retSoldData);

    $get_info = mysqli_query($connect, "SELECT * FROM shop_info WHERE id = '1'");
    $fetch_get_info = mysqli_fetch_assoc($get_info);
?>

<style type="text/css">
    #colorId {
        /*font-size: 14px;*/
        /*font-family: 'Times New Roman';*/
        font-family: Lucida Sans Unicode;
        color: black;
    }
</style>
<div class="page-content-wrapper" id="colorId">
    <div class="container-fluid"><br>
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title d-inline">Invoice Print Slip</h5>
                <a type="button" href="#" id="printButton"  class="btn btn-success waves-effect waves-light float-right btn-lg mb-3"><i class="fa fa-print"></i> Print</a>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30" >
                    <div class="card-body" id="printElement" >
                        <form method="POST" style="margin-top: -35px !important; line-height: 4px;">
                                          
                        <div class="row" style="margin-top: -10px !important; line-height: 4px;">
                            <div class="col-12" style="margin-top: -10px !important;">
                                <div class="invoice-title text-center">
                                    <h3 class="m-t-0 m-b-0 text-center">
                                        <h3 align="center" style="font-size: 15px; font-weight: bold"><?php echo $fetch_get_info['shop_name']; ?></h3>
                                        
                                        <h4 class="float-center" style="font-size: 10px; margin-top: -10px !important;">Date: 
                                            <?php
                                                echo $date = $fromDate . " - " .$toDate;
                                            ?>
                                        </h4><br>
                                    </h3>
                                </div>
                            </div>
                        </div>

                        

                        <br>

                        <table id="datatable" class="table table-bordered  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; border: 1.3px solid black !important; margin-top: 0px !important; color: black !important;">

                            <tbody>
                             <?php 
                                
                                $iteration = 1;

                                $sum = 0;

                                while ($rowMobiles = mysqli_fetch_assoc($retMobiles)) {
                                        $profit = $rowMobiles['sell_price'] - $rowMobiles['purchase_price'];

                                        $sum = $sum + $profit;
                                }
                                ?>    
                            </tbody>
                        </table>

                         <br>
                        <hr> <br>
                        

                        
                        <div style="font-size: 12px; font-weight: bold; " class="float-center">
                            <h4 align="center" class="float-center" style="font-size: 10px; margin-top: -10px !important;">
                                Total Profit: <?php echo "Rs. ".$sum ?>
                            </h4>
                            
                        </div>

                        <hr>
                        <br />
                        
                        <div style="font-size: 12px; font-weight: bold; " class="float-center">
                            <h4 align="center" class="float-center" style="font-size: 10px; margin-top: -10px !important;">
                                Phones Count: <?php echo $fetch_retSoldData['totalSoldPhones'] ?>
                            </h4>
                            
                        </div>
                                
                        <hr>
                        <br />
                        


                        <!-- <hr style="background-color: black !important;"> -->
                        <h3 align="center" style="font-size: 15px; font-weight: bold; font-family: Georgia"><i>Thank You!</i></h3>
                        <hr style="background-color: black !important;">

                        <div align="center"  style="font-size: 12px; font-weight: bold; line-height: 6px !important">
                            <label style="font-size: 8px"><b><i>Developed By:</i></b></label>
                            <span style="font-size: 8px"><b><i>Team Pixelium 03460973906</i></b></span>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container fluid -->
    </div> <!-- Page content Wrapper -->
</div> <!-- content -->
<?php include '../_partials/footer.php'?>
</div>
<!-- End Right content here -->
</div>
<!-- END wrapper -->
<!-- jQuery  -->
<?php include '../_partials/jquery.php'?>
<!-- App js -->
<?php include '../_partials/app.php'?>
<?php include '../_partials/datetimepicker.php'?>
<script type="text/javascript" src="../assets/js/select2.min.js"></script>

<script type="text/javascript" src="../assets/print.js"></script>

<script type="text/javascript">

 
    function print() {
    printJS({
    printable: 'printElement',
    type: 'html',
    targetStyles: ['*']
 })
}

    document.getElementById('printButton').addEventListener ("click", print)



</script>

<script type="text/javascript">
$('.designation').select2({
    placeholder: 'Select an option',
    allowClear: true

});

$('.attendant').select2({
    placeholder: 'Select an option',
    allowClear: true

});
</script>
<script type="text/javascript" src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
$('.select2').select2({
    placeholder: 'Select an option',
    allowClear: true

});
</script>
</body>

</html>

