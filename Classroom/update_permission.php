<?php
    // kết nối cớ sở dữ liệu
    $conn = mysqli_connect("localhost","root","","classroom") or die ('Không thể kết nối cơ sở dữ liệu');
    mysqli_set_charset($conn,"utf8");

    // Kiểm tra nếu thực hiện thao tác cập nhật quyền của người dùng
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // lấy giá trị quyền và Account người dùng cần cập nhật
        $quyen = $_POST['quyen'];
        $IdAccount = $_POST['IdAccount'];
        // Thực hiện cập nhật vào database
        if (!empty($quyen) && !empty($IdAccount)) {
            $sqlUpdate = 'UPDATE `account` SET `Quyen`="'.$quyen.'" WHERE IdAccount = '. $IdAccount;
            mysqli_query($conn, $sqlUpdate) or die( "Update query error -- ");
        }
        header('Location: Permission.php');
        exit();
    }