<?php
/*
 * Util class
 * 
 * @author Felipe Volpatto	Feb 17, 2015
 */
require_once("user.php");
class util 
{
	public static function fileNotFound() {
		echo 'File not found!';
	}
	
	public static function sanitizeData($data) {
		return strip_tags($data);
	}

	public static function isLoggedIn()
	{
		return isset($_SESSION['user']) && isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === TRUE;
	}

	public static function clearPartialLogin()
	{
		if(isset($_SESSION['user']) && !isset($_SESSION['loggedIn']))
		{
			unset($_SESSION['user']);
			unset($_SESSION['loggedIn']);
		}
	}

	public static function getLoginBox($center = false)
	{
		// return "<div id=\"logBox\"".($center ? "class='center'" : "").">
		// 			<form method=\"post\" action=\"login.php\">
		// 				<label for=\"email\">
		// 					Email Address:
		// 				</label>
		// 				<input name=\"email\" type=\"text\" id=\"email\">
		// 				<br/>
		// 				<label for=\"password\">
		// 					Password:
		// 				</label>
		// 				<input name=\"password\" type=\"password\" id=\"password\">
		// 				<br/>
		// 				<input type='submit' value='Log In' name='log'>
		// 			</form>
		// 		</div>";
		return "<div id='logBox'>
				<form class='form-inline' method='post' action='login.php'>
					<div class='form-group'>
						<input type='text' class='form-control' name='email' placeholder='Enter email'>
					</div>
					<div class='form-group'>
						<input type='password' class='form-control' name='password' id='password' placeholder='Password'>
					</div>
					<button type='submit' name='log' class='btn btn-default'>Log in</button>
				</form>
				</div>";
	}

	public static function getLogoutBox()
	{
		// $user = Util::getLoggedInUser();
		// return "<div id=\"logBox\">
		// 			<p>You are currently logged in as $user->firstName.</p>
		// 			<form method=\"post\" action=\"login.php\">
		// 				<input type='submit' value='Log Out' name='out'>
		// 			</form>
		// 		</div>";	
		$user = Util::getLoggedInUser();
		return "<div id=\"logBox\">
					
					<form class='form-inline' method='post' action='login.php'>
						<label for='logOut'>You are currently logged in as $user->firstName.</label>
						<button type='submit' name='out' id='logOut' class='btn btn-default'>Log Out</button>
					</form>
				</div>";	
	}

	public static function getQuestionBox($user)
	{
		return "<div id=\"logBox\" class=\"center\">
					<form method='post' class='form-horizontal' action='login.php'>
						<label for='question'>
							$user->questionText
						</label><br />
						<input name=\"question\" type=\"password\" id=\"question\">
						<button type='submit' name='answer' class='btn btn-default'>Submit</button>
					</form>
				</div>";
	}

	public static function getLoggedInUser()
	{
		if(Util::isLoggedIn())
		{
			return unserialize($_SESSION['user']);
		}
		else
		{
			return null;
		}
	}

	public static function isAdmin()
	{
		return Util::getUser()->isAdmin;
	}

	public static function getUser()
	{
		if(Util::isLoggedIn())
		{
			return unserialize($_SESSION['user']);
		}
	}

	public static function isImage($type){
		switch($type){
			case "image/png":
				return true;
			case "image/jpeg":
				return true;
			case "image/gif":
				return true;
			default:
				return false;
		}
	}

	public static function isWhitelistIP(){
	$ip = $_SERVER["REMOTE_ADDR"]; //get user's IP address
	$ipArray = explode(".", $ip); //tokenize IP by '.'
	if($ipArray[0] == "129" && $ipArray[1] == "82" || $ipArray[0] == "10" && $ipArray[1] == "84"){ //check if first half of user's IP is from the CS departments IP range (e.g. 129.82.XXX.XXX)
		return true;
	}else{
		return false; //set to true for testing, set to false for production
	}

}
}

?>
