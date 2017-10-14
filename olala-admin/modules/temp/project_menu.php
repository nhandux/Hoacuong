<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
function projectMenu($act, $typeFunc, $project_menu_id, $category_id, $name, $slug, $title, $description, $keywords, $parent, $is_active, $hot, $img, $comment, $type_project, $price_max, $price_min, $legal, $location, $geo_radius, array $project_use, array $project_hot, array $project_involve, $error) {
	global $tth;
	dashboardCoreAdminTwo($tth.";".$category_id);
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-files-o"></i> Dự án
			</div>
			<div class="panel-body">
				<form action="<?=$act?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="typeFunc" value="<?=$typeFunc?>" />
					<input type="hidden" name="parent" value="<?=$parent?>" />
					<input type="hidden" name="project_menu_id" value="<?=$project_menu_id?>" />
					<input type="hidden" name="category_id" value="<?=$category_id?>" />
					<input type="hidden" name="img" value="<?=$img?>" />
					<div class="panel-show-error">
						<?=$error?>
					</div>
					<table class="table table-hover" style="width: 80%;">
						<tr>
							<td width="200px"><label>Tên dự án:</label></td>
							<td><input class="form-control" type="text" id="name" name="name" maxlength="255" value="<?=stripslashes($name)?>" required="required" ></td>
						</tr>
						<tr>
							<td width="150px"><label>Liên kết tĩnh:</label></td>
							<td class="element-relative">
								<input class="form-control" type="text" id="slug" name="slug" maxlength="255" value="<?=stripslashes($slug)?>" >
								<div data-toggle="tooltip" data-placement="top" title="Tạo liên kết tĩnh" class="btn-get-slug" onclick="return getSlug('project')"></div>
							</td>
						</tr>
						<tr>
							<td><label>Mục cha:</label></td>
							<td><?=categoryName($category_id, $parent);?></td>
						</tr>
						<tr>
							<td class="ver-top"><label>Hình đại diện:</label></td>
							<td>
								<input class="form-control file file-img" type="file" name="img" data-show-upload="false" data-max-file-count="1" accept="image/*">
							</td>
						</tr>
						<tr>
							<td class="ver-top"><label>Mô tả:</label></td>
							<td>
								<textarea class="form-control" rows="3" name="comment"><?=stripslashes($comment)?></textarea>
							</td>
						</tr>
						<tr>
							<td><label>Loại dự án:</label></td>
							<td><?=loadTypeProject($type_project);?></td>
						</tr>
						<tr>
							<td class="ver-top"><label>Giá thành sản phẩm:</label></td>
							<td>
								<div class="col-lg-3 col-md-6"><span class="tth-ln-0">Giá cao nhất:</span><input class="form-control auto-money" type="text" name="price_max" data-a-sep="." data-a-dec="," data-v-max="999999999999999" data-v-min="0" maxlength="15" value="<?=$price_max?>" ></div>
								<div class="col-lg-3 col-md-6"><span class="tth-ln-0">Giá thấp nhất:</span><input class="form-control auto-money" type="text" name="price_min" data-a-sep="." data-a-dec="," data-v-max="999999999999999" data-v-min="0" maxlength="15" value="<?=$price_min?>" ></div>
							</td>
						</tr>
						<tr>
							<td class="ver-top"><label>Pháp lý:</label></td>
							<td>
								<label class="radio-inline"><input type="radio" name="legal" value="1" <?=$legal==1?"checked":""?> > Sổ đỏ</label>
								<label class="radio-inline"><input type="radio" name="legal" value="2" <?=$legal==2?"checked":""?> > Hợp đồng góp vốn</label>
							</td>
						</tr>
						<tr>
							<td class="tth-gp-b tth-bg-df" colspan="2"><span class="tth-gp-text">Vị trí địa lý:</span></td>
						</tr>
						<tr>
							<td class="tth-gp-l"><label>Theo địa giới hành chính:</label></td>
							<td class="tth-gp-r">
								<div class="col-lg-3 col-md-6"><?=loadCity($location);?></div>
								<div class="col-lg-3 col-md-6"><?=loadDistrict($location);?></div>
								<div class="col-lg-3 col-md-6"><?=loadLocation($location);?></div>
							</td>
						</tr>
						<tr>
							<td class="tth-gp-l tth-gp-b"><label>Theo bán kính:</label></td>
							<td class="tth-gp-r tth-gp-b">
								<div class="col-lg-3 col-md-6"><?=geographicalRadius($geo_radius);?></div>
							</td>
						</tr>
						<tr>
							<td class="ver-top"><label>Mục đích sử dụng:</label></td>
							<td><?=projectGetUse($project_use);?></td>
						</tr>
						<tr>
							<td class="ver-top"><label>Dự án nổi bật:</label></td>
							<td><?=projectHot($project_hot);?></td>
						</tr>
						<tr>
							<td class="ver-top"><label>Quan hệ của dự án:</label></td>
							<td><?=projectInvolve($project_involve);?></td>
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
								<button type="button" class="btn btn-form-info btn-form" onclick="location.href='?<?=TTH_PATH?>=project_manager'">Thoát</button>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$('.file-img').fileinput({
		<?php if($img!='no' && $img!='') { ?>
		initialPreview: [
			"<img src='../uploads/project_menu/<?=$img?>' class='file-preview-image' title='<?=$img?>' alt='<?=$img?>'>"
		],
		<?php } ?>
		allowedFileExtensions : ['jpg', 'png','gif']
	});
</script>
<?php
}

/**
 * @param $id
 * @param $par
 */
function categoryName($id, $par) {
	echo '<select class="form-control" disabled>';
	global $db;
	$db->table = "category";
	$db->condition = "type_id = 17";
	$db->order = "sort ASC";
	$db->limit = "";
	$rows = $db->select();
	foreach($rows as $row) {
		echo "<option value='".$row["category_id"]."'";
		if ($id==$row["category_id"] && $par==0) echo " selected ";
		echo ">".stripslashes($row["name"])."</option>";
		loadMenuCategory($db, 0, 0, $row["category_id"], $par);
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
function loadMenuCategory($db, $level, $parent, $category_id, $par){
	$db->table = "project_menu";
	$db->condition = "category_id = ".$category_id." and parent = ".$parent;
	$db->order = "sort ASC";
	$db->limit = "";
	$rows2 = $db->select();
	foreach($rows2 as $row) {
		if ($level <= 2){
			echo "<option value='".$row["category_id"]."'";
			if ($par==$row["project_menu_id"]) echo " selected ";
			echo ">".stripslashes($row["name"])."</option>";
				loadMenuCategory($db, $level+2, $row["project_menu_id"]+0, $row["category_id"]+0, $par);
		}
	}
}

/**
 * @param $id
 * @param $parent
 * @return mixed
 */
function sortAcs($id,$parent){
	global $db;
	$db->table = "project_menu";
	$db->condition = "category_id = ".($id+0)." and parent = ".($parent+0);
	$db->order = "";
	$db->limit = "";
	$rows = $db->select();
	return $db->RowCount;
}
?>
