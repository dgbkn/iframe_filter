       <?php
function get_domain($url)
{
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $regs['domain'];
  }
  return false;
}


//Get the raw html.
$furl=trim($_GET["furl"]);
// echo "Given Url is ????? ".$furl;
$raw = file_get_contents($furl);

$mydomain="https://flixe.herokuapp.com/";

//Kill anoying popups.
$raw=str_replace("alert(","isNull(",$raw);
$raw=str_replace("window.open","isNull",$raw);
$raw=str_replace("prompt(","isNull(",$raw);
$raw=str_replace("Confirm: (","isNull(",$raw);

// Modify the javascript links so they go though a filter.
$raw=str_replace("script type=\"text/javascript\" src=\"","script type=\"text/javascript\" src=\"".$mydomain."javascriptfilter.php?jurl=",$raw);
$raw=str_replace("script src=","script src=".$mydomain."javascriptfilter.php?jurl=",$raw);

// $raw = str_replace("domicileperil.com","lol.com",$raw);
//Or kill js files
//$raw=str_replace(".js",".off",$raw);

//Put in a base domain tag so images, flash and css are certain to work.
$replacethis="<head>";
$replacestring="<head><base href='".$furl."/'>";
$raw=str_replace($replacethis,$replacestring,$raw);

//Echo the website html to the iframe.
echo $raw;



?>
