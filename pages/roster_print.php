<?php
    include('../_stream/config.php');
    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $month = $_GET['month'];

    $query = mysqli_query($connect, "SELECT * FROM months WHERE m_id = '$month'");
    $fetchQuery = mysqli_fetch_assoc($query);

    $ins = $_GET['ins'];

    $refNo = $_GET['refNo'];

    $getIns = mysqli_query($connect, "SELECT institutes_name FROM institutes WHERE i_id = '$ins'");
    $fetch_getIns = mysqli_fetch_assoc($getIns);



    include('../_partials/header.php');
?>
<style type="text/css">
    body, td {
        color: black;
    }
    
    table {
        font-size: 10px !important;
    }

    .teext {
        font-size: 10px !important;
    }
    
    li {
        font-size: 10px !important;
        margin-top: -5px;
        margin-bottom: -5px;
    }

    table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto; line-height: 0.00000000001 !important }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
    
    /*.table-responsive {*/
    /*    line-height: 3px;*/
    /*}*/
</style>

<div class="page-content-wrapper " >
    <div class="container-fluid"><br>
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title d-inline">Roster Print</h5>
                <a type="button" href="#" id="printButton" class="btn btn-success waves-effect waves-light float-right btn-lg mb-3"><i class="fa fa-print"></i> Print</a>
            </div>
        </div>
        <!-- end row -->
        
        <div class="row" id="printElement">
            <div class="col-12">
                <!-- <div class="card m-b-30"> -->
                    <p align="center" style="font-size: 12px !important; line-height: 0.6rem !important; line-height: 0.6rem !important; margin-bottom: 0.1rem;"><b>SAIDU GROUP OF TEACHING HOSPITALS, SWAT</b></p>
                    <p align="center" style="font-size: 12px !important; line-height: 1rem !important; margin-bottom: 0.1rem;"><b>
                        DUTY ROSTER FOR PRACTICAL TRAINING OF STUDENTS OF <?php echo $fetch_getIns['institutes_name']; ?> FOR THE MONTH OF <?php echo strtoupper($fetchQuery['month_name']); ?>
                    </b>
                    </p>
                    <hr/>

                <div class="row">
                    <div class="col-md-6">
                        <p style="font-size: 10px !important;">No.______/D-3/P</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <p style="font-size: 10px !important;">Date: 
                        <?php
                        date_default_timezone_set("Asia/Karachi");
                        echo $currentDateWithYear = date("d M, Y");
                        ?>
                        </p>
                    </div>
                </div>

                <!-- <div class="card-body"> -->
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
                            $retStdData = mysqli_query($connect, "SELECT students.*, technology.technology_name, roster_db.refNo, wards.ward_name FROM `students`
                            INNER JOIN technology ON technology.t_id = students.std_tech
                            INNER JOIN roster_db ON roster_db.s_id = students.std_id
                            INNER JOIN wards ON wards.w_id = roster_db.r_ward
                            WHERE students.std_ins = '$ins' AND roster_db.refNo = '$refNo' ORDER BY wards.ward_name ASC");
                            $iteration = 1;

                            while ($rowStdData = mysqli_fetch_assoc($retStdData)) {
                                if (empty($rowStdData['month_one']) or empty($rowStdData['month_two']) or empty($rowStdData['month_three']) or empty($rowStdData['month_four']) or empty($rowStdData['month_five']) or empty($rowStdData['month_six'])) {
                                    echo '
                                    <tr>
                                        <td>'.$iteration++.'</td>
                                        <td>'.$rowStdData['std_name'].'</td>
                                        <td>'.$rowStdData['std_fname'].'</td>
                                        <td>'.$rowStdData['technology_name'].'</td>
                                        <td class="text-center">'."0".''.$rowStdData['month_count'].'</td>';

                                        $getWard = mysqli_query($connect, "SELECT * FROM wards");
                                        $fetchGetWard = mysqli_fetch_assoc($getWard);
                                        $studentId = $rowStdData['std_id'];

                                        $getRosterData = mysqli_query($connect, "SELECT roster_db.r_ward, wards.ward_name  FROM roster_db
                                        INNER JOIN wards ON wards.w_id = roster_db.r_ward
                                        WHERE roster_db.s_id = $studentId");

                                        $fetch_getRosterData = mysqli_fetch_assoc($getRosterData);
                                        $r_ward = $fetch_getRosterData['ward_name'];
                                        
                                        echo '<td>'.$r_ward.'</td>
                                    </tr>
                                    ';
                                    
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                <!-- </div> -->
                <!-- </div> -->
            </div>

            <div class="col-7"></div>
            <div class="col-5" align="center">
                <p class="teext" style="margin-bottom: -10px; line-height: 0.7rem !important;">
                    Sd/_______________________
                    <br />
                    Medical Superintendent
                    <br />
                    Saidu Group of Teaching Hospitals, Swat.
                </p>
            </div>

            <div class="col-12">
                <p class="teext"  style="line-height: 0.6rem !important;">No.____________/D-3/PM/<?php echo $currentDateWithYear = date("Y"); ?></p>
                <ol style="line-height: 1.0rem !important;">
                    <li>VP Clinical Saidu Medical College, Swat.</li>
                    <li>DMS Central Wing, Saidu Group of Teaching Hospitals, Swat.</li>
                    <li>DMS Saidu Wing, Saidu Group of Teaching Hospitals, Swat.</li>
                    <li>DMS Casualty, Saidu Group of Teaching Hospitals, Swat.</li>
                    <li>Manager RBC Swat.</li>
                    <li>Secretary Medical Faculty, Khyber Pakhtunkhwa Peshawar.</li>
                    <li>Chief Nursing Superintendent, Saldu Group of Teaching Hospitals, S.vat.</li>
                    <li>Supervisor, Paramedical Students, Saidu Group of Teaching Hospitals, Swat.</li>
                    <li>Accounts Section, MS Office, S.T.H, Swat</li>
                    <li>Incharge of the concerned Units with the direction to arrange shift wise training internally.</li>
                    <li>Principal Frontier Institute of Medical Sclences Swat for information and necessary action.</li>
                </ol>
                <p class="teext" style="line-height: 0.7rem !important;">
                    <b>Note:
                    <br />
                    A. The Junior Registrars of all Departments will be responsible for attendance.
                    <br />
                       Anyone found absent from his duty without permission must be reported.
                    <br />
                    B. Anyone not on duty list must leave the ward and such unauthorized personnel must be banned.
                    <br />
                    C. Duty hours and Roster must be displayed.
                    </b>
                </p>
            </div>

            <div class="col-7"></div>
            <div class="col-5" align="center">
                <p class="teext" style="line-height: 0.7rem !important;">
                    <b>Medical Superintendent
                    <br />
                    Saidu Group of Teaching Hospitals, Swat.</b>
                </p>
            </div>
        </div>
    </div>
</div>
</div>
<?php include '../_partials/footer.php'?>
</div>
<!-- End Right content here -->
</div>
<!-- END wrapper -->
<!-- jQuery  -->
<?php include '../_partials/jquery.php'?>
<!-- App js -->
<?php include '../_partials/app.php'?>
<?php include '../_partials/datetimepicker.php'?>
<script type="text/javascript" src="../assets/js/select2.min.js"></script>

<script type="text/javascript" src="../assets/print.js"></script>

<script type="text/javascript">
    function print() {
        printJS({
        printable: 'printElement',
        type: 'html',
        targetStyles: ['*']
     })
    }

    document.getElementById('printButton').addEventListener ("click", print);
</script>
</body>
</html>