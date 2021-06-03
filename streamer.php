<?php

 // Turn off output buffering
ini_set('output_buffering', 'off');
// Turn off PHP output compression
ini_set('zlib.output_compression', false);
		
//Flush (send) the output buffer and turn off output buffering
//ob_end_flush();
while (@ob_end_flush());
		
// Implicitly flush the buffer(s)
ini_set('implicit_flush', true);
ob_implicit_flush(true);



$url = $_GET['url'];
$ts_content = file_get_contents($url);
$ts_content = explode(',', $ts_content);
$ts_file = array();
foreach ($ts_content as $key => $value) {
	if($key == 0) continue;
	$value = trim($value);
	$ts_file[] = substr($value, 0, strpos($value, '.ts') + 3);
}
$url_prefix = substr($url, 0, strpos($url, '.m3u8'));
$url_prefix = substr($url, 0, strrpos($url, '/') + 1);
$file_content = '';
foreach ($ts_file as $key => $value) {
	$file_content .= file_get_contents($url_prefix . $value);
}
 
file_put_contents('tmp_out.ts', $file_content);

