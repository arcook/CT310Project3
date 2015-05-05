<?php
/**
 * Created by PhpStorm.
 * User: menghini
 * Date: 5/5/15
 * Time: 12:47 PM
 */

header('Content-type: text/json');
//header('Content-Type; text/json');
$sitePurpose=array("purpose"=>"We are FacePlace!");
echo json_encode($sitePurpose);

?>