<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Get the raw html.
$furl= $_GET["url"];
$raw = file_get_contents($furl);
preg_match_all('/"([^"]+)"/', $raw, $m);
$m3u  =  preg_match('(https.*?\.m3u8[^&">]+)',$raw);
preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $raw, $match);

echo "<pre>";
print_r($match[0]); 
echo "</pre>";


echo "<pre>";
print_r($m[0]); 
echo "</pre>";


echo $raw;
?>
