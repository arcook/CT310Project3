<?php
	$title = "Search Users";
	$userName = isset($_GET['user']) ? $_GET['user'] : "";

	include("inc/header.php");
	include_once("lib/user.php");
	// global $lastPage;
	$_SESSION['lastPage'] =  "search.php";
	Util::clearPartialLogin();
?>
 			<!-- <div class="leftContent"> -->
 			<div class="container-fluid">
 			<div class="row">
 			<div class="col-md-6 col-lg-6 col-sm-6  leftContent">
				<h2>Userlist</h2>				
				<hr/>

				<div id="search-list">
					<?php
						$userlist = User::getAll();
						foreach($userlist as $user)
						{
							$path = $user->getPicturePath();
							$name = $user->getName();
							echo "<div class=\"profile-thumb\">
											<a href=\"profile.php?userID=$user->userID\">
												<img src=\"$path\" alt=\"$name\"/>
												<span>$name</span>
											</a>
									</div>";

						}
					?>
				</div>
			</div>

<?php
	include_once("friendsList.php");
	include_once("inc/rightContent.php");
?>
</div>
</div>
<?php include("inc/footer.php"); ?>