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

    $retData = mysqli_query($connect, "SELECT * FROM technology WHERE t_id = '$id'");
    $fetch_retData = mysqli_fetch_assoc($retData);
    $technologyName = $fetch_retData['technology_name'];

    if (isset($_POST['updateTechnology'])) {
        $id = $_POST['id'];
        $technologyName = $_POST['technologyName'];

        
        $countQuery = mysqli_query($connect, "SELECT COUNT(*)AS countedIns FROM technology WHERE technology_name = '$technologyName'");
        $fetch_countQuery = mysqli_fetch_assoc($countQuery);


        if ($fetch_countQuery['countedIns'] == 0) {
            $updateQuery = mysqli_query($connect, "UPDATE technology SET technology_name = '$technologyName' WHERE t_id = '$id'");
            if (!$updateQuery) {
                $error = 'Not Added! Try again!';
            }else {
                header("LOCATION: technology_list.php");
            }
        }else {
            $alreadyAdded = '<div class="alert alert-dark" role="alert">
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
                <h5 class="page-title">Technology Edit</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-4">
                                    <input class="form-control" value="<?php echo $technologyName ?>" placeholder="Technology Name" type="text" value="" id="example-text-input"  name="technologyName"  required="">
                                </div>
                            </div>
                            <hr />
                            <div class="form-group row">
                                <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="updateTechnology">Update Technology</button>
                                </div>
                            </div>
                        </form>
                        <h5><?php echo $error ?></h5>
                        <h5><?php echo $added ?></h5>
                        <h5><?php echo $alreadyAdded ?></h5>
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