<?php
//Get the raw html.
$furl=trim($_GET["furl"]);
$raw = file_get_contents($furl);


echo $raw;
?>
