<?php
    if (!isset($_GET["email"]) && !isset($_GET["idClass"])) {
        die('Lỗi không xác định');
    }else {
        $email = $_GET["email"];
        $idClass = $_GET["idClass"];
        require_once('connection.php');

        // lấy id account
        $sql = 'select IdAccount from account where Email = ?';
        $conn = open_database();
      
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $email);
        if (!$stm->execute()){
            die('Query error: ' . $stm->error);
        }
        $result = $stm->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $IdAccount = $row['IdAccount'];
        }
        
        // thêm vào class
        $conn = open_database();
        $stm = $conn->prepare('INSERT INTO detailclass(IdAccount, IdLop) values (?,?)');

        $stm->bind_param("ii", $IdAccount, $idClass);

        if (!$stm->execute()){
            print_r('Lỗi không xác định!');
        } else {
            print_r('Tham gia lớp học thành công!');
        }
    }
?>