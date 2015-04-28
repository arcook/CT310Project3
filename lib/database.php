<?php
class Database extends PDO{
	public function __construct(){
		parent::__construct("sqlite:lib/p2.db");
	}

	//adds a user to the User database
	//expects a User object
	//returns true for successful insert and false for a failure
	function addUser($user){
		$sql = "INSERT INTO User (firstName, lastName, email, password, questionID, answer, gender, phoneNumber, isAdmin) VALUES 
		(:fName,:lName, :email, :password, :questionID, :answer, :gender, :phoneNumber, :isAdmin)";
		$stm = $this->prepare($sql);
		return $stm->execute(array(
			":fName" => $user->firstName,
			":lName" => $user->lastName,
			":email" => $user->email,
			":password" => $user->hash,
			":questionID" => $user->qID,
			":answer" => $user->answer,
			":gender" => $user->gender,
			":phoneNumber" => $user->phoneNumber,
			":isAdmin" => $user->isAdmin
		));
	}


	function getRow($query){
		$sql = $this->prepare($query);
		$result = $this->query($sql);
		return $result->fetch(PDO::FETCH_ASSOC);
	}
}
?>
