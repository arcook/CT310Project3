<?php
	$title = "Home";
	
	include("inc/header.php");	
	$util = new util();
	// global $lastPage;
	$_SESSION['lastPage'] = 'index.php';
	//var_dump($util->isIpValid());
	Util::clearPartialLogin();
?>
<div class="container-fluid">
 <div class="row">
	<!-- <div class="page-wrap"> 
		<div class="leftContent">-->
		<div class="col-md-6 col-lg-6 col-sm-6 leftContent">
			<h2>Welcome to Awesome Possum's Social Network</h2>
			<p>This social network does things adequately occassionally</p> 
					
			<hr/>
					
			<h2>Feed</h2>
			<p>Someone is friends with someone else</p>
			<hr/>
		</div>
		<?php include("friendsList.php"); 
		include("inc/rightContent.php");?>
	</div>
</div>
	<?php
		// include_once("friendsList.php");
		// include_once("inc/rightContent.php");
		include("inc/footer.php");
	?>