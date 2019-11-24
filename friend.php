<?php include 'header.php'; ?>
<div class="container">
<?php if (isset($infoUser)): ?>
	<h2>Danh sách bạn bè</h2>
	<?php 
	
	$banbe=new banbe;
	$nguoidung=new nguoidung;
	$listCurrent = $banbe->getListIdFriendCurrent($infoUser['ma']);
	?>
	<div class="list-group list-group-flush">
		<?php
		foreach ($listCurrent as $i) {
			$ban=$nguoidung->getFromId($i['ban']);
			?>
			<a href="wall.php?id=<?php echo $i['ban']; ?>" class="list-group-item"><?php echo $ban['hoten']; ?></a>
		<?php } ?>
	</div>
	
	<br />
	<h2>Đang chờ trả lời</h2>
	<div class="list-group list-group-flush">
		<?php
		$listWaiting = $banbe->getListIdFriendWaiting($infoUser['ma']);
		foreach ($listWaiting as $i) {
			$ban=$nguoidung->getFromId($i['ban']);
			?>
			<a href="wall.php?id=<?php echo $i['ban']; ?>" class="list-group-item"><?php echo $ban['hoten']; ?></a>
		<?php } ?>
	</div>
<?php endif ?>
</div>
<?php include 'footer.php'; ?>