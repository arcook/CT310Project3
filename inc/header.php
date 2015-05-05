<?php
	require_once("./lib/config.php");
	include_once("./lib/util.php");
	global $title;
	// echo "the title is: $title.";
	// Util::clearPartialLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	 <meta charset="UTF-8">
	 <meta name="author" content="Andrew Cook, Travis Menghini, Brad Alberts" />
	 <meta name="description" content="Ct310 Project 3" />
	 <meta name="keywords" content="Fake Social Network" />
	 <link href="//www.cs.colostate.edu/~ct310/yr2015sp/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 <title><?php echo $title ?> -  FacePlace</title>
	 <link rel="stylesheet" type="text/css" href="assets/css/style.css">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>
	<header>
	<div class="container header-title">
    	<div class="group-title pull-left">
    		<a href='index.php'>
    		<img src='assets/img/icon.png' alt='FacePlace Logo' class="hidden-xs" width="50">
    		FacePlace</a>
    	</div>
    	<div class="pull-right">
        	<?php if($title !== "Login")
			{
				if(Util::isLoggedIn())
				{
					echo Util::getLogoutBox();
				}
				else
				{
					echo Util::getLoginBox();
					
				}
		}
		?>	
        </div>
    </div>
    <nav class="navbar navbar-inverse" role="navigation">
    	<!-- <ul class="nav navbar-nav">
    	<li><a href="index.php">Home</a></li>
         <li><a href="search.php">Search</a></li>
         <?php
         			$user = Util::getLoggedInUser();
         			if($user != null){
         				echo "<li><a href='profile.php?userID=$user->userID'>Your Profile</a></li>";
         			}
					if(Util::isLoggedIn() && Util::isAdmin())
					{
						echo '<li><a id="admin-page" href="admin.php">Admin</a></li>';
					}
				?>
          </ul> -->
          <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="search.php">Search</a></li>
         <?php
         			$user = Util::getLoggedInUser();
         			if($user != null){
         				echo "<li><a href='profile.php?userID=$user->userID'>Your Profile</a></li>";
         			}
					if(Util::isLoggedIn() && Util::isAdmin())
					{
						echo '<li><a id="admin-page" href="admin.php">Admin</a></li>';
					}
				?>
<<<<<<< HEAD
              <li><a href="federation.php">The Federation</a></li>
          </ul>

=======
          </ul>
>>>>>>> 79289e9dcc2679ab4cf19f414cb9816924ca00d6
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	</header>
	<main>