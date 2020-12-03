<?php
require "connection.php";
$conn = open_database();
$id = $_GET["IdLop"];
$sql0 = "DELETE FROM detailclass WHERE IdLop = $id";
echo $id;
if ($conn->query($sql0) === TRUE) {
	$sql = "DELETE FROM class WHERE IdLop =$id";
	header("Location: classes.php");
}
else{
	echo "Khong xoa duoc";
}
?>