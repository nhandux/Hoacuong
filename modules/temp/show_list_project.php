<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }

$photo_avt = '';
$alt = ($row['img_note']!="") ? stripslashes($row['img_note']) : stripslashes($row['name']);
if($row['img']!="" && $row['img']!="no") {
	$photo_avt = '<img src="'. HOME_URL .'/uploads/article/pj-'. $row['img'] . '" alt="' . $alt . '" />';
	$photo_avt = '<a href="'. HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['article_menu_id'], 'article') . '/' . $stringObj->getLinkHtml($row['name'], $row['article_id']) . '" title="' . stripslashes($row['name']) . '">' . $photo_avt . '</a>';
} else {
	$photo_avt = '<img src="'. HOME_URL .'/images/not-found.png" alt="'.$alt.'" />';
	$photo_avt = '<a href="'. HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['article_menu_id'], 'article') . '/' . $stringObj->getLinkHtml($row['name'], $row['article_id']) . '" title="' . stripslashes($row['name']) . '">' . $photo_avt . '</a>';
}
?>
<div class="box-item it-<?php echo $i;?>">
	<div class="img">
		<?php echo $photo_avt; ?>
	</div>
	<div class="more-info">
		<h4>
			<a href="<?php echo HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['article_menu_id'], 'article') . '/' .  $stringObj->getLinkHtml($row['name'], $row['article_id'])?>" title="<?php echo stripslashes($row['name']); ?>" ><?php echo stripslashes($row['name']); ?><i class="fa fa-angle-right"></i></a>
		</h4>
	</div>
</div>

<?php
if($i==7) {
	$i = 0;
}
