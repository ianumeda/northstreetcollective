
	jQuery(document).ready(function($) {

         $(window).scroll(function() {
           set_nav_position();
         });

         // throttle_on_resize returns true if the amount of time since the last call to the function exceeds the limit
         var throttle_id=null;
         function throttle_on_resize(thedelayamount){
           // this function sets a timer function that calls on_resize after thedelayamount. when called during that delay a new delay is set. 
           if(thedelayamount==null) thedelayamount=1000;
           if(throttle_id!=null){
             // kill current throttle 
             clearTimeout(throttle_id);
           }
           // start a new one...
           throttle_id=setTimeout(function() { on_resize(true); },thedelayamount); 
         }
    
         function on_resize(go_immediately) {
           if(!go_immediately) throttle_on_resize();
           else {
             throttle_id=null;
             var min_height=320;
             var max_height=960;
             var ideal_image_height=$( window ).height()*2/3;
             var set_image_height = (ideal_image_height < min_height ? min_height : ideal_image_height);
         		 $('#top_image_bottom').css({'margin-top':set_image_height+'px'});
             set_footer_position();
             set_nav_position();
             gotopage();
             set_art_presenter_height();
           }
         };
    
         $( window ).resize(function() {
           on_resize(false);
         });
         
         $(".link_overlay").each(function(){
           // this vertically centers the arrow on link_overlay links 
           var parent_height=$(this).parent().outerHeight();
           $(this).css("line-height", parent_height+"px");
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
         
         on_resize(false);

			new UISearch( document.getElementById( 'sb-search-bottom' ) );

      var cbpAnimatedHeader = (function() {
 
          var docElem = document.documentElement,
              header = document.querySelector( '.cbp-af-header' ),
              didScroll = false,
              changeHeaderOn = 140;
 
          function init() {
              window.addEventListener( 'scroll', function( event ) {
                  if( !didScroll ) {
                      didScroll = true;
                      setTimeout( scrollPage, 250 );
                  }
              }, false );
          }
 
          function scrollPage() {
              var sy = scrollY();
              if ( sy >= changeHeaderOn ) {
                  classie.add( header, 'cbp-af-header-shrink' );
              }
              else {
                  classie.remove( header, 'cbp-af-header-shrink' );
              }
              didScroll = false;
          }
 
          function scrollY() {
              return window.pageYOffset || docElem.scrollTop;
          }
 
          init();
 
      })();

	});


