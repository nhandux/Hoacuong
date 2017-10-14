<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
$product_id = isset($_GET['id']) ? $_GET['id']+0 : $product_id+0;
$db->table = "product";
$db->condition = "product_id = ".$product_id;
$db->order = "";
$rows = $db->select();
foreach($rows as $row) {
	$menu_id    = $row['product_menu_id'];
}
if($db->RowCount==0) loadPageAdmin("Dữ liệu không tồn tại.","?".TTH_PATH."=product_manager");
?>
<!-- Menu path -->
<div class="row">
	<ol class="breadcrumb">
		<li>
			<a href="<?=ADMIN_DIR?>"><i class="fa fa-home"></i> Trang chủ</a>
		</li>
		<li>
			<a href="?<?=TTH_PATH?>=product_manager"><i class="fa fa-edit"></i> Quản lý nội dung</a>
		</li>
		<li>
			<a href="?<?=TTH_PATH?>=product_manager"><i class="fa fa-bookmark"></i> Sản phẩm</a>
		</li>
		<li>
			<a href="?<?=TTH_PATH?>=product_list&id=<?=$menu_id?>"><i class="fa fa-list"></i> <?=getNameMenu($menu_id, 'product')?></a>
		</li>
		<li>
			<i class="fa fa-cog"></i> Chỉnh sửa sản phẩm
		</li>
	</ol>
</div>
<!-- /.row -->
<?php
include_once (_A_TEMPLATES . DS . "product.php");
if(empty($typeFunc)) $typeFunc = "no";

$date = new DateClass();
$OK = false;
$error = '';
if($typeFunc=='edit'){
	if(empty($name)) $error = '<span class="show-error">Vui lòng nhập tiêu đề.</span>';
	else {
		$handleUploadImg = false;
		$file_max_size = FILE_MAX_SIZE;
		$dir_dest = ROOT_DIR . DS . 'uploads' . DS . 'product';
		$file_size = $_FILES['img']['size'];

		if($file_size>0) {
			$imgUp = new Upload($_FILES['img']);

			$imgUp->file_max_size = $file_max_size;
			if ($imgUp->uploaded) {
				$handleUploadImg = true;
				$OK = true;
			}
			else {
				$error = '<span class="show-error">Hình ảnh: '.$imgUp->error.'</span>';
			}
		}
		else {
			$handleUploadImg = false;
			$OK = true;
		}
		if(isset($del_img)) {
			$handleUploadImg = false;

			if(glob($dir_dest.'*'.$img)) array_map("unlink", glob($dir_dest.'*'.$img));

			$db->table = "product";
			$data = array(
				'img'=>'no'
			);
			$db->condition = "product_id = ".$product_id;
			$db->update($data);
		}

		if($OK) {
			$id_query = 0;
			$db->table = "product";
			$data = array(
				'product_menu_id'=>$product_menu_id+0,
				'name'=>$db->clearText($name),
				'img_note'=>$db->clearText($img_note),
				'product_keys'=>$db->clearText($product_keys),
				'price'=>formatNumberToInt($price),
				'model'=>$db->clearText($model),
				'sale'=>formatNumberToInt($sale),
				'comment'=>$db->clearText($comment),
				'content'=>$db->clearText($content),
				'upload_id'=>$upload_img_id+0,
				'is_active'=>$is_active+0,
				'hot'=>$hot+0,
				'pin'=>$pin+0,
				'title'=>$db->clearText($title),
				'description'=>$db->clearText($description),
				'keywords'=>$db->clearText($keywords),
				'created_time'=>strtotime($date->dmYtoYmd($created_time)),
				'modified_time'=>time(),
				'user_id'=>$_SESSION["user_id"]
			);
			$db->condition = "product_id = ".$product_id;
			$db->update($data);
			$id_query = $product_id;

			if($handleUploadImg) {
				$stringObj = new String();

				if(glob($dir_dest . DS .'*'.$img)) array_map("unlink", glob($dir_dest . DS .'*'.$img));

				$name_image = getRandomString() . '-' . $id_query . '-' . substr($stringObj->getSlug($name),0,120);
				$imgUp->file_new_name_body      = $name_image;
				$imgUp->image_resize            = true;
				$imgUp->image_ratio_crop        = true;
				$imgUp->image_y                 = 256;
				$imgUp->image_x                 = 490;
				$imgUp->Process($dir_dest);

				if($imgUp->processed) {
					$name_img = $imgUp->file_dst_name;
					$db->table = "product";
					$data = array(
						'img'=>$db->clearText($name_img)
					);
					$db->condition = "product_id = ".$id_query;
					$db->update($data);
				}

				$imgUp->file_new_name_body      = 'product-' . $name_image;
				$imgUp->image_resize            = true;
				$imgUp->image_ratio_crop        = true;
				$imgUp->image_y                 = 292;
				$imgUp->image_x                 = 380;
				$imgUp->Process($dir_dest);

				$imgUp-> Clean();
			}

			loadPageSucces("Đã chỉnh sửa dữ liệu thành công.","?".TTH_PATH."=product_list&id=".$product_menu_id);
			$OK = true;
		}
	}
}
else {
	$db->table = "product";
	$db->condition = "product_id = ".$product_id;
	$rows = $db->select();
	foreach($rows as $row) {
		$product_menu_id    = $row['product_menu_id']+0;
		$name			    = $row['name'];
		$img                = $row['img'];
		$img_note           = $row['img_note'];
		$product_keys       = $row['product_keys'];
		$price              = ($row['price']+0==0) ? "" : $row['price']+0;
		$model              = $row['model'];
		$sale               = $row['sale']+0;
		$comment            = $row['comment'];
		$content            = $row['content'];
		$upload_img_id      = $row['upload_id']+0;
		$is_active		    = $row['is_active']+0;
		$hot			    = $row['hot']+0;
		$pin                = $row['pin']+0;
		$title			    = $row['title'];
		$description	    = $row['description'];
		$keywords		    = $row['keywords'];
		$created_time       = $date->vnDateTime($row['created_time']);
	}
}
if(!$OK) product("?".TTH_PATH."=product_edit", "edit", $product_id, $product_menu_id, $name, $img, $img_note, $product_keys, $price, $model, $sale, $comment, $content, $upload_img_id, $is_active, $hot, $pin, $created_time, $title, $description, $keywords, $error);
?>