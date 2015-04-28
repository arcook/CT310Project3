<?php
	require_once("lib/util.php");
	$title = "Admin";
	include_once("inc/header.php");
	$error = '<div class="errors">You\'re not an admin. You cannot view this page.</div>';
	Util::clearPartialLogin();
?>
<!-- <div class="page-wrap">
		<div class="leftContent admin"> -->
		<div class="container-fluid">
 			<div class="row">
 			<div class="col-md-6 col-lg-6 col-sm-6  leftContent">
		<?php
			if(Util::isLoggedIn() && Util::isAdmin())
			{
				$required = array(
				                  'email' => 'User Email',
				                  'password' => 'Password',
				                  'question' => 'Security Question',
				                  'qAnswer' => 'Security Answer'
							);
				$optional = array(
				                  'fName' =>'First Name',
				                  'lName' =>'Last Name',
				                  'gender'=> 'Gender',
				                  'pNumber' => 'Phone Number',
				            );
				$repeat = true;
				$errors = array();
				$count = 0;
				$all = User::getAll();
				$email = NULL;
				if(isset($_POST['submit']))
				{
					foreach($required as $key => $value)
					{
						if(isset($_POST[$key]) && !empty($_POST[$key]))
						{
							$count++;
						}
						else
						{
							$errors[] = $value . " is required.";
						}
					}
					if($count == count($required) && empty($errors))
					{
						$repeat = false;
						$email = $_POST['email'];
						foreach($all as $u)
						{
							if($u->email === $email)
							{
								$errors[] = "$email has already been used to sign up.";
								$repeat = true;
								break;
							}
						}
						if(!$repeat)
						{
							$first = isset($_POST['fName']) && !empty($_POST['fName']) ? strip_tags($_POST['fName']) : null;
							$last = isset($_POST['lName']) && !empty($_POST['lName']) ? strip_tags($_POST['lName']) : null;
							$gender = isset($_POST['gender']) && !empty($_POST['gender']) ? strip_tags($_POST['gender']) : null;
							$phoneNumber = isset($_POST['pNumber']) && !empty($_POST['pNumber']) ? strip_tags($_POST['pNumber']) : null;
							$password = md5(strip_tags($_POST['password']));
							$answer = md5(strip_tags($_POST['qAnswer']));
							$qID = $_POST['question'];
							$newUser = new User($first, $last, $gender, $phoneNumber, $email, $password, $answer, $qID, "", false, false, null, null);
							if($newUser->createUser())
								echo "<pre class='bg-success'>User has been created</pre>";
							else
								echo '<div class="errors bg-danger">Unknown error in saving user.</div>';
						}
					}
				}
				if($repeat || !empty($errors)){
				?>
					<h2>Create new User</h2>
					<?php
						echo '<div class="errors">';
						foreach($errors as $e)
							echo "<p>$e</p>";
						echo '</div>';
					?>
					<form method="post" action="admin.php">
						<table class="table table-striped">
						<?php
							$passwordFlag = false;
							foreach($required as $key=> $field)
							{	
								echo "<tr>";
								if($key !== 'question')
								{
									echo "<td>";
									echo "<label  for=\"$key\">";
										echo $field.":";
									echo "</label></td>";
									echo "<td><input  name=\"$key\" type=".($passwordFlag ? 'password' : 'text')." id=\"$key\"></td>";
									
								}
								else
								{
									$questions = User::getQuestions();
									echo "<td><label  for=\"$key\">";
										echo $field.":";
									echo "</label></td>";
									echo "<td><select  name=\"$key\" id=\"$key\">";
									foreach($questions as $id => $q)
									{
										echo "<option value=$id>$q</option>";
									}
									echo "</select></td>";
								}
								$passwordFlag = ($passwordFlag ? false : true);	
								echo "</tr>";
							}
							foreach($optional as $key=> $field)
							{

								echo "<tr><td><label for=\"$key\">";
									echo $field.":";
								echo "</label></td>";
								echo "<td><input   name=$key type='text' id=$key></td></tr>";
							}
						?>
						</table>
						<br />
						<button type="Submit" class="btn btn-success" name="submit">Create new user</button>
					</form>
				<?php
				}
			}
			else
			{
				echo $error;
			}
		?>
	</div>
	<?php 
	include("friendsList.php");
	include("inc/rightContent.php");
	 ?>
</div>
</div>
	<?php 
		// include("inc/rightContent.php");
		// include("friendsList.php");
		include("inc/footer.php");
	?>
