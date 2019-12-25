<?php 
/**
 * lớp theo dõi
 */
class theodoi extends connectDB
{
	
	public function has($idUser, $idFollow)
	{
		$stmt = $this->getConnect()->prepare("SELECT `nddangid`, `ndbiid` FROM `theodoi` WHERE `nddangid` = ? AND `ndbiid` = ?;");
		$stmt->execute(array($idUser, $idFollow));
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			return TRUE;
		return FALSE;
	}
	
	public function add($idUser,$idFollow)
	{
		if(!$this->get($idActive,$idFollow)) {
			$stmt = $this->getConnect()->prepare("INSERT INTO `theodoi`(`nddangid`, `ndbiid`) VALUES (?, ?);");
			$stmt->execute(array($idUser, $idFollow));
			return $this->getConnect()->lastInsertId();
		}
		return 0;
	}
	
	public function delete($idUserClicked, $idFollow)
	{
		$stmt = $this->getConnect()->prepare("DELETE FROM `theodoi` WHERE `nddangid` = ? AND `ndbiid` = ?;");
		$stmt->execute(array($idUserClicked, $idFollow));

		return $stmt->rowCount();
	}
}
?>