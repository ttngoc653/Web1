<?php 
if (isset($_POST['notificationid'])) {
	include '../controller/incl.php';
	$thongbao = new thongbao;

	$listNotification = $thongbao->convertSeen($_POST['notificationid']);
} else {
	//var_dump($_POST);
}
?>