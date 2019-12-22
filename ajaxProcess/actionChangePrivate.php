<?php 
if (isset($_POST['statuid']) && isset($_POST['userid']) && isset($_POST['valueprivate'])) {
	include '../controller/incl.php';

	$trangthai=new trangthai;
	
	echo $trangthai->changePrivate($_POST['statuid'],$_POST['userid'],$_POST['valueprivate']);
}
 ?>