<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//-------------
$stringObj = new String();
?>
<!-- .slider -->
 <div class="ctslide" > 
            <div class="camera_wrap camera_azure_skin" id="camera_wrap_1" >
            <?php
            $db->table = "gallery";
            $db->condition = "`is_active` = 1 AND gallery_menu_id IN (SELECT `gallery_menu_id` FROM `".TTH_DATA_PREFIX."gallery_menu` WHERE `category_id` = 75)";
            $db->order = "created_time DESC";
            $db->limit = "5";
            $rows = $db->select();
            foreach ($rows as $row){
                ?>
                <div data-thumb="" data-src="<?php echo HOME_URL ?>/images/backsli.png" style="height: 100%;width: 100%;">
                    
                </div>
            <?php } ?>
           
    </div>
  </div>
 </div>
        
</div>

<!-- / .slider -->