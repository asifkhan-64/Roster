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
                <h5 class="page-title">Sell List (Multiple)</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title text-center">Sell List (Multiple)</h4>
                        <table id="datatable" class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Net</th>
                                    <th>Paid</th>
                                    <th>Dues</th>
                                    <th>Date</th>
                                    <th class="text-center"><i class='fa fa-print'></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $selectQuery = mysqli_query($connect, "SELECT customer_summary.*, customer_add.* FROM `customer_summary`
                                INNER JOIN customer_add ON customer_add.c_id = customer_summary.c_id
                                ORDER BY auto_date DESC");

                                $itr = 1;

                                while ($row = mysqli_fetch_assoc($selectQuery)) {
                                    echo '
                                        <tr>
                                            <td>'.$itr++.'</td>
                                            <td>'.$row['customer_name'].'</td>
                                            <td>0'.$row['customer_contact'].'</td>
                                            <td>'.$row['net_amount'].'</td>
                                            <td>'.$row['paid_amount'].'</td>
                                            <td>'.$row['remaining_amount'].'</td>
                                            <td>'.$row['custom_date'].'</td>
                                            
                                            <td class="text-center">
                                                <a href="printMultiple.php?refNo='.$row['invoice_id'].'" type="button" class="btn text-white btn-primary waves-effect waves-light btn-sm"><i class="fa fa-print"></i></a>
                                            </td>
                                        </tr>';
                                    }
                                ?>
                                
                                    
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
<!-- jQuery  -->
        <?php include('../_partials/jquery.php') ?>

<!-- Required datatable js -->
        <?php include('../_partials/datatable.php') ?>

<!-- Buttons examples -->
        <?php include('../_partials/buttons.php') ?>

<!-- Responsive examples -->
        <?php include('../_partials/responsive.php') ?>

<!-- Datatable init js -->
        <?php include('../_partials/datatableInit.php') ?>


<!-- Sweet-Alert  -->
        <?php include('../_partials/sweetalert.php') ?>


<!-- App js -->
        <?php include('../_partials/app.php') ?>
</body>

</html>