<?php 
/**
 * lớp liên quan tới (lượt) thích 
 */
class trochuyen extends connectDB {
	public function getListChat($userid)
	{
		$stmt = $this->getConnect()->prepare("SELECT L1.thoaima, l1.thoigiangui, l1.ndgui, l1.noidung, (SELECT COUNT(*) 
			FROM trochuyenlichsu L2 
			WHERE L2.thoaima = L1.thoaima 
			AND T1.ngayxemcuoicung < L1.thoigiangui) AS `slchuaxem`,
			(SELECT T2.ndtgma FROM trochuyenthamgia T2 WHERE T1.hoithoaima = T2.hoithoaima AND T1.ndtgma != T2.ndtgma LIMIT 1) `ban`
			FROM trochuyenthamgia T1 LEFT JOIN trochuyen H1 ON H1.ma = T1.hoithoaima
			RIGHT JOIN trochuyenlichsu L1 ON L1.thoaima = H1.ma
			WHERE T1.ndtgma = ? AND L1.an=0
			AND L1.ma IN (SELECT MAX(L3.ma) FROM trochuyenlichsu L3 GROUP BY L3.thoaima)  
			ORDER BY `L1`.`thoigiangui` DESC;");
		$stmt->execute(array($userid));	
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function checkOneOne($idUser,$idPartner)
	{
		$stmt = $this->getConnect()->prepare("SELECT t1.hoithoaima
			FROM trochuyenthamgia t1
			WHERE t1.hoithoaima IN (SELECT t2.hoithoaima FROM trochuyenthamgia t2 WHERE t2.ndtgma = ?)
			AND t1.hoithoaima IN (SELECT t2.hoithoaima FROM trochuyenthamgia t2 WHERE t2.ndtgma = ?)
			GROUP BY t1.hoithoaima
			HAVING COUNT(*) = 2;");
		$stmt->execute(array($idUser,$idPartner));	
		return $stmt->rowCount()>=1;
	}

	public function createOneOne($idUser,$idPartner)
	{
		if (!$this->checkOneOne($idUser,$idPartner)) {
			$stmt = $this->getConnect()->prepare("INSERT INTO `trochuyen`(`ndtaoid`) VALUES (?)");
			$stmt->execute(array($idUser));	
			//$stmt->debugDumpParams();
			$idHoiThoai=$this->getConnect()->lastInsertId();

			$stmt = $this->getConnect()->prepare("INSERT INTO `trochuyenthamgia`(`hoithoaima`, `ndtgma`) VALUES (?, ?);");
			$stmt->execute(array($idHoiThoai, $idUser));
			//$stmt->debugDumpParams();
			$stmt = $this->getConnect()->prepare("INSERT INTO `trochuyenthamgia`(`hoithoaima`, `ndtgma`) VALUES (?, ?);");
			$stmt->execute(array($idHoiThoai, $idPartner));	

			return $idHoiThoai;
		}

		return false;
	}

	public function getChat($idUser, $idRoom)
	{
		$stmt = $this->getConnect()->prepare("SELECT n1.ma `madn`, n1.hoten, n1.avatar, l1.thoigiangui, l1.noidung, l1.ma `matin`
			FROM trochuyenlichsu l1 INNER JOIN nguoidung n1 ON l1.ndgui = n1.ma
			WHERE l1.thoaima = ? AND l1.an = 0
			AND l1.thoaima IN (SELECT t1.hoithoaima FROM trochuyenthamgia t1 WHERE t1.ndtgma = ?);");
		$stmt->execute(array($idRoom, $idUser));

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function checkUserChat($idUser,$idChat)
	{
		$stmt = $this->getConnect()->prepare("SELECT * FROM `trochuyenlichsu` WHERE `ndgui` = ? AND `ma` = ?;");
		$stmt->execute(array($idUser, $idChat));	
		return $stmt->rowCount()==1;
	}

	public function hiddenChat($idUser,$idPartner)
	{
		if (!$this->checkUserChat($idUser,$idPartner)) {
			$stmt = $this->getConnect()->prepare("UPDATE `trochuyenlichsu` SET `an`= 1 WHERE `ndgui` = ? AND `ma` = ?;");
			$stmt->execute(array($idUser, $idPartner));
			return $stmt->rowCount()==1;
		}
		return false;
	}

	public function checkUserInRoom($idRoom, $idUser)
	{
		$stmt = $this->getConnect()->prepare("SELECT * FROM `trochuyenthamgia` WHERE `hoithoaima`= ? AND `ndtgma`= ?;");
		$stmt->execute(array($idRoom, $idUser));	
		return $stmt->rowCount()==1;
	}

	public function addChat($idRoom, $idUser, $content)
	{
		if ($this->getUserInRoom($idRoom,$idUser)) {
			$stmt = $this->getConnect()->prepare("INSERT INTO `trochuyenlichsu`(`ndgui`, `thoaima`, `noidung`) VALUES (?,?,?);");
			$stmt->execute(array($idUser,$idRoom,$content));	
			//$stmt->debugDumpParams();
			return $this->getConnect()->lastInsertId();
		}
		return false;
	}

	public function getListWaiting($idUser='')
	{
		$listChat = $this->getListChat($idUser);
		$numWaiting=0;

		foreach ($listChat as $i) {
			if ($i['slchuaxem']!=0) {
				$numWaiting++;
			}
		}

		return $numWaiting;
	}

	public function getChatNoSee($idUser, $idRoom)
	{
		$stmt = $this->getConnect()->prepare("SELECT * FROM trochuyenthamgia t1
			INNER JOIN trochuyenlichsu l1 ON t1.hoithoaima= l1.thoaima AND l1.ndgui != t1.ndtgma
			WHERE t1.ngayxemcuoicung<=l1.thoigiangui
			AND t1.hoithoaima = ? AND l1.an=0 AND t1.an = 0
			AND t1.ndtgma = ?;");
		$stmt->execute(array($idRoom, $idUser));	
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}


}

?>