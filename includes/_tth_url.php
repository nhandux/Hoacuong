<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }

$slug_cat = empty($path[1]) ? 'home' : $path[1];
if($slug_cat=='danaweb') {
	exit(header('Location: ' . HOME_URL . ADMIN_DIR));
} else if(!file_exists(_F_MODULES . DS .  str_replace('-','_',$slug_cat) . ".php")) {
	$slug_cat = '-error-404';
}
$id_menu = empty($path[2]) ? 0 : getIdMenu($slug_cat, $path[2]);
$id_article = getIdArticle((empty($path[3]))? 0 : $path[3]);
$page   = (isset($_GET['p'])) ? $_GET['p'] : 0;



