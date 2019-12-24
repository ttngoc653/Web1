<?php 
/**
 * lớp truy vấn cơ sở dữ liệu của bảng người dùng 
 */
class nguoidung extends connectDB
{
	// lấy tất cả thông tin người dùng hiện có
	public function getAll()
	{
		$stmt= $this->getConnect()->query("SELECT `ma`, `email`, `sdt`, `hoten`, `avatar`, `namsinh`, `avatar_img`  
			FROM `nguoidung`");
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/**
	 * Hàm lấy thông tin của 1 người dùng
	 * đầu vào: mail hoặc sđt ; mật khẩu
	 * đầu ra: thông tin người dùng (nếu có) >< NULL
	 */
	public function logIn($user='', $pass='')
	{
		$stmt = $this->getConnect()->prepare("SELECT `ma`, `email`, `sdt`, `hoten`, `avatar`, `avatar_img`, `namsinh`, IF(LENGTH(`code`) = 32, 0 , 1) AS 'actived'
			FROM `nguoidung` 
			WHERE (email = ? OR sdt = ?)
			AND matkhau = ?;");
		$stmt->execute(array($user, $user, hash('whirlpool',$pass)));
		// $stmt->debugDumpParams();
		
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			return $row;
		return NULL;
	}

	/**
	 * lấy thông tin người dùng từ email hoặc số điện thoại
	 * đầu ra: thông tin người dùng (nếu có) >< NULL
	 */
	public function getFromKey($key='')
	{
		$stmt = $this->getConnect()->prepare("SELECT `ma`, `email`, `sdt`, `hoten`, `avatar`, `namsinh`, `avatar_img` 
			FROM `nguoidung` 
			WHERE email like ? OR sdt like ?");
		$stmt->execute(array($key, $key));
		
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			return $row;
		return NULL;
	}
	
	/**
	 * lấy thông tin người dùng từ mã
	 * đầu ra: thông tin người dùng (nếu có) >< NULL
	 */
	public function getFromId($id)
	{
		$stmt = $this->getConnect()->prepare("SELECT `ma`, `email`, `sdt`, `hoten`, `avatar`, `namsinh`, `avatar_img`  
			FROM `nguoidung` 
			WHERE ma = ?");
		$stmt->execute(array($id));
		// $stmt->debugDumpParams();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			return $row;
		return NULL;
	}

	public function hasAccount($mail='', $pass='')
	{
		if ($this->logIn($mail,$pass) == NULL)
			return FALSE; 
		return TRUE;
	}
	
	public function changePass($mail='',$passOld='',$passNew='')
	{
		if (!$this->hasAccount($mail,$passOld)) {
			return FALSE;
		} else {
			$stmt = $this->getConnect()->prepare("UPDATE `nguoidung` SET `matkhau`= ? WHERE `email` LIKE ?");
			$stmt->execute(array(hash('whirlpool',$passNew), $mail));
			
			return $stmt->rowCount();	
		}
	}
	
	public function sameMail($mail='')
	{
		$stmt = $this->getConnect()->prepare("SELECT `ma`, `email`, `sdt`, `hoten`, `avatar` 
			FROM `nguoidung` 
			WHERE email like ?");
		$stmt->execute(array($mail));
		
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			return TRUE;
		return FALSE;
	}	
	
	public function samePhone($phone='')
	{
		$stmt = $this->getConnect()->prepare("SELECT `ma`, `email`, `sdt`, `hoten`, `avatar` 
			FROM `nguoidung` 
			WHERE sdt like ?");
		$stmt->execute(array($phone));
		$stmt->execute();
		
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			return TRUE;
		return FALSE;
	}
	
	/**
	 * kiểm tra đã có só điện thoại hoặc email
	 */
	public function same($input)
	{
		return $this->sameMail($input) || $this->samePhone($input);
	}
	
	public function changeInfo($id, $name,$phone,$birthyear)
	{
		$stmt = $this->getConnect()->prepare("SELECT `ma`, `email`, `sdt`, `hoten`, `avatar` 
			FROM `nguoidung` 
			WHERE ma like ?");
		$stmt->execute(array($id));
		// $stmt->debugDumpParams();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			
			$stmt = $this->getConnect()->prepare("UPDATE `nguoidung` SET `sdt`= ?, `hoten`= ?, `birthyear` = ? WHERE `ma` LIKE ?");
			$stmt->execute(array($phone, $name, $birthyear, $id));
			// $stmt->debugDumpParams();
			return $stmt->rowCount()>=0;
		}
		
		return false;
	}
	
	public function changeInfoHasAvatar($id, $name, $phone, $avatar, $birthyear)
	{
		$stmt = $this->getConnect()->prepare("SELECT `ma`, `email`, `sdt`, `hoten`, `avatar` 
			FROM `nguoidung` 
			WHERE ma like ?");
		$stmt->execute(array($id));
		
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			
			$stmt = $this->getConnect()->prepare("UPDATE `nguoidung` SET `sdt`= ?, `hoten`= ?, `avatar`= ?, `namsinh` = ? WHERE `ma` LIKE ?");
			$stmt->execute(array($phone, $name, $avatar, $birthyear, $id));
			
			return $stmt->rowCount()>=0;
		}
		
		return false;
	}
	
	public function addUser($mail, $phone, $pass, $name, $birthyear, $avatarName)
	{
		if (strlen($mail)==0 || strlen($phone)==0 || strlen($pass)==0 || strlen($name)==0 || strlen($birthyear)==0) {
			return -3;
		} elseif ($this->sameMail($mail)) {
			return -2;
		} elseif ($this->samePhone($phone)) {
			return -1;
		} else {
			$stmt = $this->getConnect()->prepare("INSERT INTO `nguoidung`(`email`, `sdt`, `hoten`, `namsinh`, `matkhau`, `avatar_img`) VALUES (?,?,?,?,?,?)");
			$stmt->execute(array($mail, $phone, $name, $birthyear, hash('whirlpool',$pass), $avatarName));

			return $this->getConnect()->lastInsertId();
		}
	}

	public function checkCode($code)
	{
		$stmt = $this->getConnect()->prepare("SELECT `ma`, `email`, `sdt`, `hoten`, `avatar` 
			FROM `nguoidung` 
			WHERE code like ?");
		$stmt->execute(array($code));
		
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			return TRUE;
		return FALSE;
	}

	public function updateWhenForgotPassword($code='',$password)
	{
		$stmt = $this->getConnect()->prepare("UPDATE `nguoidung` SET `code`= NULL, `matkhau` = ? WHERE `code` LIKE ?");
			$stmt->execute(array(hash('whirlpool',$password), $code));
			
			return $stmt->rowCount()==1;
	}
	
	public function setCode($mail, $code)
	{
		$stmt = $this->getConnect()->prepare("UPDATE `nguoidung` SET `code`= ? WHERE `email` LIKE ?");
			$stmt->execute(array($code, $mail));
			
			return $stmt->rowCount()==1;
	}
	
	public function activeAccount($code='')
	{
		$stmt = $this->getConnect()->prepare("UPDATE `nguoidung` SET `code`= NULL WHERE `code` LIKE ?");
			$stmt->execute(array($code));
			
			return $stmt->rowCount()==1;
	}

	public function search($key='')
	{
		$stmt= $this->getConnect()->prepare("SELECT `ma`, `email`, `sdt`, `hoten`, `avatar`, `avatar_img`
			FROM `nguoidung` 
			WHERE `email` LIKE ? OR `sdt` LIKE ? OR `hoten` LIKE ?;");
		$stmt->execute(array($key,$key,'%'.$key.'%'));
		//$stmt->debugDumpParams();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>