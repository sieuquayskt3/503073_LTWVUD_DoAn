<?php
require "connection.php";
$conn = open_database();
$id = $_GET["id"];
$sql = "DELETE FROM class WHERE IdLop =$id";
if ($conn->query($sql) === TRUE) {
	header("Location: classes.php");
}
?>