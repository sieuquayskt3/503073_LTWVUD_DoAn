<?php
    session_start();
    

    if (isset($_SESSION['user'])) {
        header('Location: classes.php');
        exit();
    }

    require_once('connection.php');
    $error = '';
    $success = '';
    if (isset($_SESSION['errors'])) {
        $error = $_SESSION['errors'];
    }

if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">Khôi phục mật khẩu</h3>
            <form method="post" action="sendMail.php" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input value="" name="email" id="email" type="email" class="form-control" placeholder="Nhập email của bạn">
                </div>

                <div class="form-group text-center">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>

                    <?php
                        if (!empty($success)) {
                        echo "<div class='alert alert-success'>$success</div>";
                    }
                    ?>
                    <button class="btn btn-success px-5">Gửi</button>
                </div>
                <div class="form-group text-center">
                <p>Bạn chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>.</p>
                    <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a>.</p>
                </div>
            </form>
            
        </div>
    </div>
</div>
<?php unset($_SESSION['errors']); ?>
</body>
</html>
