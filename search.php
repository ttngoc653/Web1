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
			if($i['ma']!=$infoUser['ma']) {
				if (isset($i['avatar'])) {
					$imgSrc= "data:image;base64,".$i['avatar'];
				}else {
					$imgSrc= './image/'.$i['avatar_img'];
				}
				?>
				<div class="alert col-6" role="alert" style="border-color: #c6c8ca; color: black;  display: inline-block;">
					<img src="<?php echo $imgSrc; ?>" height="72px" class="rounded-circle">	<b style="margin-left: 15px; font-weight: 400; font-size: 30px"><a href="wall.php?id=<?php echo $i['ma']; ?>"><?php echo $i['hoten']; ?></a></b>
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
		if (count($listUser)==0 || (count($listUser)==1 && $listUser[0]['ma']==$infoUser['ma'])) {
			echo '	<div class="alert" role="alert" style="border-color: #c6c8ca; color: black;"><center><h2>Không tìm thấy bất cứ kết quả nào</h2></center></div>';
		} else {
			?>
			<script>
				function getButtonAdd(idPartner) {
					return '<button id="actWall" value="add" data-partnerid="'+idPartner+'" class="btn btn-info">Kết bạn</button>';
				}
				function getButtonAccept(idPartner) {
					return '<button id="actWall" value="accept" data-partnerid="'+idPartner+'" class="btn btn-primary">Chấp nhận yêu cầu kết bạn</button>';
				}
				function getButtonDelete(idPartner) {
					return '<button id="actWall" value="delete" data-partnerid="'+idPartner+'" class="btn btn-danger">Xóa lời mời</button>';
				}
				function getButtonDestroy(idPartner) {
					return '<button id="actWall" value="destroy" data-partnerid="'+idPartner+'" class="btn btn-danger">Hủy kết bạn</button>';
				}
				function getButtonSent() {
					return '<button class="btn btn-primary" disabled style="margin-right: 5px;">Đã gửi yêu cầu kết bạn</button>';
				}
				function getButtonFriending() {
					return '<button class="btn btn-primary" disabled style="margin-right: 5px;">Bạn bè</button>';
				}

				$("body").on("click","button#actWall",function() {
					var act=$(this).val();
					//alert(act);
					var idPartner=$(this).data('partnerid');
					//alert(idPartner);
					var elementChanged=$(this).parent();
					elementChanged.empty();
					if (act.localeCompare("add")==0) {
						elementChanged.append(getButtonSent());
						elementChanged.append(getButtonDelete(idPartner));
					} else if (act.localeCompare("accept")==0) {
						elementChanged.append(getButtonFriending());
						elementChanged.append(getButtonDestroy(idPartner));
					} else if (act.localeCompare("delete")==0 || act.localeCompare("destroy")==0) {
						elementChanged.append(getButtonAdd(idPartner));
					} 

					$.ajax({
						url:"<?php echo getCurUrl(); ?>/../ajaxProcess/actionFriend.php",
						method:"POST",
						data:{userid:<?php echo isset($infoUser)?$infoUser['ma']: "0"; ?>,partnerid:idPartner,act:act},
						success:function(data) {
							//alert(data);
						}
					})
				});
			</script>
			<?php
		}
	}
	?>
</div>
<?php
include 'footer.php';
?>