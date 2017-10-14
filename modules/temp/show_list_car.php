<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }

$photo_avt = '';
$alt = ($row['img_note']!="") ? stripslashes($row['img_note']) : stripslashes($row['name']);
if($row['img']!="" && $row['img']!="no") {
	$photo_avt = '<img src="'. HOME_URL .'/uploads/car/car-'. $row['img'] . '" alt="' . $alt . '" />';
	$photo_avt = '<a href="'. HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['car_menu_id'], 'car') . '/' . $stringObj->getLinkHtml($row['name'], $row['car_id']) . '" title="' . stripslashes($row['name']) . '">' . $photo_avt . '</a>';
} else {
	$photo_avt = '<img src="'. HOME_URL .'/images/404-car.jpg" alt="'.$alt.'" />';
	$photo_avt = '<a href="'. HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['car_menu_id'], 'car') . '/' . $stringObj->getLinkHtml($row['name'], $row['car_id']) . '" title="' . stripslashes($row['name']) . '">' . $photo_avt . '</a>';
}

$sale = $price = '';
if($row['hot']>0) $sale = '<div class="_hot">&nbsp;</div>';
if($row['sale']>0) $sale = '<div class="_sale">&nbsp;</div>';
if($row['price']>0) $price = $lgTxt_price . ' <span class="price">' . formatNumberVN($row['price']) . $lgTxt_price_unit . '</span>';
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
				<a href="<?php echo HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['car_menu_id'], 'car') . '/' .  $stringObj->getLinkHtml($row['name'], $row['car_id'])?>" title="<?php echo stripslashes($row['name']); ?>"><?php echo stripslashes($row['name']);?></a>
			</p>
			<p><?php echo $price;?></p>
		</div>
		<div class="detail">
			<p>
				<a href="<?php echo HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['car_menu_id'], 'car') . '/' .  $stringObj->getLinkHtml($row['name'], $row['car_id'])?>" title="<?php echo stripslashes($row['name']); ?>"><?php echo stripslashes($row['seat']);?></a>
			</p>
		</div>
	</div>
</div>