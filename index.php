<?php include 'header.php'; ?>
<?php if (isset($_POST['formName'])): ?>
	<div class="alert alert-info text-center" role="alert">
		<?php
		$nguoidung = new nguoidung;
		if ("changepass" == $_POST['formName']) {
			if ($nguoidung->logIn($infoUser['sdt'],$_POST['passwordOld']) == NULL) {
				echo	 'SAI MẬT KHẨU CŨ. <a href="javascript:history.go(-1)">Nhấp để nhập lại.</a>';
			} elseif($_POST['passwordNew'] != $_POST['confirmPasswordNew']){
				echo 'MẬT KHẨU MỚI KHÔNG GIỐNG NHAU. <a href="javascript:history.go(-1)">Nhấp để nhập lại.</a>';
			} else {
				if (isset($_SESSION['user'])) {
					$_SESSION['user']['matkhau'] = $_POST['passwordNew'];
					$nguoidung->changePass($infoUser['email'],$_POST['passwordOld'],$_POST['passwordNew']);
					echo 'ĐỔI MẬT KHẨU THÀNH CÔNG.';
				} elseif (isset($_COOKIE['user'])) {
					$info = $_COOKIE['user'];
					$info['matkhau'] = $_POST['passwordNew'];
					$nguoidung->changePass($infoUser['email'],$_POST['passwordOld'],$_POST['passwordNew']);
					setcookie('user', $info, time() + 3600*24*3);
					echo 'ĐỔI MẬT KHẨU THÀNH CÔNG.';
				} else {
					echo 'ĐỔI MẬT KHẨU THẤT BẠI. <a href="javascript:history.go(-1)">Nhấp để thực hiện lại.</a>';
				}
			}

		} elseif (isset($_POST['formName']) && "postStatus" == $_POST['formName']) {
			$trangthai=new trangthai;
			$countfiles = count($_FILES['attach']['name']);
			$images=array();
			for ($i=0; $i < $countfiles; $i++) {
				if ($_FILES['attach']['error'][$i] == 0) {
					$image=addslashes($_FILES['attach']['tmp_name'][$i]);
					$name=addslashes($_FILES['attach']['name'][$i]);
					$image=file_get_contents($image);
					$image=base64_encode($image);
					array_push($images, $image);
				}
			}

			if (isset($infoUser) && $trangthai->create($infoUser['ma'], $_POST['contentStatus'], $_POST['privatePort'], $images ) != NULL) {
				echo 'ĐÃ ĐĂNG TRẠNG THÁI THÀNH CÔNG.';
			} else {
				echo 'XẢY RA VẤN ĐỀ KHI ĐĂNG TRẠNG THÁI.';
			}
		}
		?>
	</div>
<?php endif ?>
<?php 
if (isset($infoUser)) {
	include 'post.php';
	include 'statusInIndex.php';
}
else {
	header('Location: login.php');
}
include 'footer.php'; 
?>