<?php 
if (isset($_POST['userid']) && isset($_POST['partnerid']) && isset($_POST['act'])) {
	include '../controller/incl.php';
	$banbe=new banbe;
	$theodoi=new theodoi;
	$nguoidung=new nguoidung;
	$thongbao=new thongbao;
	switch ($_POST['act']) {
		case 'add':
			$thongbao->create($_POST['partnerid'],'<a href="./wall.php?id='.$_POST['userid'].'">'.$nguoidung->getFromId($_POST['userid'])['hoten'].'</a> đã gửi mời kết bạn.');
			echo $banbe->AddFriend($_POST['userid'],$_POST['partnerid']);
			break;
		case 'accept':
			$thongbao->create($_POST['partnerid'],'<a href="./wall.php?id='.$_POST['userid'].'">'.$nguoidung->getFromId($_POST['userid'])['hoten'].'</a> đã chấp nhận lời mời kết bạn.');
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