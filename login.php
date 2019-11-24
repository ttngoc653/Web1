<?php include 'header.php'; ?>
  <div>
    <?php 
    if (!(empty($_SESSION['user']) && empty($_COOKIE['user']))) {
    header('Location: index.php');
  } else {
  ?>
  <div class="container">
    <h1>Đăng nhập</h1>
    <form  action="index.php" method="POST" id="formSubmitted">
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