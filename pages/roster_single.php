<?php
    include('../_stream/config.php');
    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $alreadyAdded = '';
    $added = '';
    $error= '';

    $stdID = $_GET['std_id'];

    $month = $_GET['month'];

    $ins = $_GET['ins'];

    $getIns = mysqli_query($connect, "SELECT institutes_name FROM institutes WHERE i_id = '$ins'");
    $fetch_getIns = mysqli_fetch_assoc($getIns);

    if (isset($_POST['submit'])) {
        // an Array
        $s_id = $_POST['s_id'];
        $std_ward = $_POST['std_ward'];

        $month = $_POST['month'];
        $ins = $_POST['ins'];
        
        $getRefNo = mysqli_query($connect, "SELECT refNo AS countedRostersRef FROM `roster_db` WHERE month_of = '$month' AND std_ins = '$ins' GROUP BY countedRostersRef");
        $fetch_getrefNo = mysqli_fetch_assoc($getRefNo);
        $refNo = $fetch_getrefNo['countedRostersRef'];
        

        // for ($i=0; $i < sizeof($s_id_array) ; $i++) {
            // $s_id = $s_id_array[$i];
            // $std_ward = $std_ward_array[$i];

            $insertQuery = mysqli_query($connect, "INSERT INTO roster_db(s_id, refNo, month_of, std_ins, r_ward)VALUES('$s_id', '$refNo', '$month', '$ins', '$std_ward')");
            
            if ($insertQuery) {

                $updateMonthCount = mysqli_query($connect, "UPDATE students SET month_count = (month_count + 1) WHERE std_id = '$s_id'");

                if ($updateMonthCount) {

                    $getMonthCountMax = mysqli_query($connect, "SELECT month_count FROM students WHERE std_id = '$s_id'");
                    $fetch_getMonthCountMax = mysqli_fetch_assoc($getMonthCountMax);
                    if ($fetch_getMonthCountMax === '6') {
                        
                    }else {
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
                    }
                }
            }

        // }
        // $insertSummary = mysqli_query($connect, "INSERT INTO roster_summary(ins_id, refNo, month_of)VALUES('$ins', '$refNo', '$month')");

        if ($updateStudentTable) {
            header("LOCATION: roster_print.php?ins=".$ins."&month=".$month."&refNo=".$refNo."");
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
                    <form method="POST">
                        <div class="card-body">
                            <button class="btn btn-primary p-3 m-2" style="width: 30%;" name="submit" type="submit">Add Roster</button>                        
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
                                                                        WHERE students.std_ins = '$ins' AND students.std_id = '$stdID'");
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
                                                date_default_timezone_set("Asia/Karachi");
                                                $currentYear = date("Y/m");

                                                echo '</select></td>

                                                <input type="hidden" name="s_id" value="'.$rowStdData['std_id'].'" />
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