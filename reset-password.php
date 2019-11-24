<?php 
$titleWeb="1760081 - Khôi phục mật khẩu";
include 'header.php';
if (empty($nguoidung)) {
	$nguoidung=new nguoidung;
}
?>
<h1>Cài đặt mật khẩu mới</h1>
<?php if (isset($_POST['pass'])) : ?>
	<div class="alert alert-success" role="alert">
		<?php 
		if (!$nguoidung->checkCode($_POST['code'])) {
			echo "Sai mã khôi phục mật khẩu.";
		}
		elseif ($nguoidung->updateWhenForgotPassword($_POST['code'], $_POST['pass'])) {
			echo "Mật khẩu đã thay đổi thành công";
		}
		else {
			echo "Có lỗi xảy ra khi đồng bộ dữ liệu. Vui lòng thực hiện lại.";
		}
		?>
	</div>
	<?php elseif (isset($_GET['code'])): ?>
		<form action="<?php echo getCurURL(); ?>" method="POST" id="formSubmitted" accept-charset="utf-8">
			<input type="hidden" name="code" value="<?php echo $_GET['code']; ?>">

			<div class="form-group">
				<label for="exampleInputPass1">Mật khẩu</label>
				<input type="password" class="form-control" id="exampleInputPass1" name="pass" placeholder="Điền mật khẩu vào đây" required>
			</div>
			<button type="submit" name="submitReSet" value="submit" class="btn btn-primary">Cài lại mật khẩu</button>
		</form>
		<?php else: ?>
			<div class="alert alert-secondary" role="alert">
				Không nhận được mã yêu cầu khôi phục mật khẩu. <a href="forgot-password.php">Vui lòng yêu cầu gửi email khôi phục lại lần nữa.</a>
			</div>
		<?php endif ?>
		<?php 
		include 'footer.php';
		?>