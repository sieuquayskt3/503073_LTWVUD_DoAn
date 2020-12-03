<?php
session_start();
$id = "";
if (!isset($_SESSION["user"])) { // Yêu cầu đăng nhập
  header("location: login.php");
  exit();
}
require_once('connection.php');
// lấy thông tin
$IdAccount = $_SESSION["id"]; // id người dùng

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Tạo lớp học</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/f25bf5c13c.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="taolophoc.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

</head>

<body>

  <!--nav bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="btn-bars" href="classes.php">
      <button class="w3-button w3-xlarge w3-circle w3-light">
        <i class="fas fa-home"></i>
      </button>
    </a>
   
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      
    </div>
    <div>
      <a class="btn btn-outline-dark" href="logout.php">Đăng xuất</a>
    </div>
  </nav>
  <!--end nav bar -->
  <hr>
  <div class="container w-50 border border-secondary justify-content-center rounded lophoc bg-info">
    <h2 class="text-center font-weight-bold">Tạo lớp học</h2>
    <form action="" method="post" novalidate enctype="multipart/form-data">
      <?php
      // Lấy tên giáo viên từ id
      $conn = open_database();
      $sql = "SELECT * FROM account WHERE IdAccount=$IdAccount";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $name = $row["HoTen"]; // tên giáo viên

      // Mặc định các nội dung là rỗng nêu chưa có id
      $error = "";
      $nameclass = ""; // ten lop hoc
      $room = ""; // phong hoc
      $description = ""; // mo ta
      $avt = ""; // anh dai dien
      $file = ""; // loai hinh anh jpg/png/...

      if (isset($_POST['nameclass']) && isset($_POST['room']) && isset($_POST['description']) && isset($_FILES['image'])) {
        $nameclass = $_POST['nameclass'];
        $room = $_POST['room'];
        $description = $_POST['description'];

        $file = $_FILES['image'];
        $avt = $file['name'];
        $linkimage = "images/" . $file['name'];
        if ($file['type'] == 'image/jpeg' || $file['type'] == 'image/jpg' || $file['type'] == 'image/png') {
          move_uploaded_file($file['tmp_name'], 'images/' . $avt);
        }
        if (empty($nameclass)) {
          $error = 'Vui lòng nhập tên lớp học';
        } else if (empty($room)) {
          $error = 'Vui lòng nhập phòng học';
        } else if (empty($description)) {
          $error = 'Vui lòng nhập thời gian học: Thứ - ca';
        } else if (empty($avt)) {
          $error = 'Vui lòng chọn ảnh đại diện';
        } else if ($file['type'] != 'image/jpeg' && $file['type'] != 'image/jpg' && $file['type'] != 'image/png') {
          $error = 'Vui lòng chọn file ảnh';
        } else {
          // register a new account
          $result1 = CU_class($IdAccount, $nameclass, $name, $room, $description, $linkimage);
          if ($result1['code'] == 0) {
            // successful
            header('Location: login.php');
            exit();
          } else if ($result1['code'] == 2) {
            $error = "Không thể thêm lớp học";
          } else {
            $error = "Đã xảy ra lỗi vui lòng thử lại";
          }
        }
      }
      // Hiển thị thông tin lớp học khi bấm nút sửa
      if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $sql = "SELECT * FROM class WHERE IdLop=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $nameclass = $row["TenLop"];
        $room = $row["Phong"];
        $description = $row["MoTa"];
        $avt = $row["AnhDaiDien"];
      }
      ?>
      <input type="hidden" name="id" value="<?php echo $id ?>">
      <!--Ẩn id lớp học -->
      <div class="form-group font-weight-bold">
        <label for="nameclass">Tên lớp học:</label>
        <input value="<?= $nameclass ?>" type="nameclass" class="form-control" id="nameclass" name="nameclass">
      </div>
      <div class="form-group font-weight-bold">
        <label for="room">Phòng:</label>
        <input value="<?= $room ?>" type="room" class="form-control" id="room" name="room">
      </div>
      <div class="form-group font-weight-bold">
        <label for="description">Thời gian học</label>
        <input value="<?= $description ?>" type="text" class="form-control" id="description" name="description">
      </div>
      <div class="form-group font-weight-bold">
        <label for="image">Ảnh lớp:</label>
        <input type="file" class="form-control" placeholder="Chọn ảnh" id='image' name='image'>
      </div>

      <div class="form-group text-center ">
        <?php
        if (!empty($error)) {
          echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>
        <button type="reset" class="btn bg-light mr-2 pl-5 pr-5 mb-3">Hủy</button>
        <button type="submit" class="btn bg-light pl-5 pr-5 mb-3">Tạo</button>
      </div>

    </form>
  </div>

</body>

</html>