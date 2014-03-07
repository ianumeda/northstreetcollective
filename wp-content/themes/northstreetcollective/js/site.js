
	jQuery(document).ready(function($) {

         $(window).scroll(function() {
           set_nav_position();
         });

         var last_resize=0;
         function throttle_on_resize(){
           if($.now()-last_resize > 1000){
             last_resize=$.now();
             return true;
           } else { return false; }
         }


         $( window ).resize(function() {
           if(throttle_on_resize()){
       			$('#top_image_bottom').css({'margin-top':$( window ).height()+'px'});
              set_footer_position();
              set_nav_position();
           }
         });
         
         function set_footer_position(){
           var page_position=$('#page').position();
           var page_bottom=page_position.top+$('#page').outerHeight(true);
           // alert(page_position.top+" + "+$('#page').outerHeight(true));
           if( $(window).height() > page_bottom + $('#footer').outerHeight(true) ){
             $('#footer').css({'position':'fixed', 'bottom':'0px'});
           } else {
             $('#footer').css({'position':'absolute', 'top':(page_bottom)+'px'});
           }
         }
         
         function set_nav_position(){
           var page_position=$('#page').position();
           if($("#wpadminbar").get(0)) wpadminbarheight=$('#wpadminbar').outerHeight(true);
           else wpadminbarheight=0; 
           // alert($(this).scrollTop() +' > '+page_position.top+' - '+$('#main_navigation').outerHeight(true)+' - '+wpadminbarheight );
           if( $(this).scrollTop() > page_position.top-$('#main_navigation').outerHeight(true)-wpadminbarheight ){
             $('#main_navigation').css({'position':'fixed','top':(wpadminbarheight)+'px'});
           } else {
             $('#main_navigation').css({'position':'absolute','top':(page_position.top-$('#main_navigation').outerHeight(true))+'px'});
           }
         }
         
         set_nav_position();
         set_footer_position();

			new UISearch( document.getElementById( 'sb-search-bottom' ) );

	});


