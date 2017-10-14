<script type="text/javascript">
				  $(document).ready(function()
				    {
					$("body,html").animate({scrollTop:600},1000);
					
				});			
							
</script>

<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }

$date = new DateClass();
$stringObj = new String();

//---------------[ box-wp BEGIN ]---------------------------
$category_id = 0;
$breadcrumb_home = '<a href="'. HOME_URL_LANG . '" title="' . $lgTxt_menu_home . '"><i class="fa fa-home"></i></a>';
$breadcrumb_category = $breadcrumb_menu_parent = $breadcrumb_menu = '';

$db->table = "category";
$db->condition = "is_active = 1 and slug = '".$slug_cat."'";
$db->order = "";
$db->limit = 1;
$rows = $db->select();
foreach ($rows as $row) {
	$category_id = $row['category_id']+0;
	$breadcrumb_category = '<a href="' . HOME_URL_LANG . '/' . $slug_cat . '" title="' . stripslashes($row['name']) . '">' . stripslashes($row['name']) . '</a>';
}
if($id_menu > 0) {
	$parent = 0;
	$db->table = "gallery_menu";
	$db->condition = "gallery_menu_id = " . $id_menu;
	$db->order = "";
	$db->limit = 1;
	$rows = $db->select();
	if($db->RowCount>0) {
		foreach ($rows as $row) {
			$parent = $row['parent'] + 0;
			if ($parent == 0) {
				$breadcrumb_menu_parent = '<a href="' . HOME_URL_LANG . '/' . $slug_cat . '/' . stripslashes($row['slug']) . '" title="' . stripslashes($row['name']) . '">' . stripslashes($row['name']) . '</a>';
			} else {
				$db->table = "gallery_menu";
				$db->condition = "gallery_menu_id = " . $parent;
				$db->order = "";
				$db->limit = 1;
				$rows_parent = $db->select();
				if ($db->RowCount > 0) {
					foreach ($rows_parent as $row_parent) {
						$breadcrumb_menu_parent = '<a href="' . HOME_URL_LANG . '/' . $slug_cat . '/' . stripslashes($row_parent['slug']) . '" title="' . stripslashes($row_parent['name']) . '">' . stripslashes($row_parent['name']) . '</a>';
						$breadcrumb_menu = '<a href="' . HOME_URL_LANG . '/' . $slug_cat . '/' . stripslashes($row['slug']) . '" title="' . stripslashes($row['name']) . '">' . stripslashes($row['name']) . '</a>';
					}
				}
			}
		}
	}
}

echo '<div class="breadcrumb"><div class="box-wp">' . $breadcrumb_home . $breadcrumb_category . $breadcrumb_menu_parent . $breadcrumb_menu . '</div></div><section class="content box-wp clearfix">';
  
  

echo '<div class="content-left">';
//-------------------------------------------------------------------------------
if ($id_article > 0){
	$id = $id_article;
	include(_F_TEMPLATES . DS . "show_gallery.php");
} else if($id_menu <= 0) {
	$loc = array();
	$db->table = "gallery_menu";
	$db->condition = "is_active = 1 and category_id = ".$category_id;
	$db->order = "sort ASC";
	$db->limit = "";
	$rows = $db->select();
	$stt=0;
	foreach($rows as $row) {
		$loc[$stt] = $row['gallery_menu_id'];
		$stt++;
	}
	$loc = implode(',',$loc);
	$db->table = "gallery";
	$db->condition = "is_active = 1 and gallery_menu_id IN (".$loc.")";
	$db->order = "created_time DESC";
	$db->limit = "";
	$rows = $db->select();

	$total = $db->RowCount;
	 if($total>1) {
  if($slug_cat == "video")
	 {
   $video1 = videodau();
   foreach ($video1 as $row) {
       # code...
   ?>
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
     <?php }
	   }
		$total_pages = 0;
		$per_page = 9;
		if($total%$per_page==0) $total_pages = $total/$per_page;
		else $total_pages = floor($total/$per_page)+1;
			if($page<=0) $page=1;
			$start=($page-1)*$per_page;

			$db->table = "gallery";
			$db->condition = "is_active = 1 and gallery_menu_id IN (".$loc.")";
			$db->order = "created_time DESC";
			$db->limit = $start.','.$per_page;
			$rows = $db->select();

			$i = 0;
			echo '<div class="wp-list clearfix">';
			if($slug_cat == "video")
			{
                 ?>
                      <script type="text/javascript">
					   $(document).ready(function() {
					   	    $('.jw-display-controls').css('display','block !important')
					   		$('.content-right').css('display','none !important');
					   	    $('.content-left').css('width','100%');
					   });
					   
					   </script>
					  
					    <div class="videokhac"> 
					    <?php
                           	include(_F_TEMPLATES . DS . "show_list_gallery.php");
					    ?>
					    </div>                  
            <?php
			    }else{	
				foreach($rows as $row) {
					include(_F_TEMPLATES . DS . "show_list_gallery.php");
					$i++;
				}
			}
			echo '</div>';
			showPageNavigation($page, $total_pages,'/'.$slug_cat.'?p=');
    }
	else if ($total==1) {
		$id = 0;
		foreach($rows as $row) {
			$id = $row['gallery_id'];
		}
		include(_F_TEMPLATES . DS . "show_gallery.php");
	}
	else echo '<div class="wrap updating f-space25 clearfix">
                <h3>'.$lgTxt_update.'</h3>
            </div>';

} else {
	$slug_submenu = "";
	$parent = false;
	$db->table = "gallery_menu";
	$db->condition = "is_active = 1 and gallery_menu_id = ".$id_menu;
	$db->order = "";
	$db->limit = 1;
	$rows = $db->select();
	foreach($rows as $row) {
		$slug_submenu =  $row['slug'];
		$parent = ($row['parent']+0 == 0) ? true : false;
	}
	if($parent) {
		$loc = array();
		$db->table = "gallery_menu";
		$db->condition = "is_active = 1 and parent = ".$id_menu;
		$db->order = "sort ASC";
		$db->limit = "";
		$rows = $db->select();
		$stt=0;
		if($db->RowCount>0) {
			foreach($rows as $row) {
				$loc[$stt] = $row['gallery_menu_id'];
				$stt++;
			}
			$loc = implode(',',$loc);
			$loc = $id_menu . ','.$loc;
		} else {
			$loc = $id_menu;
		}
	} else {
		$loc = $id_menu;
	}

	$db->table = "gallery";
	$db->condition = "is_active = 1 and gallery_menu_id IN (".$loc.")";
	$db->order = "created_time DESC";
	$db->limit = "";
	$rows = $db->select();

	$total = $db->RowCount;
	if($total>1) {
		$total_pages = 0;
		$per_page = 9;
		if($total%$per_page==0) $total_pages=$total/$per_page;
		else $total_pages = floor($total/$per_page)+1;
		if($page<=0) $page=1;
		$start=($page-1)*$per_page;

		$db->table = "gallery";
		$db->condition = "is_active = 1 and gallery_menu_id IN (".$loc.")";
		$db->order = "created_time DESC";
		$db->limit = $start.','.$per_page;
		$rows = $db->select();

		$i = 0;
		echo '<div class="wp-list clearfix">';
		foreach($rows as $row) {
			include(_F_TEMPLATES . DS . "show_list_gallery.php");
			$i++;
		}
		echo '</div>';
		showPageNavigation($page, $total_pages,'/'.$slug_cat.'/'.$slug_submenu.'?p=');
	}
	else if ($total==1) {
		$id = 0;
		foreach($rows as $row) {
			$id = $row['gallery_id'];
		}
		include(_F_TEMPLATES . DS . "show_gallery.php");
	}
	else echo '<div class="wrap updating f-space25 clearfix">
                <h3>'.$lgTxt_update.'</h3>
            </div>';
}
echo '</div>';
include(_F_INCLUDES . DS . "tth_right.php");
echo '</section>';
