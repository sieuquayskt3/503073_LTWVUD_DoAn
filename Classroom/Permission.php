<?php

    // Kiểm tra đăng nhập
    // session_start();

    // if (!isset($_SESSION["username"])){
    //     header("location: login.php");
    //     exit();
    // }

    if (isset($_POST['edit'])){
        $newPermisstion = $_POST['permission'];
        echo $newPermisstion;
    }

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
        <div class="row font-weight-bold mt-3">
            <div class="col-1 text-center">
                Avatar
            </div>
            <div class="col-1">
                ID
            </div>
            <div class="col-2">
                Full name
            </div>
            <div class="col-2">
                Day of birth
            </div>
            <div class="col-2">
                Email
            </div>
            <div class="col-2">
                Phone number
            </div>
            <div class="col-2 text-center">
                Permission
            </div>
        </div>
        <!-- Database -->
        <!-- user 1 -->
        <div class="row mt-3">
            <div class="col-1 text-center">
                <img src="https://via.placeholder.com/32x32" alt="">
            </div>
            <div class="col-1">
                000001
            </div>
            <div class="col-2">
                Lê Thanh Bình
            </div>
            <div class="col-2">
                1/1/2000
            </div>
            <div class="col-2">
                bio@gmail.com
            </div>
            <div class="col-2">
                0123456789
            </div>
            <div class="col-2 text-center">
                Admin | <a href="#" data-toggle="modal" data-target="#change-permission">Edit</a>
                
            </div>
        </div>
        <hr>
        <!-- user 2 -->
        <div class="row mt-3">
            <div class="col-1 text-center">
                <img src="https://via.placeholder.com/32x32" alt="">
            </div>
            <div class="col-1">
                000002
            </div>
            <div class="col-2">
                Lê Thanh Bình 2
            </div>
            <div class="col-2">
                1/1/2001
            </div>
            <div class="col-2">
                bio2@gmail.com
            </div>
            <div class="col-2">
                0123456780
            </div>
            <div class="col-2 text-center">
                Student | <a href="#" data-toggle="modal" data-target="#change-permission">Edit</a>
            </div>
        </div>
        <hr>
        <!-- user 3 -->
        <div class="row mt-3">
            <div class="col-1 text-center">
                <img src="https://via.placeholder.com/32x32" alt="">
            </div>
            <div class="col-1">
                000003
            </div>
            <div class="col-2">
                Lê Thanh Bình 3
            </div>
            <div class="col-2">
                1/1/2002
            </div>
            <div class="col-2">
                bio3@gmail.com
            </div>
            <div class="col-2">
                0123456781
            </div>
            <div class="col-2 text-center">
                Teacher | <a href="#" data-toggle="modal" data-target="#change-permission">Edit</a>
            </div>
        </div>
        <hr>
        <!-- END data demo -->
        <div class="row">
            <div class="col-12 text-right text-md">
                <h5>Number of users: 3</h5>
            </div>
        </div>
        <!-- Edit permission dialog -->
        <div class="modal fade" id="change-permission">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- action = "proccessChangePermisstion.php" -->
                    <form action="" method="POST"> 
                        <div class="modal-header">
                            <h4 class="modal-title">Change permission</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                
                        <div class="modal-body">
                            <p>Choose the <strong>permission</strong> you want to change</p>
                            <div class="text-center">
                                <select class="btn btn-light border border-dark" name="permission" id="permission">
                                    <option value="admin">Admin</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="student">Student</option>
                                </select>
                            </div>  
                        </div>
                        
                        <div class="modal-footer">
                            <input type="hidden" name="edit" value="permission">
                            <button type="submit" class="btn btn-danger">Lưu</button>

                            <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy</button>
                        </div>            
                        
                    </form>
                </div>
            </div>
        </div>
        <!-- END database -->
    </div>
</body>
</html>