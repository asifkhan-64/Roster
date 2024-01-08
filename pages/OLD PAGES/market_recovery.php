<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $alreadyAdded = '';
    $added = '';
    $error= '';


    if (isset($_POST['addAmount'])) {
        $client             =     $_POST['client'];
        // $rem_dues           =     $_POST['rem_dues'];
        $payment_date       =     $_POST['payment_date'];
        $paid_amount        =     $_POST['paid_amount'];
        $remaining_amount   =     $_POST['remaining_amount'];
        $description_amount =     $_POST['description_amount'];

        $updateCustomerQuery = mysqli_query($connect, "UPDATE customer_add SET total_paid = (total_paid + $paid_amount), total_dues = (total_dues - $paid_amount) WHERE c_id = '$client'");

        if ($updateCustomerQuery) {
            $insertQuery = mysqli_query($connect, "INSERT INTO market_recovery
            (c_id, paid_amount, description_amount, payment_date)
            VALUES
            ('$client', '$paid_amount', '$description_amount', '$payment_date')");
            if (!$insertQuery) {
                $error = '
                <div class="alert alert-primary" role="alert">
                    Not Added! Try agian!
                </div>';
            }else {
                header("LOCATION: market_recovery_list.php");
            }
        }
    }

    include('../_partials/header.php');


?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Market Recovery</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Select Customer</label>
                                <div class="col-sm-10">
                                    <?php
                                        $getCustomers = mysqli_query($connect, "SELECT * FROM `customer_add`");
                                        
                                        echo '<select class="form-control comp" name="client" id="customer_selection" required >';
                                        while ($rowgetCustomers = mysqli_fetch_assoc($getCustomers)) {
                                            echo '<option value="'.$rowgetCustomers['c_id'].'">'.$rowgetCustomers['customer_name'].', 0'.$rowgetCustomers['customer_contact'].' -  Shop: '.$rowgetCustomers['customer_shop'].'</option>';
                                        }

                                        echo '</select>';
                                    ?>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Dues</label>
                                    <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                    <input type="number" name="dues" id="rem_dues" placeholder="" class="form-control" readonly="">
                                    </div>
                                    </div>    
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Date</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="date" name="payment_date" class="form-control pull-right" placeholder="Click to show Date" id="datepicker" required="">
                                    </div>
                                    </div>    
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Paid Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                        <input type="number" name="paid_amount" id="paid_amount" placeholder="" class="form-control" required="">
                                    </div>
                                    </div>    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Remaining Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                            <input type="number" name="remaining_amount" id="remaining_amount" placeholder="" class="form-control" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label>Description</label>
                                    <input type="text" name="description_amount" placeholder="Add description" class="form-control" required="">
                                </div>
                            </div>
                            
                            <hr>
                            <div class="form-group row">
                                <!-- <label for="example-password-input" class="col-sm-2 col-form-label"></label> -->
                                <div class="col-sm-12" align="right">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="addAmount">Add Amount</button>
                                </div>
                            </div>
                        </form>
                        <h5 align="center"><?php echo $error ?></h5>
                        <h5 align="center"><?php echo $added ?></h5>
                        <h5 align="center"><?php echo $alreadyAdded ?></h5>
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
  placeholder: 'No Mobile Phone Selected',
  allowClear:true
  
});
</script>

<script type="text/javascript">
  
  $(document).ready(function() {
    $('#customer_selection').change(function() {
      var customer_selection = $(this).val()
      console.log(customer_selection)
      $.ajax({
        url: "getCustomerData.php",
        method: "POST",
        data: {
          customer: customer_selection
        }, dataType: "text",
        success:function(response){
          // console.log(response)
          $('#rem_dues').val(response)
        },error:function(e){
          console.log(e)
        }
      });
    });
  });


    $(document).ready(function() {
    // $('#customer_selection').ready(function() {
      var customer_selection = $('#customer_selection').val()
      console.log(customer_selection)
      $.ajax({
        url: "getCustomerData.php",
        method: "POST",
        data: {
          customer: customer_selection
        }, dataType: "text",
        success:function(response){
          // console.log(response)
          $('#rem_dues').val(response)
        },error:function(e){
          console.log(e)
        }
      });
    // });
  });

  $(document).ready(function() {
    $('#paid_amount').val('0')
    $('#remaining_amount').val('0')

    $('#paid_amount').keyup(function() {
      if (isNaN($(this).val()))
        return
      var paidAmount = parseFloat($(this).val())
      var oldDues = parseInt($('#rem_dues').val())
      console.log(paidAmount)
      var remainingAmount = oldDues - paidAmount
      $('#remaining_amount').val(remainingAmount)
      $('#remainingAmount').keyup(function() {
        $(this).val("")
        $('#remaining_amount').val("")
      });
    });
  });

</script>
</body>

</html>