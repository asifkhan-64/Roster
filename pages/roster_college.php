<?php
    include('../_stream/config.php');
    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $alreadyAdded = '';
    $added = '';
    $error= '';

    $ins = $_GET['ins'];
    $getIns = mysqli_query($connect, "SELECT institutes_name FROM institutes WHERE i_id = '$ins'");
    $fetch_getIns = mysqli_fetch_assoc($getIns);



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
                <h5 class="page-title text-center">Duty Roster for Students of <?php echo $fetch_getIns['institutes_name'] ?></h5>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <!-- <h4 class="mt-0 header-title">Students List</h4> -->
                       
                        <table id="datatables" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>S#</th>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>Category</th>
                                    <th>Month</th>
                                    <th>Place of Duty</th>
                                    <!-- <th class="text-center"> <i class="fa fa-edit"></i> -->
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $retStdData = mysqli_query($connect, "SELECT students.*, technology.technology_name FROM `students`
                                                                    INNER JOIN technology ON technology.t_id = students.std_tech
                                                                    WHERE students.std_ins = '$ins'");
                                $iteration = 1;

                                while ($rowStdData = mysqli_fetch_assoc($retStdData)) {
                                    if (empty($rowStdData['month_one']) or empty($rowStdData['month_two']) or empty($rowStdData['month_three']) or empty($rowStdData['month_four']) or empty($rowStdData['month_five']) or empty($rowStdData['month_six'])) {
                                        echo '
                                        <tr>
                                            <td>'.$iteration++.'</td>
                                            <td><b><u><a href="old_data.php?id='.$rowStdData['std_id'].'" target="_blank" style="color:black">'.$rowStdData['std_name'].'</a></u></b></td>
                                            <td>'.$rowStdData['std_fname'].'</td>
                                            <td>'.$rowStdData['technology_name'].'</td>
                                            <td class="text-center">'."0".''.$rowStdData['month_count'] + 1 .'</td>';

                                            $getInstitutes = mysqli_query($connect, "SELECT * FROM wards");
                                            
                                            echo '<td><select style="width: 110% !important" class="form-control comp" name="std_ward" required>';
                                            while ($row = mysqli_fetch_assoc($getInstitutes)) {
                                                echo '<option value="'.$row['w_id'].'">'.$row['ward_name'].'</option>';
                                            }

                                            echo '</select></td>
                                        </tr>
                                        ';
                                    }else {
                                        echo '
                                        <td></td>
                                        <td></td>
                                        <td>No</td>
                                        <td>Data</td>
                                        <td>Found</td>
                                        <td></td>
                                        ';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
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
  placeholder: 'Select an option',
  allowClear:true
  
});
</script>
</body>

</html>