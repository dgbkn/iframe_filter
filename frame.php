<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

function parseUrl($url) {
    $r  = "^(?:(?P<scheme>\w+)://)?";
    $r .= "(?:(?P<login>\w+):(?P<pass>\w+)@)?";
    $r .= "(?P<host>(?:(?P<subdomain>[\w\.]+)\.)?" . "(?P<domain>\w+\.(?P<extension>\w+)))";
    $r .= "(?::(?P<port>\d+))?";
    $r .= "(?P<path>[\w/]*/(?P<file>\w+(?:\.\w+)?)?)?";
    $r .= "(?:\?(?P<arg>[\w=&]+))?";
    $r .= "(?:#(?P<anchor>\w+))?";
    $r = "!$r!";                                                // Delimiters
   
    preg_match ( $r, $url, $out );
   
    return $out;
}


//Get the raw html.
$furl=trim($_GET["furl"]);

$formattedurl = parseUrl($furl);

$pathwfile = $formattedurl['scheme']."://".$formattedurl['host'].$formattedurl['path'];
$domain = $formattedurl['scheme']."://".$formattedurl['host'];

$pathonly = str_replace($formattedurl['file'],"",$formattedurl['path']);
// echo "adsad ".$pathonly."  ".$formattedurl['file'];
$pathwofile = $formattedurl['scheme']."://".$formattedurl['host'].$pathonly;

// echo "Given Url is ????? ".$furl;
$raw = file_get_contents($furl);
$html = $raw;

$mydomain="https://flixe.herokuapp.com/";
$dom = new DOMDocument();
$dom->loadHTML($html);
$script = $dom->getElementsByTagName('script');

foreach($script as $item)
{
   if($item->getAttribute('src')) {
          $old = $item->getAttribute('src');
          
         if (strpos($old, '//') !== false) {
        $item->setAttribute('src',$mydomain."javascriptfilter.php?jurl=".$old);
         }
         else if($old[0]=='/'){
         $item->setAttribute('src',$mydomain."javascriptfilter.php?jurl=".$domain.$old);

         }else{
          $item->setAttribute('src',$mydomain."javascriptfilter.php?jurl=".$pathwofile.$old);
         }
    }
}


$html = $dom->saveHTML();

$raw = $html;

//Kill anoying popups.
$raw=str_replace("alert(","isNull(",$raw);
$raw=str_replace("window.open","isNull",$raw);
$raw=str_replace("prompt(","isNull(",$raw);
$raw=str_replace("Confirm: (","isNull(",$raw);

// Modify the javascript links so they go though a filter.
//$raw=str_replace("script type=\"text/javascript\" src=\"","script type=\"text/javascript\" src=\"".$mydomain."javascriptfilter.php?jurl=",$raw);
//$raw=str_replace("script src=","script src=".$mydomain."javascriptfilter.php?jurl=",$raw);

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
