<?php
function	get_user($id,$value)
{
	global $db;
	$r	=	$db->select("tgp_user","id = '".$id."'");
	while ($row = $db->fetch($r))
		return $row[$value];
}
function showPageNavigation($currentPage, $maxPage, $path = '') {
	if($currentPage==0)
	$currentPage=1;
	if ($maxPage <= 1)
	{
		return;
	}
	$suffix = '/';
	$nav = array(
		// bao nhiêu trang bên trái currentPage
		'left'	=>	3,
		// bao nhiêu trang bên phải currentPage
		'right'	=>	3,
	);	
	// nếu maxPage < currentPage thì cho currentPage = maxPage
	if ($maxPage < $currentPage) {
		$currentPage = $maxPage;
	}
	// số trang hiển thị
	$max = $nav['left'] + $nav['right'];
	// phân tích cách hiển thị
	if ($max >= $maxPage) {
		$start = 1;
		$end = $maxPage;
	}
	elseif ($currentPage - $nav['left'] <= 0) {
		$start = 1;
		$end = $max + 1;
	}
	elseif (($right = $maxPage - ($currentPage + $nav['right'])) <= 0) {
		$start = $maxPage - $max;
		$end = $maxPage;
	}
	else {
		$start = $currentPage - $nav['left'];
		if ($start == 2) {
			$start = 1;
		}
		
		$end = $start + $max;
		if ($end == $maxPage - 1) {
			++$end;
		}
	}
	
	$navig = '<div class="navigation">';
	if ($currentPage >= 2) {
		if ($currentPage >= $nav['left']) {
			if ($currentPage - $nav['left'] > 2 && $max < $maxPage) {
				// thêm nút "First"
				$navig .= '<span class="page_item"><a href="'.$path.'1'.$suffix.'">1</a></span>';
				$navig .= '<span class="current_page_item"><b>...</b></span>';
			}
		}
		// thêm nút "«"
		$navig .= '<span class="page_item"><a href="'.$path.($currentPage - 1).$suffix.'">«</a></span>';
	}
	for ($i=$start;$i<=$end;$i++) {
		// trang hiện tại
		if ($i == $currentPage) {
			$navig .= '<span class="current_page_item">'.$i.'</span>';
		}
		// trang khác
		else {
			$pg_link = $path.$i;
			$navig .= '<span class="page_item"><a href="'.$pg_link.$suffix.'">'.$i.'</a></span>';
		}
	}
	if ($currentPage <= $maxPage - 1) {
		// thêm nút "»"
		$navig .= '<span class="page_item"><a href="'.$path.($currentPage + 1).$suffix.'">»</a></span>';
		
		if ($currentPage + $nav['right'] < $maxPage - 1 && $max + 1 < $maxPage) {
			// thêm nút "Last"
			$navig .= '<span class="current_page_item">...</span>';
			$navig .= '<span class="page_item"><a href="'.$path.$maxPage.$suffix.'">'.$maxPage.'</a></span>';
		}
	}
	$navig .= '</div>';
	
	// hiển thị kết quả
	echo $navig;
}
function get_sql($sql)
{
	global $db;
	$get_sql_query_statement = $db->query($sql);
	if ($result_get_sql_query = $db->fetch($get_sql_query_statement))
	{
		return $result_get_sql_query[0];
	}
	else
	{
		return "SQL_NULL";
	}
}
function	get_page($alias,$col = "noi_dung")
{
	global $db , $_fix;	
	$alias = $db->escape($alias);	
	$db->query("UPDATE tgp_page SET luot_xem = luot_xem + 1 WHERE alias = '".$alias."'");
	$r	=	$db->select("tgp_page","alias = '".$alias."'");
	while ($row = $db->fetch($r))
	{
		return $row[$col];
	}	
	return "Unknown alias '".$alias."'";
}
function	get_bien($id)
{
	global $db;
	$r	=	$db->select("tgp_bien","ten = '".$id."'");
	while ($row = $db->fetch($r))
		return $row["gia_tri"];
}
function gui_mail($nguoigoi,$nguoinhan,$tieude,$noidung)
{
	global $conf;
	if (ereg("(.*)<(.*)>", $nguoigoi, $regs)) {
	   $nguoigoi = '=?UTF-8?B?'.base64_encode($regs[1]).'?=<'.$regs[2].'>';
	}
	
	$header = "From: ".$nguoigoi."\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-Type: text/html; charset=UTF-8\r\n";
	$noidung =	str_replace("\n"	, "<br>"	, $noidung);
	$noidung =	str_replace("  "	, "&nbsp; "	, $noidung);
	$noidung =	str_replace("<script>","&lt;script&gt;", $noidung);

	//$noidung =  $noidung;
	
	
	return (@mail($nguoinhan, $tieude, $noidung, $header));
			
}

function duan_slide($hien_thi,$vitri)
{
global $db;
$ket='';
 $sqltd=$db->select("tgp_product","hien_thi=1","ORDER BY id DESC ");
					$num= $db->num_rows($sqltd);
		 $trang= ceil($num/$hien_thi);
   if($trang>=10){
   $trang=10;
   } 
   if($trang>1){
   	for($i=1;$i<=$trang;$i++){
	$hinh='no_vi';
	if($vitri==$i){
	$hinh='ok_vi';
	}
   $ket.='<span  ><a class="'.$hinh.' dnnphantrang" onclick="load_duan_trang('.$hien_thi.','.$i.');">'.$i.'</a></span>';
   	}
   
   }
   return $ket;      			
}
function	get_title()
{
	global $db, $act, $step, $id,$txt_product,$txt_project,$txt_contact,$txt_news;
	$txt_home=get_bien("title");
	if ($act == "home")
	{
		return $txt_home;
	}
	if ($act == "gio_hang")
	{
		$txt= "Giỏ hàng - " . $txt;
	}
	if ($act == "dat_hang")
	{
		$txt= "Đặt hàng - " . $txt;
	}
	if ($act == "lien_he")
	{
		$txt= $txt_contact;
	}	

	if ($act == "hinh_anh")
	{
		$txt= "Thư viện hình ảnh";
	}
	if ($act == "khach_hang")
	{
		$txt= "Khách hàng";
	}

	if ($act == "danh_sach_san_pham")
	{
		if ($id != 0)
		{
		$r = $db->select("tgp_product_menu","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt = $rs["ten"];
		}
		}
		else
		{
			$txt = " Sản phẩm";
		}
	}

	if ($act == "san_pham")
	{
		if($step=="chi_tiet")
		{
			$r = $db->select("tgp_product","id = ".$id."");
			if ($rs = $db->fetch($r))
			{
				$rq = $db->select("tgp_product_menu", "id = ".$rs["cat"]);
				if ($rst = $db->fetch($rq))
				{
					$txt= $rs["ten"];	
				}
			}
		}
		else
		{
			if ($id != 0)
			{
			$r = $db->select("tgp_product_menu","id = ".$id."");
			if ($rs = $db->fetch($r))
			{
				$txt = $rs["ten"];
			}
			}
			else
			{
				$txt = $txt_product;
			}
		}
	}
	
	if ($act == "san_pham_xem")
	{
		$r = $db->select("tgp_product","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$rq = $db->select("tgp_product_menu", "id = ".$rs["cat"]);
			if ($rst = $db->fetch($rq))
			{
				$txt= $rs["ten"];	
			}
		}
	}
	
if ($act == "thiet_ke_noi_that")
	{
		if ($id != 0)
		{
		$r = $db->select("tgp_cms_menu","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt = $rs["ten"]." - Thiết kế nội thất - ".$txt;
		}
		}
		else
		{
			$txt = " Thiết kế nội thất - ".$txt;
		}
	}
	
	if ($act == "thiet_ke_noi_that_xem")
	{
		$r = $db->select("tgp_cms","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$rq = $db->select("tgp_cms_menu", "id = ".$rs["cat"]);
			if ($rst = $db->fetch($rq))
			{
				$txt= $rs["ten"]." - ".$rst["ten"]." - Thiết kế nội thất - ".$txt;	
			}
		}
	}	
	
	if ($act == "gioi_thieu")
	{
		$r = $db->select("tgp_page","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt=$rs["ten"];
		}
	}
	
	if ($act == "dich_vu")
	{
		$r = $db->select("tgp_page","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt=$rs["ten"];
		}
	}
	
	if ($act == "tin_tuc")
	{
		if ($id != 0)
		{
		$r = $db->select("tgp_cms_menu","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt = $rs["ten"];
		}
		}
		else
		{
			$txt = $txt_news;
		}
	}
	
	if ($act == "tin_tuc_xem")
	{
		$r = $db->select("tgp_cms","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$rq = $db->select("tgp_cms_menu", "id = ".$rs["cat"]);
			if ($rst = $db->fetch($rq))
			{
				$txt= $rs["ten"];	
			}
		}
	}

	if ($act == "kien_thuc")
	{
		if ($id != 0)
		{
		$r = $db->select("tgp_cms_menu","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt = $rs["ten"];
		}
		}
		else
		{
			$txt = "Kiến thức";
		}
	}
	
	if ($act == "kien_thuc_xem")
	{
		$r = $db->select("tgp_cms","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$rq = $db->select("tgp_cms_menu", "id = ".$rs["cat"]);
			if ($rst = $db->fetch($rq))
			{
				$txt= $rs["ten"];	
			}
		}
	}
	if ($act == "tin_khuyen_mai")
	{
		$r = $db->select("tgp_cms","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$rq = $db->select("tgp_cms_menu", "id = ".$rs["cat"]);
			if ($rst = $db->fetch($rq))
			{
				$txt= $rs["ten"];	
			}
		}
	}
	
	if ($act == "du_an")
	{
		if ($id != 0)
		{
		$r = $db->select("tgp_cms_menu","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt = $rs["ten"];
		}
		}
		else
		{
			$txt = $txt_project;
		}
	}
	
	if ($act == "du_an_xem")
	{
		$r = $db->select("tgp_video","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$rq = $db->select("tgp_video_menu", "id = ".$rs["cat"]);
			if ($rst = $db->fetch($rq))
			{
				$txt= $rs["ten"];	
			}
		}
	}


	if ($act == "tu_van_phong_thuy")
	{
		if ($id != 0)
		{
		$r = $db->select("tgp_cms_menu","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt = $rs["ten"]." - Tư vấn phong thủy - ".$txt;
		}
		}
		else
		{
			$txt = " Tư vấn phong thủy - ".$txt;
		}
	}
	
	if ($act == "tu_van_phong_thuy_xem")
	{
		$r = $db->select("tgp_cms","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$rq = $db->select("tgp_cms_menu", "id = ".$rs["cat"]);
			if ($rst = $db->fetch($rq))
			{
				$txt= $rs["ten"]." - ".$rst["ten"]." - ".$txt;	
			}
		}
	}



	if ($act == "tuyen_dung")
	{
		if ($id != 0)
		{
		$r = $db->select("tgp_cms_menu","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt = $rs["ten"]." - ".$txt;
		}
		}
		else
		{
			$txt = " Tuyển dụng - ".$txt;
		}
	}
	
	if ($act == "tuyen_dung_xem")
	{
		$r = $db->select("tgp_cms","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$rq = $db->select("tgp_cms_menu", "id = ".$rs["cat"]);
			if ($rst = $db->fetch($rq))
			{
				$txt= $rs["ten"]." - ".$rst["ten"]." - Tuyển dụng - ".$txt;	
			}
		}
	}	
	if ($act == "dai_ly")
	{
		if ($id != 0)
		{
		$r = $db->select("tgp_cms_menu","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt = $rs["ten"]." - Đại lý - ".$txt;
		}
		}
		else
		{
			$txt = " Đại lý - ".$txt;
		}
	}
	
	if ($act == "dai_ly_xem")
	{
		$r = $db->select("tgp_cms","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$rq = $db->select("tgp_cms_menu", "id = ".$rs["cat"]);
			if ($rst = $db->fetch($rq))
			{
				$txt= $rs["ten"]." - ".$rst["ten"]." - Đại lý - ".$txt;	
			}
		}
	}
	if ($act == "ty_gia")
	{
		$txt= "Tỷ giá ngoại tệ - " . $txt;
	}
	if ($act == "dich_vu_khach_hang")
	{
		if ($id != 0)
		{
		$r = $db->select("tgp_cms_menu","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt = $rs["ten"]." - Dịch vụ khách hàng - ".$txt;
		}
		}
		else
		{
			$txt = " Dịch vụ khách hàng - ".$txt;
		}
	}
	
	if ($act == "dich_vu_khach_hang_xem")
	{
		$r = $db->select("tgp_cms","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$rq = $db->select("tgp_cms_menu", "id = ".$rs["cat"]);
			if ($rst = $db->fetch($rq))
			{
				$txt= $rs["ten"]." - ".$rst["ten"]." - Dịch vụ khách hàng - ".$txt;	
			}
		}
	}
	if ($act == "dich_vu")
	{
		if ($id != 0)
		{
		$r = $db->select("tgp_cms_menu","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			//$txt = $rs["ten"]." - Dịch vụ - ".$txt;
			$txt = $rs["ten"];
		}
		}
		else
		{
			$txt = " Dịch vụ ";
		}
	}
	
	if ($act == "dich_vu_xem")
	{
		$r = $db->select("tgp_cms","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$rq = $db->select("tgp_cms_menu", "id = ".$rs["cat"]);
			if ($rst = $db->fetch($rq))
			{
				$txt= $rs["ten"]." - ".$rst["ten"]." - Dịch vụ - ".$txt;	
			}
		}
	}	
	if ($act == "phong_canh_du_lich_xem")
	{
		if ($id != 0)
		{
		$r = $db->select("tgp_cms_menu","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt = $rs["ten"]." - Phong cảnh du lịch - ".$txt;
		}
		}
		else
		{
			$txt = " Phong cảnh du lịch - ".$txt;
		}
	}
	
	if ($act == "phong_canh_du_lich_chi_tiet")
	{
		$r = $db->select("tgp_cms","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$rq = $db->select("tgp_cms_menu", "id = ".$rs["cat"]);
			if ($rst = $db->fetch($rq))
			{
				$txt= $rs["ten"]." - ".$rst["ten"]." - Phong cảnh du lịch - ".$txt;	
			}
		}
	}	
	if ($act == "kien_truc_xem")
	{
		if ($id != 0)
		{
		$r = $db->select("tgp_cms_menu","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt = $rs["ten"]." - Kiến trúc - ".$txt;
		}
		}
		else
		{
			$txt = " Kiến trúc - ".$txt;
		}
	}
	
	if ($act == "kien_truc_chi_tiet")
	{
		$r = $db->select("tgp_cms","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$rq = $db->select("tgp_cms_menu", "id = ".$rs["cat"]);
			if ($rst = $db->fetch($rq))
			{
				$txt= $rs["ten"]." - ".$rst["ten"]." - Kiến trúc - ".$txt;	
			}
		}
	}	
	if ($act == "nghe_thuat_xem")
	{
		if ($id != 0)
		{
		$r = $db->select("tgp_cms_menu","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt = $rs["ten"]." - Nghệ thuật - ".$txt;
		}
		}
		else
		{
			$txt = " Nghệ thuật - ".$txt;
		}
	}
	
	if ($act == "nghe_thuat_chi_tiet")
	{
		$r = $db->select("tgp_cms","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$rq = $db->select("tgp_cms_menu", "id = ".$rs["cat"]);
			if ($rst = $db->fetch($rq))
			{
				$txt= $rs["ten"]." - ".$rst["ten"]." - Nghệ thuật - ".$txt;	
			}
		}
	}	
	if ($act == "hinh_anh_xem")
	{
		if ($id != 0)
		{
		$r = $db->select("tgp_gallery_menu","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt = $rs["ten"];
		}
		}
		else
		{
			$txt = " Thư viện hình ảnh";
		}
	}
	if ($act == "bo_suu_tap_xem")
	{
		if ($id != 0)
		{
		$r = $db->select("tgp_gallery_menu","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt = $rs["ten"]." - Bộ sưu tập - ".$txt;
		}
		}
		else
		{
			$txt = " Bộ sưu tập - ".$txt;
		}
	}	
	if ($act == "dong_xe_moi")
	{
				$txt=" Dòng xe mới - ".$txt;
	}
	
	if ($act == "video")
	{

				$txt=" Thư viện Video - ".$txt;	

	}	
	return $txt." - ".$txt_home;
}
function demonline(){
$gia_tri = 0;
$rnk	=	mysql_query("select *  from tgp_online_daily   ");

	while ($row=mysql_fetch_array($rnk))
		$gia_tri += $row["bo_dem"];
		
		
		
		$gia_tri += 7;
		
		$x = 9 - strlen($gia_tri);
		
		for ($i = 1; $i <= $x; $i++)
		
		{
		$gia_tri = "0" . $gia_tri;
		}
		
		for ($i = 0; $i < strlen($gia_tri); $i++)
		{
		//$hinh=$hinh.'<img src="/images/so/'.$gia_tri[$i].'.png" />';
		$hinh=$hinh.'<span id="dem_online">'.$gia_tri[$i].'</span>';	
		}
		
	echo $hinh;	
}
function hashString($string)
{
	return md5('qweasdzxc'.$string);
}
function numberFormatVN($number)
{
	return number_format($number, 0, ',', '.');
}
function	admin_load($thong_bao,$url)
{
?>
<center>
	<b><font size="2"><?=$thong_bao?></font></b>
	<br /><img vspace="3" src="images/83.gif" />
	<br>Xin đợi vài giây hoặc bấm <b><a href="<?=$url?>">vào đây</a></b> để tiếp tục...
</center>
<head>
	<meta http-equiv="Refresh" content="1; URL=<?=$url?>">
</head>
<?php
	die();
}

//CREATED BY VINGUYEN 06/06/2013.
function getYoutubeVideo($url)
{
        $url_len=strlen($url);
        $v_pos=strpos($url,'v=');
        $v=substr($url,$v_pos+2);
        
        if(strpos($v,'&')) $v=substr($v,0,strpos($v,'&'));
        return $v;
		$img="http://i1.ytimg.com/vi/".$v."/mqdefault.jpg";
}
function getYoutubeImg($url)
{
        $url_len=strlen($url);
        $v_pos=strpos($url,'v=');
        $v=substr($url,$v_pos+2);       
        if(strpos($v,'&')) $v=substr($v,0,strpos($v,'&'));
		$img="http://i1.ytimg.com/vi/".$v."/mqdefault.jpg";
		return $img;
}
function getNavLink()
{
	global $db, $act,$step, $id,$txt_product,$txt_buil,$txt_contact,$txt_news,$txt_home,$txt_intro,$txt_search_results,$txt_support,$txt_customer;
	$title_home=get_bien("title");
	$link_home="<a href=\"/home/\"><img src=\"/images/home.gif\" alt=\"Trang chủ\" /></a>";
	if ($act == "lien_he")
	{
		$nav_link="&raquo;<a class=\"active\" href=\"/lien-he/\">$txt_contact</a>";
		$txt= $txt_contact;
	}
	else if ($act == "khach_hang")
	{
		$nav_link="&raquo;<a class=\"active\" href=\"/khach-hang/\">$txt_customer</a>";
		$txt= $txt_customer;
	}	
	else if ($act == "tim_kiem")
	{
		$nav_link="&raquo;<a class=\"active\" href=\"/lien-he/\">$txt_search_results</a>";
		$txt= $txt_contact;
	}
	else if ($act == "san_pham")
	{
		$nav_link="&raquo;<a class=\"active\" href=\"/san-pham/\">$txt_product</a>";
		
		if($step=="chi_tiet")
		{
			$r = $db->select("tgp_product","id = ".$id."");
			if ($rs = $db->fetch($r))
			{
				$rq = $db->select("tgp_product_menu", "id = ".$rs["cat"]);
				if ($rst = $db->fetch($rq))
				{
					$txt= $rs["ten"];	
				}
			}
		}
		else
		{
			if ($id != 0)
			{
			$r = $db->select("tgp_product_menu","id = ".$id."");
			if ($rs = $db->fetch($r))
			{
				$txt = $rs["ten"];
			}
			}
			else
			{
				$txt = $txt_product;
			}
		}
	}
	
	else if ($act == "gioi_thieu")
	{
		$nav_link="&raquo;<a class=\"active\" href=\"/gioi-thieu/\">$txt_intro</a>";
		$r = $db->select("tgp_page","id = ".$id."");
		if ($rs = $db->fetch($r))
		{
			$txt=$rs["ten"];
		}
	}
	
	else if ($act == "tin_tuc")
	{
		$nav_link="&raquo;<a class=\"active\" href=\"/tin-tuc/\">$txt_news</a>";
		if($step=="chi_tiet")
		{
			$r = $db->select("tgp_cms","id = ".$id."");
			if ($rs = $db->fetch($r))
			{
				$rq = $db->select("tgp_cms_menu", "id = ".$rs["cat"]);
				if ($rst = $db->fetch($rq))
				{
					$txt= $rs["ten"];	
				}
			}
		}
		else
		{
			if ($id != 0)
			{
			$r = $db->select("tgp_cms_menu","id = ".$id."");
			if ($rs = $db->fetch($r))
			{
				$txt = $rs["ten"];
			}
			}
			else
			{
				$txt = $txt_news;
			}
		}
	}
	
	else if ($act == "cong_trinh")
	{
		$nav_link="&raquo;<a class=\"active\" href=\"/cong-trinh/\">$txt_buil</a>";
		if($step=="chi_tiet")
		{
			$r = $db->select("tgp_cms","id = ".$id."");
			if ($rs = $db->fetch($r))
			{
				$rq = $db->select("tgp_cms_menu", "id = ".$rs["cat"]);
				if ($rst = $db->fetch($rq))
				{
					$txt= $rs["ten"];	
				}
			}
		}
		else
		{
			if ($id != 0)
			{
			$r = $db->select("tgp_cms_menu","id = ".$id."");
			if ($rs = $db->fetch($r))
			{
				$txt = $rs["ten"];
			}
			}
			else
			{
				$txt = $txt_buil;
			}
		}
	}
	

	else if ($act == "ho_tro")
	{
		$nav_link="&raquo;<a class=\"active\" href=\"/ho-tro/\">$txt_support</a>";
		if($step=="chi_tiet")
		{
			$r = $db->select("tgp_cms","id = ".$id."");
			if ($rs = $db->fetch($r))
			{
				$rq = $db->select("tgp_cms_menu", "id = ".$rs["cat"]);
				if ($rst = $db->fetch($rq))
				{
					$txt= $rs["ten"];	
				}
			}
		}
		else
		{
			if ($id != 0)
			{
			$r = $db->select("tgp_cms_menu","id = ".$id."");
			if ($rs = $db->fetch($r))
			{
				$txt = $rs["ten"];
			}
			}
			else
			{
				$txt = $txt_support;
			}
		}
	}
	else
	{
		$txt= $title_home;
		$nav_link=$link_home;
		$data=array('nav_link'=>$nav_link,'title'=>$txt);
		return $data;
	}
	$txt= $txt." - ".$title_home;
	$nav_link=$link_home.$nav_link;
	$data=array('nav_link'=>$nav_link,'title'=>$txt);
	return $data;
}
?>