<?php
    require "connection.php";
    $conn = open_database();
    $IdAccount = $_GET["IdAccount"];
    $IdLop = $_GET["IdLop"];
    $sql = "DELETE FROM detailclass WHERE IdAccount = $IdAccount and IdLop = $IdLop";
    if ($conn->query($sql) === TRUE) {
        header("Location: detailclass.php?IdLop=$IdLop");
    }
?>