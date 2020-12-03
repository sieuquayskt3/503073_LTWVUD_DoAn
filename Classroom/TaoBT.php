<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("location: login.php");
    exit();
}
$IdLop = $_GET["IdLop"];
require_once('connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Bài Tập GV</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <scrip src="https://kit.fontawesome.com/f25bf5c13c.js" crossorigin="anonymous"></scrip>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">
</head>

</head>

<body>
    <nav class="navbar nav navbar-light bg-light justify-content-between">
        <a class="btn-bars" href="classes.php">
            <button class="w3-button w3-xlarge w3-circle w3-light">
                <i class="fas fa-home"></i>
            </button>
        </a>
        <h3>Bài tập</h3>
    </nav>
    <hr>
    <div class="container work w-50 ">
        <form action="" method="post" novalidate enctype="multipart/form-data">
            <?php
            $error = "";
            $title = ""; // Tiêu đề
            $content=""; // Nội dung
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $datestart = getdate();
            $datestart = date('Y-m-d-H-i');// Ngày bắt đầu
            $deadline=""; // Ngày đến hạn
            $namefile = "";
            $file=""; // Tệp tài liệu
            $links=""; // Đường dẫn đến GG form

                if(isset($_POST["title"]) && isset($_POST["content"]) && isset($_POST["deadline"]) && isset($_FILES["file"]) && isset($_POST["paths"])){
                    $title = $_POST["title"];
                    $content = $_POST["content"];
                    $deadline = $_POST["deadline"];
                    $links = $_POST["paths"];
                    $file = $_FILES['file'];
                    $namefile = $file['name'];
                
                    $file = "uploads/" . $_FILES["file"]["name"];
                    
                    if(empty($title)){
                        $error = 'Vui lòng nhập tiêu đề';
                    
                    }else if(empty($namefile)){
                        $error = 'Vui lòng chọn file bài tập';
                    }else if(empty($deadline)){
                        $error = 'Vui lòng chọn ngày đến hạn';
                    }else if (!move_uploaded_file($_FILES["file"]["tmp_name"], $file)){
                        $error = "Sorry, there was an error uploading your file.";
                    }
                    else {
                        $result = create_assignment($IdLop,$title,$content,$file,$datestart,$deadline);
                        if($result['code']==0){
                            $code = sendMailNotify($IdLop, "Bạn có 1 bài tập mới:".$content);
                            
                            header('Location: Assignment.php?IdLop='.$IdLop.'');
                        }else if($result['code']==2){
                            $error = 'Không thể tạo bài tập';
                        }else{
                            $error = 'Đã xảy ra lỗi vui lòng thử lại';
                        }
                    }
            
                }
                

            ?>
            <div class="table-active  rounded border border-secondary pt-4 pl-4 pr-4 shadow-lg bg-info">
                <div class="form-group">
                    <input value="<?= $title ?>" id="title" type="text" class="form-control form-control-lg" placeholder="Tiêu đề" name="title">
                </div>
                <div class="form-group">
                    <label for="content">Hướng dẫn (nếu có):</label>
                    <textarea value="<?= $content ?>" class="form-control" rows="4" id="content" name="content"></textarea>
                </div>
                <div class="form-group">
                    <label for="file">Thêm file:</label>
                    <input type="file" class="form-control" placeholder="Chọn ảnh" id='file' name='file'>
                </div>
                <div class="mb-3">
                    <label for="paths">Thêm liên kết</label> <br>
                    <input value="<?= $links ?>" type="text" id="paths" name="paths" class="rounded">
                </div>
                <div>
                    <label for="deadline">Ngày đến hạn</label> <br>
                    <input value="<?= $deadline ?>" type="datetime-local" id="deadline" name="deadline">
                </div>
                <div class="d-flex justify-content-start mt-3">
                    <a href="https://docs.google.com/forms/d/1EjShkr3gH6N7zVf5WCUwVd0yc8S85_CnPuMTwScjJQc/edit" class="btn-link">Tạo bài tập bằng google form</a>
                </div>
                <div class="form-group text-center mt-3">
                    <?php
                    if (!empty($error)) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                    ?>
                    <button type="reset" class="btn bg-warning mr-2 pl-5 pr-5 mb-3">Hủy</button>
                    <button type="submit" class="btn bg-success pl-5 pr-5 mb-3">Giao bài</button>
                </div>
                


            </div>


        </form>


    </div>

</body>



</html>