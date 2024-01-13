<?php
    include('../_stream/config.php');
    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $alreadyAdded = '';
    $added = '';
    $error= '';

    $month = $_GET['month'];

    $ins = $_GET['ins'];

    $getIns = mysqli_query($connect, "SELECT institutes_name FROM institutes WHERE i_id = '$ins'");
    $fetch_getIns = mysqli_fetch_assoc($getIns);

    if (isset($_POST['submit'])) {
        // an Array
        $s_id_array = $_POST['s_id'];
        $std_ward_array = $_POST['std_ward'];

        $month = $_POST['month'];
        $ins = $_POST['ins'];
        
        $getRefNo = mysqli_query($connect, "SELECT MAX(refNo) AS refNo FROM roster_db");
        $fetch_getrefNo = mysqli_fetch_assoc($getRefNo);

        if ($fetch_getrefNo['refNo'] === 'NULL') {
            $refNo = 1;
        }else {
            $refNo = $fetch_getrefNo['refNo'] + 1;
        }

        for ($i=0; $i < sizeof($s_id_array) ; $i++) {
            $s_id = $s_id_array[$i];
            $std_ward = $std_ward_array[$i];

            $getMonthCountMax = mysqli_query($connect, "SELECT month_count FROM students WHERE std_id = '$s_id'");
            $fetch_getMonthCountMax = mysqli_fetch_assoc($getMonthCountMax);
            
            $getStdData = mysqli_query($connect, "SELECT month_count FROM students WHERE std_id = '$s_id'");
            $fetch_getStdData = mysqli_fetch_assoc($getStdData);

            $month_count = $fetch_getStdData['month_count'];

            $getWardName = mysqli_query($connect, "SELECT ward_name FROM wards WHERE w_id = '$std_ward'");
            $fetch_getWardName = mysqli_fetch_assoc($getWardName);
            $stdWardName = $fetch_getWardName['ward_name'];

            if ($month_count === '1') {
                $updateStudentTable = mysqli_query($connect, "UPDATE students SET month_one = '$stdWardName' WHERE std_id = '$s_id'");
            }elseif ($month_count === '2') {
                $updateStudentTable = mysqli_query($connect, "UPDATE students SET month_two = '$stdWardName' WHERE std_id = '$s_id'");
            }elseif ($month_count === '3') {
                $updateStudentTable = mysqli_query($connect, "UPDATE students SET month_three = '$stdWardName' WHERE std_id = '$s_id'");
            }elseif ($month_count === '4') {
                $updateStudentTable = mysqli_query($connect, "UPDATE students SET month_four = '$stdWardName' WHERE std_id = '$s_id'");
            }elseif ($month_count === '5') {
                $updateStudentTable = mysqli_query($connect, "UPDATE students SET month_five = '$stdWardName' WHERE std_id = '$s_id'");
            }elseif ($month_count === '6') {
                $updateStudentTable = mysqli_query($connect, "UPDATE students SET month_six = '$stdWardName' WHERE std_id = '$s_id'");
            }

            $updateRosterDb = mysqli_query($connect, "UPDATE roster_db SET r_ward = '$std_ward' WHERE s_id = '$s_id'");
        }

        if ($updateRosterDb) {
            header("LOCATION: roster_list.php");
        }
    }

    include('../_partials/header.php');
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title text-center">(Edit) Duty Roster for Students of <?php echo $fetch_getIns['institutes_name'] ?></h5>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <form method="POST">
                        <div class="card-body">
                            <button class="btn btn-primary p-3 m-2" style="width: 30%;" name="submit" type="submit">Update Roster</button>                        
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
                                                <td class="text-center">'."0".''.$rowStdData['month_count'].'</td>';

                                                $getWard = mysqli_query($connect, "SELECT * FROM wards");
                                                $studentId = $rowStdData['std_id'];

                                                $getRosterData = mysqli_query($connect, "SELECT r_ward FROM roster_db WHERE s_id = $studentId");
                                                $fetch_getRosterData = mysqli_fetch_assoc($getRosterData);
                                                $r_id = $fetch_getRosterData['r_ward'];
                                                
                                                echo '<td><select style="width: 110% !important" class="form-control comp" name="std_ward[]" required>';
                                                while ($row = mysqli_fetch_assoc($getWard)) {
                                                    if ($r_id === $row['w_id']) {
                                                        echo '<option value="'.$row['w_id'].'" selected>'.$row['ward_name'].'</option>';
                                                    }else {
                                                        echo '<option value="'.$row['w_id'].'">'.$row['ward_name'].'</option>';
                                                    }
                                                }
                                                date_default_timezone_set("Asia/Karachi");
                                                $currentYear = date("Y/m");

                                                echo '</select></td>

                                                <input type="hidden" name="s_id[]" value="'.$rowStdData['std_id'].'" />
                                                <input type="hidden" name="month" value="'.$currentYear.'" />
                                                <input type="hidden" name="ins" value="'.$ins.'" />
                                            </tr>
                                            ';
                                            
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
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