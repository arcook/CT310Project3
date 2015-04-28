<!-- <div class="rightContent"> -->
<div class="col-md-3 col-lg-3 col-sm-3 rightContent">
	<h4>All Users</h4>
	<?php
		include_once("lib/user.php");
		$userlist = User::getAll();
				
		echo '<div class="user-list">';

		foreach($userlist as $user) {
			$path = $user->getPicturePath();
			$name = $user->getName();
			echo "<div class=\"profile-thumb\">
						<a href=\"profile.php?userID=$user->userID\">

							<img src=\"$path\" alt=\"$name\"/>
							<span>$name</span>
						</a>
				</div>";
		}
		
		echo '</div>';
		echo "<div style='clear: both;'></div>";
	?>			
</div>