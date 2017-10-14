<?php
@session_start();
// System
define( 'TTH_SYSTEM', true );
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$path = array();
$path = explode('/',$url);
//explode : tách chuổi
if($path[0]=='en') {
	$_SESSION["language"] = 'en';
} elseif($path[0]=='vi') {
	$_SESSION["language"] = 'vi';
} else {
	$_SESSION["language"] = 'vi';
	array_unshift($path, 'vi');
	//đưa vi vào đầu pash
}
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

$account["id"] = empty($_SESSION["user_id"]) ? 0 : $_SESSION["user_id"]+0;
include_once(_F_INCLUDES . DS . "_tth_constants.php");
include_once(_F_INCLUDES . DS . "_tth_url.php");
include_once(_F_INCLUDES . DS . "_tth_online_daily.php");

?>

<!DOCTYPE html>
<html lang="<?php echo TTH_LANGUAGE;?>">
<head>
	<?php
	include(_F_INCLUDES . DS . "_tth_head.php");
	include(_F_INCLUDES . DS . "_tth_script.php");
	?>
</head>
<body>

<?=getConstant('script_body')?>
<!-- #wrapper -->
<div id="wrapper">
	<?php
	include(_F_INCLUDES . DS . "tth_header.php");
	include(_F_INCLUDES . DS . "tth_slider.php");
	?>
	<!-- .container -->
	<section class="container">
 		<?php
		include(_F_MODULES . DS .  str_replace('-','_',$slug_cat) . ".php");
		?>
	</section>
	<!-- / .container -->
	<?php
	include(_F_INCLUDES . DS . "tth_footer.php");
	include(_F_INCLUDES . DS . "tth_menu_sm.php");
	?>
</div>
<!-- / #wrapper -->
<a href="javascript:void(0)" title="Lên đầu trang" id="go-top"></a>
<div id="_loading"></div>
<?php
echo getConstant('script_bottom');
//if($slug_cat=='home'){ require_once("popup" . DS . "popup.php");}
?>
<!-- <script src="https://uhchat.net/code.php?f=3b7336"></script>
 -->
<script lang="javascript">(function() {var pname = ( (document.title !='')? document.title : document.querySelector('h1').innerHTML );var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async=1; ga.src = '//live.vnpgroup.net/js/web_client_box.php?hash=9c3ca153087e1097590b99ac1b90ef3f&data=eyJoYXNoIjoiOTJlOGYyODMzMmMyMmNmNDdlZmY5ZDE0NWFhN2Y4NTMiLCJzc29faWQiOjQ5MDQ0MTB9&pname='+pname;var s = document.getElementsByTagName('script');s[0].parentNode.insertBefore(ga, s[0]);})();</script>	
</body>
</html>