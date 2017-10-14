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
//where 
$db->order = "";
$db->limit = 1;
$rows = $db->select();
//laf mang da chieu
//gom cot va gia tri
foreach ($rows as $row) {
	$category_id = $row['category_id']+0;
	$breadcrumb_category = '<a href="' . HOME_URL_LANG . '/' . $slug_cat . '" title="' . stripslashes($row['name']) . '">' . stripslashes($row['name']) . '</a>';
}
if($id_menu > 0) {
	$parent = 0;
	$db->table = "article_menu";
	$db->condition = "article_menu_id = " . $id_menu;
	$db->order = "";
	$db->limit = 1;
	$rows = $db->select();
	if($db->RowCount>0) {
		foreach ($rows as $row) {
			$parent = $row['parent'] + 0;
			if ($parent == 0) {
				$breadcrumb_menu_parent = '<a href="' . HOME_URL_LANG . '/' . $slug_cat . '/' . stripslashes($row['slug']) . '" title="' . stripslashes($row['name']) . '">' . stripslashes($row['name']) . '</a>';
			} else {
				$db->table = "article_menu";
				$db->condition = "article_menu_id = " . $parent;
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

echo '<div class="breadcrumb wow " data-wow-delay="0.1s"><div class="box-wp">' . $breadcrumb_home . $breadcrumb_category . $breadcrumb_menu_parent . $breadcrumb_menu . '</div></div><section class="content box-wp clearfix"><div class="content-left">';
//-------------------------------------------------------------------------------
if ($id_article > 0){
	$id = $id_article;
	include(_F_TEMPLATES . DS . "show_article.php");

} else if($id_menu <= 0) {
	$loc = array();
	$db->table = "article_menu";
	$db->condition = "is_active = 1 and category_id = ".$category_id;
	$db->order = "sort ASC";
	$db->limit = "";
	$rows = $db->select();
	$stt=0;
	foreach($rows as $row) {
		$loc[$stt] = $row['article_menu_id'];
		$stt++;
	}
	$loc = implode(',',$loc);
	$db->table = "article";
	$db->condition = "is_active = 1 and article_menu_id IN (".$loc.")";
	$db->order = "created_time DESC";
	$db->limit = "";
	$rows = $db->select();

	$total = $db->RowCount;
	if($total>1) {
		$total_pages = 0;
		$per_page = 9;
		if($total%$per_page==0) $total_pages = $total/$per_page;
		else $total_pages = floor($total/$per_page)+1;
		if($page<=0) $page=1;
		$start=($page-1)*$per_page;
  if($slug_cat != "tin-tuc"){
		$db->table = "article";
		$db->condition = "is_active = 1 and article_menu_id IN (".$loc.")";
		$db->order = "created_time DESC";
		$db->limit = $start.','.$per_page;
		$rows = $db->select();
       }
    else if($slug_cat == "tin-tuc"){
    	$db->table = "article";
		$db->condition = "is_active = 1 and article_menu_id IN (".$loc.")";
		$db->order = "created_time DESC";
		$cm = $db->RowCount;
		$db->limit = '4,1';
		$rows = $db->select();
    }   
		$i = 0;
        echo '<div class="wp-list clearfix" id="loadulieura">';
        if($slug_cat == 'tin-tuc'){
        $db->table = "article";
		$db->condition = "is_active = 1 and article_menu_id = 353";
		$db->order = "created_time DESC";
		$db->limit = '1';
		$tindautien = $db->select();
        	?>
            <div class="baotintren">
            <?php foreach ($tindautien as $tindau){?>
            	
                    
            	 <div class="tin-65">
            	 	<div class="hinhtinmoi">
            	 	 <img src="<?php echo HOME_URL_LANG.'/uploads/article/'.$tindau['img'];  ?>" >
            	 		<span class="ngaythangtinmoinhat">
            	 		<?=  $date->vnFull($tindau['created_time']) ?>	
            	 		</span>
            	 	</div>
            	 	<div class="noidungtinmoi">
            	 	<a href="<?= HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($tindau['article_menu_id'], 'article') . '/' . $stringObj->getLinkHtml($tindau['name'], $tindau['article_id']) ?>" class="tomtattinmoinhat"><?= $tindau['name'] ?></a>
            	 	<p><?= $tindau['comment'] ?>
            	 	</p></div>
            	 </div>
               <?php } 
                $db->table = "article";
		      $db->condition = "is_active = 1 and article_menu_id = 353";
	          $db->order = "created_time DESC";
		      $db->limit = '1,3';
		      $slidetin = $db->select();
                ?>
            	 <div class="tin-35">
            	 	<!-- div slide tin -->
            	 	<div class="trongtin35">
            	 	 <div class="newsticker-jcarousellite" style="margin-top:5px;">
				        <ul style="margin: 0pt; padding: 0pt; position: relative; list-style-type: none; z-index: 1; height: 765px;">
				          <?php
                           foreach ($slidetin as $slitin) {
				           ?>
				          <li style="overflow: hidden; float: none; width: 100%; height: 79px;border-bottom:1px solid #e8e8e8">
				            <div class="thumbnail">
				              <img src="<?php echo HOME_URL_LANG.'/uploads/article/'.$slitin['img'];  ?>">
				            </div>
				            <div class="info">
				              <a href="<?= HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($slitin['article_menu_id'], 'article') . '/' . $stringObj->getLinkHtml($slitin['name'], $slitin['article_id']) ?>"><?= $slitin['name'] ?></a><br/>
				              <span class="ngaydangtin"><?=  $date->vnFull($slitin['created_time']) ?>	 </span>
				            </div>
				            <div class="clear"></div>
				          </li>
				         <?php } ?>
				        </ul>
				      </div>
				     </div>
				     <div class="hinhgioithieu">
				     	<img src="images/1489805106_banner.jpg" width="100%">
				     </div>
            	 	<!-- end div slide tin -->
            	 </div>
            </div>
         
           <?php
        }
        	//end phần tin tức
        else if($slug_cat == 'san-pham'){
        $db->table = "category";
		$db->condition = "is_active = 1 and category_id = 77";
		$db->order = "created_time DESC";
		$db->limit = "";
		$rows2 = $db->select();
        foreach ($rows2 as $row2) {
        echo '<h3 class="h3sanpham">sản phẩm hòa cường <a href="javascript:{0}" class="ahienthi"><i class="fa fa-caret-down" aria-hidden="true"></i></a></h3>';
         echo '<div class="dmsanphammoi">';
        
         echo $row2['comment'];
        
         echo '</div>';
          echo '<div class="cmxxx"><h3>DANH SÁCH LOẠI SẢN PHẨM</h3></div>';
        	# code...
         } 
        }
        //end phần sản phẩm
        ?>
         <script type="text/javascript">
	$('.ahienthi').click(function(event) {
		/* Act on the event */
	   $('.dmsanphammoi').slideToggle()
	});
</script>
        <?php 
         if($slug_cat != "san-pham" && $slug_cat != "gioi-thieu" && $slug_cat != 'linh-vuc-hoat-dong' && $slug_cat != "video")
	        {
			foreach($rows as $row) {
				include(_F_TEMPLATES . DS . "show_list_article.php");
				$i++;
			}
			
       }
       else if($slug_cat == "linh-vuc-hoat-dong" || $slug_cat == "gioi-thieu"){
          if($slug_cat == 'gioi-thieu') $id = 320;
          else if($slug_cat == "linh-vuc-hoat-dong") $id = 354;
		  $rows = laythongtin($id);
		  foreach ($rows as $row) {
		  	?>
		  	<div class="text-left">
			<h1 class="t-semibold hqten"><?php echo stripslashes($row['name']);?></h1>
			<?php if($slug_cat=='gioi-thieu' || $slug_cat=='linh-vuc-hoat-dong') echo '<p class="time"> Cập nhập ' . $date->vnFull($row['created_time']) . '</p>'; else echo '';?>
			<?php echo '<h3 class="t-semibold f-space10">' . stripslashes($row['comment']) . '</h3>';?>

			<div class="detail-wp f-space15"><?php echo stripslashes($row['content']); ?></div>
             </div>
		  	<?php 
		  }
		}
	  
       else if($slug_cat == "san-pham"){
        $db->table = "article_menu";
		$db->condition = "is_active = 1 and category_id = 77";
		$db->order = "created_time DESC";
		$db->limit = "";
		$rows = $db->select();  
		foreach($rows as $row) {
				include(_F_TEMPLATES . DS . "show_list_article.php");
				$i++;
			}
       }
        echo '</div>';
        if($slug_cat == "tin-tuc")
        {
        ?>
	        <div class="xemtieptintux">
	        	<span class="hinhload" ><!-- <img src="images/loading.gif"> --></span><br/><br/>
	        	<span class="spanxemtiep" id="load_more">xem thêm <i class="fa fa-angle-double-down" aria-hidden="true"></i></span>
	        </div>
	        <script type="text/javascript">
	        	$(document).ready(function() {
	        		 function loadd(){
				     $('.hinhload').html("<img src='images/loading.gif'/>").fadeIn('fast');
				     }
				    function loadhide(){
				       $('.hinhload').fadeOut('fast');
				      }      
	        		var trang = 1;
	        		$('#load_more').click(function(event) {
	        			loadd()
	        			trang = trang + 1
	        			/* Act on the event */
	        			$.get('getdata.php',{page:trang},function(data){
	        				loadhide()
                            $('#loadulieura').append(data)
                            if(data == "")
                            {
                            	 $('.hinhload').html("Hết dữ liệu tin tức").fadeIn('fast');
                            $('.xemtieptintux').remove()	
                            }
	        			})
	        		});
	        	});
	        </script>
        <?php
        }
		showPageNavigation($page, $total_pages,'/'.$slug_cat.'?p=');
	}
	else if ($total==1) {
		$id = 0;
		foreach($rows as $row) {
			$id = $row['article_id'];
		}
		include(_F_TEMPLATES . DS . "show_article.php");
	}
	else echo '<div class="wrap updating clearfix">
                <h3>'.$lgTxt_update.'</h3>
            </div>';

} else {
	if($id_menu==317) {
		$loc = array();
		$db->table = "article_menu";
		$db->condition = "is_active = 1 and category_id = ".$category_id;
		$db->order = "sort ASC";
		$db->limit = "";
		$rows = $db->select();
		$stt=0;
		foreach($rows as $row) {
			$loc[$stt] = $row['article_menu_id'];
			$stt++;
		}
		$loc = implode(',',$loc);
		$db->table = "article";
		$db->condition = "is_active = 1 and article_menu_id IN (".$loc.")";
		$db->order = "created_time DESC";
		$db->limit = "";
		$rows = $db->select();

		$total = $db->RowCount;
		if($total>1) {
			$total_pages = 0;
			$per_page = 8;
			if($total%$per_page==0) $total_pages = $total/$per_page;
			else $total_pages = floor($total/$per_page)+1;
			if($page<=0) $page=1;
			$start=($page-1)*$per_page;

			$db->table = "article";
			$db->condition = "is_active = 1 and article_menu_id IN (".$loc.")";
			$db->order = "created_time DESC";
			$db->limit = $start.','.$per_page;
			$rows = $db->select();

			$i = 0;
			echo '<div class="wp-list clearfix">';
			foreach($rows as $row) {
				include(_F_TEMPLATES . DS . "show_list_article.php");
				//cos phan phan trang 
				//neu co 1 bai viec thif show artical
				//
				$i++;
			}
			echo '</div>';
			showPageNavigation($page, $total_pages,'/'.$slug_cat.'?p=');
		}
		else if ($total==1) {
			$id = 0;
			foreach($rows as $row) {
				$id = $row['article_id'];
			}
			include(_F_TEMPLATES . DS . "show_article.php");
		}
		else echo '<div class="wrap updating clearfix">
					<h3>'.$lgTxt_update.'</h3>
				</div>';
		
	} else {
		$slug_submenu = "";
		$parent = false;
		$db->table = "article_menu";
		$db->condition = "is_active = 1 and article_menu_id = ".$id_menu;
		$db->order = "";
		$db->limit = 1;
		$rows = $db->select();
		foreach($rows as $row) {
			$slug_submenu =  $row['slug'];
			$parent = ($row['parent']+0 == 0) ? true : false;
		}
		if($parent) {
			$loc = array();
			$db->table = "article_menu";
			$db->condition = "is_active = 1 and parent = ".$id_menu;
			$db->order = "sort ASC";
			$db->limit = "";
			$rows = $db->select();
			$stt=0;
			if($db->RowCount>0) {
				foreach($rows as $row) {
					$loc[$stt] = $row['article_menu_id'];
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

		$db->table = "article";
		$db->condition = "is_active = 1 and article_menu_id IN (".$loc.")";
		$db->order = "created_time DESC";
		$db->limit = "";
		$rows = $db->select();

		$total = $db->RowCount;
		if($total>1) {
			$total_pages = 0;
			$per_page = 8;
			if($total%$per_page==0) $total_pages=$total/$per_page;
			else $total_pages = floor($total/$per_page)+1;
			if($page<=0) $page=1;
			$start=($page-1)*$per_page;

			$db->table = "article";
			$db->condition = "is_active = 1 and article_menu_id IN (".$loc.")";
			$db->order = "created_time DESC";
			$db->limit = $start.','.$per_page;
			$rows = $db->select();

			$i = 0;
			echo '<div class="wp-list clearfix">';
			foreach($rows as $row) {
				include(_F_TEMPLATES . DS . "show_list_article.php");
				$i++;
			}
			echo '</div>';
			showPageNavigation($page, $total_pages,'/'.$slug_cat.'/'.$slug_submenu.'?p=');
		}
		else if ($total==1) {
			$id = 0;
			foreach($rows as $row) {
				$id = $row['article_id'];
			}
			include(_F_TEMPLATES . DS . "show_article.php");
		}
		else{
			?>
			<div class="wrap updating clearfix">
					<h3><?= $lgTxt_update ?> </h3>
				</div>
				<?php 
			}
	}
}
echo '</div>';
include(_F_INCLUDES . DS . "tth_right.php");
echo '</section>';
//include(_F_INCLUDES . DS . "tth_gallery.php");
?>
<script language="javascript" type="text/javascript">
	  $(document).ready(function(){
	var a=10;$("div.producted").mousemove(function(b){
	  w=$(".tooltip").outerWidth();
	  h=$(".tooltip").outerHeight();
	  $(this).children(".tooltip").show();
	  $(this).children(".tooltip").css({left:b.pageX-$(this).offset().left+a,top:b.pageY-$(this).offset().top});
	  $(".result").text(b.pageY+h+a+":"+$(window).height());
	  if(b.pageX+a+w>=$(window).width()){
		$(this).children(".tooltip").css("left",b.pageX-$(this).offset().left-w-a)}
		if(b.pageY+h+a>=$(window).scrollTop()+$(window).height()){
		$(this).children(".tooltip").css("top",b.pageY-$(this).offset().top-h-a)}});
	   $("div.producted").mouseout(function(){
		 $(this).children(".tooltip").hide()})});
	</script>