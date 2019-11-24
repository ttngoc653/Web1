<?php include 'header.php' ?>
<div>
	<?php 
	if ((empty($_SESSION['user']) && empty($_COOKIE['user']))) {
		echo "<script>alert('Chưa đăng nhập. Nhấp để về trang chủ.');</script>";
    	echo "<script>
window.location.href='index.php';</script>";
	} else {
		?>
<div class="container">
	<form  action="index.php" method="POST" id="changepass">
      <input type="hidden" name="formName" value="changepass">
      <div class="form-group">
        <label for="passwordOld">Nhập khẩu cũ</label>
        <input type="password" name="passwordOld" class="form-control" id="passwordOld" aria-describedby="emailHelp" placeholder="Điền mật khẩu cũ vào đây">
      </div>
      <div class="form-group">
        <label for="passwordNew">Mật khẩu mới</label>
        <input type="password" name="passwordNew" class="form-control" id="passwordNew" value placeholder="Điền mật khẩu mới vào đây">
      </div>
      <div class="form-group">
        <label for="confirmPasswordNew">Mật khẩu mới (nhập lại)</label>
        <input type="password" name="confirmPasswordNew" class="form-control" id="confirmPasswordNew" value placeholder="Điền mật khẩu mới vào đây lần nữa">
      </div>
      <div class="row">
        <div class="col">
          <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
        </div>
      </div>
    </form>
</div>
	<?php } ?>
</div>
<?php include 'footer.php' ?>