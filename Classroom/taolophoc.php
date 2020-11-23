<?php
session_start();
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
</head>

<body>

  <!--nav bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <button class="btn"><i class="fa fa-bars"></i></button>
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
    <div>
      <a class="btn btn-outline-dark" href="logout.php">Đăng xuất</a>
    </div>
  </nav>
  <!--end nav bar -->
  <hr>
  <div class="container w-50 border border-secondary justify-content-center rounded lophoc bg-secondary">
    <h2 class="text-center font-weight-bold">Tạo lớp học</h2>
    <form action="" method="post" novalidate enctype="multipart/form-data">
      <?php
      // Lấy tên giáo viên từ id
      $conn = open_database();
      $sql = "SELECT * FROM account WHERE IdAccount=$IdAccount";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $name = $row["HoTen"]; // tên giáo viên


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
        $avt= $file['name'];
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
        } else if ($file['type'] != 'image/jpeg' && $file['type'] != 'image/jpg' && $file['type'] != 'image/png'){
          $error ='Vui lòng chọn file ảnh';
        }
         else {
          // register a new account
          $result1 = createClass($IdAccount, $nameclass, $name, $room, $description, $linkimage);
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
      <input type="hidden" name="id" value="<?php echo $id ?>"> <!--Ẩn id lớp học -->
      <div class="form-group font-weight-bold">
        <label for="nameclass">Tên lớp học:</label>
        <input value="<?= $nameclass ?>" type="nameclass" class="form-control" id="nameclass" placeholder="Nhập tên lớp " name="nameclass">
      </div>
      <div class="form-group font-weight-bold">
        <label for="room">Phòng:</label>
        <input value="<?= $room ?>" type="room" class="form-control" id="room" placeholder="Nhập phòng học" name="room">
      </div>
      <div class="form-group font-weight-bold">
        <label for="description">Mô tả:</label>
        <input value="<?= $description ?>" type="text" class="form-control" id="description" placeholder="Nhập mô tả" name="description">
      </div>
      <div class="form-group">
        <label for="image">Ảnh đại diện:</label>
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