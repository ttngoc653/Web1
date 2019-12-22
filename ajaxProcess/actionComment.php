<?php
include '../controller/incl.php';

if (isset($_POST['portid']) && isset($_POST['userid']) && isset($_POST['content'])) {
	$binhluan = new binhluan;
	$nguoidung = new nguoidung;
	$binhluan->create($_POST['userid'],$_POST['portid'],str_replace("\n","<br />", htmlentities($_POST['content'])));
	
	$statuKey = $_POST['portid'];
	include '../foreachComments.php';
}
?>