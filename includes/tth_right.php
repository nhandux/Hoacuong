<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//-------------
?>
<!-- .content-right -->
<div class="content-right" 
   <?php
    if($slug_cat == "lien-he" || $slug_cat == "video")
    {
      echo 'style="display:none"';
    }
    ?>
 >   
    <?php
    $slug55 = getSlugCategory(81);
    ?>
  <?php
   if($slug_cat == "tin-tuc" || $slug_cat == "san-pham")
   {
   ?>
         <div class="program f-space20 wow fadeInUp" data-wow-delay="0.3s">
        <h3 class="r-title-a t-crop"><a href="<?php echo HOME_URL_LANG . '/' . $slug55;?>"><?php echo $lgTxt_program_gioithieu;?></a></h3>
        <div class="r-box">
           <?php
              $db->table = "article_menu";
              $db->condition = "is_active = 1 and category_id = 77";
              $db->order = "created_time DESC";
              $db->limit = "";
              $rows = $db->select(); 
                   # code...
                 echo '<ul>';
                foreach($rows as $row) {
                    echo '<li><a href="' . HOME_URL_LANG . '/san-pham/'.getSlugMenu($row['article_menu_id'], 'article'). '/'.$stringObj->getLinkHtml($row['name'], $row['article_id']) .'">' . stripslashes($row['name']) . '</a></li>';
                }
                echo '</ul>';

           ?>
        </div>
    </div>
    <div class="program f-space20 wow fadeInUp" data-wow-delay="0.3s">
        <h3 class="r-title-a t-crop"><a href="<?php echo HOME_URL_LANG . '/' . $slug55;?>"><?php echo $lgTxt_program_title;?></a></h3>
        <div class="r-box">
            <?php
            $db->table = "article";
            $db->condition = "`is_active` = 1 AND `article_menu_id` = 353";
            $db->order = "";
            $db->limit = "4";
            $rows = $db->select();
            if($db->RowCount>0) {
                echo '<ul>';
                foreach($rows as $row) {
                    echo '<li><a href="' . HOME_URL_LANG . '/' . $slug55  .'/'.getSlugMenu($row['article_menu_id'], 'article'). '/'.$stringObj->getLinkHtml($row['name'], $row['article_id']) .'">' . stripslashes($row['name']) . '</a></li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
    </div>
    <?php } 
    else if($slug_cat == "du-an" || $slug_cat == "linh-vuc-hoat-dong")
     {
    ?>
     <div class="program f-space20 wow fadeInUp" data-wow-delay="0.3s">
        <h3 class="r-title-a t-crop"><a href="<?php echo HOME_URL_LANG . '/' . $slug55;?>"><?php echo $lgTxt_duan_title;?></a></h3>
        <div class="r-box">
            <?php
            $db->table = "article_menu";
            $db->condition = "`is_active` = 1 AND `category_id` = 78";
            $db->order = "";
            $db->limit = "4";
            $rows = $db->select();
            if($db->RowCount>0) {
                echo '<ul>';
                foreach($rows as $row) {
                    echo '<li><a href="' . HOME_URL_LANG . '/du-an/'.getSlugMenu($row['article_menu_id'], 'article'). '/'.$stringObj->getLinkHtml($row['name'], $row['article_id']) .'">' . stripslashes($row['name']) . '</a></li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
    </div>

     <div class="program f-space20 wow fadeInUp" data-wow-delay="0.3s">
        <h3 class="r-title-a t-crop"><a href="<?php echo HOME_URL_LANG . '/' . $slug55;?>"><?php echo $lgTxt_hoatdong_title;?></a></h3>
        <div class="r-box">
            <?php
            $db->table = "article_menu";
            $db->condition = "`is_active` = 1 AND `category_id` = 79";
            $db->order = "";
            $db->limit = "4";
            $rows = $db->select();
            if($db->RowCount>0) {
                echo '<ul>';
                foreach($rows as $row) {
                    echo '<li><a href="' . HOME_URL_LANG . '/linh-vuc-hoat-dong/'.getSlugMenu($row['article_menu_id'], 'article'). '/'.$stringObj->getLinkHtml($row['name'], $row['article_id']) .'">' . stripslashes($row['name']) . '</a></li>';
                }
                echo '</ul>';
            }
            ?>

        </div>
    </div>
    <?php 
      }
       else if($slug_cat == "gioi-thieu")
     {
    ?>
     <div class="program f-space20 wow fadeInUp" data-wow-delay="0.3s">
        <h3 class="r-title-a t-crop"><a href="<?php echo HOME_URL_LANG . '/' . $slug55;?>"><?php echo $lgTxt_gioithieu_title;?></a></h3>
        <div class="r-box">
            <?php
            $db->table = "article_menu";
            $db->condition = "`is_active` = 1 AND `category_id` = 9";
            $db->order = "";
            $db->limit = "4";
            $rows = $db->select();
            if($db->RowCount>0) {
                echo '<ul>';
                foreach($rows as $row) {
                    echo '<li><a href="' . HOME_URL_LANG . '/tin-tuc/'.getSlugMenu($row['article_menu_id'], 'article'). '/'.$stringObj->getLinkHtml($row['name'], $row['article_id']) .'">' . stripslashes($row['name']) . '</a></li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
    </div>
     <div class="program f-space20 wow fadeInUp" data-wow-delay="0.3s">
        <h3 class="r-title-a t-crop"><a href="<?php echo HOME_URL_LANG . '/' . $slug55;?>"><?php echo $lgTxt_hoatdong_title;?></a></h3>
        <div class="r-box">
            <?php
            $db->table = "article_menu";
            $db->condition = "`is_active` = 1 AND `category_id` = 79";
            $db->order = "";
            $db->limit = "4";
            $rows = $db->select();
            if($db->RowCount>0) {
                echo '<ul>';
                foreach($rows as $row) {
                    echo '<li><a href="' . HOME_URL_LANG . '/' . $slug55  .'/'.getSlugMenu($row['article_menu_id'], 'article'). '/'.$stringObj->getLinkHtml($row['name'], $row['article_id']) .'">' . stripslashes($row['name']) . '</a></li>';
                }
                echo '</ul>';
            }
            ?>

        </div>
    </div>
    <?php } 
     if($slug_cat != "video" && $slug_cat != "lien-he"){
    ?>
    <div class="program f-space20 wow fadeInUp classvideo" data-wow-delay="0.3s">
        <h3 class="r-title-a t-crop"><a href="<?php echo HOME_URL_LANG . '/video'?>"><i class="fa fa"></i> 
        <i class="fa fa-video-camera" aria-hidden="true"></i> Video công ty</a></h3>
    </div>  
     <div class="img f-space20 wow fadeInUp" data-wow-delay="0.3s"><?php echo getPage('banner_right');?></div>

 
   <!--  <div class="img f-space20 wow fadeInUp" data-wow-delay="0.3s">
         <?php echo getPage('thoitiet_right');?>
    </div> -->
    <div class="program f-space20 wow fadeInUp" data-wow-delay="0.3s">
        <h3 class="r-title-a t-crop"><a href="<?php echo HOME_URL_LANG . '/' . $slug55;?>"><i class="fa fa"></i> 
        <i class="fa fa-user-secret" aria-hidden="true"></i> <?= $txthotrotructuyen  ?></a></h3>
        <div class="r-box">
          <ul>
              <li>
                  <span><i class="fa fa-user"></i> Nguyễn Đức Nhân</span><br/>
                  <span><i class="fa fa-envelope-o"></i> nhanduc96@gmail.com</span><br/>
                  <span><i class="fa fa-phone"></i> 01632.852.398</span>
              </li>
          </ul>
        </div>
    </div>
    <?php } ?>
</div>
<!-- / .content-right -->