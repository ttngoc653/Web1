<?php 
include '../controller/incl.php';


if (isset($_POST['idUser']) && isset($_POST['idStatu'])) {
	$thich = new thich;
	if (isset($_POST['idComment'])) {
		$commentId=$_POST['idComment'];
	} else {
		$commentId = null;
	}
	$thich->create($_POST['idUser'],$_POST['idStatu'], $commentId);

	echo true;
}
 ?>