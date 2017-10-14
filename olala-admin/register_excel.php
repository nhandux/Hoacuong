<?php
@session_start();
// System
define( 'TTH_SYSTEM', true );
$_SESSION["language"] = (!empty($_SESSION["lang_admin"]) && isset($_SESSION["lang_admin"])) ? $_SESSION["lang_admin"] : 'vi';

require_once('..' . DIRECTORY_SEPARATOR . 'define.php');
include_once(_A_FUNCTIONS . DS . "Function.php");
try {
	$db =  new ActiveRecord(TTH_DB_HOST, TTH_DB_USER, TTH_DB_PASS, TTH_DB_NAME);
}
catch(DatabaseConnException $e) {
	echo $e->getMessage();
}
include_once(_F_INCLUDES . DS . "_tth_constants.php");

require_once(ROOT_DIR . DS . ADMIN_DIR . DS . '_check_login.php');
if($login_true) {
	/** Error reporting */
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Asia/Bangkok');
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	// Create the worksheet
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'STT')
		->setCellValue('B1', 'Họ và tên')
		->setCellValue('C1', 'Số điện thoại')
		->setCellValue('D1', 'Email')
		->setCellValue('E1', 'Địa chỉ')
		->setCellValue('F1', 'Ngày đăng ký');
	$date = new DateClass();

	$db->table = "order";
	$db->condition = "";
	$db->order = "`created_time` DESC";
	$db->limit = "";
	$rows = $db->select();
	$stt = 2;
	$i=0;
	foreach($rows as $row) {
		$i++;
		$dataArray = array( $i,
							stripslashes($row['name']),
							stripslashes($row['phone']) . ' ',
							stripslashes($row['email']),
							stripslashes($row['address']),
							$date->vnOther($row['created_time'], TTH_DATETIME_FORMAT)
						  );
		$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$stt++);
	}
	// Set title row bold
	$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	$time = date("d-m-Y_H-i-s",time());
	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="Danh_sach_dang_ky_tham_du_chuong_trinh_'.$time.'.xls"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;

}
else echo "<script>window.location.href = '".ADMIN_DIR."';</script>";
