<?php
	require_once("lib/util.php");
	require_once("lib/user.php");
	// echo '<div class="friendsList">';
	echo "<div class='col-md-3 col-lg-3 col-sm-3 friendsList'>";

	if(Util::isLoggedIn()):
		$user = Util::getLoggedInUser();
		
		if(isset($_POST['accept'])){
		//friend request accepted
			$rID = $_POST['accept'];
			$test = $user->acceptFriendRequest($rID);
			//header('Location: index.php'); //this is so the page reloads and the pending request disappears
		}
		if(isset($_POST['deny'])){
		//friend request denied
			$rID = $_POST['deny'];
			$user->denyFriendRequest($rID);
			//header('Location: index.php'); //this is so the page reloads and the pending request disappears
		}
		$pending = $user->getUsersFriendRequests();
		if(!empty($pending))
		{
			echo '<div class="user-list">';
				echo '<h4>These members want to be friends:</h4>';
				foreach($pending as $p)
				{
					$name = $p->getName();
					$path = $p->getPicturePath();
					echo "<div class=\"profile-thumb\">
							
								<a href=\"profile.php?userID=$p->userID\">
								<img style='float: left; margin-right: 10px;' src=\"$path\" alt=\"$name\"/></a>
							
							<div style='float: left;'>
								<a href=\"profile.php?userID=$p->userID\"><h3>$name</h3></a>
								<form method='post' class='form-inline'>
							<button type='submit' name='accept' class='btn btn-success' value='$p->requestID'>Accept Request</button>
							<button type='submit' name='deny' class='btn btn-danger' value='$p->requestID'>Deny Request</button>
							</form>
							</div>
						
					</div>";
				}
			echo "</div>";
		}
		echo "<div style='clear: both; margin-bottom: 20px;'></div>";
		$friends = $user->getFriends();
		if(!empty($friends))
		{
			echo '<div class="user-list">';
				echo "<h4>Your Friends</h4>";
				foreach($friends as $friend)
				{
					$name = $friend->getName();
					$path = $friend->getPicturePath();
					echo "<div class=\"profile-thumb\">
						<a href=\"profile.php?userID=$friend->userID\">
							<img style='float: left; margin-right: 10px;' src=\"$path\" alt=\"$name\"/>
							<div style='float: left;'>
								<h3>$name</h3>
							</div>
						</a>
					</div>";
				}
			echo "</div>";
		}
		else
		{
			echo '<p class="recruitment"> You have no friends to display. =(</p>';
		}
	?>
			
	<?php else: ?>
		<p class="recruitment">Join today and see your friends here!</p>
	<?php endif; ?>

	</div>