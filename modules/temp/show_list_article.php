<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }

$photo_avt = '';
$alt = ($row['img_note']!="") ? stripslashes($row['img_note']) : stripslashes($row['name']);
if($row['img']!="" && $row['img']!="no") {
	if($slug_cat == "san-pham" && isset($row['parent']))
	$photo_avt = '<img src="'. HOME_URL .'/uploads/article_menu/post-'. $row['img'] . '" alt="' . $alt . '">';
    else $photo_avt = '<img src="'. HOME_URL .'/uploads/article/post-'. $row['img'] . '" alt="' . $alt . '">';
} else {
	$photo_avt = '<img src="'. HOME_URL .'/images/404.jpg" alt="'.$alt.'">';
}
$time = '';
if(in_array($slug_cat, array('news-event','tin-tuc'))) {
	$time = ' <p class="time">' . $date->vnFull($row['created_time']) . '</p>';
}
else if(in_array($slug_cat, array('du-an'))) {
	$time = ' <p class="time"> Cập nhập <span style="text-transform:lowercase">' . $date->vnFull($row['created_time']) . '</span></p>';
} else { $time = ''; }

$photo_avt = '<a href="'. HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['article_menu_id'], 'article') . '/' . $stringObj->getLinkHtml($row['name'], $row['article_id']) . '" >' . $photo_avt . '</a>';
$title = '<h2><a href="'. HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['article_menu_id'], 'article') . '/' . $stringObj->getLinkHtml($row['name'], $row['article_id']) . '" title="' . stripslashes($row['name']) . '">' . stripslashes($row['name']) . '</a></h2>';
$linkxemtiep
?>
<?php 
  if($slug_cat == 'san-pham')
  {
?>
<div class="item-ga">
	<div class="box producted" >
		<div class="img hinhanhsanpham">
		   <?php if(isset($row['parent'])) echo '<span class="spantrenanh"><i class="fa fa-shopping-bag" aria-hidden="true"></i> '.countArticalitem($row['article_menu_id']).' SP</span>'?>
			<?php echo $photo_avt; ?>
			
		</div>
		<div class="tooltip">
			<div class="nametooltip">
				<?php echo $title; ?>
				
		<?php if(isset($row['parent'])){ ?>
				<span class="sanphamtip"> <?= countArticalitem($row['article_menu_id']) ?></span> <span class="sanphamtoll">sản phẩm</span>
		<?php } ?>
        <?php if(isset($row['article_id'])){ ?>
				<span class="sanphamtip"> <?=  $date->vnFull($row['created_time'])  ?></span> 
		<?php } ?>  
			</div>
			<div class="noidungtooltip">
				<?php echo $stringObj->crop(stripslashes($row['comment']), 60);?>
			</div>
		</div>
		<div class=" chuasanpham comment daylatitle"><h3 class="nhomtintuc"><?php echo $title; ?></h3></div>
	</div>
</div>
<?php }
	else{
	?>
 <div class="item">
	<div class="box">
		<div class="img"><?php echo $photo_avt; ?></div>
		<div class="comment">
			<?php echo $title;?>

			<?php echo $time;?>
			<p><?php echo $stringObj->crop(stripslashes($row['comment']), 60);?>
				
			</p>
			<?php echo '<a href="'. HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['article_menu_id'], 'article') . '/' . $stringObj->getLinkHtml($row['name'], $row['article_id']) . '" title="' . stripslashes($row['name']) . '">' ?><span class="spanxemtieptin"> xem tiếp <i class="fa fa-angle-double-right"></i></span></a>
		</div>
	</div>
</div> 
<?php } ?>