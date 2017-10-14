<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
$gallery_menu_id = isset($_GET['id']) ? $_GET['id']+0 : $gallery_menu_id+0;
$db->table = "gallery_menu";
$db->condition = "gallery_menu_id = ".$gallery_menu_id;
$rows = $db->select();
if($db->RowCount==0) loadPageAdmin("Mục không tồn tại.","?".TTH_PATH."=gallery_manager");
$category_id = 0;
foreach($rows as $row) {
	$category_id =	$row["category_id"]+0;
}
?>
<!-- Menu path -->
<div class="row">
	<ol class="breadcrumb">
		<li>
			<a href="<?=ADMIN_DIR?>"><i class="fa fa-home"></i> Trang chủ</a>
		</li>
		<li>
			<a href="?<?=TTH_PATH?>=gallery_manager"><i class="fa fa-edit"></i> Quản lý nội dung</a>
		</li>
		<li>
			<a href="?<?=TTH_PATH?>=gallery_manager"><i class="fa fa-image"></i> Hình ảnh</a>
		</li>
		<li>
			<a href="?<?=TTH_PATH?>=gallery_list&id=<?=$gallery_menu_id?>"><i class="fa fa-list"></i> <?=getNameMenuGal($gallery_menu_id)?></a>
		</li>
		<li>
			<i class="fa fa-plus-square-o"></i> Thêm hình ảnh
		</li>
	</ol>
</div>
<!-- /.row -->
<?php
include_once (_A_TEMPLATES . DS . "gallery.php");
if(empty($typeFunc)) $typeFunc = "no";

$date = new DateClass();

$file_max_size = FILE_MAX_SIZE;
$dir_dest = ROOT_DIR . DS .'uploads' . DS . "gallery";
$OK = false;
$error = '';
if($typeFunc=='add'){
	if(empty($name)) $error = '<span class="show-error">Vui lòng nhập tên hình.</span>';
	else {
		$handleUploadImg = false;
		$file_size = $_FILES['img']['size'];

		if($file_size>0) {
			$imgUp = new Upload($_FILES['img']);

			$imgUp->file_max_size = $file_max_size;
			if ($imgUp->uploaded) {
				$handleUploadImg = true;
				$OK = true;
			}
			else {
				$error = '<span class="show-error">Lỗi tải hình: '.$imgUp->error.'</span>';
			}
		}
		else {
			$handleUploadImg = false;
			$OK = true;
		}

		if($OK) {
			$id_query = 0;
			$db->table = "gallery";
			$data = array(
				'gallery_menu_id'=>$gallery_menu_id+0,
				'name'=>$db->clearText($name),
				'upload_id'=>$upload_img_id+0,
				'comment'=>$db->clearText($comment),
				'content'=>$db->clearText($content),
				'link'=>$db->clearText($link),
				'is_active'=>$is_active+0,
				'hot'=>$hot+0,
				'created_time'=>strtotime($date->dmYtoYmd($created_time)),
				'modified_time'=>time(),
				'user_id'=>$_SESSION["user_id"]
			);
			$db->insert($data);
			$id_query = $db->LastInsertID;

			if($handleUploadImg) {
				$stringObj = new String();

				$name_image = getRandomString().'-'.$id_query.'-'.substr($stringObj->getSlug($name),0,120);

				$imgUp->file_new_name_body    = $name_image;
				$imgUp->image_resize          = true;
				$imgUp->image_ratio_crop      = true;
				$imgUp->image_y               = 256;
				$imgUp->image_x               = 490;
				$imgUp->Process($dir_dest);

				if($imgUp->processed) {
					$name_img = $imgUp->file_dst_name;
					$db->table = "gallery";
					$data = array(
						'img'=>$db->clearText($name_img)
					);
					$db->condition = "gallery_id = ".$id_query;
					$db->update($data);
				}
                else {
                    loadPageAdmin("Lỗi tải hình: ".$imgUp->error,"?".TTH_PATH."=gallery_list&id=".$gallery_menu_id);
                }

				if($category_id==75) {
					$imgUp->file_new_name_body = 'slider-' . $name_image;
					$imgUp->image_resize = true;
					$imgUp->image_ratio_crop = true;
					$imgUp->image_y = 499;
					$imgUp->image_x = 1600;
					$imgUp->Process($dir_dest);
				} else {
					$imgUp->file_new_name_body = 'gal-' . $name_image;
					$imgUp->image_resize = true;
					$imgUp->image_ratio_crop = true;
					$imgUp->image_y = 162;
					$imgUp->image_x = 221;
					$imgUp->Process($dir_dest);
				}

				$imgUp-> Clean();
			}

			$db->table = "uploads_tmp";
			$data = array(
				'status'=>1
			);
			$db->condition = "upload_id = ".($upload_img_id+0);
			$db->update($data);
			$_SESSION['upload_id'] = 0;

			loadPageSucces("Đã thêm Hình ảnh thành công.","?".TTH_PATH."=gallery_list&id=".$gallery_menu_id);
			$OK = true;
		}
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
	$name			= "";
	$comment        = "";
	$content        = "";
	$link           = "";
	$is_active		= 1;
	$hot			= 0;
	$created_time   = $date->vnDateTime(time());
}
if(!$OK) gallery("?".TTH_PATH."=gallery_add", "add", 0, $gallery_menu_id, $name, "", $comment, $content, $link, $is_active, $hot, $created_time, $upload_img_id, $error);
?>