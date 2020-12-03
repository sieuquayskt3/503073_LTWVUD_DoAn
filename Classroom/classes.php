<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("location: login.php");
    exit();
}
// lấy thông tin
$role = $_SESSION["role"];
$IdAccount = $_SESSION["id"];

// tên các lớp học dùng để tìm kiếm
$suggest = array();
$idSuggest = array();

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
    <scrip src="https://kit.fontawesome.com/f25bf5c13c.js" crossorigin="anonymous"></scrip>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">


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
                    if ($role == "Admin") {
                        echo '<a class="btn btn-outline-dark" href="Permission.php">Phân quyền</a>';
                    }
                }
                ?>
                <a class="btn btn-outline-dark" href="register.php">Tài khoản của tôi</a>
                <a class="btn btn-outline-dark" href="JoinClass.php">Tham gia</a>
                <a class="btn btn-outline-dark" href="logout.php">Đăng xuất</a>
            </div>
        </div>
    </nav>
    <div class="container cont">

        <!-- Search engine -->
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4 text-right mb-2 d-flex align-items-center">
                <input type="text" placeholder="Tìm lớp học..." oninput="suggest(this.value)" class="w-100 p-1">
                <i class="fa fa-search ml-1"></i>
            </div>
        </div>
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4">
                <div id="suggestions" class="list-group list-group mb-1">
                    <!-- <li class="list-group-item">Cơ sở tin học</li>-->
                </div>
            </div>
        </div>
        <!-- END Search engine -->

        <div class="row">
            <?php
            require "connection.php";
            $conn = open_database();
            // Lấy id lớp theo id account trong bảng classdetail
            if ($role != "Admin") {
                $sql1 = "SELECT IdLop FROM detailclass WHERE IdAccount=$IdAccount";
                $result1 = $conn->query($sql1);


                if ($result1->num_rows > 0) {
                    // Hiển thị lớp học theo id lớp

                    while ($row1 = $result1->fetch_assoc()) {

                        $idclass = $row1["IdLop"];
                        $sql = "SELECT * FROM class WHERE IdLop=$idclass";
                        $result = $conn->query($sql);
                        // Lay thong tin lop hoc hien len
                        while ($row = $result->fetch_assoc()) {
                            // Search engine, lấy tên lớp và id lớp
                            array_push($suggest, $row["TenLop"]);
                            array_push($idSuggest, $row["IdLop"]);
            ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-body bod">
                                        <a class="card-tiltle" href="stream.php?IdLop=<?php echo $row['IdLop'] ?>">
                                            <div class="class"><?php echo $row["TenLop"] ?></div>
                                            <div class="class-info"><?php echo $row["Phong"] . " " . $row["MoTa"] ?></div>
                                            <div class="class-info">Mã lớp học: <?php echo $row["MaLop"] ?></div>
                                        </a>
                                        <div class="card-text"><?php echo $row["TenGv"] ?></div>
                                    </div>
                                    <div class="card-body">
                                        <img class="avt2" src="<?php echo $row["AnhDaiDien"] ?>" alt="">
                                    </div>
                                    <?php

                                    if ($role == "Admin" || $role == "Teacher") {
                                        echo ' <div> <a href="taolophoc.php?id=' . $row['IdLop'] . '" class="badge badge-info mr-1">Sửa</a><a href="#" class="badge btn btn-danger" data-toggle="modal" data-target="#myModal">Xóa</a> </div>';
                                    }


                                    ?>

                                </div>
                            </div>
                        <?php
                        }
                    }
                } else {
                    echo "Bạn chưa tham gia vào lớp học nào! Hãy nhập mã lớp để tham gia học nhé";
                }
            } else {
                $sql = "SELECT * FROM class";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body bod" >
                                    <a class="card-tiltle" href="stream.php?IdLop=<?php echo $row['IdLop'] ?>">
                                        <div class="class"><?php echo $row["TenLop"] ?></div>
                                        <div class="class-info"><?php echo $row["Phong"] . " " . $row["MoTa"] ?></div>
                                        <div class="class-info">Mã lớp học: <?php echo $row["MaLop"] ?></div>
                                    </a>
                                    <div class="card-text"><?php echo $row["TenGv"] ?></div>
                                </div>
                                <div class="card-body">
                                    <img class="avt2" src="<?php echo $row["AnhDaiDien"] ?>" alt="">
                                </div>
                                <?php

                                if ($role == "Admin" || $role == "Teacher") {
                                    echo ' <div> <a href="taolophoc.php?id=' . $row['IdLop'] . '" class="badge badge-info mr-1">Sửa</a><a href="#" class="badge btn btn-danger" data-toggle="modal" data-target="#myModal">Xóa</a> </div>';
                                }


                                ?>

                            </div>
                        </div>
            <?php
                    }
                } else {
                    echo "Không có lớp học";
                }
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
                    <a href="delete.php?IdLop=<?php echo $row["IdLop"] ?>" class="badge btn btn-danger">Xóa</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Search engine -->
    <script type="text/javascript">
        // convert array php to javascript
        var currClass = <?php echo json_encode($suggest);?>;
        var idClass = <?php echo json_encode($idSuggest);?>;
    </script>

    <script>
        function suggest(value){
            value = value.trim(); // xóa khoảng trắng đầu và cuối chuỗi
            if (value.length < 2){
                let list = $('#suggestions');
                list.empty();
                return;
            }

            // gửi tên lớp kèm id lớp qua suggestClass.php để kiểm tra
            $.post('suggestClass.php', {keyword: value, currClass: currClass, idClass: idClass}, (data, status) => {
                if (status==='success'){
                    if (data.success === true){
                        let list = $('#suggestions');
                        list.empty();  // clear all

                        let virtualDom = document.createDocumentFragment();
                        var i;
                        // gán 1 lượt cả class và id vào list item
                        for (i = 0; i < data.class.length; i++) {
                            $(`<a href="stream.php?IdLop=${data.idClass[i]}" class="list-group-item list-group-item-action btn btn-light">${data.class[i]}</a>`).appendTo(virtualDom);
                        }
                        
                        data.class.forEach(c=>{
                            data.idClass.forEach(i=>{
                                
                            });
                        });
                        list.append(virtualDom);
                    }
                };
            });
        }
    </script>
    <!-- END Search engine -->
</body>