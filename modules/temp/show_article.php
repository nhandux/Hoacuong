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
		$db->limit = 10;
		$rows2 = $db->select();
		$total = $db->RowCount;
?>
<div class="wrap-detail clearfix  wow fadeInUp" data-wow-delay = "0.1s">
	<div class="social-share">
		<input type="checkbox" class="checkbox" id="share">
		<label for="share" class="label fa fa-share-alt" title="Share dữ liệu web"></label>
		<div class="social">
			<ul>
				<li onclick="javascript:window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo site_url()?>','_blank')" class="fa fa-facebook"></li>
				<li onclick="javascript:window.open('https://twitter.com/intent/tweet?source=webclient&text=DANAWEB&url=<?php echo site_url()?>&hashtags=danaweb','_blank')" class="fa fa-twitter"></li>
				<li onclick="javascript:window.open('https://plus.google.com/share?url=<?php echo site_url()?>','_blank')" class="fa fa-google-plus"></li>
			</ul>
		</div>
	</div>
    <?php 
    if($slug_cat == 'san-pham'){
    ?>
    <div style="display: table;width: 100%;">
		   <div class="nhan-50 zoom" id="jqzoom">
			  <img src="<?php echo HOME_URL_LANG.'/uploads/article/'.$row['img'];  ?>" class="hinhdaidien">	 
		   </div>
		   <div class="nhan-50">
		   	<h3 class="name_sanpham"> <?= $row['name'] ?></h3>
		   	<p class="time"><i class="fa fa-calendar fa-fw"></i><?php echo $date->vnFull($row['created_time']) ?> </p>
		   	<span class="mota_sanpham">
		   		Mô tả 
		   	</span>
		   	<p class="content_mota">
		   		<?= $row['comment'] ?>
		   	</p>
		   </div>
	</div>	
	<script type="text/javascript">
		$(document).ready(function(){
          $('#jqzoom').zoom();
        });
	</script>
	<div class="noidung_sanpham">
	   		<ul class="list_dssanpham">
	   			<li class="activesp" id="ttctiet">
	   				Thông tin chi tiết
	   			</li>
	   			<li id="hinhanhkhac">
	   				Hình ảnh liên quan
	   			</li>
	   		</ul>
		<div class="list_spham">
			<?= $row['content'] ?>
		</div>
		<div class="list_hanh">
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
					
					<div class="item-ga">
						<div class="box item2">
							<div class="img item12">
							 <a class="fancybox-group" rel="gal" href="<?php echo HOME_URL;?>/uploads/photos/full_<?php echo $img[$i];?>" title="<?php echo $row['name'];?>">
							<img src="<?php echo HOME_URL;?>/uploads/photos/<?php echo 'th_' . $img[$i];?>" alt="<?php echo $alt;?>">
						</a>
						<div class="baotatcaanh">
							<?= $row['name'] ?>
						</div>
						</div>
					</div>
				</div>
				<?
				
				}
			}
		}
      ?>
		</div>
	</div>
	 
    <?php
        }else
        {
    ?>

	<?php if($slug_cat=='news-event' || $slug_cat=='tin-tuc') echo '<p class="time"><i class="fa fa-calendar fa-fw"></i> ' . $date->vnFull($row['created_time']) . '</p>'; else echo '';?>
	<h1 class="t-semibold hqten"><?php echo stripslashes($row['name']);?></h1>
	<?php if($slug_cat=='gioi-thieu' || $slug_cat=='linh-vuc-hoat-dong') echo '<p class="time"> Cập nhập ' . $date->vnFull($row['created_time']) . '</p>'; else echo '';?>
	<?php echo '<h3 class="t-semibold f-space10">' . stripslashes($row['comment']) . '</h3>';?>

	<div class="detail-wp f-space15"><?php echo stripslashes($row['content']); ?></div>
   <?php } ?>
	<?php if($id==803) { ?>
	<div class="register-edu f-space30">
		<h1 class="title alg-ctr wow fadeInDown">Đăng ký tham dự chương trình</h1>
		<p class="caption wow fadeInUp">Kính mời quý phụ huynh đăng ký để tham gia chương trình Lời Vàng Cho Con - Khai Sáng Trí Não của học viện Green Mind đồng tổ chức. Hãy chắc chắn là các quý phụ huynh đã đọc hết thông tin liên quan đến chương trình và dưới đây là mẫu đăng ký tham dự, xin vui lòng điền đầy đủ thông tin tham dự.</p>
		<div class="form-register f-space20 clearfix">
			<input type="hidden" name="lang_field" value="<?php echo $txtEnter_field;?>">
			<input type="hidden" name="lang_email" value="<?php echo $txtEnter_email;?>">
			<input type="hidden" name="lang_phone" value="<?php echo $txtEnter_tell;?>">
			<form id="_register" name="frm_register" class="ps-error" onsubmit="return sendMail('edu1_register', '_register');" method="post">
				<label class="wow fadeInLeft"><input type="text" name="name" placeholder="Họ và tên..." autocomplete="off"><i class="fa fa-user"></i></label>
				<label class="wow fadeInRight"><input type="text" name="tel" placeholder="Số điện thoại..." autocomplete="off"><i class="fa fa-phone"></i></label>
				<label class="wow fadeInLeft"><input type="text" name="email" placeholder="Email..." autocomplete="off"><i class="fa fa-envelope"></i></label>
				<label class="wow fadeInRight"><input type="text" name="address" placeholder="Địa chỉ..." autocomplete="off"><i class="fa fa-map-marker"></i></label>
				<label class="wow fadeInRight"><button type="submit" class="btn more" id="_send_register" name="register">Đăng ký</button></label>
			</form>
			<script>
				window.onload = check_register();
			</script>
		</div>
	</div>
	<?php } ?>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#ttctiet').hover(function( e ){
                $('#hinhanhkhac').removeClass('activesp')
                $(this).addClass('activesp')
                $('.list_hanh').css('display','none')
                $('.list_spham').css('display','block')
			})
			$('#hinhanhkhac').hover(function( e ){
                $('#ttctiet').removeClass('activesp')
                $(this).addClass('activesp')
                $('.list_spham').css('display','none')
                $('.list_hanh').css('display','block')
			})
		});
	</script>
	<div class="social-like clearfix" style="display: inline-block;"></div>
<?php if($slug_cat == 'gioi-thieu' || $slug_cat == 'linh-vuc-hoat-dong'){

		}else{
			 ?>
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

	
	<div><span class="danhsachlienquan">Danh sách liên quan</span></div>
	<div class="others">
		<?php
		//----------------------------------------------------------
		if($total>0) {
			echo '<ul class="list-other">';
			foreach($rows2 as $row2) {
				include(_F_TEMPLATES . DS . "show_other_article.php");
			}
			echo '</ul>';
		} ?>

	</div>
	<div class="fb-comments" data-href="<?php echo HOME_URL_LANG . '/' . $slug_cat . '/' . getSlugMenu($row2['article_menu_id'], 'article') . '/' .  $stringObj->getLinkHtml($row2['name'], $row2['article_id'])?>" data-numposts="5"></div>
<?php } ?>
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