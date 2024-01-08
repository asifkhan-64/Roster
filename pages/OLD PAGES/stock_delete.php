<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $id = $_GET['id'];

    $deleteQuery = mysqli_query($connect, "DELETE FROM `stock_add` WHERE st_id = '$id'");

    if ($deleteQuery) {
        header("LOCATION: stock_list.php");
    }

?>