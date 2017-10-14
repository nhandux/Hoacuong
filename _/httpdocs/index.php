<?php
@ob_start(); 
@session_start();

include("config.php");
$db		=	new	lg_mysql($host,$dbuser,$dbpass,$csdl);
include("languages/vn.lang");
if(isset($_POST["btn_search"]))
		$act="tim_kiem";
include("func.php");
$tanl=getNavLink();
$THANHVIEN["id"] = 0;
include("z_includes/dem_online.php");
if (empty($act)) $act = "home";
if (!in_array($act, array('home','doanh_nghiep','thong_tin_lien_he','danh_sach_san_pham','xem_chi_tiet','tu_van_xem','tuyen_dung_xem','tu_van','tuyen_dung','cac_tin_tuc','tin_tuc','tin_tuc_xem','san_pham','san_pham_xem','nang_luc_kinh_nghiem','nang_luc_kinh_nghiem_xem','so_sanh_san_pham','cac_linh_vuc','linh_vuc','linh_vuc_xem','du_an','du_an_xem','hinh_anh','hinh_anh_xem','lien_he','gioi_thieu','thiet_ke_noi_that','register','dich_vu','dich_vu_xem','danh_sach_san_pham','gio_hang','dat_hang','lich_su_giao_dich','quen_mat_khau','tin_khuyen_mai','khach_hang','khach_hang_xem','danh_sach_tin_tuc','tim_kiem','cong_trinh','ho_tro','du_an_tieu_bieu','du_an_dang_thuc_hien'
	) ) ) 
{
	$act = "home";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<?php include "z_includes/_html_head.php"; ?>
</head>
<body>
<div id="header_outline">
	<div id="header">
		<a href="/"><img id="logo" alt="Logo" src="/images/logo.png" /></a>
		<div class="header_right">
			<ul id="top_right">

				<li class="share">
					<form action="/tim-kiem/" name="frmSearch" onSubmit="return checkKeyword();" method="post">
						<input value="" id="txt_name" name="q" placeholder="Từ khóa" />
						<input type="submit" name="btn_search" id="btn_search" value="" />
                        <input type="hidden" name="cx" value="005318581416524270332:yssqsivwshk" />
	<input type="hidden" name="cof" value="FORID:11" />
	<input type="hidden" name="ie" value="UTF-8" />
					</form>
					<script>
					function checkKeyword()
						{
							var key=$('#txt_name').val();
							if(key=="")
							{
								alert("Vui lòng nhập từ khóa!");
								$('#txt_name').focus();
								return false;
							}
							else
								document.frmSearch.submit();
						}
					</script>
				</li>
				<!--li class="lang">
					<a id="li_lang" href="javascript:;"><img src="/images/bg_flag.png" alt="Languages" /></a><br />
					<a style="display:none; position:absolute; z-index:20000" id="choise_lang" href="javascript:;"><img src="/images/bg_flag_other.png" alt="Languages" /></a>
				</li-->
				<br clear="all" />
			</ul>
			<br clear="all" />
		</div>
		<br clear="all" />
	</div>
</div>
<div id="menu_outline">
	<? include 'z_includes/tgp_menu.php'?>
</div>

<!------BANNER---------->
<? if($act=='home')
{ ?>
<div class="banner">
	<div class="slider">
		<? include 'z_includes/slider_home.php'?>
	</div>
	<div>
		<? include 'z_includes/tgp_menu_show.php'?>
	</div>
    <div style="width:960px; margin:auto; padding-bottom:10px;">
<div class="fb-like" data-href="https://www.facebook.com/hypertech.vn" data-width="960" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
</div>
</div>
<? }?>
<!------WRAPPER--------->
<div id="content_outline" <? if($act!='home') echo 'style="background-color:#FFF"';?>>
<?php
if($act=='home'){
	include 'z_modules/'.$act.'.php';
}
else
{?>
<div id="content_wrapper">
	<div id="left_content">
	<?
	if(file_exists('z_modules/cat/'.$act.'_cat.php'))
	 include 'z_modules/cat/'.$act.'_cat.php';
	else
	{
		if($act=='tim_kiem')
			include 'z_modules/cat/san_pham_cat.php';
		else
		include 'z_modules/cat/du_an_cat.php';	
	}?>
    <div class="supports">
    <h3>Hỗ trợ trực tuyến</h3>
        <?=get_page('ho_tro_truc_tuyen');?>
    </div>
    <style>
	.supports{
		padding:10px;
		line-height:24px;
	}
	.supports a{
		display:block;
		padding-bottom:5px;
	}
	</style>
	</div>
	<div id="main_content">
	<? include 'z_modules/'.$act.'.php';?>
	</div>
	<br clear="all" />
</div>
<? }?>

<!-- <div class="nav_link"><? //=$tanl['nav_link']?></div> -->
</div>
<div class="customer_outline">
	<? include 'z_modules/slider_khach_hang.php'?>
	<div class="tgp_clr_left"></div>
</div>
<!------FOOTER---------->
<?
$sql	= $db->select("tgp_popup","id = '1'");
$data = $db->fetch($sql);
	?>
<div id="footer_outline" style="background-image:url(/uploads/popup/<?=$data['hinh']?>)" >
	<div id="footer">
	<div id='copyright_powered'>
	<div id="copyright">
			<?=get_page("copyright","noi_dung")?>
			</div>
             <div id="powered" style="padding-right:10px; width:144px; text-align:center;">
            <a href="http://danaweb.vn" target="_blank" style="color:#fff">Design and Maintained by <br /><img src="/logo4.png"  /></a>
            </div>
		
			</div>
			<br clear="all" />
	</div>
	</div>
</div>
<?php include("z_includes/popup_login.php"); ?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.6";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>