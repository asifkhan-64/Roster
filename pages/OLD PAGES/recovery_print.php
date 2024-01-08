<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }
    $id = $_GET['id'];
    $r_id = $_GET['r_id'];

    $selectCustomer = mysqli_query($connect, "SELECT market_recovery.*, customer_add.* FROM `market_recovery`
                                INNER JOIN customer_add ON customer_add.c_id = market_recovery.c_id
                                WHERE market_recovery.r_id = '$r_id' AND market_recovery.c_id = '$id'");

    $fetch_selectCustomer = mysqli_fetch_assoc($selectCustomer);

    $get_info = mysqli_query($connect, "SELECT * FROM shop_info WHERE id = '1'");
    $fetch_get_info = mysqli_fetch_assoc($get_info);


    include '../_partials/header.php';
?>
<!-- <link rel="stylesheet" type="text/css" href="printCss.css"> -->

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
                <h5 class="page-title d-inline">Market Recovery Print Slip</h5>
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
                                       <br>
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; margin-top: 0px !important; color: black !important;">

                            <tbody>
                            <?php
                                echo '
                                <tr>
                                    <td style="width: 100%; line-height: 0px; font-size: 10px; color: black; font-weight: bold;">Name</td>

                                    <td style="width: 100%; font-size: 10px; line-height: 0px; color: black; font-weight: bold;">
                                        '.$fetch_selectCustomer['customer_name'].'
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 100%; line-height: 0px; font-size: 10px; color: black; font-weight: bold;">Contact</td>

                                    <td style="width: 100%; font-size: 10px; line-height: 0px; color: black; font-weight: bold;">
                                        0'.$fetch_selectCustomer['customer_contact'].'
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 100%; line-height: 0px; font-size: 10px; color: black; font-weight: bold;">Shop</td>

                                    <td style="width: 100%; font-size: 10px; line-height: 0px; color: black; font-weight: bold;">
                                        '.$fetch_selectCustomer['customer_shop'].'
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 100%; line-height: 0px; font-size: 10px; color: black; font-weight: bold;">Date</td>

                                    <td style="width: 100%; font-size: 10px; line-height: 0px; color: black; font-weight: bold;">
                                        '.$fetch_selectCustomer['payment_date'].'
                                    </td>
                                </tr>
                                ';
                            ?>    
                            </tbody>
                        </table>

      

                        <br><br><br>

                        
                        <div style="font-size: 12px; font-weight: bold; " class="float-right">
                            <label style="font-size: 10px"> Paid Amount:</label>
                            <span style="font-size: 10px"><?php echo "Rs. ".$fetch_selectCustomer['paid_amount'] ?></span>
                        </div>
                                
                        <hr><br><br><br>

                        <div style="font-size: 12px; font-weight: bold; " class="float-right">
                            <label style="font-size: 10px"> Balance:</label>
                            <span style="font-size: 10px"><?php echo "Rs. ".$fetch_selectCustomer['total_dues'] ?></span>
                        </div>
                                
                        <hr><br><br><br>

                        <div style="font-size: 12px; font-weight: bold; " class="text-center">
                            <span style="font-size: 10px"><q><i><?php echo "  ".$fetch_selectCustomer['description_amount']."  " ?></i></q></span>
                        </div>
                            <br /><br><br>    
                        <hr>
                        
                        <div style="font-size: 12px; font-weight: bold">
                            <label style="font-size: 10px"> Contact:</label>
                            <span style="font-size: 10px"><?php echo "0".$fetch_get_info['shop_contact'] ?></span>
                        </div>

                        <br /><br />
                        <div style="font-size: 12px; font-weight: bold; line-height: 6px !important">
                            <label style="font-size: 10px"> Address:</label>
                            <span style="font-size: 10px"><?php echo $fetch_get_info['shop_address'] ?></span>
                        </div>

                        <!-- <hr style="background-color: black !important;"> -->
                            <h3 align="center" style="font-size: 15px; font-weight: bold; font-family: Georgia"><i>Thank You!</i></h3>
                        <hr style="background-color: black !important;">

                        <div style="font-size: 12px; font-weight: bold; line-height: 6px !important">
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