<?php
ob_start("ob_gzhandler");
header("Content-type: text/css; charset: UTF-8");
header("Cache-Control: must-revalidate");
$offset = 60 * 60 ;
$expStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
header($expStr);

$pathToCSS = './';

if($files = glob($pathToCSS .'*.css')) {
	foreach($files as $file) {
		$info = pathinfo($file);
		if ($info['basename'][0] == '+')
		{
			continue;
		}
		echo file_get_contents($file);
	}
}