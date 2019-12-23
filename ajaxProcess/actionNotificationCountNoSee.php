<?php 
if (isset($_POST['userid'])) {
	include '../controller/incl.php';
	$thongbao = new thongbao;

	echo $thongbao->countNoSeen($_POST['userid']);
} else {
	// var_dump($_POST);
}
?>