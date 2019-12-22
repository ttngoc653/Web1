<?php
include '../controller/incl.php';

if (isset($_POST['portid']) && isset($_POST['userid']) && isset($_POST['content'])) {
	$binhluan = new binhluan;
	$nguoidung = new nguoidung;
	$binhluan->create($_POST['userid'],$_POST['portid'],htmlentities($_POST['content']));
	$getListComment = $binhluan->getList($_POST['portid']);
	foreach ($getListComment as $cmt) {
		$userComment=$nguoidung->getFromId($cmt['ngbinhluanid']);
		?>
		<div class="alert" role="alert" style="border-color: #c6c8ca; color: black;">
			<img src="data:image;base64,<?php echo $userComment['avatar']; ?>" width="50px" class="rounded-circle">	<b><a href="wall.php?id=<?php echo $cmt['ngbinhluanid']; ?>"><?php echo $userComment['hoten']; ?></a></b> lúc <?php echo $cmt['thoigianthuchien']; ?><br/><?php echo $cmt['noidung']; ?></div>
		<?php }
	}
	?>