<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//

$sumView = 0;
$db->table = "article";
$db->condition = "is_active = 1 and article_id = ".$id;
$db->order = "";
$db->limit = "";
$rows = $db->select();
if($db->RowCount>0){
	foreach($rows as $row) {
		$db->table = "article";
		$db->condition = "is_active = 1 and article_menu_id = ".($row['article_menu_id']+0).' and article_id <> '.$id;
		$db->order = "created_time DESC";
		$db->limit = 5;
		$rows2 = $db->select();
		$total = $db->RowCount;

		$photo_avt = '';
		if($row['img']!="" && $row['img']!="no") {
			$photo_avt = '<a class="fancy-box" href="'. HOME_URL .'/uploads/article/'. $row['img'] . '" title="' . stripslashes($row['name']) . '"><img src="'. HOME_URL .'/uploads/article/'. $row['img'] . '" alt="' . stripslashes($row['name']) . '" /></a>';
		}
?>
<div class="wrap-con clearfix">
	<div class="social-share">
		<input type="checkbox" class="checkbox" id="share">
		<label for="share" class="label fa fa-share-alt" title="Share social buttons"></label>
		<div class="social">
			<ul>
				<li onclick="javascript:window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo site_url()?>','_blank')" class="fa fa-facebook"></li>
				<li onclick="javascript:window.open('https://twitter.com/intent/tweet?source=webclient&text=DANAWEB&url=<?php echo site_url()?>&hashtags=danaweb','_blank')" class="fa fa-twitter"></li>
				<li onclick="javascript:window.open('https://plus.google.com/share?url=<?php echo site_url()?>','_blank')" class="fa fa-google-plus"></li>
			</ul>
		</div>
	</div>
	<div class="pj-post f-space15 clearfix">
		<div class="pj-left">
			<?php echo $photo_avt;?>
		</div>
		<div class="pj-right">
			<h3 class="title-dl"><?php echo stripslashes($row['name']);?></h3>
			<div class="con-wp f-space10"><?php echo stripslashes($row['content']); ?></div>
			<div class="social-like clearfix">
				<div class="item-social">
					<div class="fb-like" data-href="<?php echo site_url()?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
				</div>
				<div class="item-social">
					<a href="<?php echo site_url()?>" class="twitter-share-button"{count} data-hashtags="danaweb">Tweet</a>
				</div>
				<div class="item-social">
					<div class="g-plusone" data-href="<?php echo site_url()?>" data-size="medium" data-annotation="bubble" data-width="50"></div>
				</div>
			</div>
			<div class="fb-comments" data-href="<?php echo site_url()?>" data-width="100%" data-numposts="5"></div>
		</div>
	</div>
</div>

<?php
		$sumView = $row['views']+1;
	}
	$db->table = "article";
	$data = array(
		'views'=>$sumView
	);
	$db->condition = "article_id = ".$id;
	$db->update($data);

}
else include(_F_MODULES . DS . "error_404.php");