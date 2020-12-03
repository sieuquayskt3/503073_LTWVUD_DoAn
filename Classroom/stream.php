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
$IdLop = $_GET["IdLop"]; // id lớp
$quyen = $_SESSION["role"]; // quyền người dùng


?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Stream</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f25bf5c13c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="stream.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
         function updateDeleteCommentDialog(idComment){
            let param = $('#idComment-to-delete-input');
            param.val(idComment);
         }
         function updateDeletePostDialog(idPost){
            let param = $('#idPost-to-delete-input');
            param.val(idPost);
         }
      </script>
</head>

<body>


    <?php

  // Lấy ngày tạo bài đăng hoặc ngày tạo comment
  $date = getdate();
  $datecreate = $date['mday'] . '/' . $date['mon'] . '/' . $date['year'];
  $error = "";
  $content = "";
  $myfile = ""; // nội dung bài post
  $idCommentToDel = "";
  $idPostToDel = "";


  if (isset($_POST['content'])) {
    $content = $_POST['content'];

    if (isset($_FILES['myfile'])) {

      $target_file = "uploads/" . $_FILES["myfile"]["name"];
      $error = $target_file;

      if (!move_uploaded_file($_FILES["myfile"]["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
      }
    }
    // kiem tra co noi dung bai dang chua
    if (empty($content)) {
      $error = "Vui lòng nhập nội dung thông báo";
    } else {
      $error = $content . $IdAccount . $IdLop . $target_file . $datecreate;
      $result = createPost($IdAccount, $IdLop, $content, $target_file, $datecreate);
      if ($result1['code'] == 0) {
        // successful
        if ($quyen == "Admin" || $quyen == "Teacher"){
          sendMailNotify($IdLop, 'Bạn có 1 thông báo mới: '.$content);
        }
        header('Location: stream.php?IdLop=' . $IdLop);
        exit();
      } else if ($result1['code'] == 2) {
        $error = "Không thể thêm lớp học";
      } else {
        $error = "Đã xảy ra lỗi vui lòng thử lại";
      }
    }
  }


  // Hiển thị thông tin bài post khi bấm nút sửa
  if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM post WHERE IdPost=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $content = $row["NoiDung"];
    $file = $row["File"];
  }

  if (isset($_POST['action'])){
    $action = $_POST['action'];
    
    // confirm delete post dialog
    if ($action == 'delete-post' 
      && isset($_GET['IdLop'])&& isset($_POST['id-post'])){
        $idPostToDel = $_POST['id-post'];
        $result = deletePost($idPostToDel);
        if ($result['code'] == 0) {
            // successful
        } else if ($result['code'] == 2) {
            $error = "Không thể xóa bình luận";
        } else {
            $error = "Đã xảy ra lỗi vui lòng thử lại";
        }
      }

    // confirm delete comment dialog
    if ($action == 'delete-comment' 
      && isset($_GET['IdLop'])&& isset($_POST['id-comment'])){
        $idCommentToDel = $_POST['id-comment'];
        $result = deleteComment($idCommentToDel);
        if ($result['code'] == 0) {
            // successful
            echo '
            <div class="alert alert-danger" role="alert">
              <strong>Đã xóa bình luận!</strong>
            </div>';
        } else if ($result['code'] == 2) {
            $error = "Không thể xóa bình luận";
        } else {
            $error = "Đã xảy ra lỗi vui lòng thử lại";
        }
      }

      // confirm add student dialog
      if ($action == 'add-student' 
      && isset($_GET['IdLop'])&& isset($_POST['input-add-student'])){
        $emailToAddStudent = $_POST['input-add-student'];
        // kiểm tra định dạng email
        $email = $_POST['input-add-student'];
        $idClass = $_GET["IdLop"];
        if (empty($email)) {
          $post_error = 'Chưa nhập email!';
        }
        else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
          $post_error = 'Email sai định dạng!';
        } else {
          $result = sendMailAddStudent($emailToAddStudent, $idClass);
          if ($result['code'] == 0) {
              // successful
              echo '
              <div class="alert alert-success" role="alert">
                <strong>Mời thành công!</strong>
              </div>';
          } else if ($result['code'] == 2) {
              $error = "Không thể xóa bình luận";
          } else {
              $error = "Đã xảy ra lỗi vui lòng thử lại";
          }
        }
       
      }
  }

  ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="btn-bars" href="classes.php">
            <button class="w3-button w3-xlarge w3-circle w3-light mr-3">
                <i class="fas fa-home"></i>
            </button>
        </a>
        <a class="navbar-brand" href="#">HK1_2020_503073_Lap trinh web </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

    <div class="container">
        <div class="bgd-img-top" style="background-image: url('images/brown.jpg');">
            <!-- Thông tin lớp học -->
            <?php
              $connClass = open_database();
              $sqlClass = 'SELECT * FROM class WHERE IdLop ='. $_GET["IdLop"];
              $resultClass = $connClass->query($sqlClass);
              if ($resultClass->num_rows > 0) {
                while ($rowClass = $resultClass->fetch_assoc()) {
                  echo '<div class="class">'.$rowClass['TenLop'].'</div>';
                  
                  echo '<div class="class-info">'.$rowClass['TenGv'].' - '.$rowClass['MoTa'].'</div>';

                  
                  echo '<div class="text-white">&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mã lớp: '.$rowClass['MaLop'].'</div>';
                }
              }
            ?>
        </div>

        <div class="account bg-light text-muted">
            <!--Tạo bài post-->
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
                                <textarea class="form-control" rows="5" id="content" name="content"
                                    autofocus></textarea>
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

    <?php
      $conn = open_database();
      $sql = "SELECT * FROM post";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>
      <div class="account">
        <div class="row">
          <div class="col-1">
              <img class="avt" src="images/person.jpg" alt="">
          </div>

          <div class="col-9">
            <div class="name-gv">
              <!-- Lấy tên giảng viên -->
              <?php
                  $connGv = open_database();
                  $sqlGv = 'SELECT * FROM account WHERE IdAccount ='. $row["IdAccount"];
                  $resultGv = $connGv->query($sqlGv);
                  if ($resultGv->num_rows > 0) {
                    while ($rowGv = $resultGv->fetch_assoc()) {
                      echo '<dt>'.$rowGv['HoTen'].'</dt>';
                    }
                  }
              ?>
              
            </div>
            <div class="date"><small><?php echo $row["NgayTao"] ?></small></div>
          </div>
          
          <div class="col-2 text-right">
            <?php
              if ($quyen == "Admin" || $quyen == "Teacher"){
                echo '<a href="#" class="badge badge-info">Sửa</a>';
                echo '<i onclick="updateDeletePostDialog('.$row['IdPost'].')" class="badge btn btn-danger" data-toggle="modal" data-target="#PostModal-del">Xóa</i>';
              }
            ?>
          </div>
        </div>

        <div><?php echo $row["NoiDung"] ?></div>
        <div><?php echo $row["File"] ?></div>
        <hr>
        
        <!-- Comment ở chổ này -->
        <?php
          $conn2 = open_database();
          $sql2 = 'SELECT * FROM comment WHERE IdPost ='. $row["IdPost"];
          $result2 = $conn2->query($sql2);
          if ($result2->num_rows > 0) {
            while ($row2 = $result2->fetch_assoc()) {
        ?>
              <div class="row mb-1">
                  <div class="col-1">
                      <img class="avt img-thumbnail" src="images/person.jpg" alt="">
                  </div>

                  <div class="col-9">
                      <div class="font-weight-bold">
                        <!-- Lấy họ tên của người comment -->
                        <?php
                          $conn3 = open_database();
                          $sql3 = 'SELECT * FROM account WHERE IdAccount ='. $row2["IdAccount"];
                          $result3 = $conn3->query($sql3);
                          if ($result3->num_rows > 0) {
                            while ($row3 = $result3->fetch_assoc()) {
                        ?>
                              <div><?php echo $row3["HoTen"]?> <small><?php echo $row2["NgayTao"]?></small> </div>
                        <?php
                            }
                          } 
                        ?>
                        <!-- END Lấy họ tên của người comment -->
                      </div>
                      <div><?php echo $row2["NoiDung"] ?></div>
                  </div>
                  <div class="col-2 text-right">
                    <?php
                      if ($quyen == "Admin" || $quyen == "Teacher"){
                        
                        echo '<i onclick="updateDeleteCommentDialog('.$row2['IdComment'].')" class="badge btn btn-danger" data-toggle="modal" data-target="#CommentModal-del">Xóa</i>';
                      }
                    ?>
                  </div>
              </div>
        <?php
            }
          } 
        ?>

        <hr>
        <div class="row">
          <div class="col-12">
            <form
              action="createComment.php?idPost=<?php echo $row["IdPost"]?>&idClass=<?php echo $_GET["IdLop"]?>"
              method="POST">
              <div class="d-flex flex-row">
                <input class="form-control w-100 mr-3" rows="1" id="comment" name="comment"
                    placeholder="Bình luận"></input>
                <button type="submit" class="btn btn-outline-secondary">Gửi</button>
              </div>
            </form>
          </div>
          <!---------------------- Thêm sinh viên -->
          <i class="btn btn-light" data-toggle="modal" data-target="#AddStudentModal-del">Thêm sinh viên</i>
        </div>

      </div> <!-- END class account-->

        <?php
          }
      }
   
    ?>
    </div>
    </div>
    <!-- Chỗ này code model-->
    <div class="modal fade" id="PostModal-del">
        <div class="modal-dialog">
          <form method="post">
              <div class="modal-content">
                  <div class="modal-header">
                      <h7 class="modal-title"><b>Xóa bài đăng?</b></h7>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Modal body -->
                  <div class="modal-body text-center">Bình luận cũng sẽ bị xóa!</div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                      <input type="hidden" name="action" value="delete-post">
                      <input type="hidden" name="id-post" value="idPost" id="idPost-to-delete-input">
                      <button type="submit" class="btn btn-danger">Xóa</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
                  </div>
              </div>
            </form>
        </div>
        
    </div>

    <!-- Chỗ này code model delete comment-->
    <div class="modal fade" id="CommentModal-del">
        <div class="modal-dialog">
          <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h7 class="modal-title"><b>Xóa bình luận</b></h7>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body text-center">Bạn muốn xóa bình luận này?</div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  <input type="hidden" name="action" value="delete-comment">
                  <input type="hidden" name="id-comment" value="idComment" id="idComment-to-delete-input">
                  <button type="submit" class="btn btn-danger">Xóa</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
                </div>
            </div>
          </form>
        </div>
    </div>

    <!-- Chỗ này code model add student-->
    <div class="modal fade" id="AddStudentModal-del">
        <div class="modal-dialog">
          <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h7 class="modal-title"><b>Thêm học viên</b></h7>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body text-center">
                  <div>Nhập email học viên</div>
                  <input class="form-control w-100 mr-3 mt-2" rows="1" name="input-add-student" placeholder="student@gmail.com" require></input>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                  <input type="hidden" name="action" value="add-student">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                  <button type="submit" class="btn btn-success">Gửi</button>
                </div>
            </div>
          </form>
        </div>
    </div>
</body>