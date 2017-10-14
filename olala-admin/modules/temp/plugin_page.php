<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
function pagePlugin($act, $typeFunc, $page_id, $alias, $name, $comment, $content, $is_active, $error) {
	dashboardCoreAdmin();
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-files-o"></i> Nội dung trang
			</div>
			<div class="panel-body">
				<form action="<?=$act?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="typeFunc" value="<?=$typeFunc?>" />
					<input type="hidden" name="page_id" value="<?=$page_id?>" />
					<div class="panel-show-error">
						<?=$error?>
					</div>
					<table class="table table-hover">
						<tr>
							<td width="150px"><label>Alias:</label></td>
							<td><input class="form-control" type="text" name="alias" maxlength="255" value="<?=stripslashes($alias)?>" required="required" ></td>
						</tr>
						<tr>
							<td><label>Tên trang:</label></td>
							<td><input class="form-control" type="text" name="name" maxlength="255" value="<?=stripslashes($name)?>" required="required" ></td>
						</tr>
						<tr>
							<td class="ver-top"><label>Mô tả:</label></td>
							<td>
								<textarea class="form-control" rows="3" name="comment"><?=stripslashes($comment)?></textarea>
							</td>
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
							<td><label>Trạng thái:</label></td>
							<td>
								<label class="radio-inline"><input type="radio" name="is_active" value="0" <?=$is_active==0?"checked":""?> > Đóng</label>
								<label class="radio-inline"><input type="radio" name="is_active" value="1" <?=$is_active==1?"checked":""?> > Mở</label>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<button type="submit" class="btn btn-form-primary btn-form">Đồng ý</button> &nbsp;
								<button type="reset" class="btn btn-form-success btn-form">Làm lại</button> &nbsp;
								<button type="button" class="btn btn-form-info btn-form" onclick="location.href='?<?=TTH_PATH?>=plugin_page'">Thoát</button>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	CKEDITOR.replace( 'content');
</script>
<?php
}
?>
