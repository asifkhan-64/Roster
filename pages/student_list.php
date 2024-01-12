<?php
    include('../_stream/config.php');
    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $alreadyAdded = '';
    $added = '';
    $error= '';

    if (isset($_POST['addInstitutes'])) {
        $institutesName = $_POST['institutesName'];

        $countQuery = mysqli_query($connect, "SELECT COUNT(*)AS countedInstitutes FROM institutes WHERE institutes_name = '$institutesName'");
        $fetch_countQuery = mysqli_fetch_assoc($countQuery);


        if ($fetch_countQuery['countedInstitutes'] == 0) {
            $insertQuery = mysqli_query($connect, "INSERT INTO institutes(institutes_name)VALUES('$institutesName')");
            if (!$insertQuery) {
                $error = 
                '<div class="alert alert-dark" role="alert">
                    Not Added! Try again!
                </div>';
            }else {
                $added = '
                <div class="alert alert-primary" role="alert">
                    Institute Added!
                </div>';
            }
        }else {
            $alreadyAdded = 
            '<div class="alert alert-dark" role="alert">
                Institute Already Added!
            </div>';
        }
    }


    include('../_partials/header.php');
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Students</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Students List</h4>
                       
                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>Institute</th>
                                    <th class="text-center"> <i class="fa fa-edit"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $retStdData = mysqli_query($connect, "SELECT students.std_id, students.std_name, students.std_fname, students.std_ins, institutes.institutes_name FROM `students`
                                                                        INNER JOIN institutes ON institutes.i_id = students.std_ins");
                                $iteration = 1;

                                while ($rowStdData = mysqli_fetch_assoc($retStdData)) {
                                    echo '
                                    <tr>
                                        <td>'.$iteration++.'</td>
                                        <td>'.$rowStdData['std_name'].'</td>
                                        <td>'.$rowStdData['std_fname'].'</td>
                                        <td>'.$rowStdData['institutes_name'].'</td>
                                        <td class="text-center"><a href="student_edit.php?id='.$rowStdData['std_id'].'" type="button" class="btn text-white btn-warning waves-effect waves-light">Edit</a></td>
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