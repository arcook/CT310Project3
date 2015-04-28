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
			<h2>Welcome to Group 7 Social Network</h2>
			<p>This social network... Suspendisse sodales accumsan erat a luctus. Nulla interdum elit vitae ultricies commodo. Suspendisse dignissim dolor vel accumsan hendrerit. Cras pharetra suscipit odio, quis pharetra nunc dignissim ultrices. Integer consectetur gravida fermentum. Ut tempus sem vel libero mollis, tincidunt vulputate leo fringilla. Proin ut orci vulputate, condimentum orci eu, convallis dolor. Quisque mattis, diam vitae elementum rutrum, turpis orci rutrum orci, vel maximus felis sapien sit amet nisl. Aliquam lacinia nisl eu pulvinar accumsan. Proin quis nisl sed nisi placerat molestie. In sagittis rhoncus mauris et hendrerit. Nunc vitae augue nec ante fermentum rutrum. In hac habitasse platea dictumst. Ut sit amet quam nulla.</p>
					
			<hr/>
					
			<h2>Feed</h2>
			<p>X is now friend of Y... Suspendisse sodales accumsan erat a luctus. Nulla interdum elit vitae ultricies commodo. Suspendisse dignissim dolor vel accumsan hendrerit. Cras pharetra suscipit odio, quis pharetra nunc dignissim ultrices. Integer consectetur gravida fermentum. Ut tempus sem vel libero mollis, tincidunt vulputate leo fringilla. Proin ut orci vulputate, condimentum orci eu, convallis dolor. Quisque mattis, diam vitae elementum rutrum, turpis orci rutrum orci, vel maximus felis sapien sit amet nisl. Aliquam lacinia nisl eu pulvinar accumsan. Proin quis nisl sed nisi placerat molestie. In sagittis rhoncus mauris et hendrerit. Nunc vitae augue nec ante fermentum rutrum. In hac habitasse platea dictumst. Ut sit amet quam nulla.</p>
					
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