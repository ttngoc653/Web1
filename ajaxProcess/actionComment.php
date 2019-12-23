<?php
include '../controller/incl.php';

if (isset($_POST['portid']) && isset($_POST['userid']) && isset($_POST['content'])) {
	$binhluan = new binhluan;
	$nguoidung = new nguoidung;
	$binhluan->create($_POST['userid'],$_POST['portid'],str_replace("\n","<br />", htmlentities($_POST['content'])));
	
	$trangthai = new trangthai;
		$nameWrite = $trangthai->getNameWritedStatus($_POST['portid']);
		if($nameWrite['ma'] != $_POST['userid']) {
			$thongbao = new thongbao;

			$nguoidung = new nguoidung;
			$nameAct = $nguoidung->getFromId($_POST['userid']);
			$contentT = $nameWrite['noidung'];

			if (strlen($contentT)>20) {
				$contentT = substr($contentT,  0, 17)."...";
			}

			$thongbao->create($nameWrite['ma'],$nameAct['hoten']. " đã bình luận bài viết ".$contentT." của bạn");
		}

	$statuKey = $_POST['portid'];
	include '../foreachComments.php';
}
?>