<?php 
if (isset($_POST['userid']) && isset($_POST['roomid']) && isset($_POST['content'])) {
	include '../controller/incl.php';
	$trochuyen=new trochuyen;
	$nguoidung=new nguoidung;
	$trochuyen->addChat($_POST['roomid'],$_POST['userid'],$_POST['content']);
}
?>