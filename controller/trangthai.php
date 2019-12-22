<?php 
/**
 * lớp liên quan tới trạng thái
 */
class trangthai extends connectDB {
	public function create($idUser,$content, $images)
	{
		$stmt = $this->getConnect()->prepare("INSERT INTO `trangthai`(`nguoidang`, `noidung`) VALUES (?, ?);");
		$stmt->execute(array($idUser, $content));

		$idTrangThai=$this->getConnect()->lastInsertId();

		for ($i=0; $i < count($images); $i++) { 
			try{
				error_reporting(0);
				$stmt = $this->getConnect()->prepare("INSERT INTO `trangthaidinhkem`(`matt`, `anhdinhkem`) VALUES (?,?);");
				$stmt->execute(array($idTrangThai, $images[$i]));
			} catch (Exception $e) {
				
			}
		}

		return $idTrangThai;
	}
	
	public function getListAccordingTo($idUser)
	{
		$stmt= $this->getConnect()->prepare("SELECT trangthai.ma,
									trangthai.nguoidang, 
									nguoidung.hoten, 
									nguoidung.avatar, 
									trangthai.thoigiandang, 
									trangthai.noidung
									FROM trangthai, nguoidung 
									WHERE nguoidung.ma=trangthai.nguoidang AND 
									trangthai.nguoidang = ? 
									ORDER BY trangthai.thoigiandang DESC;");
		$stmt->execute(array($idUser));
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);							
	}
	
	public function getListRelate($idUser)
	{
		$stmt= $this->getConnect()->prepare("SELECT DISTINCT trangthai.ma,
									trangthai.nguoidang, 
									nguoidung.hoten, 
									nguoidung.avatar, 
									trangthai.thoigiandang, 
									trangthai.noidung
									FROM trangthai, nguoidung 
									WHERE nguoidung.ma=trangthai.nguoidang AND 
									trangthai.nguoidang IN (SELECT DISTINCT IF(banbe.ban1 = ?, banbe.ban2, banbe.ban1) 
															FROM banbe 
															WHERE (banbe.ban1=? OR 
																	banbe.ban2=?) 
																AND banbe.tinhtrang=1) 
									ORDER BY trangthai.thoigiandang DESC;");
		$stmt->execute(array($idUser,$idUser,$idUser));
		
		//$stmt->debugDumpParams();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getListImageAttach($idTrangThai)
	{
		$stmt= $this->getConnect()->prepare("SELECT `matt`, `anhdinhkem` FROM `trangthaidinhkem` WHERE `matt` = ?;");
		$stmt->execute(array($idTrangThai));
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}

 ?>