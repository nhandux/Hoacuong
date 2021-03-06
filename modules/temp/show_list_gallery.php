<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }

$photo_avt = '';
$alt = stripslashes($row['name']);
if($row['img']!="" && $row['img']!="no") {
	$photo_avt = '<img src="'. HOME_URL .'/uploads/gallery/gal-'. $row['img'] . '" alt="' . $alt . '" />';
} else {
	$photo_avt = '<img src="'. HOME_URL .'/images/404.jpg" alt="'.$alt.'" />';
}
$photo_avt = '<a href="'. HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['gallery_menu_id'], 'gallery') . '/' . $stringObj->getLinkHtml($row['name'], $row['gallery_id']) . '" title="' . stripslashes($row['name']) . '">' . $photo_avt . '</a>';
$title = '<a href="'. HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['gallery_menu_id'], 'gallery') . '/' . $stringObj->getLinkHtml($row['name'], $row['gallery_id']) . '" title="' . stripslashes($row['name']) . '">' . stripslashes($row['name']) . '</a>';
 if($slug_cat != "video")
 {
?>
<div class="item-ga">
	<div class="box">
		<div class="img hinhanhlienquan">
			<?php echo $photo_avt; ?>
			
			<div class="hienthithongtinhinhanh">
				<ul>
					<li> <span style="font-size: 13px;text-transform: inherit;">• Album:</span> <?=$row['name']?></li>
					<li class="lingay">• Đăng: <span><?=  $date->vnFull($row['created_time'])  ?></span></li>
					<?php
						$alt = stripslashes($row['name']);
						$list_img = "";
						$db->table = "uploads_tmp";
						$db->condition = "upload_id = ".($row['upload_id']+0);
						$db->order = "";
						$db->limit = 1;
						$rows_gal = $db->select();
						foreach ($rows_gal as $row_gal){
							$list_img = $row_gal['list_img'];
						}
						$img = explode(";",$list_img);?>
					<li class="lihinhanh">• <?= count($img) ?> Hình ảnh</li>
                     <li class="limota">• <?php echo $stringObj->crop(stripslashes($row['comment']), 15); ?></li>
					
					<div class="social laiface">
							<ul>
								<li onclick="javascript:window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo site_url()?>','_blank')" class="fa fa-facebook"></li>
								<li onclick="javascript:window.open('https://twitter.com/intent/tweet?source=webclient&text=DANAWEB&url=<?php echo site_url()?>&hashtags=danaweb','_blank')" class="fa fa-twitter"></li>
								<li onclick="javascript:window.open('https://plus.google.com/share?url=<?php echo site_url()?>','_blank')" class="fa fa-google-plus"></li>
							</ul>
						</div>
						<li class="lixemtiep"><?php echo '<a href="'. HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['gallery_menu_id'], 'gallery') . '/' . $stringObj->getLinkHtml($row['name'], $row['gallery_id']) . '" >';?>Xem album <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
				</ul>
			</div>
		</div>
		<div class="comment binhluanvien"><h3><?php echo $title; ?></h3></div>
	</div>
</div>
<?php }
 else if($slug_cat == "video")
    {
     $dsvideo = dsvideo();
     foreach ($dsvideo as $row) {
         # code...
    echo '<a href="'. HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row['gallery_menu_id'], 'gallery') . '/' . $stringObj->getLinkHtml($row['name'], $row['gallery_id']) . '" >'
    ?>
        <div class="cacvideolienquan">
            <div class="chuaviedo">
                <?= '<img src="'. HOME_URL .'/uploads/gallery/gal-'. $row['img'] . '" alt="' . $alt . '" />' ?>
                <div class="hienthianvideo">
                    <span class="titivide"> <?= $row['name'] ?></span>
                    <p class="timevideo"> Đăng: <span style="text-transform:lowercase"><?= $date->vnFull($row['created_time'])?> </span></p>
                  <p class="tttrenvideo">
                    <?= $row['comment'] ?>
                  </p>
                </div>
                <div class="motathemvideo">
                    <?= $row['name'] ?>
                </div>
            </div>
        </div>
    </a>
    <?php
      }
} ?>
