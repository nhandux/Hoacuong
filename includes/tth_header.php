<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//-------------
?>
<!-- .header -->

     <header id="header" class="">
        <div class="logo">
            <a href="<?php echo HOME_URL;?>"><img src="<?php echo HOME_URL;?>/images/lototop.png" class="imgtop wow" title="trang chủ"></a>
            <ul class="ngoaicung">
            <li class="wow" data-wow-delay="0.1s"> <span ><?= $txthoacuong ?> </span><a href="mailto:<?= $txthoacuong ?>"><img src="<?php echo HOME_URL;?>/images/email.png" class="hinhanh"></a></li>
            <li class="wow" data-wow-delay="0.2s"> <span ><?= $txtphonelienhe ?></span><a href="tel:<?= $txtphonelienhe ?>"><img src="<?php echo HOME_URL;?>/images/phone.png" class="hinhanh" ></a></li>
            <li>
                <ul class="icon">
                   <li> <a href="<?php echo getConstant('link_youtube');?>" target="_blank"><img src ="<?php echo HOME_URL;?>/images/yotube.png" class="wow" data-wow-delay="0.5s" title="yotube"></a></li>
                    <li> <a href="<?php echo getConstant('link_twitter');?>" target="_blank"><img src ="<?php echo HOME_URL;?>/images/skype.png" class="wow" data-wow-delay="0.4s" title="skype"></a></li>
                    <li> <a href="<?php echo getConstant('link_facebook');?>" target="_blank"><img src ="<?php echo HOME_URL;?>/images/facebook.png" class="wow" data-wow-delay="0.3s" title="facebook"></a></li>
                </ul>
            </li>
        </ul>
      <div class="three col">
        <div class="hamburger" id="hamburger-1">
          <span class="line"></span>
          <span class="line"></span>
          <span class="line"></span>
        </div>
      </div>
        </div>
     </header>
    <div class="divsl">
        <div class="slide wow">
            <nav class="navmenu">
                <ul>
                    <li class="<?php if($slug_cat=='home') echo 'activemnu'; ?> wow flipInX" data-wow-delay="0.1s"><a href="<?php echo HOME_URL_LANG; ?>" title="<?php echo $lgTxt_menu_home; ?>" ><?= $txttrangchu ?></a>
                    </li>
                 <?php
                    $db->table = "category";
                    $db->condition = "`is_active` = 1 and `menu_main` = 1";
                    $db->order = "`sort_hide` ASC";
                    $db->limit = "";
                    $rows = $db->select();
                    $count = 0;
                    foreach($rows as $row){
                    $count++;
                    $speed = 0.1 * $count;
                    ?>
                    <li class="<?php if($slug_cat==$row['slug']) echo 'activemnu'; ?> wow flipInX dropdown" data-wow-delay="<?php echo $speed;?>s">
                        <a href="<?php echo HOME_URL_LANG . '/' . $row['slug'];?>" title="<?php echo stripslashes($row['name']); ?>">
                            <?php echo stripslashes($row['name']); 
                                                        
                            ?>

                        </a>
                        <?php
                        if($row['type_id']+0 == 1) {
                            $db->table = "article_menu";
                            $db->condition = "is_active = 1 and  parent = 0  and category_id = ".($row['category_id']+0);
                            $db->order = "sort ASC";
                            $db->limit = "";
                            $rows2 = $db->select();
                            if($db->RowCount>1) {
                                echo '<ul class="lidrop">';
                                foreach($rows2 as $row2){
                                    ?>
                                <li  <?php if($slug_cat==$row['slug'] && $id_menu==$row2['article_menu_id']) echo 'class="activemnu"'; ?> >
                                    <a href="<?php echo HOME_URL_LANG . '/' . $row['slug'] . '/' .  $row2['slug']; ?>" title="<?php echo stripslashes($row2['name']); ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo stripslashes($row2['name']); ?></a>
                                    <?php
                                    $db->table = "article_menu";
                                    $db->condition = "is_active = 1 and parent = ".($row2['article_menu_id']+0)." and category_id = ".($row['category_id']+0);
                                    $db->order = "sort ASC";
                                    $db->limit = "";
                                    $rows3 = $db->select();
                                    if($db->RowCount>0) {
                                        echo '<ul>';
                                        foreach($rows3 as $row3){
                                            ?>
                                            <li  <?php if($slug_cat==$row['slug'] && $id_menu==$row3['article_menu_id']) echo 'class="activemnu"'; ?> >
                                                <a href="<?php echo HOME_URL_LANG . '/' . $row['slug'] . '/' .  $row3['slug']; ?>" title="<?php echo stripslashes($row3['name']); ?>"><?php echo stripslashes($row3['name']); ?></a>
                                            </li>
                                        <?php
                                        }
                                        echo '</ul>';
                                    }
                                    ?>
                                    </li>
                                <?php
                                }
                                echo '</ul>';
                            }
                        } else if($row['type_id']+0 == 2) {
                            $db->table = "gallery_menu";
                            $db->condition = "is_active = 1 and parent = 0 and category_id = ".($row['category_id']+0);
                            $db->order = "sort ASC";
                            $db->limit = "";
                            $rows2 = $db->select();
                            if($db->RowCount>1) {
                                echo '<ul class="hinhanhan">';
                                foreach($rows2 as $row2){
                                    ?>
                                <li  <?php if($slug_cat==$row['slug'] && $id_menu==$row2['gallery_menu_id']) echo 'class="active"'; ?> >
                                    <a href="<?php echo HOME_URL_LANG . '/' . $row['slug'] . '/' .  $row2['slug']; ?>" title="<?php echo stripslashes($row2['name']); ?>"><?php echo stripslashes($row2['name']); ?></a>
                                    <?php
                                    $db->table = "gallery_menu";
                                    $db->condition = "is_active = 1 and parent = ".($row2['gallery_menu_id']+0)." and category_id = ".($row['category_id']+0);
                                    $db->order = "sort ASC";
                                    $db->limit = "";
                                    $rows3 = $db->select();
                                    if($db->RowCount>0) {
                                        echo '<ul>';
                                        foreach($rows3 as $row3){
                                            ?>
                                            <li  <?php if($slug_cat==$row['slug'] && $id_menu==$row3['gallery_menu_id']) echo 'class="active"'; ?> >
                                                <a href="<?php echo HOME_URL_LANG . '/' . $row['slug'] . '/' .  $row3['slug']; ?>" title="<?php echo stripslashes($row3['name']); ?>"><?php echo stripslashes($row3['name']); ?></a>
                                            </li>
                                        <?php
                                        }
                                        echo '</ul>';
                                    }
                                    ?>
                                    </li>
                                <?php
                                }
                                echo '</ul>';
                            }
                        } else if($row['type_id']+0 == 21) {
                            $db->table = "document_menu";
                            $db->condition = "is_active = 1 and parent = 0 and category_id = ".($row['category_id']+0);
                            $db->order = "sort ASC";
                            $db->limit = "";
                            $rows2 = $db->select();
                            if($db->RowCount>1) {
                                echo '<ul>';
                                foreach($rows2 as $row2){
                                    ?>
                                <li  <?php if($slug_cat==$row['slug'] && $id_menu==$row2['document_menu_id']) echo 'class="active"'; ?> >
                                    <a href="<?php echo HOME_URL_LANG . '/' . $row['slug'] . '/' .  $row2['slug']; ?>" title="<?php echo stripslashes($row2['name']); ?>"><?php echo stripslashes($row2['name']); ?></a>
                                    <?php
                                    $db->table = "document_menu";
                                    $db->condition = "is_active = 1 and parent = ".($row2['document_menu_id']+0)." and category_id = ".($row['category_id']+0);
                                    $db->order = "sort ASC";
                                    $db->limit = "";
                                    $rows3 = $db->select();
                                    if($db->RowCount>0) {
                                        echo '<ul>';
                                        foreach($rows3 as $row3){
                                            ?>
                                            <li  <?php if($slug_cat==$row['slug'] && $id_menu==$row3['document_menu_id']) echo 'class="active"'; ?> >
                                                <a href="<?php echo HOME_URL_LANG . '/' . $row['slug'] . '/' .  $row3['slug']; ?>" title="<?php echo stripslashes($row3['name']); ?>"><?php echo stripslashes($row3['name']); ?></a>
                                            </li>
                                        <?php
                                        }
                                        echo '</ul>';
                                    }
                                    ?>
                                    </li>
                                <?php
                                }
                                echo '</ul>';
                            }
                        } else {}
                        ?>
                    </li>
                    <?php }
                    $speed = 0.1 * ($count+1);
                    ?>
                   
                   <!--  <li class="wow flipInX" data-wow-delay="0.2s"><a href="gioi-thieu" title="">Giới thiệu</a></li>
                    <li class="wow flipInX" data-wow-delay="0.3s"><a href="" title="">Sản phẩm</a></li>
                    <li class="wow flipInX dropdown" data-wow-delay="0.4s"><a href="javascript:{0}" title="">Dự án <i class="fa fa-angle-down"></i> </a>
                        <ul class="lidrop">
                            <li><a href=""><i class="fa fa-angle-right" aria-hidden="true"></i> Dự án đã thực hiện</a></li>
                            <li><a href=""><i class="fa fa-angle-right" aria-hidden="true"></i> Dự án đang cung cấp</a></li>
                        </ul>
                    </li>
                    <li class="wow flipInX" data-wow-delay="0.5s"><a href="" title="">Lĩnh vực hoạt động</a></li>
                    <li class="wow flipInX" data-wow-delay="0.6s"><a href="" title="">Hình ảnh</a></li>
                    <li class="wow flipInX" data-wow-delay="0.7s"><a href="" title="">Tin tức</a></li> -->

                    <li class="<?php if($slug_cat==$lgTxt_slug_contact) echo 'activemnu'; ?> wow flipInX" data-wow-delay="0.8s">
                        <a href="<?php echo HOME_URL_LANG . '/' . $lgTxt_slug_contact; ?>" title="<?php echo $lgTxt_menu_contact; ?>" >
                            <span><?php echo $lgTxt_menu_contact; ?></span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- <script type="text/javascript">
                $(document).ready(function(){
                    $('.navmenu > ul > li').hover(function(e){
                       $(this).find('.lidrop').slideToggle();
                    })
                })
            </script> -->
