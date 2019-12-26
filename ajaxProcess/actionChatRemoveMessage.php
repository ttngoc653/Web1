<?php 
if (isset($_POST['userid']) && isset($_POST['messageid'])) {
	include '../controller/incl.php';
	$trochuyen=new trochuyen;
	$listChat=$trochuyen->hiddenMessage($_POST['userid'],$_POST['messageid']);

}
?>