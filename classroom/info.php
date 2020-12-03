<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("location: login.php");
    exit();
}
// lấy thông tin
$role = $_SESSION["role"];
$IdAccount = $_SESSION["id"];
require_once 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Stream</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f25bf5c13c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="stream.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <?php

    $conn = open_database();
    $sql1 = "SELECT * FROM account WHERE IdAccount=$IdAccount";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();
    ?>

    <div class="container">

        <div class="">
            <h3 class="text-info font-weight-bold text-center">THÔNG TIN TÀI KHOẢN</h3>

            <form action="register.php" method="post">
                <div class="form-group mt-5 w-50">
                    <input type="hidden" name="id" value="<?php echo $row1['IdAccount'] ?>"><br>
                    <!--Ẩn id sản phẩm -->
                    <label for="HoTen">Họ và Tên:</label> 
                    <input type="text" name="name" value="<?php echo $row1['HoTen'] ?>"><br>
                   
                    <label for="username">Tên tài khoản:</label>
                    <input type="text" name="user" value="<?php echo $row1['UserName'] ?>"><br>
                    
                    <label for="email">Email:</label>
                    <input type="text" name="email" value="<?php echo $row1['Email'] ?>"><br>
                    
                    <label for="sdt">Số điện thoại:</label>
                    <input type="text" name="sdt" value=" <?php echo $row1['Sdt'] ?>"><br>

                    <label for="namsinh">Năm sinh </label>
                    <input type="text" name="year" value="<?php echo $row1['NamSinh'] ?>"><br>
                    
                    <label for="role">Chức vụ: </label>
                    <input type="text" name="role" value="<?php echo $row1['Quyen'] ?>"><br>
                    <br>

                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>

        </div>

    </div>
</body>

</html>