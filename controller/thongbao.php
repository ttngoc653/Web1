<?php 
/**
 * lớp liên quan tới (lượt) thích 
 */
class thongbao extends connectDB {
	public function create($idUserReceive,$content, $link = NULL)
	{
		$stmt = $this->getConnect()->prepare("INSERT INTO `thongbao`(`noidung`, `link`, `ndnhanid`) VALUES (?,?,?);");
		$stmt->execute(array($content, $link, $idUserReceive));

		return $this->getConnect()->lastInsertId();
	}
	
	public function countNoSeen($idUser)
	{
		$stmt = $this->getConnect()->prepare("SELECT * FROM `thongbao` WHERE `ndnhanid` = ? AND `daxem` = 0;");
		$stmt->execute(array($idUser));	
		return $stmt->fetchColumn(); // if it is 0, result will not display
	}
	
	public function convertSeen($idlog)
	{
		$stmt = $this->getConnect()->prepare("UPDATE `thongbao` SET `daxem`=1 WHERE `ma`= ?;");
		$stmt->execute(array($idLog));	
		return $stmt->rowCount();	
	}
}

?>