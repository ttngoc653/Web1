<?php 
if (isset($_POST['keyword']) && strlen($_POST['keyword'])!=0) {
	include '../controller/incl.php';
	$nguoidung=new nguoidung;

	$listUser = $nguoidung->search($_POST['keyword']);

	foreach ($listUser as $i) {
		if(stristr($i['sdt'],$_POST['keyword']))
			echo '<option value="'.$i['hoten'].'">'.$i["sdt"].'</option>';
		else if(stristr($i['email'],$_POST['keyword']))
			echo '<option value="'.$i['hoten'].'">'.$i["email"].'</option>';
		else if(stripos($i['hoten'],$_POST['keyword'])!==false)
			echo '<option value="'.$i['hoten'].'">'.$i["hoten"].'</option>';
	}
} else {
	//var_dump($_POST);
}
?>