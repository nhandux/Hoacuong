<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//-----------------
$breadcrumb_home = '<a href="'. HOME_URL_LANG . '" title="' . $lgTxt_menu_home . '"><i class="fa fa-home"></i></a>';
$breadcrumb_category = $breadcrumb_menu_parent = $breadcrumb_menu = '';
$breadcrumb_category = '<a href="' . HOME_URL_LANG . '/' . $lgTxt_register_slug . '" title="' . $lgTxt_register_title . '">' . $lgTxt_register_title . '</a>';

echo '<div class="breadcrumb"><div class="box-wp">' . $breadcrumb_home . $breadcrumb_category . $breadcrumb_menu_parent . $breadcrumb_menu . '</div></div><section class="content box-wp clearfix"><div class="content-left">';
?>
<div class="wrap-detail">
	<input type="hidden" name="lang_field" value="<?php echo $txtEnter_field;?>"/>
	<input type="hidden" name="lang_email" value="<?php echo $txtEnter_email;?>"/>
	<input type="hidden" name="lang_phone" value="<?php echo $txtEnter_tell;?>"/>
	<form id="_frm_register" name="frm_register" class="page-register ps-error f-space20" method="post" onsubmit="return sendMail('send_register', '_frm_register');">
		<h2 class="title t-semibold">Thông tin học viên</h2>
		<div class="fm-register">
			<label>
				<input type="text" name="name" placeholder="Họ và tên: (*)" value="" maxlength="200" required>
				<i class="fa fa-child"></i>
			</label>
			<label>
				<select name="gender" required>
					<option value="">Giới tính: (*)</option>
					<option value="Nam">Nam</option>
					<option value="Nữ">Nữ</option>
				</select>
				<i class="fa fa-question-circle"></i>
			</label>
			<label>
				<input type="text" name="age" class="auto-number" placeholder="Tuổi: (*)" data-a-sep="." data-a-dec="," data-v-max="99" data-v-min="0" maxlength="2" required>
				<i class="fa fa-calendar"></i>
			</label>
		</div>
		<h2 class="title f-space40 t-semibold">Thông tin phụ huynh</h2>
		<div class="fm-register">
			<label>
				<input type="text" name="parent_name" placeholder="Họ và tên: (*)" value="" maxlength="200" required>
				<i class="fa fa-user"></i>
			</label>
			<label>
				<input type="text" name="email" placeholder="Email: (*)" value="" maxlength="200" required>
				<i class="fa fa-envelope"></i>
			</label>
			<label>
				<input type="text" name="tel" placeholder="Số điện thoại: (*)" value="" maxlength="20" required>
				<i class="fa fa-phone fa-lg"></i>
			</label>
			<label>
				<input type="text" name="address" placeholder="Địa chỉ:" value="" maxlength="250">
				<i class="fa fa-building-o"></i>
			</label>
		</div>
		<h2 class="title t-semibold">Thông tin khóa học</h2>
		<div class="fm-register">
			<h3 class="f-space20 t-semibold">Chọn khóa học muốn đăng ký.</h3>
			<?php
			$db->table = "article_menu";
			$db->condition = "`is_active` = 1 AND `category_id` = 68";
			$db->order = "`sort` ASC";
			$db->limit = "";
			$rows = $db->select();
			if($db->RowCount>0) {
				foreach($rows as $row) {
					echo '<label><input type="checkbox" name="course[]" value="' . stripslashes($row['name']) . '">' . stripslashes($row['name']) . '</label>';
				}
			}
			?>
			<label>
				<textarea name="content" placeholder="Yêu cầu bổ sung:" cols="60" rows="5"></textarea>
				<i class="fa fa-pencil"></i>
			</label>
			<label class="alg-rht">
				<input type="submit" id="_send_register" name="send_register" class="btn" value="">
			</label>
		</div>
	</form>
	<script>
		window.onload = check_register();
	</script>
</div>
<?php
echo '</div>';
include(_F_INCLUDES . DS . "tth_right.php");
echo '</section>';
include(_F_INCLUDES . DS . "tth_gallery.php");