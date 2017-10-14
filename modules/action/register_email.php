<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
if(isset($_POST['email'])) {
	$txt_email = $_POST['email'];
	if(empty($HTTP_X_FORWARDED_FOR)) $IP_NUMBER = getenv("REMOTE_ADDR");
	else $IP_NUMBER = $HTTP_X_FORWARDED_FOR;
	//---------
	$db->table = "register_email";
	$data = array(
		'email'=>$db->clearText($txt_email),
		'ip'=>$db->clearText($IP_NUMBER),
		'created_time'=>time()
	);
	$db->insert($data);
	$id_query = $db->LastInsertID;
	if($id_query > 0)
		echo $txtEmail_sendOk;
	else
		echo $txtEmail_sendDie;


}