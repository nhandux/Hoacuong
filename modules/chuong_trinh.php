<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
$id = 0;
if($id_menu > 0) {
	$parent = false;
	$db->table = "article_menu";
	$db->condition = "is_active = 1 and article_menu_id = ".$id_menu;
	$db->order = "";
	$db->limit = 1;
	$rows = $db->select();
	foreach($rows as $row) {
		$parent = ($row['parent']+0 == 0) ? true : false;
	}
	if($parent) {
		$loc = array();
		$db->table = "article_menu";
		$db->condition = "is_active = 1 and parent = ".$id_menu;
		$db->order = "sort ASC";
		$db->limit = "";
		$rows = $db->select();
		$stt=0;
		if($db->RowCount>0) {
			foreach($rows as $row) {
				$loc[$stt] = $row['article_menu_id'];
				$stt++;
			}
			$loc = implode(',',$loc);
			$loc = $id_menu . ','.$loc;
		} else {
			$loc = $id_menu;
		}
	} else {
		$loc = $id_menu;
	}

	$db->table = "article";
	$db->condition = "is_active = 1 and article_menu_id IN (".$loc.")";
	$db->order = "created_time DESC";
	$db->limit = "";
	$rows = $db->select();

	$total = $db->RowCount;
	if ($total==1) {
		foreach($rows as $row) {
			$id = $row['article_id'];
		}
	}

}
if($id==807) {
$date = new DateClass();
$stringObj = new String();

//---------------[ box-wp BEGIN ]---------------------------
$category_id = 0;
$breadcrumb_home = '<a href="'. HOME_URL_LANG . '" title="' . $lgTxt_menu_home . '"><i class="fa fa-home"></i></a>';
$breadcrumb_category = $breadcrumb_menu_parent = $breadcrumb_menu = '';

$db->table = "category";
$db->condition = "is_active = 1 and slug = '".$slug_cat."'";
$db->order = "";
$db->limit = 1;
$rows = $db->select();
foreach ($rows as $row) {
	$category_id = $row['category_id']+0;
	$breadcrumb_category = '<a href="' . HOME_URL_LANG . '/' . $slug_cat . '" title="' . stripslashes($row['name']) . '">' . stripslashes($row['name']) . '</a>';
}
if($id_menu > 0) {
	$parent = 0;
	$db->table = "article_menu";
	$db->condition = "article_menu_id = " . $id_menu;
	$db->order = "";
	$db->limit = 1;
	$rows = $db->select();
	if($db->RowCount>0) {
		foreach ($rows as $row) {
			$parent = $row['parent'] + 0;
			if ($parent == 0) {
				$breadcrumb_menu_parent = '<a href="' . HOME_URL_LANG . '/' . $slug_cat . '/' . stripslashes($row['slug']) . '" title="' . stripslashes($row['name']) . '">' . stripslashes($row['name']) . '</a>';
			} else {
				$db->table = "article_menu";
				$db->condition = "article_menu_id = " . $parent;
				$db->order = "";
				$db->limit = 1;
				$rows_parent = $db->select();
				if ($db->RowCount > 0) {
					foreach ($rows_parent as $row_parent) {
						$breadcrumb_menu_parent = '<a href="' . HOME_URL_LANG . '/' . $slug_cat . '/' . stripslashes($row_parent['slug']) . '" title="' . stripslashes($row_parent['name']) . '">' . stripslashes($row_parent['name']) . '</a>';
						$breadcrumb_menu = '<a href="' . HOME_URL_LANG . '/' . $slug_cat . '/' . stripslashes($row['slug']) . '" title="' . stripslashes($row['name']) . '">' . stripslashes($row['name']) . '</a>';
					}
				}
			}
		}
	}
}

echo '<div class="breadcrumb"><div class="box-wp">' . $breadcrumb_home . $breadcrumb_category . $breadcrumb_menu_parent . $breadcrumb_menu . '</div></div><section class="content box-wp clearfix">';

	include(_F_TEMPLATES . DS . "show_article2.php");
echo '</section>';
} else {
	include(_F_MODULES . DS . "x_edu.php");
}
