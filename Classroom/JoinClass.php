<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join class</title>
    <link rel="stylesheet" href="css/joinclass.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/f25bf5c13c.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="style.css">

 
  
</head>

<body>
    
    <?php
        $error = '';
        $MaLop = '';
        $IdAccount = '';

        if (isset($_POST['MaLop']))
        {
            $MaLop = $_POST['MaLop'];
            $IdAccount = $_SESSION["id"];
            
            if (empty($MaLop)) {
                $error = 'Vui lòng nhập mã lớp';
            }else if(strlen($MaLop) != 8){
                $error = 'Mã lớp phải gồm 8 ký tự';
            }else{
                // register a new account
                require_once('connection.php');
                $result = joinClass($IdAccount, $MaLop);
                if ($result['code'] == 0){
                    // successful
                    header('Location: classes.php');
                    exit();
                }else if ($result['code'] == 1){
                    $error = "Mã lớp không tồn tại";
                }else {
                    $error = "Lỗi không xác định. Vui lòng thử lại sau!";
                }
            
            }
        }
    ?>
    
    <nav class="navbar navbar-light bg-light">
    <a class="btn-bars" href="classes.php">
      <button class="w3-button w3-xlarge w3-circle w3-light mr-3">
        <i class="fas fa-home"></i>
      </button>
    </a>
        <h4>Tham gia lớp học</h4>
        <p></p>
    </nav>
    <div class="container acc">
        <form action="" method="post">
            <div class="account">
                <div><p>Thông tin tài khoản</p></div>
                <div class="row">
                    <div class="col-1">
                        <img class="avt1" src="image/avt1.jpg" alt="">
                    </div>
                    <div class="col-7 ml-4">
                        <p><?= $_SESSION['name'] ?></p>
                        <p><?= $_SESSION['email'] ?></p>
                    </div>
                </div>
            </div>
            <div class="class-code">
                <h5>Mã lớp</h5>
                <p>Nhập mã lớp học tại đây</p>
                <input type="text" id="MaLop" name="MaLop">
            </div>
            
            <div class="form-group text-right">
                <?php
                    if (!empty($error)) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                ?>
                <a href="classes.php" class="btn btn-secondary">Hủy</a>
                <button class="btn btn-success">Xác nhận</button>
                
            </div>
        </form>
    </div>
    
</body>

</html>