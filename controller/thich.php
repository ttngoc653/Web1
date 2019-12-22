<?php 
/**
 * lớp liên quan tới (lượt) thích 
 */
class thich extends connectDB {
	public function create($idUser,$idStatu, $idComment = NULL)
	{
		$stmt = $this->getConnect()->prepare("INSERT INTO `luotthich`(`mand`, `matt`, `macmt`) VALUES (?,?,?);");
		$stmt->execute(array($idUser, $idStatu,$idComment));

		$idTrangThai=$this->getConnect()->lastInsertId();

		return $idTrangThai;
	}
	
	public function check($idUser,$idStatu,$idComment = NULL)
	{
		if ($idComment == NULL) {
			$stmt = $this->getConnect()->prepare("SELECT * FROM `luotthich` WHERE `mand` = ? AND `matt` =  ? AND `macmt` IS NULL;");
			$stmt->execute(array($idUser, $idStatu));
		} 
		else {
			$stmt = $this->getConnect()->prepare("SELECT * FROM `luotthich` WHERE `mand` = ? AND `matt` =  ? AND `macmt` = ?;");
			$stmt->execute(array($idUser, $idStatu,$idComment));	
		}
		//$stmt->debugDumpParams();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			return TRUE;
		return FALSE;
	}	

	public function countLiked($idStatu,$idComment = NULL)
	{
		if ($idComment == NULL) {
			$stmt = $this->getConnect()->prepare("SELECT * FROM `luotthich` WHERE `matt` =  ? AND `macmt` IS NULL;;");
			$stmt->execute(array($idStatu));
		} 
		else {
			$stmt = $this->getConnect()->prepare("SELECT * FROM `luotthich` WHERE `matt` =  ? AND `macmt` = ?;");
			$stmt->execute(array($idStatu,$idComment));	
		}
		return $stmt->rowCount();
	}	

	public function delete($idUser,$idStatu,$idComment = NULL)
	{
		if ($idComment == NULL) {
			$stmt = $this->getConnect()->prepare("DELETE FROM `luotthich` WHERE `mand` = ? AND `matt` =  ? AND `macmt` IS NULL;");
			$stmt->execute(array($idUser, $idStatu));
		} 
		else {
			$stmt = $this->getConnect()->prepare("DELETE FROM `luotthich` WHERE `mand` = ? AND `matt` =  ? AND `macmt` = ?;");
			$stmt->execute(array($idUser, $idStatu,$idComment));	
		}
		
		return $stmt->rowCount()==1;	
	}
}

?>