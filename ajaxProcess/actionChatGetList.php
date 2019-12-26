<?php 
if (isset($_POST['userid'])) {
	include '../controller/incl.php';
	$trochuyen=new trochuyen;
	$nguoidung=new nguoidung;
	$listChat=$trochuyen->getListChat($_POST['userid']);

	foreach ($listChat as $i) {
		$ban=$nguoidung->getFromId($i['ban']);
		?>
		<div class="chat_list" data-chatkey="<?php echo $i['thoaima']; ?>">
			<div class="chat_people" id="loadContent" data-roomid="<?php echo $i['thoaima']; ?>">
				<div class="chat_img"> <img src="<?php echo "data:image;base64,".$ban['avatar']; ?>" alt="<?php echo $ban['hoten']; ?>"> </div>
				<div class="chat_ib">
					<h5> <?php if ($i['slchuaxem']!='0') {
						echo '<span class="badge badge-danger" style="float: left; margin-right: 10px;">'.$i['slchuaxem'].'</span>';
					} ?> <?php echo $ban['hoten']; ?> <span class="chat_date"><?php echo $i['thoigiangui']; ?></span></h5>
					<p><?php echo $i['noidung']; ?></p>
				</div>
			</div>
		</div>
		<?php
	}
}
?>