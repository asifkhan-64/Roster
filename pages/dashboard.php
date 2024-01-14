<?php 
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }
    include('../_partials/header.php');

    $countedInst = mysqli_query($connect, "SELECT COUNT(*) AS countedIns FROM `institutes`");
    $fetch_countedAllIns = mysqli_fetch_assoc($countedInst);
    $Ins = $fetch_countedAllIns['countedIns'];

    $countedWards = mysqli_query($connect, "SELECT COUNT(*) AS countedWards FROM `wards`");
    $fetch_countedAllWards = mysqli_fetch_assoc($countedWards);
    $Wards = $fetch_countedAllWards['countedWards'];

    $countedTechnologies = mysqli_query($connect, "SELECT COUNT(*) AS countedTechnologies FROM `technology`");
    $fetch_countedTechnologies = mysqli_fetch_assoc($countedTechnologies);
    $Tech = $fetch_countedTechnologies['countedTechnologies'];
    
    $countedStudents = mysqli_query($connect, "SELECT COUNT(*) AS countedStudents FROM `students`");
    $fetch_countedStudents = mysqli_fetch_assoc($countedStudents);
    $Std = $fetch_countedStudents['countedStudents'];


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
                                    <i class="fa fa-school float-right mb-0"></i>
                                </div>
                                <h6 class="text-uppercase mb-0">All Institutes</h6>
                            </div>
                            <div class="card-body">
                                <div class="pb-4 text-center text-white">
                                    <span style="font-size: 50px"><?php echo $Ins ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card mini-stat m-b-30" style="background-color: #00A65A">
                            <div class="p-3  text-white">
                                <div class="mini-stat-icon">
                                    <i class="fa fa-microscope float-right mb-0"></i>
                                </div>
                                <h6 class="text-uppercase mb-0">Technologies</h6>
                            </div>
                            <div class="card-body">
                                <div class="pb-4 text-center text-white">
                                    <span style="  font-size: 50px"><?php echo $Tech ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card mini-stat m-b-30" style="background-color:#00C0EF ">
                            <div class="p-3  text-white">
                                <div class="mini-stat-icon">
                                    <i class="fa fa-bed float-right mb-0"></i>
                                </div>
                                <h6 class="text-uppercase mb-0">Wards</h6>
                            </div>
                            <div class="card-body">
                                <div class="pb-4 text-center text-white">
                                    <span style="font-size: 50px"><?php echo $Wards ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card mini-stat m-b-30" style="background-color: #F39C12">
                            <div class="p-3  text-white">
                                <div class="mini-stat-icon">
                                    <i class="fa fa-school float-right mb-0"></i>
                                </div>
                                <h6 class="text-uppercase  mb-0">Students</h6>
                            </div>
                            <div class="card-body">
                                <div class="pb-4 text-center text-white">
                                    <span style=" font-size: 50px"><?php echo $Std  ?></span>
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

  