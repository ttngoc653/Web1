<?php 

include 'header.php';

if (isset($_GET['id'])) {
	$nguoidung=new nguoidung;
	$trangthai=new trangthai;
	$banbe=new banbe;

	if (isset($_POST['actWall'])) {
		switch ($_POST['actWall']) {
			case 'add':
			$banbe->addFriend($_POST['userId'], $_POST['seeingId']);
			break;
			case 'accept':
			$banbe->accept($_POST['userId'], $_POST['seeingId']);
			break;
			case 'exit':
			$banbe->delete($_POST['userId'], $_POST['seeingId']);
			break;
			default:
		# code...
			break;
		}
	}

	$user=$nguoidung->getFromId($_GET['id']);
	if ($user!=NULL && $user['ma']==$infoUser['ma']) {
		header('Location: index.php');
	} elseif ($user!=NULL) {
		?>
		<h2 style="text-align: center;">Tường nhà của <?php echo $user['hoten']; ?></h2>
		 <?php if (isset($infoUser)): ?>
			<form style="text-align: center;" action="" method="post" id="formSubmitted" accept-charset="utf-8">
				<input type="hidden" name="userId" value="<?php echo $infoUser['ma']; ?>" />
				<input type="hidden" name="seeingId" value="<?php echo $_GET['id']; ?>" />

				<?php
				$tinhtrang=$banbe->get($infoUser['ma'], $_GET['id']);
				if ($tinhtrang==NULL) {
					?><input type="hidden" name="actWall" value="add" />
					<button type="submit" name="actWall" value="add" class="btn btn-info">Kết bạn</button>
					<?php
				} elseif ($tinhtrang['tinhtrang']==0) {
					if ($tinhtrang['ban2']==$infoUser['ma']) {
						echo '<input type="hidden" name="actWall" value="accept" /><button type="submit" name="actWall" value="accept" class="btn btn-primary">Chấp nhập yêu cầu kết bạn</button>';
					} else {
						echo '<button type="submit" class="btn btn-primary" disabled>Đã gửi yêu cầu kết bạn</button>';
					}
					
					?>
			</form><form style="text-align: center;" action="" method="post" id="formSubmitted" accept-charset="utf-8">
				<input type="hidden" name="userId" value="<?php echo $infoUser['ma']; ?>" />
				<input type="hidden" name="seeingId" value="<?php echo $_GET['id']; ?>" />
			<input type="hidden" name="actWall" value="exit" />
					<button type="submit" name="actWall" value="exit"  class="btn btn-danger">Xóa lời mời</button>
					<?php
				} elseif ($tinhtrang['tinhtrang']==1) {
					?>
					<button class="btn btn-primary" disabled>Bạn bè</button>
					<input type="hidden" name="actWall" value="exit" />
					<button type="submit" name="actWall" value="exit"  class="btn btn-danger">Hủy kết bạn</button>
					<?php
				}
				?>
			</form>
		<?php endif ?>
		<?php

		$listStatus=$trangthai->getListAccordingTo($_GET['id']);

		include 'foreachStatus.php'; 
	}
}

include 'footer.php';
?>