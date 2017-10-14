<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//--

$breadcrumb_home = '<a href="'. HOME_URL_LANG . '" title="' . $lgTxt_menu_home . '"><i class="fa fa-home"></i></a>';
$breadcrumb_category = $breadcrumb_menu_parent = $breadcrumb_menu = '';
$breadcrumb_category = '<a class="error" href="' . HOME_URL_LANG . '" title="' . $lgTxt_error_page . '">' . $lgTxt_error_page . '</a>';

echo '<div class="breadcrumb"><div class="box-wp">' . $breadcrumb_home . $breadcrumb_category . $breadcrumb_menu_parent . $breadcrumb_menu . '</div></div><section class="content box-wp clearfix">';
?>
<div class="error404 f-space30">
   <div class="topacer"> 
	   <p>
	    <span class="note404">
	      404	
	    </span>
	    </p>
	     <p class="nuthienthi"><?php echo $lgTxt_page404;?> <a href="<?php echo HOME_URL_LANG;?>"> <?php echo $lgTxt_page404_click;?></a> <?php echo $lgTxt_page404_back;?> <a href="<?php echo HOME_URL_LANG;?>"><?php echo $lgTxt_menu_home;?></a>.</p>
	</div>    
</div>
<?php
echo '</section>';