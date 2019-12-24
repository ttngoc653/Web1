<?php 
if (isset($_POST['userid']) && isset($_POST['partnerid']) && isset($_POST['act'])) {
	include '../controller/incl.php';
	$banbe=new banbe;
	switch ($_POST['act']) {
		case 'add':
		echo $banbe->AddFriend($_POST['userid'],$_POST['partnerid']);
		break;
		case 'accept':
		echo $banbe->accept($_POST['userid'],$_POST['partnerid']);
		break;
		case 'delete':
		case 'destroy':
		case 'exit':
		echo $banbe->delete($_POST['userid'],$_POST['partnerid']);
		break;
		default:
			# code...
		break;
	}
} else {
	var_dump($_POST);
}
?>