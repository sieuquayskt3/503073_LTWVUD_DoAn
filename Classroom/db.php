<?php

    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    define('HOST', '127.0.0.1');
    define('USER', 'root');
    define('PASS', '');
    define('DB', 'lab08');
    

    function open_database() {
        $conn = new mysqli (HOST, USER, PASS, DB);
        // change charset
        $conn->set_charset("utf8");

        if ($conn->connect_error) {
            die('Connect error: ' . $conn->connect_error);
        }
        return $conn;
    }

    function login($user, $pass) {
        $sql = "select * from account where username = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $user);
        if (!$stm->execute()){
            // kết nối sql thất bại
            return array('code' => 1, 'error' => 'Can not execute command!');
        }

        $result = $stm->get_result();
        if ($result->num_rows == 0){
            // không có user tồn tại
            return array('code' => 1, 'error' => 'User does not exists!');
        }

        $data = $result->fetch_assoc();
        // check pass
        $hash = $data['password'];
        if (!password_verify($pass, $hash)) {
            return array('code' => 2, 'error' => 'Invalid password');
        }else if($data['activated'] == 0){
            return array('code' => 3, 'error' => 'This account is not activated');
        } 
        else return 
            array('code' => 0, 'error' => '', 'data' => $data);
    }

    function is_email_exists($email){
        $sql = 'select username from account where email = ?';
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $email);
        if (!$stm->execute()){
            die('Query error: ' . $stm->error);
        }

        $result = $stm->get_result();
        if ($result->num_rows > 0){
            return true; // có email
        } else {
            return false;
        }

    }

    function register($user, $pass, $first, $last, $email){
        
        if (is_email_exists($email)){
            return array('code' => 1, 'error' => 'Email exists');
        }

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $rand = random_int(0, 1000);
        $token = md5($user . '+' . $rand);

        $sql = 'insert into account(username, firstname, 
        lastname, email, password, activate_token) values(?,?,?,?,?,?)';
        
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssssss', $user, $first, $last, $email,
        $hash, $token);
        
        if (!$stm->execute()){
            return array('code' => 2, 'error' => 'can not execute command');
        }

        // send verification email
        sendActivationEmail($email, $token);

        return array('code' => 0, 'error' => 'Create account successful');
    }

    function sendActivationEmail($email, $token){
        
            // Load Composer's autoloader
            require 'vendor/autoload.php';

            // Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->CharSet = 'UTF-8'; // font tiếng Việt
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'thanhbinh@gmail.com';  // email admin                   // SMTP username
                $mail->Password   = 'Password hoặc App password nếu xác thực 2 bước';     // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('thanhbinh@gmail.com', 'Admin web');
                $mail->addAddress($email, 'Người nhận');     // Add a recipient
                /*$mail->addAddress('ellen@example.com');               // Name is optional
                $mail->addReplyTo('info@example.com', 'Information');
                $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com');*/

                // Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Xác minh tài khoản của bạn';
                $mail->Body    = "Click <a href='http://localhost/active.php?email=$email&token=$token'> vào đây </a> để xác minh tài khoản";
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                
                return true;
            } catch (Exception $e) {
                return false;
            }
    }

    function sendResetEmail($email, $token){
        
        // Load Composer's autoloader
        require 'vendor/autoload.php';

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->CharSet = 'UTF-8'; // font tiếng Việt
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'thanhbinh@gmail.com';  // email admin                   // SMTP username
            $mail->Password   = 'Password hoặc App password nếu xác thực 2 bước';     // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('thanhbinh@gmail.com', 'Admin web');
            $mail->addAddress($email, 'Người nhận');     // Add a recipient
            /*$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');*/

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Khôi phục mật khẩu của bạn';
            $mail->Body    = "Click <a href='http://localhost/reset_password.php?email=$email&token=$token'> vào đây </a> để khôi phục mật khẩu";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            
            return true;
        } catch (Exception $e) {
            return false;
        }
}

    function activeAccount($email, $token){
        $sql = 'select username from account where email = ?
        and activate_token = ? and activated = 0';

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $email, $token);

        if (!$stm->execute()){
            return array('code' => 1, 'error' => 'Can not execute command');
        }
        $result = $stm->get_result();
        if ($result->num_rows == 0){
            return array('code' => 2, 'error' => 'Email address or token not found');
        }
        // found
        $sql = "update account set activated = 1, activate_token = '' where email = ?";

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $email);
        if (!$stm->execute()){
            return array('code' => 1, 'error' => 'Can not execute command');
        }

        return array('code' => 0, 'message' => 'Account activated');
    }

    function reset_password($email){
        if (!is_email_exists($email)){
            return array('code' => 1, 'error' => 'Email does not exists');
        }
        $token = md5($email . '+' . random_int(1000, 2000));
        $sql = 'update reset_token set token = ? where email = ?';

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $token, $email);

        if (!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not execute command');
        }
        
        if ($stm->affected_rows == 0){
            // chưa có dòng nào của email này, ta sẽ thêm dòng mới
            $exp = time() + 3600*24; // hết hạn sau 24h

            $sql = 'insert into reset_token values(?,?,?)';

            $stm = $conn->prepare($sql);
            $stm->bind_param('ssi', $token, $email, $exp);

            if (!$stm->execute()){
                return array('code' => 1, 'error' => 'Can not execute command');
            }

            // chèn hoặc update thành công token của dòng đã có
            // giờ gửi email để họ reset password
            $success = sendResetEmail($email, $token);
            return array('code' => 0, 'success' => $success);
            
        }
    }
?>