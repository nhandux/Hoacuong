<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
$project_menu_id = isset($_GET['id']) ? $_GET['id']+0 : $project_menu_id+0;
$db->table = "project_menu";
$db->condition = "project_menu_id = ".$project_menu_id;
$rows = $db->select();
if($db->RowCount==0) loadPageAdmin("Mục không tồn tại.","?".TTH_PATH."=project_manager");
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
			<a href="?<?=TTH_PATH?>=project_list&id=<?=$project_menu_id?>"><i class="fa fa-list"></i> <?=getNameMenu($project_menu_id, 'project')?></a>
		</li>
		<li>
			<i class="fa fa-plus-square-o"></i> Thêm bài viết
		</li>
	</ol>
</div>
<!-- /.row -->
<?php
include_once (_A_TEMPLATES . DS . "project.php");
if(empty($typeFunc)) $typeFunc = "no";

$date = new DateClass();

$dir_dest = ROOT_DIR . DS . 'uploads';
$OK = false;
$error = '';
if($typeFunc=='add'){
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
			'sort'=>sortAcs($project_menu_id+0)+1,
			'is_active'=>$is_active+0,
			'hot'=>$hot+0,
			'created_time'=>strtotime($date->dmYtoYmd($created_time)),
			'modified_time'=>time(),
			'user_id'=>$_SESSION["user_id"]
		);
		$db->insert($data);

		$db->table = "uploads_tmp";
		$data = array(
			'status'=>1
		);
		$db->condition = "upload_id = ".($upload_img_id+0);
		$db->update($data);
		$_SESSION['upload_id'] = 0;

		loadPageSucces("Đã thêm Bài viết thành công.","?".TTH_PATH."=project_list&id=".$project_menu_id);
		$OK = true;
	}
}
else {
	$upload_img_id  = 0;
	if($upload_img_id==0) {
		$db->table = "uploads_tmp";
		$data = array(
				'created_time'=>time()
		);
		$db->insert($data);
		$upload_img_id = $db->LastInsertID;
	}

	$name			    = "";
	$title			    = "";
	$description	    = "";
	$keywords		    = "";
	$content            = "";
	$is_active		    = 1;
	$hot			    = 0;
	$created_time       = $date->vnDateTime(time());
}
if(!$OK) project("?".TTH_PATH."=project_add", "add", 0, $project_menu_id, $name, $title, $description, $keywords, $content, $upload_img_id, $is_active, $hot, $created_time, $error);
?>