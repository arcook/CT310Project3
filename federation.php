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
                <h1>Test</h1>
                <script>



                    function getPurpose(url) {
                        $.get(url+"/purpose.php",{}, function(data, status){
                            var x=data;
                            //var x=JSON.parse('"'+data+'"');
                            console.log(x.purpose);
                        });
//
                    }

                    /*
                            var request = $.ajax({
                                method: "GET",
                                url: "http://www.cs.colostate.edu/~menghini/CT310/Project3/purpose.php",
                                //data: {},
                                dataType: 'application/json; charset=utf-8'});
                        request.done(function( msg ) {
                                    console.log("here");
                                    //var x = jQuery.parseJSON(msg);

                                    //alert("Data Saved: ");
                                });
                        request.fail(function( jqXHR, textStatus ) {
                            console.log( "Request failed: " + textStatus);
                            console.log(jqXHR);
                        });


                            //xmlhttp.send();
                        }
                        */

                </script>

                <div id="myDiv"><h2 onmouseover="getPurpose(' ')">Let AJAX change this text</h2></div>
                <!--<button type="button" onclick="loadXMLDoc()">Change Content</button>-->

                <script src="https://code.jquery.com/jquery-1.10.2.js"></script>




                <?php if(Util::isLoggedIn())
                {
                    ?>
                    <h2>The Federation</h2>
                    <br>Stuff will go here. You are logged in.</br>
                    <?php
                }
                else {
                    ?>
                    <h2>The Federation</h2>
                    <br>Stuff will go here. You are NOT logged in.</br>
                    <?php
                }
                ?>

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