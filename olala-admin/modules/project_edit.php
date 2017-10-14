<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
$project_id = isset($_GET['id']) ? $_GET['id']+0 : $project_id+0;
$db->table = "project";
$db->condition = "project_id = ".$project_id;
$db->order = "";
$rows = $db->select();
foreach($rows as $row) {
	$menu_id    = $row['project_menu_id'];
}
if($db->RowCount==0) loadPageAdmin("Bài viết không tồn tại.","?".TTH_PATH."=project_manager");
?>
<!-- Menu path -->
<div class="row">
	<ol class="breadcrumb">
		<li>
			<a href="<?=ADMIN_DIR?>"><i class="fa fa-home"></i> Trang chủ</a>
		</li>
		<li>
			<a href="?<?=TTH_PATH?>=project_manager"><i class="fa fa-edit"></i> Quản lý nội dung</a>
		</li>
		<li>
			<a href="?<?=TTH_PATH?>=project_manager"><i class="fa fa-cubes"></i> Dự án đầu tư</a>
		</li>
		<li>
			<a href="?<?=TTH_PATH?>=project_list&id=<?=$menu_id?>"><i class="fa fa-list"></i> <?=getNameMenu($menu_id, 'project')?></a>
		</li>
		<li>
			<i class="fa fa-cog"></i> Chỉnh sửa bài viết
		</li>
	</ol>
</div>
<!-- /.row -->
<?php
include_once (_A_TEMPLATES . DS . "project.php");
if(empty($typeFunc)) $typeFunc = "no";

$date = new DateClass();

$OK = false;
$error = '';
if($typeFunc=='edit'){
	if(empty($name)) $error = '<span class="show-error">Vui lòng nhập tiêu đề bài viết.</span>';
	else {
		$db->table = "project";
		$data = array(
			'project_menu_id'=>$project_menu_id+0,
			'name'=>$db->clearText($name),
			'title'=>$db->clearText($title),
			'description'=>$db->clearText($description),
			'keywords'=>$db->clearText($keywords),
			'content'=>$db->clearText($content),
			'upload_id'=>$upload_img_id+0,
			'is_active'=>$is_active+0,
			'hot'=>$hot+0,
			'created_time'=>strtotime($date->dmYtoYmd($created_time)),
			'modified_time'=>time(),
			'user_id'=>$_SESSION["user_id"]
		);
		$db->condition = "project_id = ".$project_id;
		$db->update($data);

		loadPageSucces("Đã chỉnh sửa Bài viết thành công.","?".TTH_PATH."=project_list&id=".$project_menu_id);
		$OK = true;
	}
}
else {
	$db->table = "project";
	$db->condition = "project_id = ".$project_id;
	$rows = $db->select();
	foreach($rows as $row) {
		$project_menu_id    = $row['project_menu_id']+0;
		$name			    = $row['name'];
		$title			    = $row['title'];
		$description	    = $row['description'];
		$keywords		    = $row['keywords'];
		$content            = $row['content'];
		$upload_img_id      = $row['upload_id'];
		$is_active		    = $row['is_active']+0;
		$hot			    = $row['hot']+0;
		$created_time       = $date->vnDateTime($row['created_time']);
	}
}
if(!$OK) project("?".TTH_PATH."=project_edit", "edit", $project_id, $project_menu_id,  $name, $title, $description, $keywords, $content, $upload_img_id, $is_active, $hot, $created_time, $error);
?>