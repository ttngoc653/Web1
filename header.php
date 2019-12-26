<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>1760081_1560165</title>
  <link rel="stylesheet" href="">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" integrity="sha256-46qynGAkLSFpVbEBog43gvNhfrOj+BmwXdxFgVK/Kvc=" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<?php 
session_start(); 
include "controller/incl.php";
?>
  <div style="padding-bottom: 10px;">
    <header class="navbar navbar-expand-lg navbar-light bg-light">
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

      <form class="form-inline my-2 my-lg-0" method="GET" action="search.php">
        <input list="listSearching" name="q" id="keywordSearch" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
  <datalist id="listSearching">
  </datalist>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
      <script>
          $("body").on("keyup","input#keywordSearch",function() {
            var keywordInputted = $(this).val();

            var elementAdd=$("datalist#listSearching");

            $.ajax({
              url:"<?php echo getCurUrl(); ?>/../ajaxProcess/actionSearch.php",
              method:'POST',
              data:{keyword:keywordInputted},
              success:function(data) {
                elementAdd.html(data);
                //alert(data);
              }
            })
          });
      </script>
      <?php
      if(isset($infoUser)) {
        ?>
        <div class="dropdown">
          <a class="nav-item nav-lin dropdown-toggle" data-toggle="dropdown" onclick="showListNotification()" style="cursor: pointer;">
            <i class="far fa-bell"><span class="badge badge-success" id="countNotifiNoSee">0</span></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" id="listNotifi" style="z-index: 10; max-height: 320px; overflow: auto; margin-top: 10px;">
          </div>
        </div>
        <script>
          $("body").on("click","#toShowOtherNotification",function(){
            var arrayNotifi = ["-1"];
            $("div#statusItem").each(function(index) {
              arrayNotifi.push($(this).data('idnotification'));
            });
            elementAdd=$(this);
            $.ajax({
              url:"<?php echo getCurUrl(); ?>/../ajaxProcess/actionNotification.php",
              method:'POST',
              data:{userid:<?php echo $infoUser['ma'] ?>, listshowed:arrayNotifi},
              success:function(data) {
                elementAdd.before(data);
                elementAdd.remove();
              }
            })
          });
          function showListNotification(){
            if($("div#listNotifi").is(":visible")){
              //alert("showed -> hide");
              $("div#listNotifi").empty();
            } else {
              // alert("hide -> showed");

              var arrayNotifi = ["-1"];
              var elementAdd=$("div#listNotifi");
              $.ajax({
                url:"<?php echo getCurUrl(); ?>/../ajaxProcess/actionNotification.php",
                method:'POST',
                data:{userid:<?php echo $infoUser['ma'] ?>, listshowed:arrayNotifi},
                success:function(data) {
                  elementAdd.html(data);
                }
              })
            }
            $("div#listNotifi").toggle();
          }

          setInterval(function() {
            var elementAdd=$("span#countNotifiNoSee");
              $.ajax({
                url:"<?php echo getCurUrl(); ?>/../ajaxProcess/actionNotificationCountNoSee.php",
                method:'POST',
                data:{userid:<?php echo $infoUser['ma'] ?>},
                success:function(data) {
                  elementAdd.html(data);
                }
              })
          },100);
        </script>
        <?php
      }
      ?>
    </header>
  </div>
  <div style="padding-left: 0.5%; padding-right: 0.5%;">