<?php
// System
define( 'TTH_SYSTEM', true );
//----------------------------------------------------------------------------------------------------------------------
require_once(str_replace( DIRECTORY_SEPARATOR, '/', dirname( __file__ ) ) . '/define.php');
//str_replace( DIRECTORY_SEPARATOR, '/', dirname( __file__ ) ); đường dẩn chuẩn cho web
require_once(ROOT_DIR . DS ."lang" . DS . TTH_LANGUAGE . ".lang");
//echo ROOT_DIR . DS ."lang" . DS . TTH_LANGUAGE . ".lang";
include_once(_F_FUNCTIONS . DS . "Function.php");
try {
	$db =  new ActiveRecord(TTH_DB_HOST, TTH_DB_USER, TTH_DB_PASS, TTH_DB_NAME);
	//chuyen source giong cau dung mau
	//bd laf cais bang lay 
	//
}
catch(DatabaseConnException $e) {
	echo $e->getMessage();
}
 if(!isset($_GET['id_menu']))
 	$id_menu = 1;

 else $id_menu = (int)$_GET['id_menu'];

 echo getSlugMenu($id_menu, "article");

