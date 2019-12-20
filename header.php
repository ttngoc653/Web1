﻿<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>1760081_1560165</title>
  <link rel="stylesheet" href="">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <style type="text/css" media="screen">
    .avatar-pic {
      width: 150px;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
  <?php 
  session_start(); 
  include 'controller/incl.php';
  ?>
  <div style="padding-bottom: 10px;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">1760081 - 1560165</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link" href="index.php">Trang chủ</a>
          <?php if (empty($_SESSION['user']) && empty($_COOKIE['user'])) {
            ?>
            <a class="nav-item nav-link" href="register.php">Đăng ký</a>
            <a class="nav-item nav-link" href="login.php">Đăng nhập</a>
            <a class="nav-item nav-link" href="forgot-password.php">Quên mật khẩu</a>
            <?php 
          } else {
            ?>
            <a class="nav-item nav-link" href="post.php">Đăng trạng thái</a>
            <a class="nav-item nav-link" href="friend.php">Bạn bè</a>
            <a class="nav-item nav-link" href="profile.php">
              <?php 
              $infoUser = isset($_SESSION['user']) ? $_SESSION['user'] : $_COOKIE['user'];
              echo $infoUser['hoten'];
              ?>
            </a>
            <a class="nav-item nav-link" href="changepassword.php">Đổi mật khẩu</a>
            <a class="nav-item nav-link" href="logout.php">Đăng xuất</a>
            <?php 
          }
          ?>
        </div>
      </div>
    </nav>
  </div>
  <div class="container">