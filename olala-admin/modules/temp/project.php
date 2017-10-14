<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
function project($act, $typeFunc, $project_id, $project_menu_id, $name, $title, $description, $keywords, $content, $upload_img_id, $is_active, $hot, $created_time, $error) {
	global $db, $tth;
	$db->table = "project_menu";
	$db->condition = "project_menu_id = ".$project_menu_id;
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
				<i class="fa fa-files-o"></i> Nội dung bài viết về dự án
			</div>
			<div class="panel-body table-responsive">
				<form action="<?=$act?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="typeFunc" value="<?=$typeFunc?>" />
					<input type="hidden" name="project_id" value="<?=$project_id?>" />
					<input type="hidden" name="upload_img_id" value="<?=$upload_img_id?>">
					<div class="panel-show-error">
						<?=$error?>
					</div>
					<table class="table table-hover">
						<tr>
							<td width="200px"><label>Tiêu đề:</label></td>
							<td><input class="form-control" type="text" name="name" maxlength="255" value="<?=stripslashes($name)?>" required="required" ></td>
						</tr>
						<tr>
							<td><label>Mục:</label></td>
							<td><?=categoryName($project_menu_id);?></td>
						</tr>
						<tr>
							<td><label>Nội dung chi tiết:</label></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea class="form-control" name="content" id="content" required="required" ><?=stripslashes($content)?></textarea>
							</td>
						</tr>
						<tr>
							<td class="ver-top"><label>Thư viện hình:</label></td>
							<td>
								<input id="album" class="form-control file" type="file" name="images[]" data-max-file-count="15" accept="image/*" multiple>
							</td>
						</tr>
						<tr>
							<td><label>Trạng thái:</label></td>
							<td>
								<label class="radio-inline"><input type="radio" name="is_active" value="0" <?=$is_active==0?"checked":""?> > Đóng</label>
								<label class="radio-inline"><input type="radio" name="is_active" value="1" <?=$is_active==1?"checked":""?> > Mở</label>
							</td>
						</tr>
						<tr>
							<td><label>Nổi bật:</label></td>
							<td>
								<label class="radio-inline"><input type="radio" name="hot" value="0" <?=$hot==0?"checked":""?> > Đóng</label>
								<label class="radio-inline"><input type="radio" name="hot" value="1" <?=$hot==1?"checked":""?> > Mở</label>
							</td>
						</tr>
						<tr>
							<td><label>Ngày đăng:</label></td>
							<td><input class="form-control" id="input-datetime" type="text" name="created_time" style="width: 160px;"  value="<?=$created_time?>" ></td>
						</tr>
						<tr>
							<td class="tth-bg-df" colspan="2"><strong>SEO</strong> -<span class="tth-gp-text">Không bắt buộc phải nhập, dữ liệu được lấy tự động nếu rỗng.</span></td>
						</tr>
						<tr>
							<td class="tth-gp-l"><label>Title:</label></td>
							<td class="tth-gp-r"><input class="form-control" type="text" name="title" maxlength="255" value="<?=stripslashes($title)?>" ></td>
						</tr>
						<tr>
							<td class="tth-gp-l"><label>Description:</label></td>
							<td class="tth-gp-r"><input class="form-control" type="text" name="description" maxlength="255" value="<?=stripslashes($description)?>" ></td>
						</tr>
						<tr>
							<td class="tth-gp-l tth-gp-b"><label>Keywords:</label></td>
							<td class="tth-gp-r tth-gp-b"><input class="form-control" type="text" name="keywords" data-role="tagsinput" value="<?=stripslashes($keywords)?>" ></td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<button type="submit" class="btn btn-form-primary btn-form">Đồng ý</button> &nbsp;
								<button type="reset" class="btn btn-form-success btn-form">Làm lại</button> &nbsp;
								<button type="button" class="btn btn-form-info btn-form" onclick="location.href='?<?=TTH_PATH?>=project_list&id=<?=$project_menu_id?>'">Thoát</button>
							</td>
						</tr>
					</table>
				</form>
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
	CKEDITOR.replace('content', {
			height: 300}
	);
	$('#input-datetime').datetimepicker({
		mask:'39/19/9999 29:59',
		lang:'vi',
		format:'<?=TTH_DATETIME_FORMAT?>'
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
</script>
<?php
}
/**
 * @param $id
 * @param $par
 */
function categoryName($id) {
	echo '<select name="project_menu_id" class="form-control">';
	global $db;
	$db->table = "category";
	$db->condition = "type_id = 17";
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
	$db->table = "project_menu";
	$db->condition = "category_id = ".$category_id." and parent = ".$parent;
	$db->order = "sort ASC";
	$db->limit = "";
	$rows2 = $db->select();
	foreach($rows2 as $row) {
		if ($level <= 3){
			echo "<option value='".$row["project_menu_id"]."'";
			if ($id==$row["project_menu_id"]) echo " selected ";
			echo ">".$space.stripslashes($row["name"])."</option>";
				loadMenuCategory($db, $level+2, $row["project_menu_id"]+0, $row["category_id"]+0, $id);
		}
	}
}

function sortAcs($id = 0){
	global $db;
	$db->table = "project";
	$db->condition = "project_menu_id = " . $id;
	$db->order = "";
	$db->limit = "";
	$db->select();
	return $db->RowCount;
}
