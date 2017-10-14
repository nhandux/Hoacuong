<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//-------------
?>
<!-- .gallery -->
<section class="gallery f-space20 clearfix">
    <div id="_gallery">
        <?php
        $db->table = "gallery";
        $db->condition = "`is_active` = 1 AND `gallery_menu_id` IN (SELECT `gallery_menu_id` FROM `".TTH_DATA_PREFIX."gallery_menu` WHERE `category_id` = 56)";
        $db->order = "`created_time` DESC";
        $db->limit = 1;
        $rows = $db->select();
    if($row)
    {
        foreach ($rows as $row){
            $alt = stripslashes($row['name']);
            $list_img = "";
            $db->table = "uploads_tmp";
            $db->condition = "upload_id = ".($row['upload_id']+0);
            $db->order = "";
            $db->limit = 1;
            $rows_gal = $db->select();
            foreach ($rows_gal as $row_gal){
                $list_img = $row_gal['list_img'];
            }
            $img = explode(";",$list_img);
            if($list_img!="") {
                for($i=0;$i<count($img);$i++) {
                    if($img[$i] != ""){
                        ?>
                        <div class="slide item">
                            <div class="img">
                                <a class="fancybox-group" rel="gallery" href="<?php echo HOME_URL;?>/uploads/photos/full_<?php echo $img[$i];?>" title="<?php echo $alt;?>">
                                    <img src="<?php echo HOME_URL;?>/uploads/photos/<?php echo 'thm_' . $img[$i];?>" alt="<?php echo $alt;?>">
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
        }
    }else{
        echo 'Đang cập nhập danh sách hình ảnh';
    }
        ?>


    </div>
</section>
<!-- / .gallery -->