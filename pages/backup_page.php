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
                    <h5 class="page-title">Backup</h5>
                </div>
            </div>

            <br>
          <div class="row">
            <div class="col-md-12" align="center">
                <pre style="font-size:20px; font-family:Times; border: 1px solid #888; background-color:#c2c2c2"><marquee><b>To backup your database manually, click on the  [Database Backup] button.</b></marquee></pre>
            </div>
          </div><br><br><br><br><br><br><br><br>
          <div class="row" >
            <div class="col-md-12" style="display:flex; justify-content: center;">
                <a href="backup.php" data-toggle="tooltip" title="Download BackUp" data-placement="top" type="button" style="border-radius:.5rem; box-shadow:1px 1px 1px 1px #878787" class="btn btn-success btn-lg">Database Backup</a>
            </div>
          </div>
            <!-- end row -->
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
  