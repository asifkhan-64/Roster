<?php
    include('../_stream/config.php');
    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $month = $_GET['month'];
    $date = $_GET['date'];

    if ($month < 10) {
        $dateIs = $date."/0".$month;
    }else {
        $dateIs = $date."/".$month;
    }

    $query = mysqli_query($connect, "SELECT * FROM months WHERE m_id = '$month'");
    $fetchQuery = mysqli_fetch_assoc($query);


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
    
    .listViewClass {
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
                <h5 class="page-title d-inline">Report Print </h5>
                <a type="button" href="#" id="printButton" class="btn btn-success waves-effect waves-light float-right btn-lg mb-3"><i class="fa fa-print"></i> Print</a>
            </div>
        </div>
        <!-- end row -->
        
        <div class="row" id="printElement">
            <div class="col-12">
                <!-- <div class="card m-b-30"> -->
                    <p align="center" style="font-size: 12px !important; line-height: 0.6rem !important; line-height: 0.6rem !important; margin-bottom: 0.1rem;">
                    <b>SAIDU GROUP OF TEACHING HOSPITALS, SWAT</b></p>
                    <p align="center" style="font-size: 12px !important; line-height: 1rem !important; margin-bottom: 0.1rem;"><b>
                    PRIVATE PARAMEDICAL INSTITUTES STUDENTS DISTRIBUTION, FOR THE MONTH OF <q><?php echo strtoupper($fetchQuery['month_name']); ?></q>
                    </b>
                    </p>
                    <hr style="background-color: black;" class="p-0 m-2" />

                <div class="row">
                    <div class="col-md-6">
                        <!-- <p style="font-size: 10px !important;">No.______/D-3/PM</p> -->
                    </div>
                    <div class="col-md-6 text-right">
                        <p style="font-size: 10px !important;">Date: 
                        <?php
                        date_default_timezone_set("Asia/Karachi");
                        echo $currentDateWithYear = date("d M, Y");
                        $thisDate = date("Y/m");
                        ?>
                        </p>
                    </div>
                </div>

                <!-- <div class="card-body"> -->
                    <table id="datatables" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; border-color: #fff !important; width: 100%;">
                        <thead>
                            <tr style="border-color: #fff; border-bottom: none !important">
                                <th style=" border: none !important">S#</th>
                                <th style=" border: none !important">Unit / Institute</th>
                                <th style=" border: none !important">Total</th>
                                <th style=" border: none !important">Amount</th>
                                <th class="text-center" style=" border: none !important">Signature</th>
                                <!-- <th>Place of Duty</th> -->
                                <!-- <th class="text-center"> <i class="fa fa-edit"></i> -->
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $retWards = mysqli_query($connect, "SELECT * FROM `wards`");
                            $iteration = 1;
                            $total = 0;

                            while ($retWardRow = mysqli_fetch_assoc($retWards)) {
                                $wardID = $retWardRow['w_id'];

                                $getWardCount = mysqli_query($connect, "SELECT COUNT(*) AS countedTotal FROM `roster_db` WHERE month_of = '$dateIs' AND r_ward = '$wardID'");
                                $fetch_getWardCount = mysqli_fetch_assoc($getWardCount);
                                $countedWardsTotal = $fetch_getWardCount['countedTotal'];
                                $total = $total + $countedWardsTotal;
                                if ($countedWardsTotal > 0) {
                                echo '
                                <tr>
                                    <td style="border: none !important; width: 3%; ">'.$iteration++.'.</td>
                                    <td style="border: none !important; width: 37%; ">'.$retWardRow['ward_name'].'</td>
                                    <td style="border: none !important; width: 20%; ">'.$countedWardsTotal.'</td>
                                    <td style="border: none !important; width: 20%; "></td>
                                    <td style="border: none !important; width: 20%; border-bottom: 1px solid black !important"></td>
                                </tr>
                                ';
                                }
                            }   

                            echo '
                            
                                <tr>
                                    <td style="border: none !important; width: 3%; "></td>
                                    <td class="text-right" style="border: none !important; width: 37%; "><b>Total:</b></td>
                                    <td class="text-left" style="border: none !important; width: 20%; "><b>'.$total.'</b></td>
                                    <td style="border: none !important; width: 20%; "></td>
                                    <td class="text-right" style="border: none !important; width: 20%; "></td>
                                </tr>';
                            ?>
                        </tbody>
                    </table>
                <!-- </div> -->
                <!-- </div> -->
            </div>

            <!-- <div class="col-7"></div>
            <div class="col-5" align="center">
                <p class="teext" style="margin-bottom: -10px; line-height: 0.7rem !important;">
                    Sd/_______________________
                    <br />
                    Medical Superintendent
                    <br />
                    Saidu Group of Teaching Hospitals, Swat.
                </p>
            </div> -->

            <!-- <div class="col-12">
                <p class="teext"  style="line-height: 0.6rem !important;">No.____________/D-3/PM/<?php echo $currentDateWithYear = date("Y"); ?></p>
                <ol style="line-height: 1.0rem !important;">
                    <li class="listViewClass">VP Clinical Saidu Medical College, Swat.</li>
                    <li class="listViewClass">DMS Central Wing, Saidu Group of Teaching Hospitals, Swat.</li>
                    <li class="listViewClass">DMS Saidu Wing, Saidu Group of Teaching Hospitals, Swat.</li>
                    <li class="listViewClass">DMS Casualty, Saidu Group of Teaching Hospitals, Swat.</li>
                    <li class="listViewClass">Manager RBC Swat.</li>
                    <li class="listViewClass">Secretary Medical Faculty, Khyber Pakhtunkhwa Peshawar.</li>
                    <li class="listViewClass">Chief Nursing Superintendent, Saldu Group of Teaching Hospitals, S.vat.</li>
                    <li class="listViewClass">Supervisor, Paramedical Students, Saidu Group of Teaching Hospitals, Swat.</li>
                    <li class="listViewClass">Accounts Section, MS Office, S.T.H, Swat</li>
                    <li class="listViewClass">Incharge of the concerned Units with the direction to arrange shift wise training internally.</li>
                    <li class="listViewClass">Principal Frontier Institute of Medical Sclences Swat for information and necessary action.</li>
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
            </div> -->
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