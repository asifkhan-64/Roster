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
    $getStdData = mysqli_query($connect, "SELECT * FROM students WHERE std_id = '$id'");
    $fetch_getStdData = mysqli_fetch_assoc($getStdData);

    include('../_partials/header.php');
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h5 class="page-title">Previous Data of Student <?php echo $fetch_getStdData['std_name']; ?></h5>
            </div>
            <div class="col-md-6">
                <h5 class="text-right"><a style="color: red;" href="javascript:window. close();"> Exit Tab <i class="fa fa-times"></i></i> </a> </h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">History</h4>

                       
                        <table id="datatables" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            
                            <tbody>
                                <tr>
                                    <th>Month 01</th>
                                    <th>
                                        <?php
                                            if (empty($fetch_getStdData['month_one'])) {
                                                echo "No data found!";
                                            }else {
                                                echo $fetch_getStdData['month_one'];
                                            }
                                        ?>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Month 02</th>
                                    <th>
                                        <?php
                                            if (empty($fetch_getStdData['month_two'])) {
                                                echo "No data found!";
                                            }else {
                                                echo $fetch_getStdData['month_two'];
                                            }
                                        ?>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Month 03</th>
                                    <th>
                                        <?php
                                            if (empty($fetch_getStdData['month_three'])) {
                                                echo "No data found!";
                                            }else {
                                                echo $fetch_getStdData['month_three'];
                                            }
                                        ?>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Month 04</th>
                                    <th>
                                        <?php
                                            if (empty($fetch_getStdData['month_four'])) {
                                                echo "No data found!";
                                            }else {
                                                echo $fetch_getStdData['month_four'];
                                            }
                                        ?>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Month 05</th>
                                    <th>
                                        <?php
                                            if (empty($fetch_getStdData['month_five'])) {
                                                echo "No data found!";
                                            }else {
                                                echo $fetch_getStdData['month_five'];
                                            }
                                        ?>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Month 06</th>
                                    <th>
                                        <?php
                                            if (empty($fetch_getStdData['month_six'])) {
                                                echo "No data found!";
                                            }else {
                                                echo $fetch_getStdData['month_six'];
                                            }
                                        ?>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
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
</body>

</html>