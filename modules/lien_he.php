<script type="text/javascript">
				  $(document).ready(function()
				    {
					$("body,html").animate({scrollTop:600},1000);
					
				});			
							
</script>

<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//-----------------
$breadcrumb_home = '<a href="'. HOME_URL_LANG . '" title="' . $lgTxt_menu_home . '"><i class="fa fa-home"></i></a>';
$breadcrumb_category = $breadcrumb_menu_parent = $breadcrumb_menu = '';
$breadcrumb_category = '<a href="' . HOME_URL_LANG . '/' . $lgTxt_slug_contact . '" title="' . $lgTxt_menu_contact . '">' . $lgTxt_menu_contact . '</a>';
echo '<div class="breadcrumb wow flipInX" data-wow-delay="0.2s"><div class="box-wp">' . $breadcrumb_home . $breadcrumb_category . $breadcrumb_menu_parent . $breadcrumb_menu . '</div></div><section class="content box-wp clearfix"><div class="content-left">';
  if($slug_cat == "lien-he")
   {
	?>
   <script type="text/javascript">
   $(document).ready(function() {
   		$('.content-right').css('display','none !important');
   	    $('.content-left').css('width','100%');
   });
   
   </script>

	<?php
	}?>
<div class="wrap-detail">
	<!-- map google -->
	<div class="wow flipInX" data-wow-delay="0.3s"><?=getPage('contact_maps')?></div>
    <!-- end map google -->
	<h3 class="title t-semibold f-space20 wow flipInX" data-wow-delay="0.3s"><?= $txtttcongty ?> </h3>
	<div class="contact-info f-space10 wow flipInX" data-wow-delay="0.3s">
		<?php echo getPage('contact_page')?>
	</div>
	<input type="hidden" name="lang_field" value="<?php echo $txtEnter_field;?>"/>
	<input type="hidden" name="lang_email" value="<?php echo $txtEnter_email;?>"/>
	<input type="hidden" name="lang_phone" value="<?php echo $txtEnter_tell;?>"/>

		<h3 class="title t-semibold f-space20 wow flipInX" data-wow-delay="0.3s" style="margin: 10px 0px 15px 0px;"><?=getPage('contact_page', 'name')?> </h3>
		<span class="wow flipInX" data-wow-delay="0.4s"><?= $txtctlienhe   ?></span>
	<form id="_frm_contact" name="frm_contact" class="frm f-space20" method="post" onsubmit="return sendMail('send_contact', '_frm_contact');">
		<div class="f-space05 clearfix">
			<div class="form-item form-sm wow fadeInUp" data-wow-delay = "0.1s">
				<input type="text" name="full_name" placeholder="<?=$txtContact_name?>" value="" maxlength="250">
				<i class="fa fa-user"></i>
			</div>
			<div class="form-item form-sm  wow fadeInUp" data-wow-delay = "0.2s" >
				<input type="text" name="address" placeholder="<?=$txtContact_address?>" value="" maxlength="250">
				<i class="fa fa-building-o"></i>
			</div>
			<div class="clearfix"></div>
			<div class="form-item form-sm  wow fadeInUp" data-wow-delay = "0.3s">
				<input type="text" name="email" placeholder="<?=$txtContact_email?>" value="" maxlength="250">
				<i class="fa fa-envelope"></i>
			</div>
			<div class="form-item form-sm  wow fadeInUp" data-wow-delay = "0.4s">
				<input type="text" name="tel" placeholder="<?=$txtContact_fone?>" value="" maxlength="20">
				<i class="fa fa-phone fa-lg"></i>
			</div>
		</div>
		<div class="form-item form-bg  wow fadeInUp" data-wow-delay = "0.5s">
			<textarea name="content" placeholder="<?=$txtContact_content?>" cols="60" rows="5"></textarea>
			<i class="fa fa-pencil"></i>
		</div>
		<div class="form-bg clearfix">
			<div class="form-item form-sm wow fadeInUp" data-wow-delay = "0.5s" style="text-align: right;"><input type="submit" id="_send_contact" name="send_contact" value="<?= $txtbtlienhe ?>"></div>
			<div class="form-item form-sm  wow fadeInUp" data-wow-delay = "0.5s">
				
				<input type="reset" id="reset_contact" name="send_contact" value="<?= $txtbtlammoi ?>">
			</div>
		</div>
	</form>
	<script>
		window.onload = check_contact();
	</script>
</div>
<?php
echo '</div>';
include(_F_INCLUDES . DS . "tth_right.php");
echo '</section>';
// include(_F_INCLUDES . DS . "tth_gallery.php");