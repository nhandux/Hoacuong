 (function($){
    $.fn.zPaging = function(options){
       
       var defaults = {
        "rows"        : "#tab1",
        "nutbamvao"   : ".nutbamvao",
        "danhsachtrang":".danhsachtrang",
        "pages"       : "#pages",
        "items"       : 6,
        "height"      : 27,
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
    
    //=============================================
    //Khoi tao cac ham can thi khi Plugin duoc su dung
    //=============================================
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

      btnPrevious.on('click',function(e){
       loading_show()
       goPrevious()
      })

      btnNext.on('click',function(e){
        loading_show()
        goNext()
      })
     
      txtCurrentPage.on('keyup',function(e){
        if(e.keyCode == 13)
        {
          var currentPageValue = parseInt($(this).val())
          if(isNaN(currentPageValue) || currentPageValue <= 0){
            alert('Giá trị bạn nhập vào không phù hợp')
          }
          else if(currentPageValue > options.total){
            alert('Giá trị bạn nhập quá lớn')
          }
          else{
             options.currentPage = currentPageValue;
             loadData(currentPageValue)
             pageInfo();
          }
        }
      })
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
  console.log(aRows)

   $(aRows).on('click',function(e){
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

function loading_show(){
        $('#loading').html("<img src='images/loading.gif'/>").fadeIn('fast');
    }
    // PHƯƠNG THỨC ẨN HÌNH LOADING
function loading_hide(){
        $('#loading').fadeOut('fast');
}         
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
           id_armenu = val.article_menu_id
          var str = '<li class="wow fadeInUp" data-wow-delay="'+i*0.1+'s"><a href="<?php echo HOME_URL_LANG  ?>/san-pham/'+'<?php  echo getSlugMenu("361", "article")  ?>">  <img src="<?= HOME_URL_LANG ?>/uploads/article/post-'+val.img+'"><div class="anhtop">'+val.name+'</div></a></li>'
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