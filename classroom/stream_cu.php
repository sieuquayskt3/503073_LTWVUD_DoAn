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
?>
<!doctype html>
<html lang="en">

<head>
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
  // Lấy ngày tạo bài đăng
  $date = getdate();
  $datecreate = $date['mday'] .'/' .$date['mon'] .'/'. $date['year'];
  $error = "";
  $content = ""; // nội dung bài post

  if (isset($_POST['content'])) {
    $content = $_POST['content'];
    if (isset($_FILES['myfile'])) {
      $target_file = "uploads/" . $_FILES["myfile"]["name"];
      if (!move_uploaded_file($_FILES["myfile"]["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
      }
    }
    // kiem tra co noi dung bai dang chua
    if (empty($content)) {
      $error = "Vui lòng nhập nội dung thông báo";
    } else {
      
      $result = createPost($IdAccount, $IdLop, $content, $target_file, $datecreate);
      if ($result1['code'] == 0) {
        // successful
        header('Location: stream.php?IdLop='.$IdLop);
        exit();
      } else if ($result1['code'] == 2) {
        $error = "Không thể thêm lớp học";
      } else {
        $error = "Đã xảy ra lỗi vui lòng thử lại";
      }
    }
    
  }

  // Hiển thị thông tin bài post khi bấm nút sửa
  // if (isset($_GET["id"])) {
  //   $id = $_GET["id"];
  //   $sql = "SELECT * FROM post WHERE IdPost=$id";
  //   $result = $conn->query($sql);
  //   $row = $result->fetch_assoc();
  //   $content = $row["NoiDung"];
  //   $file = $row["File"];
  // }
  ?>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="btn-bars" href="classes.php">
      <button class="w3-button w3-xlarge w3-circle w3-light mr-3">
        <i class="fas fa-home"></i>
      </button>
    </a>
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
      <?php
        if ($role == "Teacher"){
          echo '<a class="btn btn-outline-dark mr-1" href="TaoBT.php?IdLop='. $row['IdLop'] .'">Tạo bài tập</a>';
        }
      ?>
      <a class="btn btn-outline-dark" href="logout.php">Đăng xuất</a>
    </div>
  </nav>

  <div class="container">

    <div class="bgd-img-top" style="background-image: url('images/brown.jpg');">
      <div class="class">Lập trình web và ứng dụng</div>
      <div class="class-info">Đặng Minh Thắng-Thu2-Ca3</div>
    </div>

    <div class="account bg-light text-muted">

      <a href="" data-toggle="modal" data-target="#myModal">Chia sẻ với lớp học</a>

      <form action="" method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="myModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h7 class="modal-title">Đăng</h7>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <input type="hidden" name="id" value="<?php echo $id ?>">
              <!--Ẩn id bài post -->
              <div class="modal-body">
                <textarea class="form-control" rows="5" id="content" name="content" autofocus></textarea>
              </div>

              <div class="modal-footer">
                <input type="file" class="form-control" id='myfile' name='myfile'>

                <button type="reset" class="btn btn-primary" data-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary">Đăng</button>
              </div>
            </div>
          </div>
        </div>
      </form>

    </div>
    <div class="account">

      <div class="row">

        <div class="col-1">
          <img class="avt" src="images/person.jpg" alt="">
        </div>

        <div class="col-9">
          <div class="name">Đặng Minh Thắng</div>
          <div class="date">Oct 15</div>
        </div>
      </div>
      <div>jjjjjjjjjjjjjjjjjj</div>
      <?php
      if (!empty($error)) {
        echo "<div class='alert alert-danger'>$error</div>";
      }
      ?>

    </div>
  </div>
</body>