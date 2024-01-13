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
                <h5 class="page-title">Roster</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Roster List</h4>
                       
                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Institute Name</th>
                                    <th>Year / Month</th>
                                    <th class="text-center"> <i class="fa fa-edit"></i>
                                    <th class="text-center"> <i class="fa fa-print"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $retInstitutes = mysqli_query($connect, "SELECT roster_summary.*, institutes.institutes_name FROM `roster_summary`
                                INNER JOIN institutes ON institutes.i_id = roster_summary.ins_id
                                ORDER BY roster_summary.de_date DESC");

                                $iteration = 1;

                                while ($rowInstitutes = mysqli_fetch_assoc($retInstitutes)) {
                                    echo '
                                    <tr>
                                        <td>'.$iteration++.'</td>
                                        <td>'.$rowInstitutes['institutes_name'].'</td>
                                        <td>'.$rowInstitutes['month_of'].'</td>';
                                        $explode = explode("/", $rowInstitutes['month_of']);
                                        $explode_month = $explode[1];

                                        $monthIs = (int)$explode_month;
                                        echo '
                                        <td class="text-center"><a href="roster_college_edit.php?ins='.$rowInstitutes['ins_id'].'&month='.$explode_month.'&refNo='.$rowInstitutes['refNo'].'" type="button" class="btn text-white btn-warning waves-effect waves-light">Edit</a></td>
                                        <td class="text-center"><a href="roster_print.php?ins='.$rowInstitutes['ins_id'].'&month='.$monthIs.'&refNo='.$rowInstitutes['refNo'].'" type="button" class="btn text-white btn-primary waves-effect waves-light">Print</a></td>
                                    </tr>
                                    ';
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