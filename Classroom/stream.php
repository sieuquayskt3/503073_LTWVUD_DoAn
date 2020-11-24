<?php
session_start();
if (!isset($_SESSION["user"])) { // Yêu cầu đăng nhập
  header("location: login.php");
  exit();
}
require_once('connection.php');

?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

  <title>Stream</title>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/f25bf5c13c.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="stream.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="btn-bars" href="classes.php">
      <button class="w3-button w3-xlarge w3-circle w3-light mr-3">
        <i class="fas fa-home"></i>
      </button>
    </a>
    <a class="navbar-brand" href="#">HK1_2020_503073_Lap trinh web </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">Stream <span class="sr-only">(current)</span></a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Classwork</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">People</a>
        </li>
      </ul>
    </div>
    <div>
      <a class="btn btn-outline-dark" href="logout.php">Đăng xuất</a>
    </div>
  </nav>

  <div class="container">

    <div class="bgd-img-top" style="background-image: url('images/brown.jpg');">
      <div class="class">Lập trình web và ứng dụng</div>
      <div class="class-info">Đặng Minh Thắng-Thu2-Ca3</div>
    </div>

    <div class="account">
      <div class="row">

        <div class="col-1">
          <img class="avt" src="images/person.jpg" alt="">
        </div>

        <div class="col-9">
          <div style="font-weight: 500;">Đặng Minh Thắng</div>
          <div style="font-weight: 200;">Oct 15</div>
        </div>
      </div>
      <div>Hướng dẫn trình bày bài báo cáo cuối kỳ</div>
    </div>

    <div class="account">
      <div class="row">
        <div class="col-1">
          <img class="avt" src="images/person.jpg" alt="">
        </div>
        <div class="col-9">
          <div style="font-weight: 500;">Đặng Minh Thắng posted a new material: Điểm danh</div>
          <div style="font-weight: 200;">Oct 25</div>
        </div>
      </div>
    </div>
  </div>
</body>