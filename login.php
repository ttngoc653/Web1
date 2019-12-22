<?php include 'header.php'; ?>
  <div>
    <?php 
    if (!(empty($_SESSION['user']) && empty($_COOKIE['user']))) {
      redirectTo("Đã đăng nhập rồi.");
    } else {
      if (isset($_POST['formName']) && "login" == $_POST['formName']) {
        $nguoidung = new nguoidung;
        $login = $nguoidung->logIn($_POST['email'],$_POST['password']);
        if ($login==NULL) {
          echo '<div class="alert alert-danger" role="alert">SAI THÔNG TIN ĐĂNG NHẬP. <a href="javascript:history.go(-1)">Nhấp để thực hiện lại.</a></div>';
        }
        elseif ($login['actived']=='0') {
          echo '<div class="alert alert-info" role="alert">TÀI KHOẢN CHƯA ĐƯỢC KÍCH HOẠT. VUI LÒNG VÀO EMAIL ĐÃ ĐĂNG KÝ ĐỂ KÍCH HOẠT TÀI KHOẢN.</div>';
        }
        else {  
          $infoUser = $login;
          if (isset($_POST['remember'])) {
            setcookie('user', $login, time() + 3600*24*7);
            echo "Chào mừng ".$login['hoten']." đã trở lại trang.";
          } else {
            $_SESSION['user'] = $login;
            echo "Chào mừng ".$login['hoten']." đã trở lại trang.";
          }
          header('Location: index.php');
        }
    }
  ?>
  <div class="container">
    <h1>Đăng nhập</h1>
    <form  action="login.php" method="POST" id="formSubmitted">
      <input type="hidden" name="formName" value="login">
      <div class="form-group">
        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Nhập email">
      </div>
      <div class="form-group">
        <input type="password" name="password" class="form-control" id="password" value placeholder="Nhập Mật khẩu">
      </div>
      <div class="row">
        <div class="form-group form-check col" style="text-align: right;">
          <input type="checkbox" name="remember" class="form-check-input" id="remember">
          <label class="form-check-label" for="remember">Ghi nhớ</label>
        </div>
        <div class="col" style="text-align: left;">
          <button type="submit" class="btn btn-primary">Đăng nhập</button>
        </div>
      </div>
      <div class="form-group">
        <a href="forgot-password.php">Bạn đã quên mật khẩu?</a>
      </div>
    </form>
  </div>
  <?php 
}
?>
</div>
<?php include 'footer.php'; ?>