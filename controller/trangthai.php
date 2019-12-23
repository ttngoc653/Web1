<?php 
/**
 * lớp liên quan tới trạng thái
 */
class trangthai extends connectDB {
	public function create($idUser,$content,$privateP, $images)
	{
		$stmt = $this->getConnect()->prepare("INSERT INTO `trangthai`(`nguoidang`, `riengtu`,`noidung`) VALUES (?, ?, ?);");
		$stmt->execute(array($idUser, $privateP, str_replace("\n","<br />", str_replace("\n","<br />", htmlentities($content)))));

		$idTrangThai=$this->getConnect()->lastInsertId();

		for ($i=0; $i < count($images); $i++) { 
			try{
				error_reporting(0);
				$stmt = $this->getConnect()->prepare("INSERT INTO `trangthaidinhkem`(`matt`, `anhdinhkem`) VALUES (?,?);");
				$stmt->execute(array($idTrangThai, $images[$i]));
			} catch (PDOException $e) {
				echo $i;
			}
		}

		return $idTrangThai;
	}
	

	public function getNameWritedStatus($statuId)
	{
		$stmt= $this->getConnect()->prepare("SELECT nguoidung.hoten
			,nguoidung.ma
			,trangthai.noidung
			FROM trangthai, nguoidung 
			WHERE nguoidung.ma=trangthai.nguoidang AND 
			trangthai.ma = ?;");
		$stmt->execute(array($statuId));
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			return $row;
		return '';
	}

	public function getListAccordingTo($idUser, $private = 2)
	{
		$stmt= $this->getConnect()->prepare("SELECT trangthai.ma,
			trangthai.nguoidang, 
			trangthai.riengtu,
			nguoidung.hoten, 
			hoten.avatar, 
			trangthai.thoigiandang, 
			trangthai.noidung
			FROM trangthai, nguoidung 
			WHERE nguoidung.ma=trangthai.nguoidang AND 
			trangthai.nguoidang = ? AND
			trangthai.riengtu >= ?
			ORDER BY trangthai.thoigiandang DESC
			LIMIT 10;");
		$stmt->execute(array($idUser, $private));

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getListHasArrayAccordingTo($idUser, $private = 0, $listShowed = array())
	{
		$strIds = " AND trangthai.ma != ".implode(" AND trangthai.ma != ",$listShowed);
		$stmt= $this->getConnect()->prepare("SELECT trangthai.ma,
			trangthai.nguoidang, 
			trangthai.riengtu,
			nguoidung.hoten, 
			nguoidung.avatar, 
			trangthai.thoigiandang, 
			trangthai.noidung
			FROM trangthai, nguoidung 
			WHERE nguoidung.ma=trangthai.nguoidang AND 
			trangthai.nguoidang = ? AND
			trangthai.riengtu >= ? 
			".$strIds." 
			ORDER BY trangthai.thoigiandang DESC
			LIMIT 10;");
		$stmt->execute(array($idUser, $private));
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);							
	}
	
	public function getListRelate($idUser)
	{
		$stmt= $this->getConnect()->prepare("SELECT DISTINCT trangthai.ma,
			trangthai.nguoidang,
			trangthai.riengtu, 
			nguoidung.hoten, 
			nguoidung.avatar, 
			trangthai.thoigiandang, 
			trangthai.noidung
			FROM trangthai, nguoidung 
			WHERE nguoidung.ma=trangthai.nguoidang AND 
			((trangthai.riengtu != 0 AND trangthai.nguoidang != ?) || trangthai.nguoidang = ?) AND 
			trangthai.nguoidang IN (SELECT DISTINCT IF(banbe.ban1 = ?, banbe.ban2, banbe.ban1) 
			FROM banbe 
			WHERE (banbe.ban1=? OR 
			banbe.ban2=?) 
			AND banbe.tinhtrang=1) 
			ORDER BY trangthai.thoigiandang DESC
			LIMIT 10;");
		$stmt->execute(array($idUser, $idUser, $idUser, $idUser, $idUser));
		
		//$stmt->debugDumpParams();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getListRelateHasArray($idUser,$arrayIdsLoaded)
	{
		$strIds = " AND trangthai.ma != ".implode(" AND trangthai.ma != ",$arrayIdsLoaded);
		$stmt= $this->getConnect()->prepare("SELECT DISTINCT trangthai.ma,
			trangthai.nguoidang,
			trangthai.riengtu, 
			nguoidung.hoten, 
			nguoidung.avatar, 
			trangthai.thoigiandang, 
			trangthai.noidung
			FROM trangthai, nguoidung 
			WHERE nguoidung.ma=trangthai.nguoidang AND 
			((trangthai.riengtu != 0 AND trangthai.nguoidang != ?) || trangthai.nguoidang = ?) AND 
			trangthai.nguoidang IN (SELECT DISTINCT IF(banbe.ban1 = ?, banbe.ban2, banbe.ban1) 
			FROM banbe 
			WHERE (banbe.ban1=? OR 
			banbe.ban2=?) 
			AND banbe.tinhtrang=1)  
			".$strIds." 
			ORDER BY trangthai.thoigiandang DESC
			LIMIT 10;");
		$stmt->execute(array($idUser, $idUser, $idUser, $idUser, $idUser));
		
		//$stmt->debugDumpParams();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getListImageAttach($idTrangThai)
	{
		$stmt= $this->getConnect()->prepare("SELECT `matt`, `anhdinhkem` FROM `trangthaidinhkem` WHERE `matt` = ?;");
		$stmt->execute(array($idTrangThai));
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function changePrivate($statuId,$userId,$privateP=0)
	{
		if ($privateP!=0 && $privateP!=1 && $privateP!=2) {
			return 0;
		} else {
			$stmt = $this->getConnect()->prepare("UPDATE `trangthai` SET `riengtu` = ? WHERE `ma` = ? AND `nguoidang` = ?;");
			$stmt->execute(array($privateP, $statuId, $userId));
			
			return $stmt->rowCount();	
		}
	}
}

?>