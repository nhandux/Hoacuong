<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//

function tour($act, $typeFunc, $tour_id, $tour_menu_id, $name, $img, $img_note, $comment, $tour_keys, $price, $date_schedule, $date_departure, $means, $tour_type, $destination, $sale, $schedule, $price_list_service, $upload_img_id, $maps, $video, $is_active, $hot, $pin, $created_time, $title, $description, $keywords, $error) {
	global $db, $tth;
	$db->table = "tour_menu";
	$db->condition = "tour_menu_id = ".$tour_menu_id;
	$db->order = "";
	$db->limit = "";
	$rows = $db->select();
	foreach($rows as $row){
		dashboardCoreAdminTwo($tth.";".$row['category_id']);
	}
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-files-o"></i> Nội dung tour
			</div>
			<div class="panel-body">
				<div class="table-respon">
					<form action="<?=$act?>" method="post" enctype="multipart/form-data">
						<input type="hidden" name="typeFunc" value="<?=$typeFunc?>" />
						<input type="hidden" name="tour_id" value="<?=$tour_id?>" />
						<input type="hidden" name="img" value="<?=$img?>" />
						<input type="hidden" name="upload_img_id" value="<?=$upload_img_id?>">
						<div class="panel-show-error">
							<?=$error?>
						</div>
						<table class="table table-hover">
							<tr>
								<td width="12%"><label>Tiêu đề:</label></td>
								<td width="88%" colspan="3"><input class="form-control" type="text" name="name" maxlength="255" value="<?=stripslashes($name)?>" required="required" ></td>
							</tr>
							<tr>
								<td><label>Mục:</label></td>
								<td colspan="3"><?=categoryName($tour_menu_id);?></td>
							</tr>
							<tr>
								<td width="12%" class="ver-top"><label>Hình đại diện:</label></td>
								<td width="38%" class="ver-top">
									<input class="form-control file file-img" type="file" name="img" data-show-upload="false" data-max-file-count="1" accept="image/*" >
								</td>
								<td width="12%" class="ver-top"><label>Ghi chú hình:</label></td>
								<td width="38%" class="ver-top"><input class="form-control" type="text" name="img_note" maxlength="255" value="<?=stripslashes($img_note)?>" ></td>
							</tr>
							<tr>
								<td><label>Mã tour:</label></td>
								<td><input class="form-control" type="text" name="tour_keys" maxlength="50" value="<?=stripslashes($tour_keys)?>" ></td>
								<td><label>Giá:</label></td>
								<td><input class="form-control auto-number" type="text" name="price" data-a-sep="." data-a-dec="," data-v-max="9999999999" data-v-min="0" maxlength="15" placeholder="0 =  Liên hệ" value="<?=stripslashes($price)?>"></td>
							</tr>
							<tr>
								<td><label>Thời gian:</label></td>
								<td><input class="form-control" type="text" name="date_schedule" maxlength="255" value="<?=stripslashes($date_schedule)?>" placeholder="VD: 3 ngày 2 đêm"></td>
								<td><label>Ngày khởi hành:</label></td>
								<td>
									<label><input class="form-control input-date" id="date_departure" type="text" name="date_departure" onchange="return onchange_departure();"  style="width: 160px;" maxlength="255" value="<?=stripslashes($date_departure)?>"></label>
									<label class="checkbox-inline">&nbsp; <input type="checkbox" id="date_always" name="date_always" value="1" onchange="return onchange_date();" >Khởi hành hàng ngày.</label>
								</td>
							</tr>
							<tr>
								<td><label>Phương tiện:</label></td>
								<td><input class="form-control" type="text" name="means" maxlength="255" data-role="tagsinput" value="<?=stripslashes($means)?>"></td>
								<td><label>Loại hình du lịch:</label></td>
								<td><input class="form-control" type="text" name="tour_type" maxlength="255" data-role="tagsinput" value="<?=stripslashes($tour_type)?>"></td>
							</tr>
							<tr>
								<td><label>Điểm đến:</label></td>
								<td><input class="form-control" type="text" name="destination" maxlength="255" data-role="tagsinput" value="<?=stripslashes($destination)?>"></td>
								<td><label>Sale: (%)</label></td>
								<td><input class="form-control auto-number" type="text" name="sale" maxlength="2" value="<?=stripslashes($sale)?>" data-a-sep="." data-a-dec="," data-v-max="99" data-v-min="0" autocomplete="off"></td>
							</tr>
							<tr>
								<td class="ver-top"><label>Mô tả:</label></td>
								<td colspan="3">
									<textarea class="form-control" rows="3" name="comment" required="required"><?=stripslashes($comment)?></textarea>
								</td>
							</tr>
							<tr>
								<td class="ver-top"><label>Lịch trình:</label></td>
								<td colspan="3">
									<textarea class="form-control" name="schedule" id="schedule"><?=stripslashes($schedule)?></textarea>
								</td>
							</tr>
							<tr>
								<td class="ver-top"><label>Bảng giá & Dịch vụ:</label></td>
								<td colspan="3">
									<textarea class="form-control" name="price_list_service" id="service"><?=stripslashes($price_list_service)?></textarea>
								</td>
							</tr>
							<tr>
								<td class="ver-top"><label>Upload photos:</label></td>
								<td colspan="3">
									<input id="album" class="form-control file" type="file" name="images[]" data-max-file-count="15" accept="image/*" multiple>
								</td>
							</tr>
							<tr>
								<td class="ver-top"><label>Bản đồ:</label></td>
								<td colspan="3">
									<textarea class="form-control" name="maps" id="maps"><?=stripslashes($maps)?></textarea>
								</td>
							</tr>
							<tr>
								<td class="ver-top"><label>Video:</label></td>
								<td colspan="3">
									<textarea class="form-control" name="video" id="video"><?=stripslashes($video)?></textarea>
								</td>
							</tr>
							<tr>
								<td><label>Trạng thái:</label></td>
								<td colspan="3">
									<label class="radio-inline"><input type="radio" name="is_active" value="0" <?=$is_active==0?"checked":""?> > Đóng&nbsp;</label>
									<label class="radio-inline"><input type="radio" name="is_active" value="1" <?=$is_active==1?"checked":""?> > Mở&nbsp;</label>
								</td>
							</tr>
							<tr>
								<td><label>Nổi bật:</label></td>
								<td colspan="3">
									<label class="radio-inline"><input type="radio" name="hot" value="0" <?=$hot==0?"checked":""?> > Đóng&nbsp;</label>
									<label class="radio-inline"><input type="radio" name="hot" value="1" <?=$hot==1?"checked":""?> > Mở&nbsp;</label>
								</td>
							</tr>
							<tr>
								<td><label>Ghim trang chủ:</label></td>
								<td colspan="3">
									<label class="radio-inline"><input type="radio" name="pin" value="0" <?=$pin==0?"checked":""?> > Đóng&nbsp;</label>
									<label class="radio-inline"><input type="radio" name="pin" value="1" <?=$pin==1?"checked":""?> > Mở&nbsp;</label>
								</td>
							</tr>
							<tr>
								<td><label>Ngày đăng:</label></td>
								<td colspan="3"><input class="form-control input-datetime" type="text" name="created_time" style="width: 160px;"  value="<?=$created_time?>" ></td>
							</tr>
							<tr>
								<td class="tth-bg-df" colspan="4"><strong>SEO</strong> -<span class="tth-gp-text">Không bắt buộc phải nhập, dữ liệu được lấy tự động nếu rỗng.</span></td>
							</tr>
							<tr>
								<td class="tth-gp-l"><label>Title:</label></td>
								<td class="tth-gp-r" colspan="3"><input class="form-control" type="text" name="title" maxlength="255" value="<?=stripslashes($title)?>" ></td>
							</tr>
							<tr>
								<td class="tth-gp-l"><label>Description:</label></td>
								<td class="tth-gp-r" colspan="3"><input class="form-control" type="text" name="description" maxlength="255" value="<?=stripslashes($description)?>" ></td>
							</tr>
							<tr>
								<td class="tth-gp-l tth-gp-b"><label>Keywords:</label></td>
								<td class="tth-gp-r tth-gp-b" colspan="3"><input class="form-control" type="text" name="keywords" data-role="tagsinput" value="<?=stripslashes($keywords)?>" ></td>
							</tr>
							<tr>
								<td colspan="4" align="center">
									<button type="submit" class="btn btn-form-primary btn-form">Đồng ý</button> &nbsp;
									<button type="reset" class="btn btn-form-success btn-form">Làm lại</button> &nbsp;
									<button type="button" class="btn btn-form-info btn-form" onclick="location.href='?<?=TTH_PATH?>=tour_list&id=<?=$tour_menu_id?>'">Thoát</button>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
	<div class="slides"></div>
	<h3 class="title"></h3>
	<a class="prev">‹</a>
	<a class="next">›</a>
	<a class="close">×</a>
	<a class="play-pause"></a>
	<ol class="indicator"></ol>
</div>
<?php
$dir_dest = ROOT_DIR . DS .'uploads'. DS .'photos';
$list_img = "";
$p1 = $p2 = array();
$db->table = "uploads_tmp";
$db->condition = "upload_id = ".$upload_img_id;
$db->order = "";
$db->limit = "";
$rows = $db->select();
foreach ($rows as $row){
	$list_img = $row['list_img'];
}

$files_img = explode(";", $list_img);
if(count($files_img)>0) {
	for ($i = 0; $i < count($files_img); $i++) {
		if ($files_img[$i] != "" && file_exists($dir_dest . DS . $files_img[$i])) {
			$src = "/uploads/photos/" . $files_img[$i];
			$l_key = explode("_", $files_img[$i]);
			$key = $l_key[0];
			$url = '/uploads/upload.php?type=2&id='.$upload_img_id.'&item='.$files_img[$i].'&lang='.TTH_LANGUAGE;
			$p1[$i] = '"<a href=\''.$src.'\' data-gallery><img src=\''.$src.'\' class=\'file-preview-image\'></a>"';
			$p2[$i] = '{url: "'.$url.'", key: '.$key.'}';
		}
	}
}
?>
<script>
	function onchange_departure() {
		$("#date_always").attr("checked", false);
	}
	function onchange_date() {
		$("#date_departure").val('');
	}
	$(".file-img").fileinput({
		<?php if($img!='no' && $img!='') { ?>
		initialPreview: [
			"<img src='../uploads/tour/<?=$img?>' class='file-preview-image' title='<?=$img?>' alt='<?=$img?>'>"
		],
		<?php } ?>
		'allowedFileExtensions' : ['jpg', 'png','gif']
	});
	$("#album").fileinput({
		uploadUrl: "/uploads/upload.php?type=1&id=<?=$upload_img_id?>&lang=<?=TTH_LANGUAGE?>",
		uploadAsync: false,
		initialPreview: [
			<?php echo implode(',', $p1);?>
		],
		initialPreviewConfig: [
			<?php echo implode(',', $p2);?>
		]
	});
	CKEDITOR.replace('schedule', {
			height: 250,
			toolbarGroups: [
				{ name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
				{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
				{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
				{ name: 'colors' },
				{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align'] },
				{ name: 'links' },
				{ name: 'insert' },
				{ name: 'tools' }
			]
		}
	);
	CKEDITOR.replace('service', {
			height: 250,
			toolbarGroups: [
				{ name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
				{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
				{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
				{ name: 'colors' },
				{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align'] },
				{ name: 'links' },
				{ name: 'insert' },
				{ name: 'tools' }
			]
		}
	);
	CKEDITOR.replace('maps', {
			height: 150,
			toolbarGroups: [
				{ name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
				{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align'] },
				{ name: 'others' },
				{ name: 'tools' }
			]
		}
	);
	CKEDITOR.replace('video', {
			height: 150,
			toolbarGroups: [
				{ name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
				{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align'] },
				{ name: 'others' },
				{ name: 'tools' }
			]
		}
	);
	$('.input-date').datetimepicker({
		lang:'vi',
		timepicker: false,
		format:'<?=TTH_DATE_FORMAT?>'
	});
	$('.input-datetime').datetimepicker({
		mask:'39/19/9999 29:59',
		lang:'vi',
		format:'<?=TTH_DATETIME_FORMAT?>'
	});
</script>
<?php
}
/**
 * @param $id
 * @param $par
 */
function categoryName($id) {
	echo '<select name="tour_menu_id" class="form-control">';
	global $db;
	$db->table = "category";
	$db->condition = "type_id = 9";
	$db->order = "sort ASC";
	$db->limit = "";
	$rows = $db->select();
	foreach($rows as $row) {
		echo "<option value='".$row["category_id"]."' disabled";
		echo ">".stripslashes($row["name"])."</option>";
		loadMenuCategory($db, 0, 0, $row["category_id"], $id);
	}
	echo '</select>';

}

/**
 * @param $db
 * @param $level
 * @param $parent
 * @param $category_id
 * @param $par
 */
function loadMenuCategory($db, $level, $parent, $category_id, $id){
	$space = "-&nbsp;-&nbsp;";
	for($i=0; $i<$level; $i++){
		$space.="-&nbsp;";
	}
	$db->table = "tour_menu";
	$db->condition = "category_id = ".$category_id." and parent = ".$parent;
	$db->order = "sort ASC";
	$db->limit = "";
	$rows2 = $db->select();
	foreach($rows2 as $row) {
		if ($level <= 3){
			echo "<option value='".$row["tour_menu_id"]."'";
			if ($id==$row["tour_menu_id"]) echo " selected ";
			echo ">".$space.stripslashes($row["name"])."</option>";
				loadMenuCategory($db, $level+2, $row["tour_menu_id"]+0, $row["category_id"]+0, $id);
		}
	}
}
?>
