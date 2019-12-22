<?php 
if (isset($statuKey)) {
	//include 'controller/incl.php';
	$binhluan = new binhluan;
	$nguoidung=new nguoidung;
	$getListComment = $binhluan->getList($statuKey);
	foreach ($getListComment as $cmt) {
		$userComment=$nguoidung->getFromId($cmt['ngbinhluanid']);
		?>
		<div class="alert" role="alert" style="border-color: #c6c8ca; color: black;">
			<img src="data:image;base64,<?php echo $userComment['avatar']; ?>" width="50px" class="rounded-circle">	<b><a href="wall.php?id=<?php echo $cmt['ngbinhluanid']; ?>"><?php echo $userComment['hoten']; ?></a></b> lúc <?php echo $cmt['thoigianthuchien']; ?><br/><?php echo str_replace('\n',"<br/>",$cmt['noidung']); ?>
		</div>
		<?php 
	}
}
?>