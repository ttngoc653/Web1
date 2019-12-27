<?php 
include 'header.php';
?>
<h3>Kết quả tìm kiếm:</h3>
<div>
	<?php 
	if (isset($_GET['q'])) {
		$nguoidung=new nguoidung;
		$banbe=new banbe;

		$listUser=$nguoidung->search($_GET['q']);

		echo '<div class="container row" style="margin: auto;">';
		foreach ($listUser as $i) {
			if(!isset($infoUser) || $i['ma']!=$infoUser['ma']) {
				if (isset($i['avatar'])) {
					$imgSrc= "data:image;base64,".$i['avatar'];
				}else {
					$imgSrc= './image/'.$i['avatar_img'];
				}
				?>
				<div class="alert col-6" role="alert" style="border-color: #c6c8ca; color: black;  display: inline-block;">
					<img src="<?php echo $imgSrc; ?>" height="72px" class="rounded-circle">	<b style="margin-left: 15px; font-weight: 400; font-size: 30px"><a href="wall.php?id=<?php echo $i['ma']; ?>"><?php echo $i['hoten']; ?></a></b> <a href="./chat.php?id=<?php echo $i['ma']; ?>">(Nhắn tin)</a>
					<?php if (isset($infoUser)): ?>
						<div style="float: right;">
							<?php
							$tinhtrang=$banbe->get($infoUser['ma'], $i['ma']);
							if ($tinhtrang==NULL) {
								?><button id="actWall" value="add" data-partnerid="<?php echo $i['ma']; ?>" class="btn btn-info">Kết bạn</button>
								<?php
							} elseif ($tinhtrang['tinhtrang']==0) {
								if ($tinhtrang['ban2']==$infoUser['ma']) {
									echo '<button id="actWall" value="accept" data-partnerid="'.$i["ma"].'" class="btn btn-primary">Chấp nhập yêu cầu kết bạn</button>';
								} else {
									$showBtnDisable=true;
								}
								if (isset($showBtnDisable)): ?>
									<button class="btn btn-primary" disabled>Đã gửi yêu cầu kết bạn</button>
								<?php endif ?>
								<button id="actWall" value="delete" data-partnerid="<?php echo $i['ma']; ?>" class="btn btn-danger">Xóa lời mời</button>
								<?php
							} elseif ($tinhtrang['tinhtrang']==1) {
								?>
								<button class="btn btn-primary" disabled>Bạn bè</button>
								<button id="actWall" value="destroy" data-partnerid="<?php echo $i['ma']; ?>" class="btn btn-danger">Hủy kết bạn</button>
								<?php
							}
							?>
						</div>
					<?php endif ?>
				</div>
				<?php
			}
		}
		echo '</div>';
		if (count($listUser)==0 || (count($listUser)==1 && (isset($infoUser) && $listUser[0]['ma']==$infoUser['ma']))) {
			echo '	<div class="alert" role="alert" style="border-color: #c6c8ca; color: black;"><center><h2>Không tìm thấy bất cứ kết quả nào</h2></center></div>';
		} else {
			include 'funcOfFollow.php';
			include 'funcOfWall.php';
		}
	}
	?>
</div>
<?php
include 'footer.php';
?>