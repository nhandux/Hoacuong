<?
	@session_start();

include("config.php");
$db		=	new	lg_mysql($host,$dbuser,$dbpass,$csdl);
include("func.php");
if ($_SESSION["member_ok"])
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MUABANDAT24H.COM</title>
<link href="css/template_css.css" rel="stylesheet" type="text/css" />
<body id="bd" class="fs3">
<script type="text/javascript">
// NDK Loading
var ie45,ns6,ns4,dom;
if (navigator.appName=="Microsoft Internet Explorer") ie45=parseInt(navigator.appVersion)>=4;
else if (navigator.appName=="Netscape"){  ns6=parseInt(navigator.appVersion)>=5;  ns4=parseInt(navigator.appVersion)<5;}
dom=ie45 || ns6;
// Function
function $(id) {
	return document.all ? document.all[id] :   dom ? document.getElementById(id) :   document.layers[id];
}
function Forward(url)
{
	document.location.href = url;
}
</script>
<form name="xxx" action="Upload.php" METHOD="POST" ENCTYPE="multipart/form-data">
<input type="hidden" name="func" value="upload" />
<input type="hidden" name="frm" value="<?=$frm?>" />
<input type="hidden" name="frm_box" value="<?=$frm_box?>" />
<input type="hidden" name="img" value="<?=$img?>" />
<table align=center>
	<tr>
		<td colspan=2 class=intro>
		<b>Insert Picture/File</b>
		</td>
	</tr>
	<tr>
		<td colspan=2><font color="red" size="1">
<?
if ($func == 'upload')
{
	$dir = "uploads/tmp/";
	
	$now	=	time();
	$r		=	mysql_query("INSERT INTO `tgp_upload_tmp` ( `id` , `time` ) VALUES ('0', '".$now."');");
	$id		=	mysql_insert_id();
	
	$MAX_FILE_SIZE = 2048000;
	$file_type = $HTTP_POST_FILES['txt_hinh']['type'];
	$file_name = $HTTP_POST_FILES['txt_hinh']['name'];
	$file_size = $HTTP_POST_FILES['txt_hinh']['size'];

	switch ($file_type)
	{
		case "image/pjpeg"	: $file_type = "jpg"; break;
		case "image/jpeg"	: $file_type = "jpg"; break;
		case "image/gif" 	: $file_type = "gif"; break;
		case "image/x-png" 	: $file_type = "png"; break;
		case "image/png" 	: $file_type = "png"; break;
		default : $file_type = "unk"; break;
	}
	$file_full_name = $id.".".$file_type;
	$check = TRUE;
	if ($file_size == 0)				{ printf("Sai định dạng File, chỉ hỗ trợ .jpg, .gif, .png"); $check = FALSE; }
	if ($file_type == "unk")			{ printf("Sai định dạng File, chỉ hỗ trợ .jpg, .gif, .png"); $check = FALSE; }
	if ($file_size > $MAX_FILE_SIZE)	{ printf("Dung lượng file không quá 2000kb"); $check=FALSE;}
	if ($check)
	{	
		$file	=	$dir.$file_full_name;
		@mkdir($dir, 0777);
		@unlink($file);
		@move_uploaded_file($HTTP_POST_FILES['txt_hinh']['tmp_name'],$file);

		?>
			Upload thành công !!!
			<br /><input type=button class=button name="cmsBack" value="Close" LANGUAGE=javascript onclick="return cmsBack_onclick('<?='/'.$dir.$file_full_name?>')">
			<SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
			function cmsBack_onclick(xxx) {
			window.opener.document.<?=$frm?>.<?=$frm_box?>.value=xxx;
			<?
			if (!empty($img))
			{
			?>
			window.opener.document.<?=$frm?>.<?=$img?>.src=xxx;
			<?
			}
			?>
			window.close();
			}
			</SCRIPT>
		<?
			die();
	}
}
?>		</font>
		<hr color=red size=1>
		</td>
	</tr>
	<tr>
		<td >
		File:
		</font>
		</td>
		<td>
			<input type=file name=txt_hinh class=txt size=30>
		</td>
	</tr>
	<tr>
		<td colspan=2>
		<hr color=red size=1>
		</td>
	</tr>
	<tr>
		<td colspan=2 align=center>
		<input type=submit class=btn value="Insert" name=CmdInsert>
		</td>
	</tr>
</table>
<center>Các dạng file chấp nhận: .jpg, .gif, .png</font><br />Kích thước tối đa của ảnh/file: <strong>2MB</strong></center>
</form>
</body>
</html>
<?
}
else
die("Login again.");
?>