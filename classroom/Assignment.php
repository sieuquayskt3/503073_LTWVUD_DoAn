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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài tập</title>
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
    $sql = "SELECT * FROM class WHERE IdLop=$IdLop";
    $result = $conn->query($sql);
    $row1 = $result->fetch_assoc();

    ?>
    <!--Nav bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="btn-bars" href="classes.php">
            <button class="w3-button w3-xlarge w3-circle w3-light mr-3">
                <i class="fas fa-home"></i>
            </button>
        </a>
        <a class="navbar-brand" href="#">HK1_2020_<?php echo $row1['TenLop'] ?> </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item ">
                    <a class="nav-link" href="stream.php?IdLop=<?php echo $IdLop ?>">Thông báo <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="Assignment.php?IdLop=<?php echo $IdLop ?>">Bài tập</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="detailclass.php?IdLop=<?php echo $IdLop ?>">Mọi người</a>
                </li>
            </ul>
        </div>
        <div>
            <?php
            if ($role == "Teacher" || $role == "Admin") {
                echo '<a class="btn btn-outline-dark mr-1" href="TaoBT.php?IdLop=' . $IdLop . '">Tạo bài tập</a>';
            }
            ?>
            <a class="btn btn-outline-dark" href="logout.php">Đăng xuất</a>
        </div>
    </nav>
    <!--Nội dung-->

    <div class="container">

        <div class="bgd-img-top" style="background-image: url('images/bg1.jpg');">
            <div class="class"><?php echo $row1['TenLop'] ?></div>
            <div class="class-info"><?php echo $row1['TenLop'] . ' - ' .$row1['MoTa'] ?></div>
        </div>

        <?php // Hiển thị danh sách bài tập trong lớp học
        require_once 'connection.php';

        $conn = open_database();
        $sql = "";
        $sql = "SELECT * FROM assignment WHERE IdLop = $IdLop";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <?php
                $IdBaiTap = $row['IdBaiTap'];
                ?>
                <div class="account">

                    <div class="row">
                        <div class="col-lg-9 col-sm-12">
                            <a class="text-primary" href="classwork.php?IdLop=<?php echo $IdLop ?>&IdAccount=<?php echo $IdAccount ?>&IdBaiTap=<?php echo $IdBaiTap ?>"><?php echo $row['TieuDe'] ?></a>
                        </div>
                        <div class="date col-lg-3 col-sm-12"><small>
                                <h5 class="text-primary">Hạn nộp bài</h5>
                                <?php echo $row['Deadline'] ?>

                            </small>
                        </div>

                    </div>

                    <div> Hướng dẫn: <?php echo $row['NoiDung'] ?></div>
                    <div class="mt-2 mb-2">
                        File kèm theo: <a href="<?php echo $row['File'] ?>" class="text-primary"><?php echo $row['File'] ?></a>
                    </div>

                    <textarea class="form-control" rows="1" id="content" name="content">Bình luận</textarea>
                </div>

        <?php
            }
        } else {
            echo '<div class="text-center text-success"> <h3> Không có bài tập !!!</h3></div>';
        }
        ?>
    </div>

</body>

</html>