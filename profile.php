<?php
	$title = "Profile Page";
	
	$userName = isset($_GET['user']) ? $_GET['user'] : "";
	$profile = isset($_POST['profile']) ? $_POST['profile'] : "";



	include_once("inc/header.php");
	require_once("lib/user.php");
	require_once("lib/util.php");
	
	Util::clearPartialLogin();
?>
		<!-- <div class="page-wrap">
			<div class="leftContent"> -->
			<div class="container-fluid">
 			<div class="row">
 			<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 leftContent">
				<?php
				$id = filter_input(INPUT_GET, "userID", FILTER_SANITIZE_NUMBER_INT);
				$user = User::getUserByID($id);					
				if(is_null($user)) 
				{
					echo '<div class="errors"><h2>Profile not found!</h2></div>';
				} 
				else 
				{
					if(Util::isLoggedIn())
					{
						$u = Util::getLoggedInUser();
						if(isset($_POST['request'])){
							$rID = $_POST['request'];
							$u->createFriendRequest($rID);
						}
						if($u->userID === $id)
						{
							global $errors;
							if(isset($_POST['upload'])){
								if($_FILES['img']['size'] > 1000000 || $_FILES['img']['error'] === 1) { 
									$errors[] = "Error: Image filesize is too big";
								}else if (!Util::isWhitelistIP()){
									$errors[] = "Error: Your IP is not allowed to upload";
								}else if(!Util::isImage($_FILES['img']['type'])){
									$errors[] = "Error: Uploaded file is not an image";
								}else{
									$name = $_FILES['img']['name'];
									$dir = "assets/img/$name";
									$filepath = __DIR__ . "/" . $dir;
									move_uploaded_file($_FILES['img']['tmp_name'], $filepath);
									$u->picturePath = $dir;
									$u->updatePicture();
								}
							}
							if(isset($_POST['save'])){
								if(empty($_POST['email'])){
									$errors[] = "Error: Email is required";
								}else{
									$u->firstName = isset($_POST['firstName']) && !empty($_POST['firstName']) ? strip_tags($_POST['firstName']) : null;
									$u->lastName = isset($_POST['lastName']) && !empty($_POST['lastName']) ? strip_tags($_POST['lastName']) : null;
									$u->gender = isset($_POST['gender']) && !empty($_POST['gender']) ? strip_tags($_POST['gender']) : null;
									$u->email = isset($_POST['email']) && !empty($_POST['email']) ? strip_tags($_POST['email']) : null;
									$u->phoneNumber = isset($_POST['phoneNumber']) && !empty($_POST['phoneNumber']) ? strip_tags($_POST['phoneNumber']) : null;
									$u->updateUser();
								}
								
							}
							if(isset($_POST['edit'])){
								echo "<h2 style='float: left'>Your Profile</h2>";
								
								$img = $u->getPicturePath();
								// echo "<img src=\"$img\">";
								echo "<form method='post' class='form'>
							 	<div class='profilePic'><img src='$img'></div>
								<table class='table table-striped'>
									<tr>
										<td>First Name</td>
										<td><input type='text' name='firstName' value='$user->firstName'></td>
									</tr>
									<tr>
										<td>Last Name</td>
										<td><input type='text' name='lastName' value='$user->lastName'></td>
									</tr>
									<tr>
										<td>Gender</td>
										<td><input type='text' name='gender' value='$user->gender'></td>
									</tr>
									<tr>
										<td>Email</td>
										<td><input type='text' name='email' value='$user->email'></td>
									</tr>
									<tr>
										<td>Phone Number</td>
										<td><input type='text' name='phoneNumber' value='$user->phoneNumber'></td>
									</tr>
									
									</table>
									
										<button type='submit' name='save' class='btn btn-success'>Save Profile Info</button>
										<button type='submit' name='cancel' class='btn btn-danger'>Cancel Editing</button>
									</form>";
							}
							else{
								$user = User::getUserByID($id);	
								$img = $user->getPicturePath();
								
								if(count($errors) > 0){
									echo "<div class='error bg-danger'>";
									echo "<ul>";
									foreach ($errors as $error) {
										echo "<li>$error</li>";
									}
									echo "</ul></div>";
								}
									
								echo "<h2 style='float: left'>Your Profile</h2>";
								echo "<div class='friendBtn'><form method='post' class='form'>
										<button type='submit' name='edit' class='btn btn-info'>Edit Profile Info</button>
									</form>
									</div>";
								echo "<div class='profilePic'><img src='$img'>
								</div>

								<form style='clear: both;' method='post' enctype='multipart/form-data'>
								<input type=\"file\" name='img'>
								<button type='submit' name='upload'>Upload Picture</button>
								</form><br />";

							echo "<table class='table table-striped'>
									<tr>
										<td>First Name</td>
										<td>$user->firstName</td>
									</tr>
									<tr>
										<td>Last Name</td>
										<td>$user->lastName</td>
									</tr>
									<tr>
										<td>Gender</td>
										<td>$user->gender</td>
									</tr>
									<tr>
										<td>Email</td>
										<td>$user->email</td>
									</tr>
									<tr>
										<td>Phone Number</td>
										<td>$user->phoneNumber</td>
									</tr>
									</table>";
									
							}
							//user's page
							//include_once("profileEdit.php");
						}
						else
						{
							//someone else's page 
							if(isset($_POST['remove'])){
							$u->removeFriend($id);
							}
							$name = $user->getName();
							$gender = $user->gender;
							echo "<h2 style='float: left'>$name</h2>";
							$user = User::getUserByID($id);	
								$img = $user->getPicturePath();
								
							if($u->isFriend($id)){
								echo "<div class='friendBtn'>
							<form method='post'>
							<button type='submit' name='remove' class='btn btn-danger' value='$id'>Remove friend</button>
							</form> 
							</div>";
							}else if($u->isRequestPending($id)){
								echo "<div class='friendBtn'><button type='submit' class='btn btn-success' disabled='disabled' name='disabled'>Friend request pending</div>";
							}else{
								echo "<div class='friendBtn'>
							<form method='post'>
							<button type='submit' class='btn btn-success' name='request' value='$id'>Send Friend Request</button>
							</form> 
							</div>";
							}
							echo "<div class='profilePic'><img src='$img'></div>";
							echo "<table class='table table-striped'>
									<tr>
										<td>First Name</td>
										<td>$user->firstName</td>
									</tr>
									<tr>
										<td>Last Name</td>
										<td>$user->lastName</td>
									</tr>
									<tr>
										<td>Gender</td>
										<td>$user->gender</td>
									</tr>
									<tr>
										<td>Email</td>
										<td>$user->email</td>
									</tr>
									<tr>
										<td>Phone Number</td>
										<td>$user->phoneNumber</td>
									</tr>
									</table>";


						}
					}
					else
					{
						//less detailed
						$user = User::getUserByID($id);	
								$img = $user->getPicturePath();
								$name = $user->getName();
						echo "<h2 style='float: left'>$name</h2>";
						echo "<div class='profilePic'><img src='$img'></div>";
						$gender = $user->gender;
						echo "<h3>Log in to see more info!</h3>";

					}
				}
				?>
			</div> <!-- end of leftConent  -->
			<?php include_once("friendsList.php");
				include_once("inc/rightContent.php"); ?>
		</div> <!-- end of row  -->
	</div> <!-- end of container  -->
<?php
	// include_once("friendsList.php");
	// include_once("inc/rightContent.php");
	include("inc/footer.php")
?>
