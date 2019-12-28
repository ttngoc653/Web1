<?php include 'header.php'; ?>
<div class="container">
	<?php if (isset($infoUser)): ?>
		<h2>Danh sách bạn bè</h2>
		<?php 

		$banbe=new banbe;
		$nguoidung=new nguoidung;
		$listCurrent = $banbe->getListIdFriendCurrent($infoUser['ma']);
		?>
		<div class="list-group list-group-flush row">
			<?php
			foreach ($listCurrent as $i) {
				$ban=$nguoidung->getFromId($i['ban']);
				if (isset($ban['avatar'])) {
					$imgSrc= "data:image;base64,".$ban['avatar'];
				}else {
					$imgSrc= './image/'.$ban['avatar_img'];
				}
				?>
				<div class="list-group-item col-6"><div>
					<a href="wall.php?id=<?php echo $i['ban']; ?>"style="font-size: 18px;"><img src="<?php echo $imgSrc; ?>" height="36px" class="rounded-circle" style="margin-right: 15px;"><?php echo $ban['hoten']; ?></a> 
					<a href="./chat.php?id=<?php echo $i['ban']; ?>">(Nhắn tin)</a>
					<?php
					$theodoi=new theodoi;
					if ($theodoi->check($infoUser['ma'],$i['ban'])) {
						echo '<button id="actFollow" value="delete" data-partnerid="'.$i["ban"].'" class="btn btn-secondary" style="margin-left: 10px;">Bỏ theo dõi</button>';
					}
					else {
						echo '<button id="actFollow" value="add" data-partnerid="'.$i["ban"].'" class="btn btn-secondary" style="margin-left: 10px;">Theo dõi</button>';
					}
					?>
					<button class="btn btn-danger" id="actWall" value="destroy" data-partnerid="<?php echo $i['ban']; ?>" style="float: right;">Xóa bạn</button>
				</div></div>
			<?php } ?>
		</div>

		<br />
		<h2>Đang chờ trả lời</h2>
		<div class="list-group list-group-flush row">
			<?php
			$listWaiting = $banbe->getListIdFriendWaiting($infoUser['ma']);
			foreach ($listWaiting as $i) {
				$ban=$nguoidung->getFromId($i['ban']);
				if (isset($ban['avatar'])) {
					$imgSrc= "data:image;base64,".$ban['avatar'];
				}else {
					$imgSrc= './image/'.$ban['avatar_img'];
				}
				?>
				<div class="list-group-item col-6"><div>
					<a href="wall.php?id=<?php echo $i['ban']; ?>"style="font-size: 18px;"><img src="<?php echo $imgSrc; ?>" height="36px" class="rounded-circle" style="margin-right: 15px;"><?php echo $ban['hoten']; ?></a> <a href="./chat.php?id=<?php echo $i['ban']; ?>">(Nhắn tin)</a>
					<?php
					$theodoi=new theodoi;
					if ($theodoi->check($infoUser['ma'],$i['ban'])) {
						echo '<button id="actFollow" value="delete" data-partnerid="'.$i["ban"].'" class="btn btn-secondary" style="margin-left: 10px;">Bỏ theo dõi</button>';
					}
					else {
						echo '<button id="actFollow" value="add" data-partnerid="'.$i["ban"].'" class="btn btn-secondary" style="margin-left: 10px;">Theo dõi</button>';
					}
					?>
					<button class="btn btn-danger" id="actWall" value="delete" data-partnerid="<?php echo $i['ban']; ?>" style="float: right;">Xóa lời mời</button>
					<button class="btn btn-primary" id="actWall" value="accept" data-partnerid="<?php echo $i['ban']; ?>" style="float: right; margin-right: 5px;">Chấp nhận</button>
				</div></div>
			<?php } ?>
		</div>
		<?php 
		include 'funcOfFollow.php';
		?>
		<script>
			$("body").on("click","button#actWall",function() {
				var act=$(this).val();
					//alert(act);
					var idPartner=$(this).data('partnerid');
					//alert(idPartner);
					var elementChanged=$(this).parent();
					var elementFollow = elementChanged.find('button#actFollow');

					$.ajax({
						url:"<?php echo getCurUrl(); ?>/../ajaxProcess/actionFriend.php",
						method:"POST",
						data:{userid:<?php echo isset($infoUser)?$infoUser['ma']: "0"; ?>,partnerid:idPartner,act:act},
						success:function(data) {
							if (act.localeCompare("accept")==0) {
								elementFollow.val("add");
								actionProcessFollow(elementFollow);
							} else if (act.localeCompare("destroy")==0) {
								elementFollow.val("delete");
								actionProcessFollow(elementFollow);
							} 
							elementChanged.parent().remove();
						}
					})
				});
			</script>
			<?php else: ?>
				<?php redirectTo("Đăng nhập để sử dụng tính năng này."); ?>
			<?php endif ?>
		</div>
		<?php include 'footer.php'; ?>