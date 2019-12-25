<?php 
if (isset($_POST['userid']) && isset($_POST['partnerid']) && isset($_POST['act'])) {
	include '../controller/incl.php';
	$banbe=new banbe;
	$theodoi=new theodoi;
	switch ($_POST['act']) {
		case 'add':
			echo $banbe->AddFriend($_POST['userid'],$_POST['partnerid']);
			break;
		case 'accept':
			echo $banbe->accept($_POST['userid'],$_POST['partnerid']);
			break;
		case 'destroy':
			$theodoi->delete($_POST['partnerid'],$_POST['userid']);
		case 'delete':
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