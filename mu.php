<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Get the raw html.
$furl= $_GET["url"];
$raw = file_get_contents($furl);
$m3u  =  preg_match('(https.*?\.m3u8[^&">]+)',$raw);


echo $m3u;
?>
