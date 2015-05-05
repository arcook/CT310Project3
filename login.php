<?php

	$title = "Login";
	include_once("inc/header.php");
	require_once("lib/user.php");
	require_once("lib/util.php");
	$errors = array();
	$output = array();
	$lastPage = $_SESSION['lastPage'];
	if(filter_has_var(INPUT_POST, "out"))
	{
		unset($_SESSION['user']);
		unset($_SESSION['loggedIn']);
		header("Location: ".$lastPage);
	}
	else if(Util::isLoggedIn())
	{
		$errors[] = "<p>You are already logged in!</p>";
		$output[] = Util::getLogoutBox();
	}
	else if(isset($_SESSION['user']))
	{
		if(filter_has_var(INPUT_POST, "question"))
		{
			$answer = filter_input(INPUT_POST,"question", FILTER_SANITIZE_STRING);
			$user = unserialize($_SESSION['user']);
			$answer = md5($answer);
			echo "<br>";
			if($user->answer === $answer)
			{
				$_SESSION['loggedIn'] = true;
				header("Location: ". $lastPage);
			}
			else
			{
				$errors[] = "Invalid question/answer combination.";
				$output[] = Util::getQuestionBox($user);
			}
		}
		else
		{
			$output[] = Util::getQuestionBox($user);
		}
		
	}
	else
	{
		if(!filter_has_var(INPUT_POST, "email"))
		{
			$errors[] = "removed email";
		}
		if(!filter_has_var(INPUT_POST, "password"))
		{
			$errors[] = "removed password";
		}
		if(empty($errors))
		{
			$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
			$email = SQLite3::escapeString($email);
			$password = filter_input(INPUT_POST,"password", FILTER_SANITIZE_STRING);
			$password = SQLite3::escapeString($password);
			if(empty($email) || empty($password))
			{
				$errors[] = "Invalid email/password combination.";
				$output[] = Util::getLoginBox(true);
			}
			else
			{
				$user = User::getUser($email, $password);
				if($user !== NULL)
				{
					$_SESSION['user'] = serialize($user);
					$output[] =  Util::getQuestionBox($user);
				}
				else
				{
					$errors[] = "Invalid email/password combination.";
					$output[] = Util::getLoginBox(true);
				}
			}
			
		}
	}
	if(!empty($errors))
	{
		echo '<div class="errors">';
			foreach($errors as $e)
			{
				echo "<p>$e</p>";
			}
		echo '</div>';
	}
	foreach($output as $out)
	{
		echo $out;
	}

	include_once("inc/footer.php");
?>
