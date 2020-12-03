<?php
session_start();
    $id = "";
    if (!isset($_SESSION["user"])) { // Yêu cầu đăng nhập
    header("location: login.php");
    exit();
    }
    require_once('connection.php');
    $IdLop = $_GET["IdLop"]; // id lớp
    $conn = open_database();
    $role = $_SESSION['role'];

    $sql = "SELECT class.IdLop as IdClass, account.* FROM class INNER JOIN detailclass ON class.IdLop = detailclass.IdLop INNER JOIN account ON detailclass.IdAccount = account.IdAccount WHERE class.IdLop =". $IdLop;
    $result = $conn->query($sql);

    $data = [];// khởi tạo mạng $data
    if( $result)// Kiểm tra kết quả $result trả về nếu rỗng thì không chạy hàm if này
    {
        while ($num = mysqli_fetch_assoc($result)) // đọc từng dòng dữ liệu trong object $result
        {
            $data[] = $num;// thêm từng dòng dữ liệu vào mảng $data
        }
    }
    // lấy ra thông tin lớp
    $sqlClass = "SELECT TenLop FROM `class` WHERE IdLop = ". $IdLop;
    $resultClass = $conn->query($sqlClass);
    $class = mysqli_fetch_assoc($resultClass);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách thành viên lớp</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f25bf5c13c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="style.css">
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
                    <a class="nav-link " href="Assignment.php?IdLop=<?php echo $IdLop ?>">Bài tập</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="detailclass.php?IdLop=<?php echo $IdLop ?>">Mọi người</a>
                </li>
            </ul>
        </div>
        <div>
           
            <a class="btn btn-outline-dark" href="logout.php">Đăng xuất</a>
        </div>
    </nav>
    <hr class="m-0">
    <div class="container cont">
        <table class="table table-bordered" style="margin-top: 30px;">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Họ tên</th>
                    <th scope="col">Tài khoản</th>
                    <th scope="col">Ngày sinh</th>
                    <th scope="col">Email</th>
                    <th scope="col">Số điện thoại</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data)) { ?>
                    <?php foreach($data as $item) { ?>
                        <tr>
                            <th scope="row"><?= $item['IdAccount'] ?></th>
                            <td><?= $item['HoTen'] ?></td>
                            <td><?= $item['UserName'] ?></td>
                            <td><?= $item['NamSinh'] ?></td>
                            <td><?= $item['Email'] ?></td>
                            <td><?= $item['Sdt'] ?></td>
                            <td><a href="delete_account.php?IdAccount=<?= $item['IdAccount'] ?>&&IdLop=<?= $IdLop ?>" class="confrim-delete">Delete</a></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <!-- END data demo -->
        <div class="row">
            <div class="col-12 text-right text-md">
                <h5>Số lượng thành viên : <?= !empty($data) ? count($data) : 0 ?></h5>
            </div>
        </div>
        <!-- Edit permission dialog -->
    </div>
</body>
<script>
    $(function(){
        $('.confrim-delete').confirm({
        title:'Xóa dữ liệu',
        content: "Bạn có chăc chắn muốn xóa dữ liệu ?",
        icon: 'fa fa-warning',
        type: 'red',
        buttons: {
            confirm: {
                text: 'Xác nhận',
                btnClass: 'btn-blue',
                action: function () {
                    location.href = this.$target.attr('href');
                }
            },
            cancel: {
                text: 'Hủy',
                btnClass: 'btn-danger',
                action: function () {
                }
            }
        }
    });
    })
</script>
</html>