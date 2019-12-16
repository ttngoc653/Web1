<?php include 'header.php'; ?>
<?php if (isset($_POST['formName'])): ?>
	<div class="alert alert-info text-center" role="alert">
		<?php
		$nguoidung = new nguoidung;
		if ("changepass" == $_POST['formName']) {
			if ($nguoidung->logIn($infoUser['sdt'],$_POST['passwordOld']) == NULL) {
				echo 'SAI MẬT KHẨU CŨ. <a href="javascript:history.go(-1)">Nhấp để nhập lại.</a>';
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

		} elseif ("login" == $_POST['formName']) {
			$login = $nguoidung->logIn($_POST['email'],$_POST['password']);
			if ($login==NULL) {
				echo 'SAI THÔNG TIN ĐĂNG NHẬP. <a href="javascript:history.go(-1)">Nhấp để thực hiện lại.</a>';
			}
			elseif ($login['actived']=='0') {
				echo "TÀI KHOẢN CHƯA ĐƯỢC KÍCH HOẠT. VUI LÒNG VÀO EMAIL ĐÃ ĐĂNG KÝ ĐỂ KÍCH HOẠT TÀI KHOẢN.";
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
		} elseif ("register" == $_POST['formName']) {
			if (empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['showname']) || $_FILES['avatar']['error'] != 0) {
				echo 'THIẾU THÔNG TIN ĐỂ ĐĂNG KÝ. <a href="javascript:history.go(-1)">Nhấp để thực hiện lại.</a>';
			} else {
				$image=addslashes($_FILES['avatar']['tmp_name']);
				$name=addslashes($_FILES['avatar']['name']);
				$image=file_get_contents($image);
				$image=base64_encode($image);

				$keyCode=bin2hex(random_bytes(16));

				if ($nguoidung->sameMail($_POST['email']) || $nguoidung->samePhone($_POST['phone'])) {
					echo 'EMAIL HOẶC SỐ ĐIỆN THOẠI ĐÃ CÓ NGƯỜI ĐĂNG KÝ. <a href="javascript:history.go(-1)">Nhấp vào đây để đăng ký với thông tin khác.</a>';
				} elseif ($nguoidung->addUser($_POST['email'], $_POST['phone'], $_POST['password'], $_POST['showname'], $image, $keyCode) > 0) {
					$banbe=new banbe;
					$info=$nguoidung->getFromKey($_POST['email']);
					$banbe->addFriend($info['ma'], $info['ma']);
					$banbe->accept($info['ma'], $info['ma']);
					$nguoidung->setCode($_POST['email'], $keyCode);
					echo 'ĐÃ ĐĂNG KÝ THÀNH CÔNG. '.relatedemail::sendActiveAccount($_POST['email'], $keyCode).' Vui lòng kiểm tra email để kích hoạt tài khoản.';
				} else {
					echo 'ĐĂNG KÝ THẤT BẠI. <a href="register.php">Nhấp vào đây để đăng ký lại.</a>';
				}

			}

		} elseif (isset($_POST['formName']) && "postStatus" == $_POST['formName']) {
			$trangthai=new trangthai;
			if ($_FILES['attach']['error'] == 0) {
				$image=addslashes($_FILES['attach']['tmp_name']);
				$name=addslashes($_FILES['attach']['name']);
				$image=file_get_contents($image);
				$image=base64_encode($image);
			}

			if (isset($infoUser) && $trangthai->create($infoUser['ma'], $_POST['contentStatus'], (isset($image) ? $image : NULL)) != NULL) {
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
	include 'statusInIndex.php';
}
include 'footer.php'; 
?>