<?php
    session_start();
    session_start();
    if (!isset($_SESSION["user"])) {
        header("location: login.php");
        exit();
    }
    // lấy thông tin quyền
    $role = $_SESSION["role"];
    if ($role != 'Admin'){
        header('Location:classes.php');
    }
    // kết nối cớ sở dữ liệu
    $conn = mysqli_connect("localhost","root","","classroom") or die ('Không thể kết nối cơ sở dữ liệu');
    mysqli_set_charset($conn,"utf8");

    // Truy vấn dữ liệu bảng account
    $sql = "SELECT * FROM `account` WHERE 1";

    $result = mysqli_query($conn, $sql) or die("Lỗi truy vấn dữ liệu" .mysqli_error($conn));
    $data = [];// khởi tạo mạng $data
    if( $result)// Kiểm tra kết quả $result trả về nếu rỗng thì không chạy hàm if này
    {
        while ($num = mysqli_fetch_assoc($result)) // đọc từng dòng dữ liệu trong object $result
        {
            $data[] = $num;// thêm từng dòng dữ liệu vào mảng $data
        }
    }
    $permission = [
        'Admin' => 'Quản trị viên',
        'Teacher' => 'Giảng viên',
        'Student' => 'Sinh viên',
    ];
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="header m-2 mr-5 col-form-label-lg">
        <div class="row">
            <div class="col-12 d-flex mx-3 d-flex d-row">
                <!-- <php include 'menu.php' ?>; -->
                <div class="dropdown">
                    <button class="p-1 btn btn-light" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://via.placeholder.com/24x24" alt="">
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
                <!-- END menu demo -->
                <div class="ml-3">Phân quyền người dùng</div>
                <div class="ml-auto"><img src="https://via.placeholder.com/24x24" alt=""></div>
            </div>
        </div>
    </div>
    <hr class="m-0">
    <div class="container">
        <table class="table table-bordered" style="margin-top: 30px;">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Họ tên</th>
                    <th scope="col">Tài khoản</th>
                    <th scope="col">Ngày sinh</th>
                    <th scope="col">Email</th>
                    <th scope="col">Số điện thoại</th>
                    <th scope="col">Quyền</th>
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
                            <td><?= $permission[$item['Quyen']] ?> | <a href="#" IdAccount="<?= $item['IdAccount'] ?>" class="change-permission" data-toggle="modal" data-target="#change-permission">Edit</a></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <!-- END data demo -->
        <div class="row">
            <div class="col-12 text-right text-md">
                <h5>Số lượng người dùng : <?= !empty($data) ? count($data) : 0 ?></h5>
            </div>
        </div>
        <!-- Edit permission dialog -->
        <div class="modal fade" id="change-permission">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- action = "proccessChangePermisstion.php" -->
                    <form action="update_permission.php" method="POST"> 
                        <div class="modal-header">
                            <h4 class="modal-title">Thay đổi quyền</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                
                            <div class="modal-body">
                                <p>Chọn <strong>quyền</strong> bạn muốn thay đổi</p>
                                <div class="text-center">
                                    <select class="btn btn-light border border-dark" name="quyen" id="permission">
                                        <?php foreach($permission as $key =>  $pre) : ?>
                                            <option value="<?= $key ?>"><?= $pre ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" name="IdAccount" class="IdAccount">
                                </div>
                            </div>
    
                            <div class="modal-footer">
                                <input type="hidden" name="edit" value="permission">
                                <button type="submit" class="btn btn-danger">Lưu</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy</button>
                            </div>            
                        </div>
                    </form>
                </div>
            </div>
        <!-- END database -->
    </div>
</body>
<script>
    $(function(){
        $('.change-permission').click(function() {
            let id = $(this).attr('IdAccount');
            $('.IdAccount').val(id)
        })
    })
</script>
</html>