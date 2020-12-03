<?php
session_start();
    require_once __DIR__."/send_mail/SendMail.php";
    require_once('connection.php');

    // Kiểm tra nếu thực hiện thao tác cập nhật quyền của người dùng
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $errors = '';
        $email = '';
        // kiem tra email co ton tai va dung dinh dang
        if(isset($_POST['email'])&& filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
        {
            $email = $_POST['email'];
        }
        else
        {
            $errors = "email";
        }
        if (empty($_POST['email'])) {
            $_SESSION['errors'] = 'Please enter your email';
            header('Location: forgot.php');
            exit();
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = 'Email address does not exist';
            header('Location: forgot.php');
            exit();
        }
        if (empty($errors) && !empty($email)) {
            $conn = open_database();
            $sql = "SELECT  `IdAccount`, `HoTen`, `UserName`, `Email` FROM `account` WHERE Email = '". $email. "'";
            $result = $conn->query($sql);
            $account = mysqli_fetch_assoc($result);

            if (empty($account)) {
                $_SESSION['errors'] = 'Email address does not exist ';
                header('Location: forgot.php');
                exit();
            }

            $randPassword = rand_string(8);
            $title = 'Cập nhật mật khẩu';
            $content = "<h3> Gửi ". $account['UserName']. '</h3>';
            $content .= "<p>Mật khẩu mới của bạn là: </p> <b>$randPassword</b>";
            $sendMai = SendMail::send($title, $content, $account['HoTen'], $account['Email']);

            if ($sendMai) {
                $hash = password_hash($randPassword, PASSWORD_DEFAULT);
                $sqlUpdate = "UPDATE `account` SET `Pass`= '". $hash ."' WHERE `IdAccount` = ". $account['IdAccount'];
                $conn->query($sqlUpdate);
                $_SESSION['success'] = 'We sent you an email please check it';
                header('Location: forgot.php');
            } else {
                $_SESSION['errors'] = 'An error has occurred unable to retrieve the password';
                header('Location: forgot.php');
                exit();
            }
        }

    }