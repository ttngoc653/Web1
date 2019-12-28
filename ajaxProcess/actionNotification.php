<?php 
if (isset($_POST['userid']) && isset($_POST['listshowed'])) {
	include '../controller/incl.php';
	$thongbao = new thongbao;

	$listNotification = $thongbao->getList($_POST['userid'], $_POST['listshowed']);

	foreach ($listNotification as $i) {
		echo '<div href="#" class="dropdown-item" id="statusItem" '.($i['daxem']=='0' ? 'style="background-color: #edf2fa;"' : "").' data-idnotification="'.$i['ma'].'">'.$i['noidung'].'</div>';
	}
	echo '<div href="#" class="dropdown-item" id="toShowOtherNotification"><center>Nhấp để hiển thị thêm</center></div>';
} else {
	//var_dump($_POST);
}
?>