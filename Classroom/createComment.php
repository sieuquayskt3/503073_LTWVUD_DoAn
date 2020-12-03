<?php
    session_start();
    if (!isset($_SESSION["user"]) || !isset($_GET['idPost']) || !isset($_POST["comment"])) { // Yêu cầu đăng nhập
        header("location: login.php");
        exit();
    }

    require_once('connection.php');

    $date = getdate();
    $datecreate = $date['mday'] . '/' . $date['mon'] . '/' . $date['year'];
    $IdAccount = $_SESSION['id'];
    $idPost = $_GET['idPost'];
    $comment = $_POST["comment"];

    $idClass = $_GET['idClass'];
    
    $result = createComment($IdAccount, $idPost, $comment, $datecreate);
    if ($result['code'] == 0) {
        // successful
        if ($quyen == "Admin" || $quyen == "Teacher"){
            sendMailNotify($idClass, 'Đã trả lời bình luận của bạn: '.$comment);
        }
        header('Location: stream.php?IdLop=' . $idClass);
        exit();
    } else if ($result['code'] == 2) {
        $error = "Không thể thêm lớp học";
    } else {
        $error = "Đã xảy ra lỗi vui lòng thử lại";
    }
?>