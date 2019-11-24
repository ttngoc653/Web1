<?php include 'header.php'; ?>
<div class="container">
  <?php 
  if (!(empty($_SESSION['user']) && empty($_COOKIE['user']))) {
    header('Location: index.php');
  } else {
    ?>
    <h1>Đăng ký tài khoản</h1>
    <form action="index.php" method="POST" enctype="multipart/form-data" id="formSubmitted">
      <input type="hidden" name="formName" value="register">
      <div class="form-group">
        <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
      </div>
      <div class="form-group">
        <input type="text" name="showname" class="form-control" placeholder="Nhập tên hiển thị" required>
      </div>
      <div class="form-group">
        <input type="phone" name="phone" class="form-control" placeholder="Nhập số điện thoại" required>
      </div>
      <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
      </div>
      <div class="custom-file">
        <input type="file" accept="image/*" name="avatar" class="custom-file-input" id="avatarFile" required>
        <label class="custom-file-label" for="avatarFile">Chọn hình đại diện</label>
      </div>
      <center>
        <button type="submit" class="btn btn-primary mt-3">Đăng ký</button>
      </center>
    </form>
    <?php 
  }
  ?>
</div>
<?php include 'footer.php'; ?>