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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="createpost.css">
</head>

<body>
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
            <a class="btn btn-outline-dark" href="logout.php">Đăng xuất</a>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-8 border my-3 p-4 rounded mx-3 bg-light">
                <form action="" method="post" enctype="multipart/form-data">
                    <?php
                    // Lấy ngày tạo bài đăng
                    $conn = open_database();
                    $date = getdate();
                    $datecreate = $date['mday'] . '/' . $date['mon'] . '/' . $date['year'];

                    $error = "";
                    $content = ""; // nội dung bài post
                    $myfile = ""; // file

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
                            
                            $result = createPost($IdAccount, $IdLop, $content, $target_file, $datecreate);
                            if ($result1['code'] == 0) {
                                // successful
                                header("Location: stream.php?IdLop=" . $IdLop);
                                exit();
                            } else if ($result1['code'] == 2) {
                                $error = "Không thể thêm lớp học";
                            } else {
                                $error = "Đã xảy ra lỗi vui lòng thử lại";
                            }
                        }
                    }


                    // Hiển thị thông tin bài post khi bấm nút sửa
                    if (isset($_GET["IdPost"])) {
                        $id = $_GET["IdPost"];
                        $sql = "SELECT * FROM post WHERE IdPost=$id";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $content = $row["NoiDung"];
                        $file = $row["File"];
                    }
                    ?>
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <!--Ẩn id lớp học -->
                    <div class="form-group">
                        <h5 for="post" class="text-muted">Đăng</h5>
                        <hr>
                        <textarea class="form-control" rows="5" id="content" name="content" require><?php echo $content ?></textarea>
                    </div>
                    <div class="form-group">
                        <input value="<?= $file ?>" type="file" class="form-control" id='myfile' name='myfile'>
                    </div>
                    <hr>
                    <div class="form-group text-right">
                       
                       <a href="stream.php" class="btn btn-success">Hủy</a>
                        <button type="submit" class="btn btn-primary">Đăng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>