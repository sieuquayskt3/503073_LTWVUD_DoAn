<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
define('HOST', '127.0.0.1');
define('USER', 'root');
define('PASS', '');
define('DB', 'classroom');

function open_database() {
  $conn = new mysqli (HOST, USER, PASS, DB);
  // change charset
  $conn->set_charset("utf8");

  if ($conn->connect_error) {
      die('Connect error: ' . $conn->connect_error);
  }
  return $conn;
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
// đăng ký
function register($user, $pass, $name, $email, $phone, $year){
        
  if (is_email_exists($email)){
      return array('code' => 1, 'error' => 'Email exists');
  }

  $hash = password_hash($pass, PASSWORD_DEFAULT);
  $rand = random_int(0, 1000);
  $token = md5($user . '+' . $rand);
  $Quyen = 'Student';

  $sql = 'insert into account(HoTen, UserName, Email, Pass, Sdt, NamSinh, Quyen) values(?,?,?,?,?,?,?)';
  
  $conn = open_database();
  $stm = $conn->prepare($sql);
  $stm->bind_param('sssssss', $name, $user, $email, $hash, $phone, $year, $Quyen);
  
  if (!$stm->execute()){
      return array('code' => 2, 'error' => 'can not execute command');
  }

  return array('code' => 0, 'error' => 'Create account successful');
}

// Đăng nhập
function login($user, $pass) {
  $sql = "select * from account where UserName = ?";
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
  $hash = $data['Pass'];
  if (!password_verify($pass, $hash)) {
    return array('code' => 2, 'error' => 'Invalid password');
  }
  else return 
    array('code' => 0, 'error' => '', 'data' => $data);
}

function CU_Class($IdAccount,$nameclass, $name, $room, $description,$linkimage)
{
  $randnum = random_int(1000, 9999);
  $text = 'qwertyuioplkjhgfdsazxcvbnmMNBVCXZASDFGHJKLPOIUYTREWQ';
  $randtext = str_shuffle($text);
  $rand =substr(($randtext),0,4);
  $codes = $rand.$randnum;
 
  if(empty($_POST['id'])){
    $sql = 'INSERT INTO class(IdAccount, TenLop, TenGV, Phong, MoTa, AnhDaiDien,MaLop) values (?,?,?,?,?,?,?)';
    $conn = open_database();
    $stm = $conn->prepare($sql);
  }
  else {
    $conn = open_database();
    $id = $_POST["id"];
    $stm = $conn->prepare("UPDATE class SET IdAccount=?, TenLop=?, TenGv=?, Phong=?, MoTa=?, AnhDaiDien=?, MaLop=? WHERE IdLop= $id");
  
  }
  $stm->bind_param('issssss', $IdAccount, $nameclass, $name, $room, $description,$linkimage,$codes);

  if (!$stm->execute()){
    return array('code' => 2, 'error' => 'can not execute command');
  }
  return array('code' => 0, 'error' => 'Create account successful');
}


// Kiểm tra Mã lớp học
function is_MaLop_exists($MaLop){
  $sql = 'select IdLop from class where MaLop = ?';
  $conn = open_database();

  $stm = $conn->prepare($sql);
  $stm->bind_param('s', $MaLop);
  if (!$stm->execute()){
      die('Query error: ' . $stm->error);
  }

  $result = $stm->get_result();
  while ($row = $result->fetch_assoc()) {
    $IdLop = $row['IdLop'];
  }
  if ($result->num_rows > 0){
      return $IdLop; // có Mã lớp hợp lệ
  } else {
      return false;
  }

}

// Tham gia lớp học
function joinClass($IdAccount, $MaLop)
{
  $conn = open_database();
  $IdLop = is_MaLop_exists($MaLop);
  if ($IdLop==false){
    return array('code' => 1, 'error' => 'Mã lớp không tồn tại');
  }
  $stm = $conn->prepare('INSERT INTO detailclass(IdAccount, IdLop) values (?,?)');
  
  $stm->bind_param("ii", $IdAccount, $IdLop);
  if (!$stm->execute()){
    return array('code' => 2, 'error' => 'can not execute command');
  }
  return array('code' => 0, 'error' => 'Join class successful');
}

function createPost($IdAccount,$IdLop,$content,$target_file,$datecreate){
  $sql = 'INSERT INTO post(IdAccount, IdLop, NoiDung, File, NgayTao) values (?,?,?,?,?)';
  $conn = open_database();
  $stm = $conn->prepare($sql);
  $stm->bind_param('iisss', $IdAccount, $IdLop, $content, $target_file,$datecreate);
  if (!$stm->execute()){
    return array('code' => 2, 'error' => 'can not execute command');
  }
  return array('code' => 0, 'error' => 'Create account successful');
}

//delete post
function deletePost($idPost){
  $sql = "DELETE FROM post WHERE IdPost = ?";
  $conn = open_database();
  $stm = $conn->prepare($sql);
  $stm->bind_param('i', $idPost);
  if (!$stm->execute()){
    return array('code' => 2, 'error' => 'can not execute command');
  }
  return array('code' => 0, 'success' => 'Create comment successful');
}

// create comment
function createComment($IdAccount, $idPost, $comment, $datecreate){
  $sql = 'INSERT INTO comment(IdAccount, IdPost, NoiDung, NgayTao) values (?,?,?,?)';
  $conn = open_database();
  $stm = $conn->prepare($sql);
  $stm->bind_param('iiss', $IdAccount, $idPost, $comment, $datecreate);
  if (!$stm->execute()){
    return array('code' => 2, 'error' => 'can not execute command');
  }
  return array('code' => 0, 'success' => 'Create comment successful');
}

//delete comment
function deleteComment($idComment){
  $sql = "DELETE FROM comment WHERE IdComment = ?";
  $conn = open_database();
  $stm = $conn->prepare($sql);
  $stm->bind_param('i', $idComment);
  if (!$stm->execute()){
    return array('code' => 2, 'error' => 'can not execute command');
  }
  return array('code' => 0, 'success' => 'Create comment successful');
}

// add student
function sendMailAddStudent($email, $idClass){


    // Load Composer's autoloader
    require 'vendor/autoload.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer();

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->CharSet = 'UTF-8'; // font tiếng Việt
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'sieuquayskt4@gmail.com';  // email admin                   // SMTP username
        $mail->Password   = '123456789Binh';     // Password hoặc App password nếu xác thực 2 bước
        $mail->SMTPSecure = 'tls';    
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('sieuquayskt4@gmail.com', 'Admin Web');
        $mail->addAddress($email, 'Người nhận');

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Thư mời tham gia lớp học';
        $mail->Body    = "Click <a href='http://localhost/addStudentByEmail.php?email=$email&idClass=$idClass'> vào đây </a> để tham gia lớp học";
        $mail->AltBody = 'Lỗi không xác định';

        $mail->send();
        
        return array('code' => 0, 'success' => 'Gửi mail thành công');
    } catch (Exception $e) {
      return array('code' => 1, 'error' => 'Không thể gửi mail');
    }
}
?>