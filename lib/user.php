<?php
//errors are turned on for debugging, remove for production
ini_set('display_errors',1);  
error_reporting(E_ALL);
/**
 * An adaptation of the User used in lecture.
 * @author pfiorella
 *
 */

require_once('database.php');

class User {
	public $firstName = 'John';          
	public $lastName = 'Doe';           
	public $gender = "";
	public $phoneNumber = "";
	public $email = '';              
	public $hash = '';              
	public $answer = '';	
	public $qID = '';	
	public $questionText = "";
	public $userID = "";
	public $loggedIn = false;
	public $isAdmin = false;	
	public $picturePath = null;
	public $interests = "";
	public $description = "";
	public $requestID = "";

	public function __construct($first = "", $last = "", $gender = "", $phoneNumber = "",
		$email = "", $passwd = "", $answer="", $qID = '', $id ='', $questionText='', $loggedIn = false, $isAdmin = false, $interest = "", $descip = ""){
		$this->firstName = $first;
		$this->lastName  = $last;
		$this->gender = $gender;
		$this->phoneNumber = $phoneNumber;
		$this->email  = $email;
		$this->questionText = $questionText;
		$this->hash = $passwd; //i know md5 is super shitty but it works for now
		$this->answer = $answer;
		$this->qID = $qID;
		$this->userID = $id;
		$this->loggedIn = $loggedIn;
		$this->isAdmin = $isAdmin;
		$this->interests = $interest;
		$this->description = $descip;
		
	}
	
	public function getName()
	{
		return $this->firstName . " ". $this->lastName;
	}

	//gets user from database and loads DB items into User object. 
	//returns User object if email and password match db record, else returns null
	//USAGE: $user = User::getUser($enteredEmail, $enteredPassword);
	//if $user != null, user is logged in, else email or password was wrong
	public static function getUser($email, $password){
		$db = new Database();
		$sql = "SELECT User.*, Question.text FROM User INNER JOIN Question ON User.questionID = Question.questionID WHERE email = '$email'";
		$result = $db->query($sql);
		$row = $result->fetch(PDO::FETCH_ASSOC);
		if($result != false){
			if(md5($password) === $row['password']){
				 $tempuser = new User($row['firstName'], $row['lastName'], $row['gender'], $row['phoneNumber'], $row['email'], $row['password'], $row['answer'], $row['questionID'], $row['ID'], $row['text'], true, $row['isAdmin'], $row['interests'], $row['description']);
				 $tempuser->picturePath = $row['picturePath'];
				 return $tempuser;
			}else{
				return null;
			}
		}else{
			return null;
		}
		return null;
	}


	//updates the users profile information
	//returns false if error
    function updateUser(){
		$db = new SQLite3('lib/p2.db');
		$sql = "UPDATE User SET firstName='$this->firstName', lastName='$this->lastName', questionID='$this->qID', answer='$this->answer', phoneNumber='$this->phoneNumber', gender='$this->gender', interests='$this->interests', description='$this->description'  WHERE ID = $this->userID";
		return $db->exec($sql);
		//$stm = $db->prepare($sql);
		// return $stm->execute(array(
		// 	':fName' => $this->firstName,
		// 	':lName' => $this->lastName,
		// 	':questionID' => $this->qID,
		// 	':answer' => $this->answer, 
		// 	':gender' => $this->gender,
		// 	':phoneNumber' => $this->phoneNumber
		// ));
	}
	//stores the user into the db
	//returns false if error
	function createUser()
	{
		$db = new SQLite3('lib/p2.db');
		$sql = "INSERT INTO User('email','password','firstName', 'lastName', 'questionID', 'answer', 'phoneNumber', 'gender', 'interests', 'description') 
		VALUES('$this->email','$this->hash','$this->firstName','$this->lastName','$this->qID','$this->answer','$this->phoneNumber','$this->gender','$this->interests','$this->description')";
		return $db->exec($sql) == 1;
	}

	//adds a friend request to the FriendRequest table
	//expects userID of sender of request and userID of reciever
	//returns true for success, false for failure 
	function createFriendRequest($recieverID){
		$db = new Database();
		date_default_timezone_set('America/Denver');
		$date = date('m/d/Y h:i:s a', time());
		$sql = "INSERT INTO FriendRequest (senderID, recieverID, requestDate) VALUES ($this->userID, $recieverID, '$date')";
		$stm = $db->prepare($sql);
		return $stm->execute();
	}

	//gets pending friend requests from database
	//returns an array of user objects, these are the users that have sent the logged in user a request
	function getUsersFriendRequests(){
		$users = array();
		$db = new Database();
		$sql = "SELECT DISTINCT u.firstName, u.lastName, u.ID, f.requestID FROM User u INNER JOIN FriendRequest f ON u.ID = f.senderID WHERE recieverID = '$this->userID'";
		$result = $db->query($sql);
		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			$user = new User();
			$user->firstName = $row['firstName'];
			$user->lastName = $row['lastName'];
			$user->userID = $row['ID'];
			$user->requestID = $row['RequestID'];
			$users[] = $user;
		}
		return $users;
	}

	//should we show the Send Friend REquest button
	//returns false if users are friends or there is a pending friend request between them
	function showButton($otherUserID){
		if(User::isFriend($otherUserID) || User::isRequestPending($otherUserID)){
			return false;
		}else{
			return true;
		}
	}

	//checks if there are pending friend requests between loggedin user and otherUser
	//returns true if there are pending friend requests
	function isRequestPending($otherUserID){
		$db = new Database();
		$sql = "SELECT RequestID FROM FriendRequest WHERE senderID = $this->userID AND recieverID = $otherUserID UNION SELECT RequestID FROM FriendRequest WHERE senderID = $otherUserID AND recieverID = $this->userID";
		$result = $db->query($sql);
		$num = $result->fetch(PDO::FETCH_ASSOC);
		if($num == false){
			return false;
		}else{
			return true;
		}

	}

	//checks if logged in user is friends with otherUser
	//returns true if they are friends
	function isFriend($otherUserID){
		$db = new Database();
		$sql = "SELECT FriendshipID FROM Friendship WHERE userOneID = $this->userID AND userTwoID = $otherUserID UNION SELECT FriendshipID FROM Friendship WHERE userTwoID = $this->userID AND userOneID = $otherUserID";
		$result = $db->query($sql);
		$num = $result->fetch(PDO::FETCH_ASSOC);
		if($num == false){
			return false;
		}else{
			return true;
		}

	}

	//returns a user object
	//this should be used for viewing profiles, e.g. example.com/user.php?id=2. Get the users ID from query string and pass into this function
	//expects user's database ID  
	//returns User object (only relavant profile info loaded) or null
	public static function getUserById($userID){
		$db = new Database();
		$sql = "SELECT * FROM User WHERE ID = '$userID'";
		$result = $db->query($sql);
		$row = $result->fetch(PDO::FETCH_ASSOC);
		if(!empty($row)){
			$user =  new User($row['firstName'], $row['lastName'], $row['gender'], $row['phoneNumber'], $row['email']);
			$user->picturePath = $row['picturePath'];
			return $user;
		}else{
			return null;
		}
		
	}

	public static function getAll()
	{
		$users = array();
		$db = new Database();
		$sql = "SELECT * FROM User";
		$result = $db->query($sql);
		while($row = $result->fetch(PDO::FETCH_ASSOC) ){
			$user = new User();
			$user->userID = $row['ID'];
			$user->firstName = $row['firstName'];
			$user->lastName = $row['lastName'];
			$user->gender = $row['gender'];
			$user->phoneNumber = $row['phoneNumber'];
			$user->email =  $row['email'];
			$user->loggedIn = $row['loggedIn'];
			$user->picturePath = $row['picturePath'];
			$users[] = $user; 
		}
		return $users;
	}


	function getPicturePath()
	{
		if(is_null($this->picturePath) || empty($this->picturePath))
		{
			return "assets/img/noPicture.jpg";
		}
		else
		{
			return $this->picturePath;
		}
	}


	//gets user's friendlist
	//returns an array of users objects
	function getFriends(){
		$db = new Database();
		$friends = array();
		$sql = "SELECT u.ID, u.firstName, u.lastName, u.picturePath FROM Friendship f JOIN User u ON u.ID = f.userOneID WHERE userTwoID = $this->userID UNION SELECT u.ID, u.firstName, u.lastName,  u.picturePath FROM Friendship f JOIN User u ON u.ID = f.userTwoID WHERE userOneID = $this->userID";
		$result = $db->query($sql);
		while($row = $result->fetch(PDO::FETCH_ASSOC) ){
			$user = new User();
			$user->userID = $row['u.ID'];
			$user->firstName = $row['u.firstName'];
			$user->lastName = $row['u.lastName'];
			$user->picturePath = $row['u.picturePath'];
			$friends[] = $user;
		}
		return $friends;
	}

	public static function getQuestions()
	{
		$db = new Database();
		$questions = array();
		$sql = "SELECT * FROM Question;";
		$result = $db->query($sql);
		while($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$questions[$row['questionID']] = $row['text'];
		}
		return $questions;
	}


	function acceptFriendRequest($requestID){
		//get userID of sender
		$db = new Database();
		$sql = "SELECT senderID FROM FriendRequest WHERE RequestID = $requestID";
		$result = $db->query($sql);
		if($result != false){
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$sender = $row['senderID'];
			//insert into Friends table
			$insert = "INSERT INTO Friendship (userOneID, userTwoID) VALUES ($this->userID, $sender)";
			$stm = $db->prepare($insert);
			$insertResult = $stm->execute();
			if($insertResult != false){
				$delete = "DELETE FROM FriendRequest WHERE requestID = $requestID";
				$stmt = $db->prepare($delete);
				$deleteREsult = $stmt->execute();
				if($deleteREsult != false){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function denyFriendRequest($requestID){
		$db = new Database();
		$delete = "DELETE FROM FriendRequest WHERE requestID = $requestID";
		$stmt = $db->prepare($delete);
		$deleteREsult = $stmt->execute();
		if($deleteREsult != false){
			return true;
		}else{
			return false;
		}
	}
	function removeFriend($friendID){
		$db = new Database();
		$getFriendship = "SELECT FriendshipID FROM Friendship WHERE userOneID = $this->userID AND userTwoID = $friendID UNION SELECT FriendshipID FROM Friendship WHERE userTwoID = $this->userID AND userOneID = $friendID";
		$result = $db->query($getFriendship);
		if($result != false){
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$friendship = $row['FriendshipID'];
			$remove = "DELETE FROM Friendship WHERE FriendshipID = $friendship";
			$stmt = $db->prepare($remove);
			$deleteREsult = $stmt->execute();
		}	
	}

	function updatePicture(){
		$db = new SQLite3('lib/p2.db');
		$update = "UPDATE User SET picturePath = '$this->picturePath' WHERE ID = $this->userID";
		return $db->exec($update);
	}
}
?>


