<?php
$title = $_POST["title"];
$content = $_POST["content"];
$deadline = $_POST["deadline"];


// if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
// {
//     die("Sorry, there was an error uploading your file.");
// }

require "connection.php";

if (empty($_POST["id"])) {
	$stmt = $conn->prepare("INSERT INTO baitap(TieuDe, NoiDung, Deadline) VALUES (?, ?, ?)");
 } //else {
// 	$id = $_POST["id"];
// 	$stmt = $conn->prepare("UPDATE product SET name=?, category=?, price=?, description=?, image=? WHERE id=$id");
// }


$stmt->bind_param("sss", $title, $content, $deadline);

if ($stmt->execute() === TRUE) {
   header("Location: list.php");
    
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
?>