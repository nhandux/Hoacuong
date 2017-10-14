<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
function locationMenu($act, $typeFunc, $location_menu_id, $category_id, $name, $parent, $is_active, $hot, $img, $error) {
	global $tth;
	dashboardCoreAdminTwo($tth.";".$category_id);
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-files-o"></i> Mục vị trí địa lý
			</div>
			<div class="panel-body">
				<div class="table-respon">
					<form action="<?=$act?>" method="post" enctype="multipart/form-data">
						<input type="hidden" name="typeFunc" value="<?=$typeFunc?>" />
						<input type="hidden" name="parent" value="<?=$parent?>" />
						<input type="hidden" name="location_menu_id" value="<?=$location_menu_id?>" />
						<input type="hidden" name="category_id" value="<?=$category_id?>" />
						<input type="hidden" name="img" value="<?=$img?>" />
						<div class="panel-show-error">
							<?=$error?>
						</div>
						<table class="table table-hover" style="width: 70%;">
							<tr>
								<td width="150px"><label>Tên mục:</label></td>
								<td><input class="form-control" type="text" id="name" name="name" maxlength="255" value="<?=stripslashes($name)?>" required="required" ></td>
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
								<td colspan="2" align="center">
									<button type="submit" class="btn btn-form-primary btn-form">Đồng ý</button> &nbsp;
									<button type="reset" class="btn btn-form-success btn-form">Làm lại</button> &nbsp;
									<button type="button" class="btn btn-form-info btn-form" onclick="location.href='?<?=TTH_PATH?>=location_manager'">Thoát</button>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('.file-img').fileinput({
		<?php if($img!='no' && $img!='') { ?>
		initialPreview: [
			"<img src='../uploads/location_menu/<?=$img?>' class='file-preview-image' title='<?=$img?>' alt='<?=$img?>'>"
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
	$db->condition = "type_id = 12";
	$db->order = "sort ASC";
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
	$db->table = "location_menu";
	$db->condition = "category_id = ".$category_id." and parent = ".$parent;
	$db->order = "sort ASC";
	$rows2 = $db->select();
	foreach($rows2 as $row) {
		if ($level <= 2){
			echo "<option value='".$row["category_id"]."'";
			if ($par==$row["location_menu_id"]) echo " selected ";
			echo ">".stripslashes($row["name"])."</option>";
				loadMenuCategory($db, $level+2, $row["location_menu_id"]+0, $row["category_id"]+0, $par);
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
	$db->table = "location_menu";
	$db->condition = "category_id = ".($id+0)." and parent = ".($parent+0);
	$db->order = "";
	$db->limit = "";
	$rows = $db->select();
	return $db->RowCount;
}
?>
