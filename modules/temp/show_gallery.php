<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
if($slug_cat == "video")
{
  $ctvideo = chitietvideo($id);
  foreach ($ctvideo as $row) {
  	# code...
  ?>
   <script type="text/javascript">
					   $(document).ready(function() {
					   	    $('.jw-display-controls').css('display','block !important')
					   		$('.content-right').css('display','none !important');
					   	    $('.content-left').css('width','100%');
					   }); 
					   </script>
    <div class="videotop">
    <div class="chuavidio">
    	 <div class="body-container vidio" style="max-width: 100%; height: 100%; margin: 0 auto;margin-top: 10px;">
		    <script src="https://content.jwplatform.com/libraries/XmRneLwC.js"></script>
		       <div id="aRzklaXf">Đang tải video...</div>
               

		       <script type="text/javascript">
               var url = "<?= $row['link'] ?>"
		       var playerInstance = jwplayer("aRzklaXf");
		           playerInstance.setup({   
		            file:  url,
		            image: "images/hinh4k.jpg",
		            mediaid: "aRzklaXf",
		            autostart: true,
		            cast: {
		                appid: "EDF7B42C",
		                endscreen: "https://assets-jpcust.jwpsrv.com/watermarks/UhfJXj85.png",
		                loadscreen: "https://assets-jpcust.jwpsrv.com/watermarks/zAWOWPbu.png",
		                logo: "https://assets-jpcust.jwpsrv.com/watermarks/mxQeCt89.png"
		            },
		       });
		    </script>
		</div>
    </div> 
    <div class="motavideo">
    	<span class="namepagevideo">
    		<?= $row['name'] ?>
    	</span>
    	<span class="ngayvideo">
    		<p class="time"> Cập nhập <span style="text-transform:lowercase"><?= $date->vnFull($row['created_time'])?> </span></p>
    	</span>
         <span class="tomtatvideo">
         	<?= $row['comment'] ?>
         </span>
     <div class="laivideo">
		<ul >
			<li class="fb-like" data-href="<?php echo site_url()?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></li>
			<li onclick="javascript:window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo site_url()?>','_blank')" class="fa fa-facebook"></li>
				<li onclick="javascript:window.open('https://twitter.com/intent/tweet?source=webclient&text=DANAWEB&url=<?php echo site_url()?>&hashtags=danaweb','_blank')" class="fa fa-twitter"></li>
				<li onclick="javascript:window.open('https://plus.google.com/share?url=<?php echo site_url()?>','_blank')" class="fa fa-google-plus"></li>
        </ul>
	</div>
	<div class="commentvideo" id="style-1">
		<div class="fb-comments comentface" data-href="<?php echo HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row2['gallery_menu_id'], 'gallery') . '/' .  $stringObj->getLinkHtml($row2['name'], $row2['gallery_id'])?>" data-width="100%" data-numposts="5"></div>
		<div class="force-overflow"></div>
	</div>

    </div>  
    </div>
  <?php
   }
}
else if($slug_cat != "video"){
$sumView = 0;
$db->table = "gallery";
$db->condition = "is_active = 1 and gallery_id = ".$id;
$db->order = "";
$db->limit = "";
$rows = $db->select();
if($db->RowCount>0){
	foreach($rows as $row) {
		$db->table = "gallery";
		$db->condition = "is_active = 1 and gallery_menu_id = ".($row['gallery_menu_id']+0).' and gallery_id <> '.$id;
		$db->order = "created_time DESC";
		$db->limit = 5;
		$rows2 = $db->select();
		$total = $db->RowCount;
?>
<div class="wrap-detail clearfix">
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
    
	<h1 class="t-semibold"><i class="fa fa-tags"></i> <?php echo stripslashes($row['name']); ?></h1>
	<?php echo '<p class="time"> ' . $date->vnFull($row['created_time']) . '</p>';?>
	<div class="detail-wp f-space15"><?php echo stripslashes($row['comment']); ?></div>
	<div class="grid gal-opy f-space10 clearfix">
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
		$img = explode(";",$list_img);
		if($list_img!="") {
			for($i=0;$i<count($img);$i++) {
				if($img[$i] != ""){
					?>
					<a class="fancybox-group danhsachhinh" rel="gal" href="<?php echo HOME_URL;?>/uploads/photos/full_<?php echo $img[$i];?>" title="<?php echo $alt;?>">
						<img src="<?php echo HOME_URL;?>/uploads/photos/<?php echo 'th_' . $img[$i];?>" alt="<?php echo $alt;?>">
					</a>
				<?
				}
			}
		}		
		?>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			var options = {
				srcNode: 'a',
				margin: '8px',
				width: '262px',
				max_width: '',
				resizable: true,
				transition: 'all 1s ease'
			};
			document.querySelector('.grid').gridify(options);
		});
	</script>
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
	
	<div class="others">
		<?php
		//----------------------------------------------------------
		if($total>0) {
			echo '<ul class="list-other">';
			foreach($rows2 as $row2) {
				include(_F_TEMPLATES . DS . "show_other_gallery.php");
			}
			echo '</ul>';
		} ?>
	</div>
</div>
<?php } 
		$sumView = $row['views']+1;
	}
	$db->table = "gallery";
	$data = array(
		'views'=>$sumView
	);
	$db->condition = "gallery_id = ".$id;
	$db->update($data);

}else include(_F_MODULES . DS . "error_404.php");
if($slug_cat == "video") {
  $dsvideo = dsvideokhac($id);
   echo ' <div class="videokhac"> ';  
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
      echo '</div>';
 }
