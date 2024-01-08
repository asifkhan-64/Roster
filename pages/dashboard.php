<?php 
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }
    include('../_partials/header.php');

    $countedAllProducts = mysqli_query($connect, "SELECT COUNT(*) AS countedIns FROM `institutes`");
    $fetch_countedAllIns = mysqli_fetch_assoc($countedAllProducts);
    $Ins = $fetch_countedAllIns['countedIns'];


    // $approvedProducts = mysqli_query($connect, "SELECT COUNT(*) AS approvedProducts FROM `stock_add` WHERE mobile_status = '1' AND mobile_imei = '1'");
    // $fetch_approvedProducts = mysqli_fetch_assoc($approvedProducts);
    // $approved = $fetch_approvedProducts['approvedProducts'];

    // $nonApprovedProducts = mysqli_query($connect, "SELECT COUNT(*) AS nonApprovedProducts FROM `stock_add` WHERE mobile_status = '1' AND mobile_imei = '2'");
    // $fetch_nonApprovedProducts = mysqli_fetch_assoc($nonApprovedProducts);
    // $nonApproved = $fetch_nonApprovedProducts['nonApprovedProducts'];

    // $imeiChange = mysqli_query($connect, "SELECT COUNT(*) AS imeiChange FROM `stock_add` WHERE mobile_status = '1' AND mobile_imei = '3'");
    // $fetch_imeiChange = mysqli_fetch_assoc($imeiChange);
    // $changeProducts = $fetch_imeiChange['imeiChange'];

?>

        <div class="page-content-wrapper ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <h5 class="page-title">Dashboard</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card mini-stat m-b-30" style="background-color:#DD4B39">
                            <div class="p-3  text-white">
                                <div class="mini-stat-icon">
                                    <i class="fa fa-area-chart float-right mb-0"></i>
                                </div>
                                <h6 class="text-uppercase mb-0">All Institutes</h6>
                            </div>
                            <div class="card-body">
                                <div class="border-bottom pb-4 text-center text-white">
                                    <span style="  font-size: 100px"><?php echo $Ins ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card mini-stat m-b-30" style="background-color: #00A65A">
                            <div class="p-3  text-white">
                                <div class="mini-stat-icon">
                                    <i class="fa fa-check float-right mb-0"></i>
                                </div>
                                <h6 class="text-uppercase mb-0">PTA Apprroved</h6>
                            </div>
                            <div class="card-body">
                                <div class="border-bottom pb-4 text-center text-white">
                                    <span style="  font-size: 100px"><?php echo $approved ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card mini-stat m-b-30" style="background-color:#00C0EF ">
                            <div class="p-3  text-white">
                                <div class="mini-stat-icon">
                                    <i class="fa fa-times float-right mb-0"></i>
                                </div>
                                <h6 class="text-uppercase mb-0">NON_PTA</h6>
                            </div>
                            <div class="card-body">
                                <div class="border-bottom pb-4 text-center text-white">
                                    <span style="font-size: 100px"><?php echo $nonApproved ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card mini-stat m-b-30" style="background-color: #F39C12">
                            <div class="p-3  text-white">
                                <div class="mini-stat-icon">
                                    <i class="fa fa-edit float-right mb-0"></i>
                                </div>
                                <h6 class="text-uppercase  mb-0">IMEI Changed</h6>
                            </div>
                            <div class="card-body">
                                <div class="border-bottom pb-4 text-center text-white">
                                    <span style=" font-size: 100px"><?php echo $changeProducts  ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../_partials/footer.php'; ?>

</div>
    <!-- End Right content here -->

</div>
<!-- END wrapper -->


<!-- jQuery  -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/modernizr.min.js"></script>
<script src="../assets/js/detect.js"></script>
<script src="../assets/js/fastclick.js"></script>
<script src="../assets/js/jquery.slimscroll.js"></script>
<script src="../assets/js/jquery.blockUI.js"></script>
<script src="../assets/js/waves.js"></script>
<script src="../assets/js/jquery.nicescroll.js"></script>
<script src="../assets/js/jquery.scrollTo.min.js"></script>

<!-- skycons -->
<script src="../assets/plugins/skycons/skycons.min.js"></script>

<!-- skycons -->
<script src="../assets/plugins/peity/jquery.peity.min.js"></script>

<!--Morris Chart-->
<script src="../assets/plugins/morris/morris.min.js"></script>
<script src="../assets/plugins/raphael/raphael-min.js"></script>

<!-- dashboard -->
<script src="../assets/pages/dashboard.js"></script>

<!-- App js -->
<script src="../assets/js/app.js"></script>

</body>
</html>

  