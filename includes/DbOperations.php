<?php

	class DbOperations
	{
		private $con;

		function __construct(){

			require_once dirname(__FILE__).'./DbConnect.php';

			$db = new DbConnect();

			$this->con = $db->connect(); 
		}

		//crud

		public function createUser($username,$pass,$email)
		{
			if($this->isUserExist($username,$email))
			{
				return 0;
			}
			else{

				$password = md5($pass); //will encrypt the password in hash 5

				$stmt = $this->con->prepare("INSERT INTO `where is my place`.`users` (`id`, `username`, `password`,`email`) VALUES (NULL, ?, ?, ?);");

				$stmt->bind_param("sss",$username,$password,$email);

				if ($stmt->execute()) {
					return 1;
				} 
				else{
					print($stmt->error);
					return 2;
				}
			}
		}

		// public function getUserLocName($username)
		// {
		// 	$stmt = $this->con->prepare("SELECT locName FROM `where is my place`.`userdata` WHERE username = ?");
		// 	$stmt->bind_param("s",$username);
		// 	$array = array();
		// 	$i = 0;
		// 	if ($stmt->execute()) {
		// 		return $stmt->get_result()->fetch_all();
		// 	}
		// 	else{
		// 		return 0;
		// 	}
		// }

		// public function getUserLat($username)
		// {
		// 	$stmt = $this->con->prepare("SELECT lat FROM `where is my place`.`userdata` WHERE username = ?");
		// 	$stmt->bind_param("s",$username);
		// 	$array = array();
		// 	$i = 0;
		// 	if ($stmt->execute()) {
		// 		return $stmt->get_result()->fetch_all();
		// 	}
		// 	else{
		// 		return 0;
		// 	}
		// }

		public function getUserData($username)
		{
			$stmt = $this->con->prepare("SELECT locName,lat,lon FROM `where is my place`.`userdata` WHERE username = ?");
			$stmt->bind_param("s",$username);
			$array = array();

			$i = 0;
			if ($stmt->execute()) {
				// while ($row = $stmt->get_result()->fetch_assoc() {
				// 	$array[] = $row;
				// }
				//return $stmt->get_result()->fetch_all();
				return $stmt->get_result()->fetch_all();
			}
			else{
				return 0;
			}
		}

		public function addData($username,$locName,$lat,$lon)
		{
			$stmt = $this->con->prepare("INSERT INTO `userdata` (`username`, `locName`, `lat`, `lon`) VALUES (?, ?, ?, ?);");

				$stmt->bind_param("ssss",$username,$locName,$lat,$lon);

				if ($stmt->execute()) {
					return 1;
				} 
				else{
					return 2;
				}			
		}

		public function editData($username,$oldLocName,$newLocName)
		{
			$stmt = $this->con->prepare("UPDATE `userdata` SET locName=? where username=? and locName=?;");

				$stmt->bind_param("sss",$newLocName,$username,$oldLocName);

				if ($stmt->execute()) {
					return 1;
				} 
				else{
					return 2;
				}			
		}


		public function deleteLoc($username,$locName)
		{
			$stmt = $this->con->prepare("DELETE FROM `userdata` WHERE username= ? and locName= ?;");

				$stmt->bind_param("ss",$username,$locName);

				if ($stmt->execute()) {
					return true;
				} 
				else{
					return false;
				}			
		}
		
		public function userLogin($username,$pass){
			$password=md5($pass);
			$stmt = $this->con->prepare("SELECT id FROM `where is my place`.`users` WHERE username = ? AND password = ? ");
			$stmt->bind_param("ss",$username,$password);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows==1;
		}

		public function getUserByUsername($username){
			$stmt= $this->con->prepare("SELECT * FROM users WHERE username = ?");
			$stmt->bind_param("s",$username);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}


		private function isUserExist($username,$email)
		{
			$stmt = $this->con->prepare("SELECT id FROM users WHERE username=? OR email=?");
			$stmt->bind_param("ss",$username,$email);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}
	}
?>