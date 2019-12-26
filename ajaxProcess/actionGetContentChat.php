<?php 
if (isset($_POST['userid']) && isset($_POST['roomid'])) {
	include '../controller/incl.php';
	$trochuyen=new trochuyen;

	$listChat=$trochuyen->getChat($_POST['userid'],$_POST['roomid']);

	foreach ($listChat as $i) {
		if ($i['madn']==$_POST['userid']) {
			?>
			<div class="outgoing_msg">
				<div class="sent_msg">
					<p>
						<button alt="Nhấp để xóa" type="button" class="close" aria-label="Close" id='delChat' data-idchat="<?php echo $i['matin']; ?>" style="float: left;margin-right: 2px;">
							<span aria-hidden="true">&times;</span>
							</button><?php echo $i['noidung']; ?>
						</p>
						<span class="time_date"><?php echo $i['thoigiangui']; ?></span> 
					</div>
				</div>
			<?php		}	else {	?>
				<div class="incoming_msg">
					<div class="incoming_msg_img"> <img src="data:image;base64,<?php echo $i['avatar']; ?>" alt="<?php echo $i['hoten']; ?>"> 
					</div>
					<div class="received_msg">
						<div class="received_withd_msg">
							<p><?php echo $i['noidung']; ?></p>
							<span class="time_date"><?php echo $i['thoigiangui']; ?></span>
						</div>
					</div>
				</div>
				<?php
			}
		}
	}
	else {
	//var_dump($_POST);
	}
	?>