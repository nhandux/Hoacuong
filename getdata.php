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
}
catch(DatabaseConnException $e) {
	echo $e->getMessage();
}
 
 $account["id"] = empty($_SESSION["user_id"]) ? 0 : $_SESSION["user_id"]+0;
include_once(_F_INCLUDES . DS . "_tth_constants.php");
include_once(_F_INCLUDES . DS . "_tth_url.php");
include_once(_F_INCLUDES . DS . "_tth_online_daily.php");

include_once(_F_CLASSES . DS . "DateClass.class.php");
include_once(_F_CLASSES . DS . "String.class.php");
$date = new DateClass();


$stringObj = new String();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$limit = 1;

  		$start = ($page - 1) * $limit;
        $start = $start + 4; 

$rows = getLimitArticleItem(353, $start, $limit);
foreach ($rows as $row) {
 ?>
	 <div class="item">
	<div class="box">
		<div class="img"><img src="<?php echo '/uploads/article/'.$row['img'];  ?>"></div>
		<div class="comment">
			<h2><a href="<?php echo 'tin-tuc/'.getSlugMenu($row['article_menu_id'], 'article') . '/' . $stringObj->getLinkHtml($row['name'], $row['article_id']);  ?>"><?= $row['name'];?></a></h2>

          <p class="time"><?php echo  $date->vnFull($row['created_time']) ?></p>	
			<p><?= $stringObj->crop(stripslashes($row['comment']), 60);?></p>
			<a href="<?php echo 'tin-tuc/'.getSlugMenu($row['article_menu_id'], 'article') . '/' . $stringObj->getLinkHtml($row['name'], $row['article_id']);  ?>"> <span class="spanxemtieptin"> xem tiếp <i class="fa fa-angle-double-right"></i></span></a>
		</div>
	</div>
</div> 
<?php
}
sleep(1)
?>
