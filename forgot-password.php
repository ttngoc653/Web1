<?php 
$titleWeb="1760081- Forgot Password";
include 'header.php';
if (isset($infoUser)) {
	header('Location: index.php');
}
elseif (empty($nguoidung)) {
	$nguoidung=new nguoidung;
}
?>
<h1>Quên mật khẩu</h1>
<?php if (isset($_POST['email'])): ?>
	<div class="alert alert-success" role="alert">
		<?php if (!$nguoidung->sameMail($_POST['email'])) {
			echo "Mail chưa đăng ký với hệ thống.";
		} else {
			$keyCode=bin2hex(random_bytes(32));

			$nguoidung->setCode($_POST['email'], $keyCode);
			echo relatedemail::sendResetPass($_POST['email'],$keyCode);
		}
		?>
	</div>
	<?php else: ?>
		<form action="" method="post" accept-charset="utf-8" id="formSubmitted">
			<div class="form-group">
				<label for="exampleInputEmail1">Địa chỉ email</label>
				<input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Điền email vào đây" required>
			</div>
			<button type="submit" name="submitForgot" value="submit" class="btn btn-primary">Quên mật khẩu</button>
		</form>
	<?php endif ?>
	<?php 
	include 'footer.php';
	?>