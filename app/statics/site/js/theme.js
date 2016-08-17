$(function () {
    $(window).scroll(function(){
        // global scroll to top button
        if ($(this).scrollTop() > 200) {
            $('.scrolltop').fadeIn();
        } else {
            $('.scrolltop').fadeOut();
        }        
    });
    // scroll back to top btn
    $('.scrolltop').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 400);
        return false;
    });
    // wechat popover
   $(function () {  
              $('[data-toggle="popover"]').popover()  
            })  
              
            $(document).ready(function () {  
                //自定义popover显示的内容  
               $('#wechat,#wechat2').popover({  
			        trigger:'hover',  
                    html : true,  
                    title: function() {  
                      return $("#popover-head").html();  
                    },  
                    content: function() {  
                      return $("#popover-content").html();  
                    }  
                });
				
			 }); 
	// others
    $('#kfyx').tooltip();
});