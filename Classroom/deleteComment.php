<?php
session_start();
if (!isset($_SESSION["user"]) || !isset($_GET['idComment']) || !isset($_GET["idClass"])) { // Yêu cầu đăng nhập
    header("location: login.php");
    exit();
}
require "connection.php";

$idComment = $_GET['idComment'];
$idClass = $_GET['idClass'];
$result = deleteComment($idComment);
if ($result['code'] == 0) {
    // successful
    header('Location: stream.php?IdLop=' . $idClass);
    exit();
} else if ($result['code'] == 2) {
    $error = "Không thể xóa bình luận";
} else {
    $error = "Đã xảy ra lỗi vui lòng thử lại";
}

?>