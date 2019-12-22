<?php 
if (isset($_POST['userid']) && isset($_POST['arrayLoaded'])) {
	include '../controller/incl.php';
	//$data = json_decode(stripslashes($_POST['arrayLoaded']));

	$trangthai = new trangthai;
	//$data = explode(",", $_POST['arrayLoaded']);

	$listStatus = $trangthai->getListRelateHasArray($_POST['userid'], $_POST['arrayLoaded']);
	$infoUserCode=$_POST['userid'];
	include '../foreachStatus.php';
}
else {
	var_dump($_POST);
}
 ?>