<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $notAdded = '';


    if (isset($_POST['addStock'])) {
        $comp_id            = $_POST['comp_id'];
        $mod_id             = $_POST['mod_id'];
        $purchase_price     = $_POST['purchase_price'];
        $sell_price         = $_POST['sell_price'];
        $purchase_date      = $_POST['purchase_date'];
        $mobile_color       = $_POST['mobile_color'];
        $mobile_ram         = $_POST['mobile_ram'];
        $mobile_space       = $_POST['mobile_space'];
        $mobile_condition   = $_POST['mobile_condition'];
        $mobile_imei        = $_POST['mobile_imei'];
        $mobile_imeione     = $_POST['mobile_imeione'];
        $mobile_imeitwo     = $_POST['mobile_imeitwo'];
        $box_status         = $_POST['box_status'];

        $o_name             = $_POST['o_name'];
        $o_address          = $_POST['o_address'];
        $o_contact          = $_POST['o_contact'];
        $o_bill             = $_POST['o_bill'];

        $queryAddStock = mysqli_query($connect, 
            "INSERT INTO `stock_add`(
                `comp_id`,
                 `mod_id`,
                  `purchase_price`,
                   `sell_price`,
                    `purchase_date`,
                     `mobile_color`,
                      `mobile_ram`,
                       `mobile_space`,
                        `mobile_condition`,
                         `mobile_imei`,
                          `mobile_imeione`,
                           `mobile_imeitwo`,
                            `box_status`,
                             `o_name`,
                              `o_address`,
                               `o_contact`,
                                `o_bill`
                ) VALUES (
                    '$comp_id',
                     '$mod_id',
                      '$purchase_price',
                       '$sell_price',
                        '$purchase_date',
                         '$mobile_color',
                          '$mobile_ram',
                           '$mobile_space',
                            '$mobile_condition',
                             '$mobile_imei',
                              '$mobile_imeione',
                               '$mobile_imeitwo',
                                '$box_status',
                                 '$o_name',
                                  '$o_address',
                                   '$o_contact',
                                    '$o_bill'
            )
           ");

        if (!$queryAddStock) {
            $notAdded = 'Not added';
        }else {
            header("LOCATION: stock_list.php");
        }
    }


    include('../_partials/header.php') 
?>
<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datetimepicker.css">
<!-- Top Bar End -->
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Add Stock</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                        <h4 class="mb-4 page-title"><u>Phone Detials</u></h4>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Company</label>
                                <div class="col-sm-4">
                                    <?php
                                        $getCompanies = mysqli_query($connect, "SELECT * FROM companies");
                                        
                                        echo '<select class="form-control comp" name="comp_id" required>';
                                        while ($row = mysqli_fetch_assoc($getCompanies)) {
                                            echo '<option value="'.$row['id'].'">'.$row['company_name'].'</option>';
                                            
                                        }

                                        echo '</select>';
                                    ?>
                                </div>


                                <label class="col-sm-2 col-form-label">Model</label>
                                <div class="col-sm-4">
                                    <?php
                                        $getCompanies = mysqli_query($connect, "SELECT * FROM company_model");
                                        
                                        echo '<select class="form-control comp" name="mod_id" required>';
                                        while ($row = mysqli_fetch_assoc($getCompanies)) {
                                            echo '<option value="'.$row['mod_id'].'">'.$row['model_name'].'</option>';
                                        }

                                        echo '</select>';
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Purchase Price</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="purchase_price" placeholder="Purshase Price" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Sell Price</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="sell_price" placeholder="Sell Price" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Purchase Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="purchase_date" placeholder="Purshase Date" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Mobile Color</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="mobile_color" placeholder="Mobile Color" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Ram</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="mobile_ram" placeholder="Ram" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Space</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="mobile_space" placeholder="Mobile Space" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Mobile Condition</label>
                                <div class="col-sm-4">
                                    <select name="mobile_condition" class="form-control comp">
                                        <option value="1">Rough</option>
                                        <option value="2">Fresh</option>
                                    </select>
                                </div>

                                <label class="col-sm-2 col-form-label">IMEI Status</label>
                                <div class="col-sm-4">
                                    <select name="mobile_imei" class="form-control comp">
                                        <option value="1">PTA Approved</option>
                                        <option value="2">PTA Non-Approved</option>
                                        <option value="3">IMEI Changed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">IMEI No. 1</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="mobile_imeione" placeholder="IMEI_01" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">IMEI No. 2</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="mobile_imeitwo" placeholder="IMEI_02" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Box Status</label>
                                <div class="col-sm-4">
                                    <select name="box_status" class="form-control comp">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="o_name" placeholder="Owner Name" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="o_address" placeholder="Owner Address" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Contact</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="o_contact" placeholder="Owner Contact" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Bill No</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="o_bill" placeholder="Bill Number" required="">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="addStock" class="btn btn-primary waves-effect waves-light">Add Stock</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <h3>
                        <?php echo $notAdded; ?>
                    </h3>
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
<!-- App js -->
        <?php include('../_partials/app.php') ?>
        <?php include('../_partials/datetimepicker.php') ?>

<script type="text/javascript">
    $(".form_datetime").datetimepicker({
        format: "yyyy-mm-dd hh:ii"
    });
</script>
        
<script type="text/javascript" src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
$('.comp').select2({
  placeholder: 'Select an option',
  allowClear:true
  
});
</script>
</body>

</html>