<?php
if (!defined('TTH_SYSTEM')) { die('Please stop!'); }
?>

<script type="text/javascript" src="<?php echo HOME_URL;?>/js/jquery/jquery-1.11.0.js"></script>
<script type="text/javascript" src="<?php echo HOME_URL;?>/js/modernizr.custom.js"></script>
<script type="text/javascript" src="<?php echo HOME_URL;?>/js/jquery.mmenu.min.all.js"></script>
<script type="text/javascript" src="<?php echo HOME_URL;?>/js/jquery.easing.js"></script>
<script type="text/javascript" src="<?php echo HOME_URL;?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo HOME_URL;?>/js/jquery.carousels-slider.min.js"></script>
<script type="text/javascript" src="<?php echo HOME_URL;?>/js/jquery.popup/jquery.modal.min.js"></script>
<script type="text/javascript" src="<?php echo HOME_URL;?>/js/auto-numeric.js"></script>
<script type="text/javascript" src="<?php echo HOME_URL;?>/js/wow.min.js"></script>
<script type="text/javascript" src="<?php echo HOME_URL;?>/js/script.js"></script>
<script type="text/javascript" src="<?php echo HOME_URL;?>/js/gridify.js"></script>
<script type="text/javascript" src="<?php echo HOME_URL;?>/js/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo HOME_URL;?>/js/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?php echo HOME_URL;?>/js/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript" src="<?php echo HOME_URL;?>/js/jquery.popup/jquery.boxes.js"></script>
<script type="text/javascript" src="<?php echo HOME_URL;?>/js/jquery.popup/jquery.boxes.repopup.js"></script>
<script type='text/javascript' src='<?php echo HOME_URL;?>/js/jquery.mobile.customized.min.js'></script>
<script type='text/javascript' src='<?php echo HOME_URL;?>/js/jquery.easing.1.3.js'></script> 
<script type='text/javascript' src='<?php echo HOME_URL;?>/js/jcarousellite_1.js'></script> 
<script type='text/javascript' src='<?php echo HOME_URL;?>/js/camera.min.js'></script> 
<script src='https://cdn.rawgit.com/jackmoore/zoom/master/jquery.zoom.min.js'></script>
    <script src="<?php echo HOME_URL;?>/js/lightslider.js"></script> 
    <script>
    $(function() {
    $(".newsticker-jcarousellite").jCarouselLite({
      vertical: true,
      hoverPause:true,
      visible: 3,
      auto:500,
      speed:1000
    });
  });
    $(document).ready(function() {
      $('#autoWidth').lightSlider({
        auto:true,
        autoWidth:true,
        loop:true,
        onSliderLoad: function() {
            $('#autoWidth').removeClass('cS-hidden');
        } 
    });  
  });
     jQuery(document).ready(function($) {
        $('.chondanhsach > ul > li').click(function(){
           $('.mdsmenu').slideToggle();
        })
     });
      $(document).ready(function() {
     $('#responsive').lightSlider({
        item:6,
        loop:false,
        slideMove:0,
        easing: 'cubic-bezier(0.2, 0, 0.2, 0.2)',
        speed:400,
        responsive : [
            {
                breakpoint:840,
                settings: {
                    item:4,
                    slideMove:1,
                    slideMargin:60,
                  }
            },
            {
                breakpoint:400,
                settings: {
                    item:2,
                    slideMove:1,
                    slideMargin:30
                  }
            }
        ]
    });  
  });

    jQuery(document).ready(function() {
        $('.dschonlua ul li').click(function(){
            $('.dschonlua ul li').find('a').removeClass('activep')
            $(this).find('a').addClass('activep')
        })
    });
      jQuery(document).ready(function() {
        $('.mdsmenu li').click(function(){
            $('.mdsmenu li').find('a').removeClass('activep')
            $(this).find('a').addClass('activep')
        })
    });
    v = 1060
    $(document).ready(function(){
    $('ul.tabs li a').click(function(){
        v = v + 2
        var tab_id = $(this).attr('data-tab');
        $('ul.tabs li a').removeClass('current');
        $('.tab-content').removeClass('current');
        $("body,html").animate({scrollTop:v},1000);
        $(this).addClass('current');
        $("#"+tab_id).addClass('current')
    })

})

    </script>
    <script>
        jQuery(function(){
            
            jQuery('#camera_wrap_1').camera({
                thumbnails: true
            });

            jQuery('#camera_wrap_2').camera({
                
                loader: 'bar',
                pagination: false,
                thumbnails: true
            });
        });
        $(document).ready(function(){
          $(".hamburger").click(function(){
            $(this).toggleClass("is-active")
            $('.navmenu').toggleClass("activemenu")

          });
        });
    </script>
    <script>
    $(function() {
        $('nav#menu').mmenu({
            extensions	: [ 'effect-slide-menu', 'pageshadow' ],
            searchfield	: true,
            counters	: false,
            navbar 		: {
                title		: 'Green Mind Institute'
            },
            offCanvas: {
                position: "right"
            },
            navbars		: [
                {
                    position	: 'top',
                    content		: [ 'searchfield' ]
                }, {
                    position	: 'top',
                    content		: [
                        'prev',
                        'title',
                        'close'
                    ]
                }
            ]
        });
    });
</script>
  
<?php echo getConstant('google_analytics')?>
<?php echo getConstant('chat_online')?>