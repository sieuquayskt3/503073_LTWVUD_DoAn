<?php
session_start();
$id = "";
if (!isset($_SESSION["user"])) { // Yêu cầu đăng nhập
  header("location: login.php");
  exit();
}
require_once('connection.php');
// lấy thông tin
$role = $_SESSION["role"];
$IdAccount = $_SESSION["id"]; // id người dùng
$IdLop = $_GET["IdLop"]; // id lớp
$IdBaiTap = $_GET["IdBaiTap"]; // id bai tap
$HoTen = $_SESSION['name']; // Ho ten tai khoan
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Classwork</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button id="btn-menu" class="btn"><i class="fa fa-bars"></i></button>
    <a class="navbar-brand" href="#">HK1_2020_503073_Lap trinh web </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">Stream <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Classwork</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">People</a>
        </li>

      </ul>
    </div>
  </nav>
  <div class="row container-fluid">
    <?php // Hiển thị danh sách bài tập trong lớp học
    require_once 'connection.php';

    $conn = open_database();
    
    $sql = "SELECT * FROM assignment WHERE IdBaiTap = ".$IdBaiTap;
    $result = $conn->query($sql);
    $date = getdate();
    $ngayhientai = date('Y-m-d');

    while ($row = $result->fetch_assoc()) {
    ?>

      <div class="col-xl-9">
        <div class="Tittle">
          <h3 style="color: blue; padding-right: 10px;"><?php echo $row['TieuDe'] ?></h3>
          <p class="namegv" style="float:left;"><?php echo $HoTen ?></p>
          <b class="time" style="float:right;"><?php echo $row['Deadline'] ?></b>
          <br>
          <hr style="background-color: blue;">
        </div>
      </div>
      <div class="col-xl-3">
        <div id="baitap" class="card text-left text-truncate mx-auto p-1">
          <h5>Bài tập của bạn</h5>
          <input style="padding: 5px; border-radius: 10px;" type="file" placeholder="Thêm tiệp đính kèm">
          <!--Kiểm tra nếu còn hạn nộp thì hiển thị button nộp bài-->
          <?php
            $deadline = $row['Deadline'];
          
          if($deadline > $ngayhientai){
            echo '<button type="submit" class="btn btn-primary">Nộp bài</button>';
            
          }else{
            echo '<button type="submit" class="btn btn-light disabled text-danger font-weight-bold" disabled>Quá hạn!</button>';
         
          }
          ?>
        </div>
      </div>
    <?php
    }
    ?>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="mb-9 col-xl-9 col-lg-9 col-md-9 col-sm-9 p-3">
        <div class="card text-left text-truncate mx-auto p-1">
          <!--In các bình luận-->
          <p><b>Bình Luận</b></p>


          <!--Nhập bình luận-->
          <div class="container-fluid">
            <div class="row">
              <div class="mb-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 p-2">
                <form method="post" action="" enctype="multipart/form-data">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="mb-10 col-xl-11 col-lg-11 col-md-10 col-sm-9 pt-2">

                        <div class="card text-left text-truncate mx-auto">
                          <input type="text" placeholder="Nhập bình luận" id="binhluan" name="binhluan">
                        </div>
                      </div>
                      <div class="pt-2 w-5">
                        <div class="card text-left text-truncate mx-auto">
                          <button type="submit">Gửi</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>