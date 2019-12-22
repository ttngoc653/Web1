<?php 
/**
 * lớp thông tin kết bạn
 */
class banbe extends connectDB
{
	public function getListIdFriendCurrent($idUser)
	{
		$stmt = $this->getConnect()->prepare("SELECT DISTINCT IF(ban1 = ?,ban2,ban1) AS 'ban'
			FROM banbe 
			WHERE tinhtrang = 1 
			AND (ban1=? OR ban2=?) AND (ban1!=ban2)");
		$stmt->execute(array($idUser, $idUser, $idUser));
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getListIdFriendWaiting($idUser)
	{
		$stmt = $this->getConnect()->prepare("SELECT DISTINCT ban1 AS 'ban' 
			FROM banbe 
			WHERE tinhtrang = 0 
			AND ban2=?;");
		$stmt->execute(array($idUser));
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function get($idUser, $idFriend)
	{
		$stmt = $this->getConnect()->prepare("SELECT * 
			FROM banbe 
			WHERE (ban1=? AND ban2=?) OR 
			(ban1=? AND ban2=?);");
		$stmt->execute(array($idUser, $idFriend, $idFriend, $idUser));
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			return $row;
		return NULL;
	}
	
	public function addFriend($idActive,$idPartner)
	{
		if($this->get($idActive,$idPartner)==NULL) {
			$stmt = $this->getConnect()->prepare("INSERT INTO `banbe`(`ban1`, `ban2`) VALUES (?,?)");
			$stmt->execute(array($idActive, $idPartner));
			return $this->getConnect()->lastInsertId();
		}
		return 0;
	}
	
	public function accept($idUserClicked, $idUserSend)
	{
		$stmt = $this->getConnect()->prepare("UPDATE `banbe` SET `tinhtrang`=? WHERE `ban1`=? AND `ban2`=?");
		$stmt->execute(array('1', $idUserSend, $idUserClicked));
		//$stmt->debugDumpParams();
		return $stmt->rowCount();
	}
	
	public function delete($idUserClicked, $idPartner)
	{
		$stmt = $this->getConnect()->prepare("DELETE FROM `banbe` 
			WHERE (ban1=? AND ban2=?) OR 
			(ban1=? AND ban2=?);");
		$stmt->execute(array($idPartner, $idUserClicked, $idUserClicked, $idPartner));

		return $stmt->rowCount();
	}
}
?>