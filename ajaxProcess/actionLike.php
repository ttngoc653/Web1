<?php 
include '../controller/incl.php';


if (isset($_POST['idUser']) && isset($_POST['idStatu'])) {
	$thich = new thich;
	if (isset($_POST['idComment'])) {
		$commentId=$_POST['idComment'];
	} else {
		$commentId = null;
	}
	if (!$thich->check($_POST['idUser'],$_POST['idStatu'], $commentId)) {
		$thich->create($_POST['idUser'],$_POST['idStatu'], $commentId);

		$trangthai = new trangthai;
		$nameWrite = $trangthai->getNameWritedStatus($_POST['idStatu']);
		if($nameWrite['ma'] != $_POST['idUser']) {
			$thongbao = new thongbao;

			$nguoidung = new nguoidung;
			$nameAct = $nguoidung->getFromId($_POST['idUser']);
			$contentT = $nameWrite['noidung'];

			if (strlen($contentT)>20) {
				$contentT = substr($contentT,  0, 17)."...";
			}

			$thongbao->create($nameWrite['ma'],$nameAct['hoten']. " đã quan tâm bài viết ".$contentT." của bạn");
		}
	}

	echo $thich->countLiked($_POST['idStatu'], $commentId);;
}
?>