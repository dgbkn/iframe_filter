<?php
//Get the raw html.
$furl="https://voe.sx/e/".$_GET["id"]);
$raw = file_get_contents($furl);


echo $raw;
?>
