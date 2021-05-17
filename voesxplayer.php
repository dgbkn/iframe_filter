<?php
//Get the raw html.
$furl="https://voe.sx/e/". $_GET["url"];
$raw = file_get_contents($furl);
$m3u  =  preg_match('(http.*?\.m3u8[^&">]+)',$raw);


echo $m3u;
?>
