<?php
define('HOST', '127.0.0.1');
define('USER', 'root');
define('PASS', '');
define('DB', 'web');

function open_database()
{
    $conn = new mysqli(HOST, USER, PASS, DB);
    if ($conn->connect_error) {
        die('Connect error:' . $conn->connect_error);
    }
    return $conn;
}

function login($user, $pass)
{
    $sql = "select * from account where username = ?";
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $user);

    if (!$stm->execute()) {
        //chay sql that bai vi 1 ly do nao do
        return array('code' => 1, 'error' => 'can not excute command');
    }

    $result = $stm->get_result();
    // Kiểm tra username có tồn tại không?
    if ($result->num_rows == 0) {
        //user khong ton tai
        return array('code' => 1, 'error' => 'User does not exist');
    }

    $data = $result->fetch_assoc();

    $hased_password = $data['password'];
    if (!password_verify($pass, $hased_password)) {
        // co user nhung sai password
        return array('code' => 2, 'error' => 'Invalid password');
    } else if ($data['activated'] == 0) {
        return array('code' => 3, 'error' => 'This account is not activated');
    } else
        return array('code' => 0, 'error' => '', 'data' => $data);
}
