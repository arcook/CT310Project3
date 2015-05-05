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
                <h2>The Federation</h2>
                <br>Stuff will go here.</br>
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