<?php

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
  $Quyen = 'student';

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
  
  if(empty($_POST['id'])){
    $sql = 'INSERT INTO class(IdAccount, TenLop, TenGV, Phong, MoTa, AnhDaiDien) values (?,?,?,?,?,?)';
    $conn = open_database();
    $stm = $conn->prepare($sql);
  }
  else {
    $conn = open_database();
    $id = $_POST["id"];
    $stm = $conn->prepare("UPDATE class SET IdAccount=?, TenLop=?, TenGv=?, Phong=?, MoTa=?, AnhDaiDien=? WHERE IdLop= $id");
  
  }
  $stm->bind_param('isssss', $IdAccount, $nameclass, $name, $room, $description,$linkimage);

  if (!$stm->execute()){
    return array('code' => 2, 'error' => 'can not execute command');
  }
  return array('code' => 0, 'error' => 'Create account successful');
}



?>