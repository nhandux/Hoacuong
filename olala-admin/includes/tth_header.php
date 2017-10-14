<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
$date = new DateClass();
?>

<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
	    <i class="fa fa-bars fa-2x"></i>
    </button>
	<a class="navbar-brand" target="_blank" href="http://hoacuong.vn/">
		<img src="./images/dnw-adminpanel.png" height="40px" alt="Hòa Cường Editor Panel (www.hoacuong.vn | HOACUONG Co., Ltd.)" />
	</a>
</div>
<!-- /.navbar-header -->

<ul class="nav navbar-top-links navbar-right">
	<?php
	$rows_order = $rows_contact = $distance = array();
	if(in_array('order_list',$corePrivilegeSlug)) {
		$db->table = "order";
		$db->condition = "is_active = 1";
		$db->order = "created_time DESC";
		$db->limit = "";
		$rows_order = $db->select();
	}

	if(in_array('contact_list',$corePrivilegeSlug)) {
		$db->table = "contact";
		$db->condition = "is_active = 1";
		$db->order = "created_time DESC";
		$db->limit = "";
		$rows_contact = $db->select();
	}

	$rows = array_merge($rows_order, $rows_contact);

	foreach ($rows as $key => $row) {
		$distance[$key] = $row['created_time'];
	}

	array_multisort($distance, SORT_DESC, $rows);
	$count_rows = count($rows);
	if($count_rows>0) {
		?>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-globe fa-fw fa-lg"></i> <i class="fa fa-caret-down"></i> <span class="notification-label"><?php echo $count_rows;?></span>
			</a>
			<div class="dropdown-menu dropdown-alerts">
				<div class="node-hv">&nbsp;</div>
				<ul class="header-list-notification">
					<?php foreach($rows as $row) {
						echo '<li><div><span class="pull-left"><i class="fa ' . stripslashes($row['icon']) . '"></i> ' . stripslashes($row['name']) . ' <i class="time">(' . $date->vnDateTime($row['created_time']) . ')</i></span>';
						if($row['icon']=='fa-send-o') echo '<button type="button" class="btn btn-warning btn-sm-sm" data-toggle="modal" data-target="#_notification" onclick="open_notification($(this), '.$row["contact_id"].', \'contact\');"><i class="fa fa-eye"></i></button>';
						else echo '<button type="button" class="btn btn-warning btn-sm-sm" data-toggle="modal" data-target="#_notification" onclick="open_notification($(this), '.$row["order_id"].', \'order\');"><i class="fa fa-eye"></i></button>';
						echo '</div></li><li class="divider"></li>';
					} ?>
				</ul>
				<ul>
					<li class="list-link clearfix">
						<a class="text-center" href="?ol=order_list">
							<strong>Booking</strong>
							<i class="fa fa-shopping-cart fa-fw"></i>
						</a>
						<a class="text-center" href="?ol=contact_list">
							<strong>Liên hệ</strong>
							<i class="fa fa-send-o fa-fw"></i>
						</a>
					</li>
				</ul>
			</div>
		</li>
	<?php } ?>
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			<img height="20px" src="images/f_<?=TTH_LANGUAGE?>.png"> <i class="fa fa-database fa-fw fa-lg"></i> <i class="fa fa-caret-down"></i>
		</a>
		<ul class="dropdown-menu">
			<div class="node-hv">&nbsp;</div>
			<li>
				<a href="javascript:_postback();" onclick="Forward('?<?=TTH_PATH?>=set_language&lang=vi');"><img height="25px" src="images/f_vi.png">&nbsp; (vi-vn)</a>
			</li>
			<!--
			<li class="divider"></li>
			<li>
				<a href="javascript:_postback();" onclick="Forward('?<?=TTH_PATH?>=set_language&lang=en');"><img height="25px" src="images/f_en.png">&nbsp; (en-us)</a>
			</li>
			-->
		</ul>
	</li>
    <li class="dropdown">
        <a class="dropdown-toggle toggle-user" data-toggle="dropdown" href="#">
            <?php
            $info_user = array();
            $info_user = getInfoUser($_SESSION["user_id"]);
            ?>
            <label class="tth-user-admin"><?php echo $info_user[4] . ' ' . $info_user[0];?>&nbsp; <i class="fa fa-caret-down"></i></label>
        </a>
        <ul class="dropdown-menu dropdown-user">
	        <div class="node-hv">&nbsp;</div>
            <li>
                <a href="javascript:_postback();" onclick="Forward('?<?=TTH_PATH?>=core_user_changeinfo&active=info');"><i class="fa fa-user fa-fw fa-slideDown"></i> Thông tin cá nhân</a>
            </li>
	        <li>
		        <a href="javascript:_postback();" onclick="Forward('?<?=TTH_PATH?>=core_user_changeinfo&active=pass');"><i class="fa fa-gear fa-fw"></i> Đổi mật khẩu</a>
	        </li>
            <li class="divider"></li>
            <li>
	            <a target="_blank" href="mailto:<?php echo $info_user[3];?>"><i class="fa fa-envelope fa-fw"></i> Gửi thư điện tử</a>
            </li>
            <li class="divider"></li>
	        <li>
		        <a target="_blank" href="/"><i class="fa fa-external-link fa-fw"></i> Trang chủ site</a>
	        </li>
            <li>
                <a href="javascript:_postback();" onclick="Forward('?logout=OK');"><i class="fa fa-sign-out fa-fw"></i> Đăng xuất</a>
            </li>
        </ul>
    </li>
</ul>