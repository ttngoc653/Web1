<?php 
/**
 * lớp liên quan tới (lượt) thích 
 */
class binhluan extends connectDB {
	public function create($idUser,$idStatu,$content, $idComment = NULL)
	{
		$stmt = $this->getConnect()->prepare("INSERT INTO `binhluan`(`matt`, `binhluancha`, `ngbinhluanid`, `noidung`) VALUES (?, ?, ?, ?);");
		$stmt->execute(array($idStatu, $idComment, $idUser, $content));

		return $this->getConnect()->lastInsertId();
	}
	
	public function count($idStatu,$idCommentParent = NULL)
	{
		if ($idCommentParent == NULL) {
			$stmt = $this->getConnect()->prepare("SELECT * FROM `binhluan` WHERE `matt` =  ?;");
			$stmt->execute(array($idStatu));
		} 
		else {
			$stmt = $this->getConnect()->prepare("SELECT * FROM `binhluan` WHERE `matt` =  ? AND `binhluancha` = ?;");
			$stmt->execute(array($idStatu,$idCommentParent));	
		}
		return $stmt->rowCount();
	}	

	public function getList($idStatu, $idCommentParent=NULL)
	{
		if ($idCommentParent == NULL) {
			$stmt = $this->getConnect()->prepare("SELECT * FROM `binhluan` WHERE `matt` =  ? AND `binhluancha` IS NULL;");
			$stmt->execute(array($idStatu));
		} 
		else {
			$stmt = $this->getConnect()->prepare("SELECT * FROM `binhluan` WHERE `matt` =  ? AND `binhluancha` = ?;");
			$stmt->execute(array($idStatu,$idCommentParent));	
		}
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function delete($idUser,$idStatu,$idCommentParent = NULL)
	{
		if ($idComment == NULL) {
			$stmt = $this->getConnect()->prepare("DELETE FROM `binhluan` WHERE `ngbinhluanid` = ? AND `matt` =  ?;");
			$stmt->execute(array($idUser, $idStatu));
		} 
		else {
			$stmt = $this->getConnect()->prepare("DELETE FROM `binhluan` WHERE `ngbinhluanid` = ? AND `matt` =  ? AND `binhluancha` = ?;");
			$stmt->execute(array($idUser, $idStatu,$idCommentParent));	
		}
		
		return $stmt->rowCount()==1;	
	}
}

?>