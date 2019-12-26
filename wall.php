<?php 

include 'header.php';

if (isset($_GET['id'])) {
	$nguoidung=new nguoidung;
	$trangthai=new trangthai;
	$banbe=new banbe;

	$user=$nguoidung->getFromId($_GET['id']);
	if ($user!=NULL && isset($infoUser) && $user['ma']==$infoUser['ma']) {
		echo ' <script> location.replace("profile.php"); </script>';
	} elseif ($user!=NULL) {
		?>
		<h2 style="text-align: center;">
			<img src="data:image;base64,<?php echo $user['avatar']; ?>" width="150px" class="rounded-circle"> Tường nhà của <?php echo $user['hoten'];
				echo '<a href="/chat.php?id='.$_GET['id'];.'">(Nhắn tin)</a>';
				$theodoi=new theodoi;
				if ($theodoi->check($infoUser['ma'],$_GET['id'])) {
					echo '<button id="actFollow" value="delete" data-partnerid="'.$_GET['id'].'" class="btn btn-secondary" style="margin-left: 10px;">Bỏ theo dõi</button>';
				}
				else {
					echo '<button id="actFollow" value="add" data-partnerid="'.$_GET['id'].'" class="btn btn-secondary" style="margin-left: 10px;">Theo dõi</button>';
				}
				include 'funcOfFollow.php'; 
			?>
		</h2>
		<?php if (isset($infoUser)): ?>
			<div style="margin: auto; text-align: center;">
				<?php
				$tinhtrang=$banbe->get($infoUser['ma'], $_GET['id']);
				if ($tinhtrang==NULL) {
					?><button id="actWall" value="add" data-partnerid="<?php echo $_GET['id']; ?>" class="btn btn-info">Kết bạn</button>
					<?php
				} elseif ($tinhtrang['tinhtrang']==0) {
					if ($tinhtrang['ban2']==$infoUser['ma']) {
						echo '<button id="actWall" value="accept" data-partnerid="'.$_GET['id'].'" class="btn btn-primary">Chấp nhập yêu cầu kết bạn</button>';
					} else {
						$showBtnDisable=true;
					}
					if (isset($showBtnDisable)): ?>
						<button class="btn btn-primary" disabled>Đã gửi yêu cầu kết bạn</button>
					<?php endif ?>
					<button id="actWall" value="delete" data-partnerid="<?php echo $_GET['id']; ?>" class="btn btn-danger">Xóa lời mời</button>
					<?php
				} elseif ($tinhtrang['tinhtrang']==1) {
					?>
					<button class="btn btn-primary" disabled>Bạn bè</button>
					<button id="actWall" value="destroy" data-partnerid="<?php echo $_GET['id']; ?>" class="btn btn-danger">Hủy kết bạn</button>
					<?php
				}
				include 'funcOfWall.php';
				?>
			</div>
		<?php endif ?>
	</div>
	<?php

	$privateToSee = 3;
	if (isset($tinhtrang) && $tinhtrang['tinhtrang']==1) {
		$privateToSee=1;
	} else {
		$privateToSee=2;
	}
	/*echo "<script>alert(".$privateToSee.");</script>";*/
	$listStatus=$trangthai->getListAccordingTo($_GET['id'], $privateToSee);
	$infoUserCode=-1;

	if (isset($infoUser)) {
		$infoUserCode=$infoUser['ma'];
	}
	echo "<div style='padding-left: 0.5%; padding-right: 0.5%;'>";
	include 'foreachStatus.php'; 
	include 'funcOfStatus.php';
	echo "</div>";
}
}

include 'footer.php';
?>

<script>
	$("body").on("click", "button#btnToShowMorePosts", function(){
		var arrayStatus= [];
		$("button#itemLike.btn").each(function(index) {
			arrayStatus.push($(this).data('statuid'));
		});	
		/*alert(arrayStatus);*/

		var elementAdd=$("div#showMoreStatus");
		$.ajax({
			url:"<?php echo getCurURL(); ?>/../ajaxProcess/actionGetStatusWall.php",
			method:"POST",
			data:{userid:<?php echo isset($_GET['id']) ? $_GET['id'] : "-1"; ?>, arrayLoaded:arrayStatus, private:<?php echo isset($privateToSee)?$privateToSee:'2'; ?>},
			success:function(data) {//alert(data);
				elementAdd.before(data);
				elementAdd.remove();
			}
		})
	});
</script>