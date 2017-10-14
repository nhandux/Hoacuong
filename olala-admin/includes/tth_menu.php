<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//
?>

<div class="sidebar-nav navbar-collapse">
    <ul class="nav" id="side-menu">
        <li>
            <a <?=(empty($tth)||$tth=='home')?'class="active"':''?> href="<?=ADMIN_DIR?>"><i class="fa fa-home fa-fw"></i> <span>Trang chủ</span></a>
        </li>
        <?php
        $active = array();
        $db->table = "category_type";
        $db->condition = "is_active = 1";
        $db->order = "";
        $db->limit = "";
        $rows = $db->select();
        $i = 0;
        foreach($rows as $row) {
            $active[$i] = $row['slug'];
            $i++;
        }
        $active2 = array(
	        'category_edit',
	        'article_menu_add','article_menu_edit', 'article_list', 'article_add', 'article_edit',
	        'gallery_menu_add','gallery_menu_edit', 'gallery_list', 'gallery_add', 'gallery_edit',
	        'project_menu_add','project_menu_edit', 'project_list', 'project_add', 'project_edit',
	        'product_menu_add','product_menu_edit', 'product_list', 'product_add', 'product_edit',
	        'bds_business_menu_add','bds_business_menu_edit', 'bds_business_list', 'bds_business_add', 'bds_business_edit',
	        'location_menu_add','location_menu_edit', 'location_list', 'location_add', 'location_edit',
	        'tour_menu_add','tour_menu_edit', 'tour_list', 'tour_add', 'tour_edit',
	        'gift_menu_add','gift_menu_edit', 'gift_list', 'gift_add', 'gift_edit',
	        'car_menu_add','car_menu_edit', 'car_list', 'car_add', 'car_edit',
	        'teacher_list', 'teacher_add', 'teacher_edit',
	        'street_add', 'street_edit',
	        'road_add', 'road_edit',
	        'direction_add', 'direction_edit',
	        'others_menu_add', 'others_menu_edit',
	        'plugin_page' , 'plugin_page_add', 'plugin_page_edit',
        );
        $active3 = array('plugin_page' , 'plugin_page_add', 'plugin_page_edit');
        ?>
        <li <?=(in_array($tth,$active) || in_array($tth,$active2)) ? 'class="active"' : ''?> >
            <a href="#"><i class="fa fa-edit fa-fw"></i> <span>Quản lý nội dung</span><span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
                <?php
                $icon = array('fa-newspaper-o', 'fa-image', 'fa-shopping-cart', 'fa-send-o', 'fa-tag', 'fa-rotate-right', 'fa-clock-o');
                $db->table = "category_type";
                $db->condition = "is_active = 1";
                $db->order = "sort ASC";
                $rows = $db->select();
                $i = 0;
                foreach($rows as $row) {
                ?>
                    <li>
                        <a <?=($tth==$row['slug'])?'class="active"':''?> href="?<?=TTH_PATH?>=<?=$row['slug']?>"><i class="fa <?=$icon[$i]?> fa-fw"></i> <span><?=$row['name']?></span></a>
                    </li>
                <?php
                    $i++;
                }
                ?>
	            <li>
		            <a  <?=(in_array($tth,$active3))?'class="active"':''?> href="?<?=TTH_PATH?>=plugin_page"><i class="fa fa-file-text-o fa-fw"></i> <span>Phần bổ sung</span></a>
	            </li>
            </ul>
            <!-- /.nav-second-level -->
        </li>
	    <?php
	    $active4 = array('backup_data', 'backup_config');
	    ?>
        <li <?=(in_array($tth,$active4))?'class="active"':''?> >
            <a href="#"><i class="fa fa-database fa-fw"></i> <span>Cơ sở dữ liệu</span><span class="fa arrow"></span></a>
	        <ul class="nav nav-second-level">
		        <li>
			        <a <?=($tth == 'backup_data')? 'class="active"':''?> href="?<?=TTH_PATH?>=backup_data"><i class="fa fa-paste fa-fw"></i> <span>Sao lưu dữ liệu</span></a>
		        </li>
		        <li>
			        <a <?=($tth == 'backup_config')? 'class="active"':''?> href="?<?=TTH_PATH?>=backup_config"><i class="fa fa-crosshairs fa-fw"></i> <span>Cấu hình sao lưu</span></a>
		        </li>
	        </ul>
	        <!-- /.nav-second-level -->
        </li>
	    <?php
	    $active5 = array('config_general', 'config_smtp', 'config_datetime', 'config_plugins', 'config_socialnetwork', 'config_search', 'config_upload');
	    ?>
        <li <?=(in_array($tth,$active5))?'class="active"':''?> >
            <a href="#"><i class="fa fa-cogs fa-fw"></i> <span>Cấu hình</span><span class="fa arrow"></span></a>
	        <ul class="nav nav-second-level">
		        <li>
			        <a <?=($tth == 'config_general')? 'class="active"':''?> href="?<?=TTH_PATH?>=config_general"><i class="fa fa-globe fa-fw"></i> <span>Cấu hình chung</span></a>
		        </li>
		        <li>
			        <a <?=($tth == 'config_smtp')? 'class="active"':''?> href="?<?=TTH_PATH?>=config_smtp"><i class="fa fa-paper-plane-o fa-fw"></i> <span>Cấu hình SMTP</span></a>
		        </li>
		        <li>
			        <a <?=($tth == 'config_datetime')? 'class="active"':''?> href="?<?=TTH_PATH?>=config_datetime"><i class="fa fa-clock-o fa-fw"></i> <span>Cấu hình thời gian</span></a>
		        </li>
		        <li>
			        <a <?=($tth == 'config_plugins')? 'class="active"':''?> href="?<?=TTH_PATH?>=config_plugins"><i class="fa fa-plug fa-fw"></i> <span>Trình cắm bổ sung</span></a>
		        </li>
		        <li>
			        <a <?=($tth == 'config_socialnetwork')? 'class="active"':''?> href="?<?=TTH_PATH?>=config_socialnetwork"><i class="fa fa-recycle fa-fw"></i> <span>Mạng xã hội</span></a>
		        </li>
		        <li>
			        <a <?=($tth == 'config_search')? 'class="active"':''?> href="?<?=TTH_PATH?>=config_search"><i class="fa fa-search fa-fw"></i> <span>Máy chủ tìm kiếm</span></a>
		        </li>
		        <li>
			        <a <?=($tth == 'config_upload')? 'class="active"':''?> href="?<?=TTH_PATH?>=config_upload"><i class="fa fa-cloud-upload fa-fw"></i> <span>Cấu hình upload</span></a>
		        </li>
	        </ul>
	        <!-- /.nav-second-level -->
        </li>
	    <?php
	    $active6 = array('tool_delete', 'tool_site', 'tool_keywords', 'tool_ipdie', 'tool_update');
	    ?>
	    <li <?=(in_array($tth,$active6))?'class="active"':''?> >
            <a href="#"><i class="fa fa-wrench fa-fw"></i> <span>Công cụ hỗ trợ</span><span class="fa arrow"></span></a>
	        <ul class="nav nav-second-level">
		        <li>
			        <a <?=($tth == 'tool_delete')? 'class="active"':''?> href="?<?=TTH_PATH?>=tool_delete"><i class="fa fa-trash-o fa-fw"></i> <span>Dọn dẹp hệ thống</span></a>
		        </li>
		        <li>
			        <a <?=($tth == 'tool_site')? 'class="active"':''?> href="?<?=TTH_PATH?>=tool_site"><i class="fa fa-repeat fa-fw"></i> <span>Chuẩn đoán site</span></a>
		        </li>
		        <li>
			        <a <?=($tth == 'tool_keywords')? 'class="active"':''?> href="?<?=TTH_PATH?>=tool_keywords"><i class="fa fa-signal fa-fw"></i> <span>Hạng site theo từ khóa</span></a>
		        </li>
		        <li>
			        <a <?=($tth == 'tool_ipdie')? 'class="active"':''?> href="?<?=TTH_PATH?>=tool_ipdie"><i class="fa fa-ban fa-fw"></i> <span>Quản lý IP cấm</span></a>
		        </li>
		        <li>
			        <a <?=($tth == 'tool_update')? 'class="active"':''?> href="?<?=TTH_PATH?>=tool_update"><i class="fa fa-download fa-fw"></i> <span>Kiểm tra phiên bản</span></a>
		        </li>
	        </ul>
	        <!-- /.nav-second-level -->
        </li>
	    <?php
	    $active7 = array('core_role', 'core_role_add', 'core_role_edit', 'core_dashboard', 'core_user', 'core_user_add', 'core_user_edit', 'core_user_changeinfo');
	    $active71 = array('core_role', 'core_role_add', 'core_role_edit', 'core_dashboard', 'core_user_changeinfo');
	    $active72 = array('core_user', 'core_user_add', 'core_user_edit');
	    ?>
	    <li <?=(in_array($tth,$active7))?'class="active"':''?> >
            <a href="#"><i class="fa fa-dashboard fa-fw"></i> <span>Quản trị hệ thống</span><span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
                <li>
                    <a <?=(in_array($tth,$active71))?'class="active"':''?> href="?<?=TTH_PATH?>=core_role"><i class="fa fa-group fa-fw"></i> <span>Nhóm quản trị</span></a>
                </li>
	            <li>
		            <a <?=(in_array($tth,$active72))?'class="active"':''?> href="?<?=TTH_PATH?>=core_user"><i class="fa fa-male fa-fw"></i> <span>Quản lý thành viên</span></a>
	            </li>
	            <li>
		            <a href="?<?=TTH_PATH?>=core_mail"><i class="fa fa-envelope-o fa-fw"></i> <span>Gửi mail thành viên</span></a>
	            </li>
            </ul>
            <!-- /.nav-second-level -->
        </li>
	    <?php
	    $active8 = array('sys_info_diary', 'sys_info_php', 'sys_info_site', 'sys_info_expansion');
	    ?>
	    <li <?=(in_array($tth,$active8))?'class="active"':''?> >
		    <a href="#"><i class="fa fa-sitemap fa-fw"></i> <span>Thông tin hệ thống</span><span class="fa arrow"></span></a>
		    <ul class="nav nav-second-level">
			    <li>
				    <a <?=($tth == 'sys_info_diary')? 'class="active"':''?> href="?<?=TTH_PATH?>=sys_info_diary"><i class="fa fa-book fa-fw"></i> <span>Thống kê hoạt động</span></a>
			    </li>
			    <li>
				    <a <?=($tth == 'sys_info_site')? 'class="active"':''?> href="?<?=TTH_PATH?>=sys_info_site"><i class="fa fa-tasks fa-fw"></i> <span>Cấu hình site</span></a>
			    </li>
			    <li>
				    <a <?=($tth == 'sys_info_php')? 'class="active"':''?> href="?<?=TTH_PATH?>=sys_info_php"><i class="fa fa-file-code-o fa-fw"></i> <span>Cấu hình PHP</span></a>
			    </li>
			    <li>
				    <a <?=($tth == 'sys_info_expansion')? 'class="active"':''?> href="?<?=TTH_PATH?>=sys_info_expansion"><i class="fa fa-folder-open-o fa-fw"></i> <span>Tiện ích mở rộng</span></a>
			    </li>
		    </ul>
		    <!-- /.nav-second-level -->
	    </li>
    </ul>
</div>
<!-- /.sidebar-collapse -->
<div class="sidebar-minified js-toggle-minified">
	<a class="toggle-nav" href="#" data-toggle="tooltip" data-placement="right" title="Menu Mở rộng/Thu gọn">
		<i class="fa fa-chevron-left"></i>
	</a>
</div>