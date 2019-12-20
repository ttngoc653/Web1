<?php 
/**
 * lớp liên quan tới trạng thái
 */
class trangthai extends connectDB {
	public function create($idUser,$content, $image)
	{
		$stmt = $this->getConnect()->prepare("INSERT INTO `trangthai`(`nguoidang`, `noidung`, `anhdinhkem`) VALUES (?, ?, ?);");
		$stmt->execute(array($idUser, $content, $image));

		return $this->getConnect()->lastInsertId();
	}
	
	public function getListAccordingTo($idUser)
	{
		$stmt= $this->getConnect()->prepare("SELECT trangthai.nguoidang, 
									nguoidung.hoten, 
									nguoidung.avatar, 
									trangthai.thoigiandang, 
									trangthai.noidung,
									trangthai.anhdinhkem 
									FROM trangthai, nguoidung 
									WHERE nguoidung.ma=trangthai.nguoidang AND 
									trangthai.nguoidang = ? 
									ORDER BY trangthai.thoigiandang DESC;");
		$stmt->execute(array($idUser));
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);							
	}
	
	public function getListRelate($idUser)
	{
		$stmt= $this->getConnect()->prepare("SELECT trangthai.nguoidang, 
									nguoidung.hoten, 
									nguoidung.avatar, 
									trangthai.thoigiandang, 
									trangthai.noidung,
									trangthai.anhdinhkem 
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
}

 ?>