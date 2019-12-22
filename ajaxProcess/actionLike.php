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
	}

	echo $thich->countLiked($_POST['idStatu'], $commentId);;
}
?>