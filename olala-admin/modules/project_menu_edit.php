<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
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
			<i class="fa fa-cog"></i> Chỉnh sửa chuyên mục
		</li>
	</ol>
</div>
<!-- /.row -->
<?php
include_once (_A_TEMPLATES . DS . "project_menu.php");
if(empty($typeFunc)) $typeFunc = "no";
$project_menu_id =  isset($_GET['id']) ? $_GET['id']+0 : $project_menu_id+0;
$db->table = "project_menu";
$db->condition = "project_menu_id = ".$project_menu_id;
$rows = $db->select();
if($db->RowCount==0) loadPageAdmin("Chuyên mục không tồn tại.","?".TTH_PATH."=project_manager");

$OK = false;
$error = '';
if($typeFunc=='edit'){
	if(empty($name)) $error = '<span class="show-error">Vui lòng nhập tên chuyên mục.</span>';
	else {
		$handleUploadImg = false;
		$file_max_size = FILE_MAX_SIZE;
		$dir_dest = ROOT_DIR . DS . 'uploads' . DS . 'project_menu';
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
			$stringObj = new String();

			$slug = (empty($slug)) ? $name : $slug;
			$slug = $stringObj->getSlug($slug);
			$db->table = "project_menu";
			$db->condition = "slug = '".$slug."'";
			$rows = $db->select();
			$id = 0;
			foreach ($rows as $row) {
				$id = $row['project_menu_id'];
			}
			if($db->RowCount > 0 && $id != $project_menu_id) {
				$slug = $slug. '-' .$stringObj->getSlug(getRandomString(10));
			}
			$legal = (isset($legal)) ? $legal : '';
			$location = (isset($location_id)) ? $location_id : '';
			$geo_radius = (isset($geo_radius)) ? $geo_radius : '';
			$project_use = (isset($project_use)) ? implode(',',$project_use) : '';
			$project_hot = (isset($project_hot)) ? implode(',',$project_hot) : '';
			$project_involve = (isset($project_involve)) ? implode(',',$project_involve) : '';
			//-----------------------------------------------

			$id_query = 0;
			$db->table = "project_menu";
			$data = array(
				'name'=>$db->clearText($name),
				'slug'=>$db->clearText($slug),
				'title'=>$db->clearText($title),
				'description'=>$db->clearText($description),
				'keywords'=>$db->clearText($keywords),
				'is_active'=>$is_active+0,
				'hot'=>$hot+0,
				'comment'=>$db->clearText($comment),
				'project_type'=>$project_type+0,
				'price_max'=>formatNumberToInt($price_max),
				'price_min'=>formatNumberToInt($price_min),
				'legal'=>$legal+0,
				'location'=>$location+0,
				'geo_radius'=>$geo_radius+0,
				'project_use'=>$db->clearText($project_use),
				'project_hot'=>$db->clearText($project_hot),
				'project_involve'=>$db->clearText($project_involve),
				'modified_time'=>time(),
				'user_id'=>$_SESSION["user_id"]
			);
			$db->condition = "project_menu_id = ".$project_menu_id;
			$db->update($data);
			$id_query = $project_menu_id;

			if($handleUploadImg) {
				$stringObj = new String();

				if(glob($dir_dest . DS .'*'.$img)) array_map("unlink", glob($dir_dest . DS .'*'.$img));

				$img_name_file = getRandomString().'-'.$id_query.'-'.substr($stringObj->getSlug($name),0,120);

				$imgUp->file_new_name_body      = $img_name_file;
				$imgUp->image_resize            = true;
				$imgUp->image_ratio_crop        = true;
				$imgUp->image_y                 = 331;
				$imgUp->image_x                 = 450;

				$imgUp->Process($dir_dest);
				if($imgUp->processed) {
					$name_img = $imgUp->file_dst_name;
					$db->table = "project_menu";
					$data = array(
						'img'=>$db->clearText($name_img)
					);
					$db->condition = "project_menu_id = ".$id_query;
					$db->update($data);
				}
                else {
                    loadPageAdmin("Lỗi tải hình: ".$imgUp->error,"?".TTH_PATH."=project_manager");
                }

				$imgUp->file_new_name_body      = 'hm_' . $img_name_file;
				$imgUp->image_resize            = true;
				$imgUp->image_ratio_crop        = true;
				$imgUp->image_y                 = 220;
				$imgUp->image_x                 = 500;
				$imgUp->Process($dir_dest);

				$imgUp-> Clean();
			}

			loadPageSucces("Đã chỉnh sửa Chuyên mục thành công.","?".TTH_PATH."=project_manager");
			$OK = true;
		}
	}
}
else {
	$db->table = "project_menu";
	$db->condition = "project_menu_id = ".$project_menu_id;
	$rows = $db->select();
	foreach($rows as $row) {
		$category_id        = $row['category_id']+0;
		$name			    = $row['name'];
		$slug			    = $row['slug'];
		$title			    = $row['title'];
		$description	    = $row['description'];
		$keywords		    = $row['keywords'];
		$parent			    = $row['parent'];
		$is_active		    = $row['is_active']+0;
		$hot			    = $row['hot']+0;
		$img                = $row['img'];
		$comment            = $row['comment'];
		$project_type       = $row['project_type']+0;
		$price_max          = $row['price_max']+0;
		$price_min          = $row['price_min']+0;
		$legal              = $row['legal']+0;
		$location           = $row['location']+0;
		$geo_radius         = $row['geo_radius']+0;
		$project_use        = explode(',', $row['project_use']);
		$project_hot        = explode(',', $row['project_hot']);
		$project_involve    = explode(',', $row['project_involve']);
	}
}
if(!$OK) projectMenu("?".TTH_PATH."=project_menu_edit", "edit", $project_menu_id, $category_id, $name, $slug, $title, $description, $keywords, $parent, $is_active, $hot, $img, $comment, $project_type, $price_max, $price_min, $legal, $location, $geo_radius, $project_use, $project_hot, $project_involve, $error);
?>
