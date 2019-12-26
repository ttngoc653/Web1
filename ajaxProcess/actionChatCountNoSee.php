<?php 
if (isset($_POST['userid'])) {
	include '../controller/incl.php';
	$trochuyen=new trochuyen;
	echo $trochuyen->getListWaiting($_POST['userid']);
}
?>