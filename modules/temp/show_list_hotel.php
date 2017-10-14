<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }

$photo_avt = '';
$alt = ($row['img_note']!="") ? stripslashes($row['img_note']) : stripslashes($row['name']);
if($row['img']!="" && $row['img']!="no") {
	$photo_avt = '<img src="'. HOME_URL .'/uploads/article/hotel-'. $row['img'] . '" alt="' . $alt . '" />';
	$photo_avt = '<a href="'. HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['article_menu_id'], 'article') . '/' . $stringObj->getLinkHtml($row['name'], $row['article_id']) . '" title="' . stripslashes($row['name']) . '">' . $photo_avt . '</a>';
} else {
	$photo_avt = '<img src="'. HOME_URL .'/images/404-hotel.jpg" alt="'.$alt.'" />';
	$photo_avt = '<a href="'. HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['article_menu_id'], 'article') . '/' . $stringObj->getLinkHtml($row['name'], $row['article_id']) . '" title="' . stripslashes($row['name']) . '">' . $photo_avt . '</a>';
}
?>

<div class="col-2">
	<div class="img">
		<?php echo $photo_avt; ?>
	</div>
	<div class="comment">
		<h4>
			<a href="<?php echo HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['article_menu_id'], 'article') . '/' .  $stringObj->getLinkHtml($row['name'], $row['article_id'])?>" title="<?php echo stripslashes($row['name']); ?>" ><?php echo stripslashes($row['name']); ?></a>
		</h4>
		<p>* <?php echo $stringObj->crop(stripslashes($row['comment']), 50);?></p>
	</div>
</div>