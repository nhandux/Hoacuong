<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
function street($act, $typeFunc, $street_id, $name, $slug, $is_active, $hot, $error) {
	dashboardCoreAdmin();
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-files-o"></i> Chuyên mục đường phố
			</div>
			<div class="panel-body">
				<form action="<?=$act?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="typeFunc" value="<?=$typeFunc?>" />
					<input type="hidden" name="street_id" value="<?=$street_id?>" />
					<div class="panel-show-error">
						<?=$error?>
					</div>
					<table class="table table-hover" style="width: 70%;">
						<tr>
							<td width="150px"><label>Tên đường:</label></td>
							<td><input class="form-control" type="text" id="name" name="name" maxlength="255" value="<?=stripslashes($name)?>" required="required" ></td>
						</tr>
						<tr>
							<td width="150px"><label>Tên xử lý:</label></td>
							<td class="element-relative">
								<input class="form-control" type="text" id="slug" name="slug" maxlength="255" value="<?=stripslashes($slug)?>" >
								<div data-toggle="tooltip" data-placement="top" title="Tạo liên kết tĩnh" class="btn-get-slug" onclick="return getSlugOther()"></div>
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
								<button type="button" class="btn btn-form-info btn-form" onclick="location.href='?<?=TTH_PATH?>=street_manager'">Thoát</button>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
}
/**
 * @param $id
 * @param $parent
 * @return mixed
 */
function sortAcs(){
	global $db;
	$db->table = "street";
	$db->condition = "";
	$db->order = "";
	$db->limit = "";
	$db->select();
	return $db->RowCount;
}
?>
