<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }
    


    $id = $_GET['refNo'];

    $deleteQuery = mysqli_query($connect, "DELETE FROM `sell_product` WHERE sell_id = '$id'");

    if ($deleteQuery) {
        header("LOCATION: sell_list.php");
    }
?>