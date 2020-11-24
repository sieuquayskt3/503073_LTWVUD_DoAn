<?php
//createclass.php
    session_start();
    $id = "";
    if(isset($_SESSION['idnguoidung'])){
        $id = $_SESSION['idnguoidung'];
    }
    require_once('database.php');
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = getdate();
    $idclass = $date['year'].$date['mon'].$date['mday'].$date['hours'].$date['minutes'].$date['seconds'];
    $classname = "";
    $subject = "";
    $classroom = "";
    $file_name = "";
    $file = "";

    if(isset($_POST['classname'])){
        $classname = $_POST['classname'];
    }

    if(isset($_POST['subject'])){
        $subject = $_POST['subject'];
    }

    if(isset($_POST['classroom'])){
        $classroom = $_POST['classroom'];
    }

    if(isset($_FILES['image'])){
        $file = $_FILES['image'];
        $file_name = $file['name'];
        if($file['type'] == 'image/jpeg' || $file['type'] == 'image/jpg' || $file['type'] == 'image/png'){
            move_uploaded_file($file['tmp_name'], 'images/'.$file_name);
        }
    }
    if($idclass != "" && $classname != "" && $subject != "" && $classroom != "" && $file_name != ""){
        addClass($idclass, $classname, $subject, $classroom, $file_name);
        addIdClassAndIdUser($idclass, $id);
        header('Location: homepage.php');
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Thêm lớp học</title>
</head>
<body>
<h1 id='login-h1'>TẠO LỚP HỌC</h1>
    <div class="container">
        <form id='formlogin' method="post" action="" enctype="multipart/form-data">

            <div class="form-group">
                <label for="">Tên lớp:</label>
                <input type="text" class="form-control" placeholder="Tên lớp" id='classname' name='classname'>
            </div>


            <div class="form-group">
                <label for="subject">Môn học:</label>
                <input type="text" class="form-control" placeholder="Môn học" id='subject' name='subject'>
            </div>

            <div class="form-group">
                <label for="classroom">Phòng học:</label>
                <input type="text" class="form-control" placeholder="Phòng học" id='classroom' name='classroom'>
            </div>

            <div class="form-group">
                <label for="image">Ảnh đại diện:</label>
                <input type="file" class="form-control" placeholder="Chọn ảnh" id='image' name='image'>
            </div>

            <!--<div class="d-flex justify-centent-center form-group w-10">-->
                <table style="margin: auto; text-align: center">
                    <td>
                        <tr>
                            <button type="submit" id='login-bt-dangky' class="btn btn-success">OK</button>
                        </tr>
                    </td>
                    <td>
                        <tr>
                            <button type="submit" id='login-bt-default' class="btn btn-default"><a href="homepage.php">Cancel</a></button>
                        </tr>
                    </td>
                </table>
            <!--</div>-->

        </form>
    </div>
</body>
</html>