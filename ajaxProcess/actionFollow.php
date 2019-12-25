<?php 
if (isset($_POST['userid']) && isset($_POST['partnerid']) && isset($_POST['act'])) {
	include '../controller/incl.php';
	$theodoi=new theodoi;
	switch ($_POST['act']) {
		case 'add':
		echo $theodoi->add($_POST['userid'],$_POST['partnerid']);
		break;
		case 'delete':
		echo $theodoi->delete($_POST['userid'],$_POST['partnerid']);
		break;
		default:
			echo "-1";
		break;
	}
} else {
	var_dump($_POST);
}
?>