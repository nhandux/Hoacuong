<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
//-------------

$date = new DateClass();
$stringObj = new String();

$slug7  = getSlugCategory(7);
$slug55 = getSlugCategory(55);
$slug68 = getSlugCategory(68);
$slug78 = getSlugCategory(78);
              ?>
</div>
 <div class="vechungtoi"> 
        <h2 class="wow fadeInRight" data-wow-delay="0.1s"><?=  $txtvechungtoi  ?></h2>
        <p class="wow fadeInRight" data-wow-delay="0.4s">
            <?php
            $db->table = "article";
            $db->condition = "is_active = 1 and article_id = 766";
            $db->order = "";
            $db->limit = "";
            $rows = $db->select();
            foreach($rows as $row){
               echo $stringObj->crop(stripslashes($row['content']), 77);
            }
            ?>
        </p>
        <div class="xemtiep wow fadeInRight" data-wow-delay="0.5s">
        <a href="<?= $txtslugxemthem ?>"><?= $txtxemthem ?>
        </a>
        </div>
     </div>
   <div class="anhcau">
        <div class="duandalam wow tada"  data-wow-delay="0.1s">
          <a href="<?= $txtslugduan ?>" title="<?= $txtslugduan ?>" >
          <span> <?= $txtduan ?> </span>
           <div class="divtxtduan"></div>
          </a>
        </div>
        <div class="list_duan" style="text-align: center;">
         <ul id="autoWidth" class="cs-hidden" style="margin: auto">
           <?php
            $db->table = "article";
            $db->condition = "is_active = 1 and article_menu_id = 351";
            $db->order = "";
            $db->limit = "3";
            $rows = $db->select();
            $count = 0.1;
            foreach($rows as $row){
            ?>
              <li>
             
                <div class="wow fadeInUp" data-wow-delay="<?= $count ?>s">
                <?php 
                     $alt = stripslashes($row['name']);
                        $list_img = "";
                        $db->table = "uploads_tmp";
                        $db->condition = "upload_id = ".($row['upload_id']+0);
                        $db->order = "";
                        $db->limit = '3';
                        $rows_gal = $db->select(); 
                        foreach ($rows_gal as $row_gal){
                            $list_img = $row_gal['list_img'];
                            }
                        $img = explode(";",$list_img);    
                      ?>
                    <img src="<?php  echo HOME_URL_LANG; ?>/uploads/photos/full_<?php echo $img[0]; ?>"><br/>

                     <span class="tenname"><?php echo $row['name'] ?></span>
                     
                     <div class="hienthithongtin">
                          <ul>
                         <li> <span style="font-size: 15px;text-transform: inherit;">• Dự án:</span><span class="tenduan"> <?=$row['name']?></span></li>
                         <li class="lingay">• Đăng: <span><?=  $date->vnFull($row['created_time'])  ?></span></li>
                         <li class="limota">• <?php echo $stringObj->crop(stripslashes($row['comment']), 35); ?></li>
                       <div class="social laiduan">
                            <ul>
                                <li onclick="javascript:window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo site_url()?>','_blank')" class="fa fa-facebook"></li>
                                <li onclick="javascript:window.open('https://twitter.com/intent/tweet?source=webclient&text=DANAWEB&url=<?php echo site_url()?>&hashtags=danaweb','_blank')" class="fa fa-twitter"></li>
                                <li onclick="javascript:window.open('https://plus.google.com/share?url=<?php echo site_url()?>','_blank')" class="fa fa-google-plus"></li>
                            </ul>
                             <a href="<?php  echo HOME_URL_LANG.'/'.$slug78.'/'.$slugchill.'/'.$stringObj->getLinkHtml($row['name'], $row['article_id']) ; ?>">
                              <span class="xemthemduan">Xem thêm <i class="fa fa-angle-double-right" aria-hidden="true"></i></span> </a>
                        </div>
                    
                     </div>
                    
                    </div>
              
              </li>
              <?php 
              $count = $count + 0.2;
                }
              ?>
              </ul></div>              
        </div>
<div class="content1">
    <div class="sanphamtren wow tada"  data-wow-delay="0.1s">
        <span class="spansanphammoi">SẢN PHẨM</span>
        <div class="divsanphammoi"></div>
    </div>
    <div class="dsct">
            <nav class="dschonlua">
                <ul class="tabs">
                    <li class="wow flipInX" data-wow-delay="0.1s"><a href="javascript:{0}" title="" class="tab-link current activep" data-tab="tab-1">Tất cả </a></li>
                     <?php
                        $db->table = "article_menu";
                        $db->condition = "is_active = 1 and category_id = 77";
                        $db->order = "";
                        $db->limit = "6";
                        $rows = $db->select();
                        $count = 0.2;
                        $sodem = 2;
                        foreach($rows as $row){
                        ?>
                    <li class="wow flipInX" data-wow-delay="<?= $count?>s"><a href="javascript:{0}" title="" class="tab-link" data-tab="tab-<?= $sodem; ?>">
                        <?= $row['name'] ?>
                    </a></li>
                    <?php
                     $count = $count + 0.1;
                     $sodem = $sodem + 1;
                    } ?>
                </ul>
             </nav> 
        <nav class="chondanhsach">
            <ul> 
                <li> <i class="fa fa-bars" aria-hidden="true"></i> Chọn danh sách các sản phẩm
                   <ul class="mdsmenu tabs">
                        <li><a href="javascript:{0}" title=""  class="tab-link current activep" data-tab="tab-1">Tất cả</a></li>
                        <?php
                        $db->table = "article_menu";
                        $db->condition = "is_active = 1 and category_id = 77";
                        $db->order = "";
                        $db->limit = "6";
                        $rows = $db->select();
                        $count = 0.2;
                        $sodem = 2;
                        foreach($rows as $row){
                        ?>
                        <li><a href="javascript:{0}" title="" class="tab-link" data-tab="tab-<?= $sodem ?>" ><?= $row['name'] ?></a></li>
                       <?php
                         $sodem = $sodem + 1;
                       } ?>
                   </ul>
                </li>
            </ul>
        </nav>
             <div class="listcate">
             <div id="loading" style="min-height: 200px;width: 100%;text-align: center;line-height: 200px;position: absolute;background: rgba(255,255,255,0.3);top:0;left:0">
               
             </div>
             <div>
             <div id="tab-1" class="tab-content current"  style="width: 100%;">
             <ul id="tab1">
               
             </ul>
                <div class="phantrang wow fadeInUp" data-wow-delay="0.5s">
             <ul>
                    <li style="display: none"><span class="pageInfo"></span></li>
                    <li><a href="javascript:{0}" class="goPrevious"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                    <span class="danhsachtrang">
                      
                    </span>                    
                    <li><a href="javascript:{0}" class="goNext"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
             </ul>  
            </div>
             </div>
            </div> 
                <?php 
                  $db->table = "article_menu";
                        $db->condition = "is_active = 1 and category_id = 77";
                        $db->order = "";
                        $db->limit = "";
                        $rows = $db->select(); 
                        $sotab = 1;            
                        foreach($rows as $row){
                        $sotab = $sotab + 1;
                        if($rows == ''){
                            echo '<div><ul id="tab-'.$sotab.'" class="tab-content ">Hiện chưa có thông tin sản phẩm</ul></div>';
                        }  
                        else{
                        echo '<div  id="tab-'.$sotab.'" class="tab-content" ><ul id="rowsul_'.$row['article_menu_id'].'">';
                        $rows2 = getLimitArticleItem($row['article_menu_id'],0,8);
                        foreach($rows2 as $row2){
                           $solchay = $solchay + 0.07; 
                    ?><script type="text/javascript">
                    </script>
                    <li class="wow fadeInUp" data-wow-delay="<?= $solchay ?>s">
                    <?php
                   echo '<a href="'. HOME_URL_LANG . '/san-pham/' . getSlugMenu($row2['article_menu_id'], 'article') . '/' . $stringObj->getLinkHtml($row2['name'], $row2['article_id']) . '" title="' . stripslashes($row2['name']) . '">';
                     ?>
                        <img src="<?= HOME_URL_LANG ?>/uploads/article/post-<?= $row2['img'] ?>">
                        <div class="anhtop1">

                        <span class="titsptc"><?= $row2['name'] ?></span><br/>
                        </div>    
                    </a></li>
               <?php 
               

                   }
               ?>
               </ul>
               <?php
              if( countArticalitem($row['article_menu_id']) < 8)
                {
               ?>
                <div class="phantrang wow fadeInUp" data-wow-delay="0.4s" id="ds_<?= $row['article_menu_id'] ?>">
             <ul>
                    <li style="display: none"><span class="pageInf"></span></li>
                    <li><a href="javascript:{0}" class="gogrevios"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                    <li><a href="<?= HOME_URL_LANG?>/san-pham/<?=  getSlugMenu($row['article_menu_id'], 'article') ?>"> xem thêm </a></li>                    
                    <li><a href="javascript:{0}" class="gogext"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
             </ul>  
               </div>
               <?php } ?>
                   </div> 

               <?php
                   }
                }
           ?>
      
            </div>
        </div>
          <div class="nganhang">
                    <ul id="responsive" class="content-slider">
                            <li class="wow fadeInRight" data-wow-delay="0.1s"><img src="<?php echo HOME_URL_LANG; ?>/images/kientruc.png"></li>
                            <li class="wow fadeInRight" data-wow-delay="0.2s"><img src="<?php echo HOME_URL_LANG; ?>/images/buiding.png"></li>
                            <li class="wow fadeInRight" data-wow-delay="0.3s"><img src="<?php echo HOME_URL_LANG; ?>/images/noithat.png"></li>
                            <li class="wow fadeInRight" data-wow-delay="0.4s"><img src="<?php echo HOME_URL_LANG; ?>/images/giaphat.png"></li>
                            <li class="wow fadeInRight" data-wow-delay="0.5s"><img src="<?php echo HOME_URL_LANG; ?>/images/ngoinhan.png"></li>
                            <li class="wow fadeInRight" data-wow-delay="0.5s"><img src="<?php echo HOME_URL_LANG; ?>/images/ngoinhan.png"></li>
                    </ul>   
        </div>
<div class="contenner">

      <div class="contant">
         <div class="bentrai">
             <span class="video wow tada"  data-wow-delay="0.1s">
                <?= $txtvideo ?>
              <div style="height: 5px;width: 30px;border-bottom:1px solid #fff;margin-left: 5px;margin-top: 10px;margin-bottom: 5px;">
                 
               </div>
            </span>
            <div class="chuavideo wow flipInX" >
                <div class="body-container vidio" style="max-width: 360px; height: 205px; margin: 0 auto;margin-top: 10px;">
            <script src="https://content.jwplatform.com/libraries/XmRneLwC.js"></script>
               <div id="aRzklaXf">Đang tải video...</div>
               <script type="text/javascript">
               var playerInstance = jwplayer("aRzklaXf");
                   playerInstance.setup({
                    file: "mp4/nhan.mp4",
                    image: "images/video.png",
                    mediaid: "aRzklaXf",
                    autostart: false,
                    cast: {
                        appid: "EDF7B42C",
                        endscreen: "https://assets-jpcust.jwpsrv.com/watermarks/UhfJXj85.png",
                        loadscreen: "https://assets-jpcust.jwpsrv.com/watermarks/zAWOWPbu.png",
                        logo: "https://assets-jpcust.jwpsrv.com/watermarks/mxQeCt89.png"
                    },
               });
            </script>
            </div>
            </div>
         </div>
         <div class="benphai">
            <span class="video wow tada"  data-wow-delay="0.1s">
                <?= $txttintucsukien ?>
              <div style="height: 5px;width: 90px;border-bottom:1px solid #fff;margin-left: 5px;margin-top: 10px;">
                 
               </div>
            </span>
            <div class="chuatin">
                <div class="listtin">
                        <nav>
                            <ul>
                             <?php
                                $db->table = "article";
                                $db->condition = "`is_active` = 1 AND `article_menu_id` = 353";
                                $db->order = "";
                                $db->limit = "2";
                                $rows = $db->select();
                                if($db->RowCount>0) {
                                    foreach($rows as $row) {
                            ?>
                                <li class="wow flipInX" data-wow-delay="0.1s">
                                <a <?php echo 'href="' . HOME_URL_LANG . '/tin-tuc/'.getSlugMenu($row['article_menu_id'], 'article'). '/'.$stringObj->getLinkHtml($row['name'], $row['article_id']) .'"'?> title="">
                                    <img src="<?php echo HOME_URL_LANG; ?>/uploads/article/post-<?= $row['img'] ?>" align="left">
                                     
                                        <span class="titletin"><?= $row['name'] ?></span>
                                        <br/>
                                        <span class="ngay"> <?= $date->vnFull($row['created_time']) ?></span><br/>
                                        <span class="tomtat">
                                           <?= $row['comment'] ?>
                                        </span>

                                </a></li>
                            <?php
                                  } 
                                }
                            ?>
                           
                            </ul>
                        </nav>
                    </div>
            </div>
         </div>
         

      </div>
 <!-- bottom -->
 <div class="mauxanhbot">
    <div class="baoduoibot">
     <div class="lienhect lienhectien">
            <ul class="trai">
                <li class="wow flipInX" data-wow-delay="0.1s"><img src="<?php echo HOME_URL_LANG; ?>/images/emailn.png" align="left"><?= $txttieukhu ?></li>
                <li class="wow flipInX" data-wow-delay="0.3s">
                 <i class="fa fa-envelope-o ifio" aria-hidden="true"></i> <?= $txtinfoct ?></li>
                <li class="wow flipInX" data-wow-delay="0.5s"><img src="<?php echo HOME_URL_LANG; ?>/images/phonen.png" align="left"><?= $txtphonect ?></li> 

            </ul>
            <ul class="phair">
                <li class="wow fadeInRight" data-wow-delay="0.1s"><a href="<?php echo getConstant('link_facebook');?>"><img src="<?php echo HOME_URL_LANG; ?>/images/fb.png"></a></li>
                <li class="wow fadeInRight" data-wow-delay="0.2s"><a href="<?php echo getConstant('link_twitter');?>"><img src="<?php echo HOME_URL_LANG; ?>/images/titew.png"></a></li>
                <li class="wow fadeInRight" data-wow-delay="0.3s"><a href="<?php echo getConstant('link_linkedIn');?>"><img src="<?php echo HOME_URL_LANG; ?>/images/intagram.png"></a></li>
                <li class="wow fadeInRight" data-wow-delay="0.4s"><a href="<?php echo getConstant('link_googleplus'); ?>"><img src="<?php echo HOME_URL_LANG; ?>/images/google.png"></a></li> 

            </ul>
        </div>
        </div>
      </div>  
 <!-- bottom -->


     </div>
   
     <script type="text/javascript">          
  (function($){
    $.fn.zPaging = function(options){
       
       var defaults = {
        "rows"        : "#tab1",
        "nutbamvao"   : ".nutbamvao",
        "danhsachtrang":".danhsachtrang",
        "pages"       : "#pages",
        "items"       : 8,
        "currentPage"   : 1,
        "total"       : 0,
        "btnPrevious"   : ".goPrevious",
        "btnNext"     : ".goNext",
        "txtCurrentPage"  : "#currentPage",
        "pageInfo"      : ".pageInfo"
      };
    options = $.extend(defaults,options);
    
    //=============================================
    //Cac bien se su dung trong Plugin
    //=============================================
    var rows      = $(options.rows);
    var nutbamvao = $(options.nutbamvao);
    var danhsachtrang = $(options.danhsachtrang);
    var pages       = $(options.pages);
    var btnPrevious   = $(options.btnPrevious);
    var btnNext     = $(options.btnNext);
    var txtCurrentPage  = $(options.txtCurrentPage);
    var lblPageInfo   = $(options.pageInfo);
    
    var aRows     = '';
  
    init();
    function init(){
      $.ajax({
        url   : "load_data.php?type=count&items=" + options.items,
        type  : "GET",
        dataType: "json"
      }).done(function(data){
        options.total = data.total
        truyendayso()
        pageInfo()
        loadData(options.currentPage)
        
    }).error(function(ev) {
      alert(0)
      /* Act on the event */
    });
     }
     setCurrenPage(options.currentPage);
     function loading_show(){
            $('#loading').html("<img src='images/loading.gif'/>").fadeIn('fast');
     }
    function loading_hide(){
            $('#loading').fadeOut('fast');
    }
      btnPrevious.on('click',function(e){
       goPrevious()
      })

      btnNext.on('click',function(e){
       
        goNext()
      })
     
      // txtCurrentPage.on('keyup',function(e){
      //   if(e.keyCode == 13)
      //   {
      //     var currentPageValue = parseInt($(this).val())
      //     if(isNaN(currentPageValue) || currentPageValue <= 0){
      //       alert('Giá trị bạn nhập vào không phù hợp')
      //     }
      //     else if(currentPageValue > options.total){
      //       alert('Giá trị bạn nhập quá lớn')
      //     }
      //     else{
      //        options.currentPage = currentPageValue;
      //        loadData(currentPageValue)
      //        pageInfo();
      //     }
      //   }
      // })
      loading_show()
      $('.nutbamvao').click(function(event) {
        /* Act on the event */
        alert(1)
      });
    nutbamvao.on('click',function(e){
      alert(1)
    })
 function truyendayso(){
  var sodau = options.total;
  var hientai = options.currentPage;
  var i = 1;
  danhsachtrang.empty()
  for(i = 1 ; i <= sodau ; i ++){
    if(i != hientai)
    var sttr = '<li><a href="javascript:{0}" item_id="'+i+'">'+i+'</a></li>'
     else if(i == hientai)
      sttr =   '<li><span>'+i+'</span></li>'
     danhsachtrang.append(sttr)
  } 
  aRows = options.danhsachtrang + " li a"
   $(aRows).on('click',function(e){
      loading_show()
      bamsotrang(this)
   })
 }  
 function bamsotrang(page){

    p = $(page).attr('item_id')
        loadData(p)
        setCurrenPage(p)
        options.currentPage = p
        pageInfo()
        truyendayso()  
 }
   var danhsachtranga = options.danhsachtrang +" a"
    $(danhsachtranga).on('click',function(e){
      alert(1)
    })
    function loadData(page){
      $.ajax({
        url: "load_data.php?type=list",
        type: "POST",
        dataType:"json",
        cache: false,
        data:{
          "items":options.items,
          "currentPage" : page
        }
      }).done(function(data){
        loading_hide()
        var mi = 0
        if(data.length >  0){
         rows.empty()
         $.each(data,function(i,val){
           id_armenu = parseInt(val.article_menu_id);
          var str = '<li class="wow fadeInUp" data-wow-delay="'+i*0.1+'s"><a href="<?php
           echo HOME_URL_LANG  
           ?>/san-pham/'+'<?php $sinhtu="'+id_armenu+'";echo $sinhtu; echo getSlugMenu($sinhtu1,'article'); ?>"><img src="<?= HOME_URL_LANG 
           ?>/uploads/article/post-'+val.img+'"><div class="anhtop">'+val.name+'</div></a></li>'
          rows.append(str)
         })
        }
      })
    }
     
    function setCurrenPage(value)
       {
       txtCurrentPage.val(value)
       }
    
    function pageInfo(){
      lblPageInfo.text("Page "+ options.currentPage + " of " + options.total)
    }
    

    function goPrevious(){
      if(options.currentPage != 1){
        loading_show()
        var p = options.currentPage - 1;
        loadData(p)
        setCurrenPage(p)
        options.currentPage = p
        pageInfo()
        truyendayso()
      }
    }

    function goNext(){

      if(options.currentPage < options.total){
        loading_show()
        var p = options.currentPage + 1;
        loadData(p)
        setCurrenPage(p)
        options.currentPage = p
        pageInfo()
        truyendayso()
      }
    }

// end game
    }
  })(jQuery);
  $(document).ready(function() {
   var obj = {}
   $('.listcate').zPaging(obj)
  });
</script>