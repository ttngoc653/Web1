<?php 
$titleWeb="1760081_1560165 - Kích hoạt thành công";
include 'header.php';
if (empty($nguoidung)) {
	$nguoidung=new nguoidung;
}
?>
<h1>Kích hoạt tài khoản</h1>
<?php if (isset($_GET['code'])) : ?>
	<?php if (!$nguoidung->checkCode($_GET['code'])): ?>
		<div class="alert alert-success" role="alert">
			Kích hoạt tài khoản thất bại. Do mã kích hoạt không hợp lệ. Vui lòng kiểm tra lại email.
			<?php elseif ($nguoidung->activeAccount($_GET['code'])): ?>
				<div class="alert alert-success" role="alert">
					Kích hoạt tài khoản thành công.
					<?php else: ?>
						<div class="alert alert-success" role="alert">
							Kích hoạt tài khoản thất bại. Do cập nhật có vấn đề khi đồng bộ dữ liệu.
						<?php endif ?>
						<?php else: ?>
							<div class="alert alert-secondary" role="alert">
								Có lỗi xảy ra.
							<?php endif ?>
						</div>
						<?php 
						include 'footer.php';
						?>