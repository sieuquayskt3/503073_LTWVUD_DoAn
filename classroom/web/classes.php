<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("location: login.php");
    exit();
}
// lấy thông tin
$role = $_SESSION["role"];
$IdAccount = $_SESSION["id"];
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Classes</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f25bf5c13c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="classes.css">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <a class="btn-bars" href="classes.php">
                <button class="w3-button w3-xlarge w3-circle w3-light">
                    <i class="fas fa-home"></i>
                </button>
            </a>
            <a class="navbar-brand">Google Classrooms</a>
            <div class="btn-plus">
                <?php
                if ($role == "Admin" || $role == "Teacher") {
                    echo '<a class="btn btn-outline-dark mr-1" href="taolophoc.php">Tạo</a>';
                    echo '<a class="btn btn-outline-dark" href="Permission.php">Phân quyền</a>';
                }
                ?>
                <a class="btn btn-outline-dark" href="JoinClass.php">Tham gia</a>
                <a class="btn btn-outline-dark" href="logout.php">Đăng xuất</a>
            </div>
        </div>
    </nav>
    <div class="container" style="padding: 80px;">
        <div class="row">
            <?php
            require "connection.php";
            $conn = open_database();
            $sql = "SELECT * FROM class";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
            ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body" style="background-image: url('images/brownsmall.jpg');">
                            <a class="card-tiltle">
                                <div class="class"><?php echo $row["TenLop"] ?></div>
                                <div class="class-info"><?php echo $row["Phong"] . " " . $row["MoTa"] ?></div>
                            </a>
                            <div class="card-text"><?php echo $row["TenGv"] ?></div>
                        </div>
                        <div class="card-body">
                            <img class="avt" src="<?php echo $row["AnhDaiDien"] ?>" alt="">
                        </div>
                        <div>
                            <a href="taolophoc.php?id=<?php echo $row['IdLop'] ?>" class="badge badge-info">Sửa</a>
                            <a href="#" class="badge btn btn-danger" data-toggle="modal" data-target="#myModal">Xóa</a>

                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="modal" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận thao tác</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <h4 class="text-center text-warning">Bạn có chắc chắn muốn xóa lớp học này không ?</h4>
                </div>
                <div class="modal-footer">
                    <?php
                    $sql = "SELECT * FROM class";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    ?>
                    <a href="#" class="badge btn btn-secondary" data-dismiss="modal">Hủy</a>
                    <a href="delete.php?id=<?php echo $row['IdLop'] ?>" class="badge btn btn-danger">Xóa</a>
                </div>
            </div>
        </div>
    </div>
</body>