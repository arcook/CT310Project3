<?php
$title = "Home";
$fedKey = "WQT3xKmVV7";

$temp = file_get_contents("http://www.cs.colostate.edu/~ct310/yr2015sp/project/roster.php?key=$fedKey");
if($temp !== FALSE)
    {
    $raw = explode("},", $temp);
    $roster = array();
    foreach($raw as $k => $r)
    {
        $temp = explode(",", $r);
        $nameTemp = strpos($temp[0], ":");
        $urlTemp = strpos($temp[1], ":");
        $name = substr($temp[0], $nameTemp+1);
        $url = substr($temp[1], $urlTemp+1);
        $url = str_replace("}]", "", $url);
        $roster[$k] = array("name" => $name, "url" => $url);
    }
}
else
{
    $roster = array();
}
include("inc/header.php");
$util = new util();
// global $lastPage;
$_SESSION['lastPage'] = 'index.php';
//var_dump($util->isIpValid());
Util::clearPartialLogin();
?>
<script>
    function getPurpose(url) {
        $("#purpose").val('');
        $("#purpose").addClass("hidden");
        $.get(url+"/purpose.php",{}, function(data, status){
            if(data.purpose !== undefined)
            {
                $("#purpose").val(data.purpose);
                $("#purpose").removeClass("hidden");
            }
        });
}
</script>
    <div class="container-fluid">
        <div class="row">
            <!-- <div class="page-wrap">
                <div class="leftContent">-->
            <div class="col-md-6 col-lg-6 col-sm-6 leftContent">
                <h2>The Federation</h2>
                <table id="fedTable">
                    <?php
                        foreach($roster as $key => $value)
                        {
                            $name = str_replace('"', "", $value['name']);
                            $url = $value['url'];
                            $x = " ";
                            if(Util::isLoggedIn())
                            {

                                echo "<tr><td onmouseover='getPurpose($url)' onmouseout='getPurpose($x)';'><a href=$url>$name</td></a></tr>";
                            }
                            else
                            {
                                echo "<tr><td><a href=$url>$name</td></a></td></tr>";
                            }
                        }
                    ?>
                </table>
                <?php 
                    if(Util::isLoggedIn())
                        echo '<textarea id="purpose" class="hidden"></textarea>';
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