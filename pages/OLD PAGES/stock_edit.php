<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $notAdded = '';

    $id = $_GET['id'];
    $getQuery = mysqli_query($connect, "SELECT * FROM stock_add WHERE st_id = '$id'");
    $fetch_getQuery = mysqli_fetch_assoc($getQuery);


    if (isset($_POST['editStock'])) {
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
        
        $id                 = $_POST['id'];

        $o_name             = $_POST['o_name'];
        $o_address          = $_POST['o_address'];
        $o_contact          = $_POST['o_contact'];
        $o_bill             = $_POST['o_bill'];

        $queryUpdateStock = mysqli_query($connect, 
            "UPDATE `stock_add` SET 
                `comp_id` = '$comp_id',
                 `mod_id` = '$mod_id',
                  `purchase_price` = '$purchase_price',
                   `sell_price` = '$sell_price',
                    `purchase_date` = '$purchase_date',
                     `mobile_color` = '$mobile_color',
                      `mobile_ram` = '$mobile_ram',
                       `mobile_space` = '$mobile_space',
                        `mobile_condition` = '$mobile_condition',
                         `mobile_imei` = '$mobile_imei',
                          `mobile_imeione` = '$mobile_imeione',
                           `mobile_imeitwo` = '$mobile_imeitwo',
                            `box_status` = '$box_status',
                             `o_name` = '$o_name',  
                              `o_address` = '$o_address', 
                               `o_contact` = '$o_contact', 
                                `o_bill` = '$o_bill'
                            
                             WHERE st_id = '$id'
           ");

        if (!$queryUpdateStock) {
            $notAdded = 'Not added';
        }else {
            header("LOCATION: stock_list.php");
        }
    }


    include('../_partials/header.php') 
?>
<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datetimepicker.css">
<!-- Top Bar End -->
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Edit Stock</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <h4 class="mb-4 page-title"><u>Phone Detials</u></h4>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Company</label>
                                <div class="col-sm-4">
                                    <?php
                                        $getCompanies = mysqli_query($connect, "SELECT * FROM companies");
                                        
                                        echo '<select class="form-control comp" name="comp_id" required>';
                                        while ($row = mysqli_fetch_assoc($getCompanies)) {
                                            if ($row['id'] === $$fetch_getQuery['comp_id']) {
                                                echo '<option value="'.$row['id'].'" selected>'.$row['company_name'].'</option>';
                                            }else {
                                                echo '<option value="'.$row['id'].'">'.$row['company_name'].'</option>';
                                            }
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
                                            if ($row['mod_id'] === $fetch_getQuery['mod_id']) {
                                                echo '<option value="'.$row['mod_id'].'" selected>'.$row['model_name'].'</option>';
                                            }else {
                                                echo '<option value="'.$row['mod_id'].'">'.$row['model_name'].'</option>';
                                            }
                                        }

                                        echo '</select>';
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Purchase Price</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" value="<?php echo $fetch_getQuery['purchase_price'] ?>"  name="purchase_price" placeholder="Purshase Price" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Sell Price</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" value="<?php echo $fetch_getQuery['sell_price'] ?>"  name="sell_price" placeholder="Sell Price" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Purchase Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control"  value="<?php echo $fetch_getQuery['purchase_date'] ?>"  name="purchase_date" placeholder="Purshase Date" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Mobile Color</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  value="<?php echo $fetch_getQuery['mobile_color'] ?>"  name="mobile_color" placeholder="Mobile Color" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Ram</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  value="<?php echo $fetch_getQuery['mobile_ram'] ?>"  name="mobile_ram" placeholder="Ram" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Space</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="mobile_space"  value="<?php echo $fetch_getQuery['mobile_space'] ?>"  placeholder="Mobile Space" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Mobile Condition</label>
                                <div class="col-sm-4">
                                    <select name="mobile_condition" class="form-control comp">
                                        <?php
                                        if ($fetch_getQuery['mobile_condition'] === '1') {
                                            echo '
                                            <option value="1" selected>Rough</option>
                                            <option value="2">Fresh</option>
                                            ';
                                        }elseif ($fetch_getQuery['mobile_condition'] === '2') {
                                            echo '
                                            <option value="1">Rough</option>
                                            <option value="2" selected>Fresh</option>
                                        ';
                                        }
                                        ?>
                                        
                                    </select>
                                </div>

                                <label class="col-sm-2 col-form-label">IMEI Status</label>
                                <div class="col-sm-4">
                                    <select name="mobile_imei" class="form-control comp">
                                        <?php
                                        if ($fetch_getQuery['mobile_imei'] === '1') {
                                            echo '
                                            <option value="1" selected>PTA Approved</option>
                                            <option value="2">PTA Non-Approved</option>
                                            <option value="3">IMEI Changed</option>
                                            ';
                                        }elseif ($fetch_getQuery['mobile_imei'] === '2') {
                                            echo '
                                            <option value="1">PTA Approved</option>
                                            <option value="2" selected>PTA Non-Approved</option>
                                            <option value="3">IMEI Changed</option>
                                        ';
                                        }elseif ($fetch_getQuery['mobile_imei'] === '3') {
                                            echo '
                                            <option value="1">PTA Approved</option>
                                            <option value="2">PTA Non-Approved</option>
                                            <option value="3" selected>IMEI Changed</option>
                                        ';
                                        }
                                        ?>
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">IMEI No. 1</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="mobile_imeione"  value="<?php echo $fetch_getQuery['mobile_imeione'] ?>"  placeholder="IMEI_01" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">IMEI No. 2</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="mobile_imeitwo"  value="<?php echo $fetch_getQuery['mobile_imeitwo'] ?>"  placeholder="IMEI_02" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Box Status</label>
                                <div class="col-sm-4">
                                    <select name="box_status" class="form-control comp">
                                        <?php
                                        if ($fetch_getQuery['box_status'] === '1') {
                                            echo '
                                                <option value="1" selected>Yes</option>
                                                <option value="0">No</option>
                                            ';
                                        }elseif ($fetch_getQuery['box_status'] === '0') {
                                            echo '
                                            <option value="1">Yes</option>
                                            <option value="0" selected>No</option>
                                        ';
                                        }
                                        ?>
                                        
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="o_name" value="<?php echo $fetch_getQuery['o_name'] ?>" placeholder="Owner Name" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="o_address" value="<?php echo $fetch_getQuery['o_address'] ?>" placeholder="Owner Address" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Contact</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="o_contact" value="0<?php echo $fetch_getQuery['o_contact'] ?>" placeholder="Owner Contact" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Bill No</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="o_bill" value="<?php echo $fetch_getQuery['o_bill'] ?>" placeholder="Bill Number" required="">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="editStock" class="btn btn-primary waves-effect waves-light">Edit Stock</button>
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