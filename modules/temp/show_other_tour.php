<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }

$photo_avt = '';
$alt = ($row2['img_note']!="") ? stripslashes($row2['img_note']) : stripslashes($row2['name']);
if($row2['img']!="" && $row2['img']!="no") {
	$photo_avt = '<img src="'. HOME_URL .'/uploads/tour/tour-'. $row2['img'] . '" alt="' . $alt . '" />';
	$photo_avt = '<a href="'. HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row2['tour_menu_id'], 'tour') . '/' . $stringObj->getLinkHtml($row2['name'], $row2['tour_id']) . '" title="' . stripslashes($row2['name']) . '">' . $photo_avt . '</a>';
} else {
	$photo_avt = '<img src="'. HOME_URL .'/images/404-tour.jpg" alt="'.$alt.'" />';
	$photo_avt = '<a href="'. HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row2['tour_menu_id'], 'tour') . '/' . $stringObj->getLinkHtml($row2['name'], $row2['tour_id']) . '" title="' . stripslashes($row2['name']) . '">' . $photo_avt . '</a>';
}

$sale = $price = '';
if($row2['hot']>0) $sale = '<div class="_hot">&nbsp;</div>';
if($row2['sale']>0) $sale = '<div class="_sale">&nbsp;</div>';
if($row2['price']>0) $price = $lgTxt_price . ' <span class="price">' . formatNumberVN($row2['price']) . $lgTxt_price_unit . '</span>';
else $price = $lgTxt_price . ' <span class="price">' . $lgTxt_price_contact . '</span>';
?>

<div class="col-1">
	<?php echo $sale;?>
	<div class="img">
		<?php echo $photo_avt; ?>
	</div>
	<div class="post">
		<div class="comment">
			<p>
				<a href="<?php echo HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row2['tour_menu_id'], 'tour') . '/' .  $stringObj->getLinkHtml($row2['name'], $row2['tour_id'])?>" title="<?php echo stripslashes($row2['name']); ?>"><?php echo stripslashes($row2['name']);?></a>
			</p>
			<p><?php echo $price;?></p>
		</div>
		<div class="detail">
			<p>
				<a href="<?php echo HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row2['tour_menu_id'], 'tour') . '/' .  $stringObj->getLinkHtml($row2['name'], $row2['tour_id'])?>" title="<?php echo stripslashes($row2['name']); ?>"><?php echo stripslashes($row2['date_schedule']);?></a>
			</p>
		</div>
	</div>
</div>