<?php 
if (isset($infoUser)) {
	$trangthai = new trangthai;
	$listStatus = $trangthai->getListRelate($infoUser['ma']);

	include 'foreachStatus.php';
}
?>