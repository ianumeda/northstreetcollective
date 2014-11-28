<?php
/**
 * The Template for displaying all art posts
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php 
// this checks if art post has parent pages and goes to the top-most parent page if so. Child art posts do not manifest on this site except within the art_presenter on the top-level post
if($parents=get_post_ancestors($post->ID)) {
  $top_ancestor=end($parents);
  header( "Location: ".get_permalink($top_ancestor) );
} else {
 ?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header-piece' ) ); ?>
<div id="art_presenter">
  <div id="presenter_container">
    <?php     
    $pagenumber=0;
    ?>
    <div id="art_page_<?php echo $pagenumber; ?>" class="col-xs-10 col-sm-8 col-lg-6 art_page page_<?php echo $pagenumber; ?>" page_number="<?php echo $pagenumber; ?>">
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
      <div class="row">
        <div class="col-md-8 col-md-push-2 content">
              <article>
                <div class="section_heading">
                  <?php 
                  if($shows=get_arts_shows($post->ID)) {
                    foreach($shows as $show) {
                      $showpost=get_post($show);
                      echo '<h5><a href="'. get_permalink($showpost->ID) .'" alt="Go back to &ldquo;'. get_the_title($showpost->ID) .'&rdquo;">'. get_the_title($showpost->ID) .'</a></h5>'; 
                    }
                  }
                  ?>
                  <h2><?php the_title(); ?></h2>
                  <?php 
                  $arts_artists=get_arts_artists($post->ID);
              		echo '<h5 class="byline artist_list">by ';
            	    foreach($arts_artists as $artistID){
                    $artist=get_post($artistID);
            	      echo '<span class="artist_name"><a href="'. get_permalink($artist->ID) .'" alt="goto '. display_name_format( get_the_title($artist->ID) ) .'&apos;s page">'. display_name_format( get_the_title($artist->ID) ) .'</a></span>';
            	    }
            	    echo '</h5>';
                  ?>
                </div>
                <?php remove_filter( 'the_content', 'sharing_display', 19 ); ?>
                  <?php remove_filter( 'the_excerpt', 'sharing_display', 19 ); ?>
                <?php the_content(); ?>
              </article>
        </div>
      </div>
      <!-- <div class="page_controls">
        <div class="go_page_right btn btn-link">Next <span class="glyphicon glyphicon-arrow-right"></span></div>
      </div> -->
    </div>
  <?php
    if(has_post_thumbnail( $post->ID ) ){
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); 
      $imgurl=$image[0];
      $pagenumber++;
  ?>
  
  <div id="art_page_<?php echo $pagenumber; ?>" class="col-xs-12 col-sm-9 col-md-7 art_page image_page page_<?php echo $pagenumber; ?>" page_number="<?php echo $pagenumber; ?>" style="background-image: url('<?php echo $imgurl; ?>')">
    <div class="art_content">
      <img src="<?php echo $imgurl; ?>" >
    </div>
  </div>

  <?php
  $query = new WP_Query( array( 'post_type' => 'piece', 'post_parent' => $post->ID, 'posts_per_page' => '-1', 'offset' => '0', 'order' => 'ASC', 'orderby' => 'menu_order' ));
  if ( $query->have_posts() ) {
  	while ( $query->have_posts() ) {
      $pagenumber++;
  		$query->the_post();
      ?>
      <?php
        if(has_post_thumbnail( $post->ID ) ){
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); 
          $imgurl=$image[0];
      ?>
      
      <div id="art_page_<?php echo $pagenumber; ?>" class="col-xs-12 col-sm-10 col-lg-8 art_page image_page page_<?php echo $pagenumber; ?>" page_number="<?php echo $pagenumber; ?>" style="background-image: url('<?php echo $imgurl; ?>')">
        <div class="row art_content">
        
      <?php } else { ?>      
      
      <div id="art_page_<?php echo $pagenumber; ?>" class="col-xs-12 col-sm-9 col-lg-7 art_page page_<?php echo $pagenumber; ?>" page_number="<?php echo $pagenumber; ?>">
        <div class="row">
        
      <?php } ?>      
      
          <div class="col-md-8 col-md-offset-2 content">
            <article>
              <div class="section_heading">
                <h2><?php the_title(); ?></h2>
              </div>
              <?php the_content(); ?>
            </article>
          </div>
        </div>
        <!-- <div class="page_controls">
          <div class="go_page_left btn btn-link"><span class="glyphicon glyphicon-arrow-left"></span> Previous</div>
          <div class="go_page_right btn btn-link">Next <span class="glyphicon glyphicon-arrow-right"></span></div>
        </div> -->
      </div>

      <?php 
      }
    }
  $pagenumber++;  
  ?>
  <?php wp_reset_postdata(); ?>
  <div id="art_page_<?php echo $pagenumber; ?>" class="col-xs-8 col-sm-5 col-lg-3 art_page last_page page_<?php echo $pagenumber; ?>" page_number="<?php echo $pagenumber; ?>">
    <div class="row">
      <div class=" content">
        <article>
          <div class="section_heading">
            <h2>The End</h2>
          </div>
          <div class="row">
            <h6>The artist(s):</h6>
            <?php 
            $arts_artists=get_arts_artists($post->ID);
            if(!empty($arts_artists)){
              foreach($arts_artists as $artistID){
            ?>
            <div class="col-xs-12 post_preview">
              <h4 class="artist_name"><?php echo display_name_format( get_the_title($artistID) ); ?></h4>
              <a class="post_preview_link link_overlay" href="<?php echo get_permalink($artistID); ?>" alt="goto <?php echo display_name_format( get_the_title($artistID) ); ?>&apos;s page"><span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
            <?php
              }
      	    } else {?>
              <div class="col-xs-12 alert alert-warning">No associated artists</div>
            <?php 
            }
            ?>


            <h6>This piece featured in:</h6>
            <?php 
            $arts_shows=get_arts_shows($post->ID);
            if(!empty($arts_shows)){
        	    foreach($arts_shows as $showID){
            ?>

            <div class="col-xs-12 post_preview">
      		    <h4><?php echo get_the_title($showID); ?></h4>
              <a href="<?php echo get_permalink($showID); ?>" class="post_preview_link link_overlay"><span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>

            <?php
              }              
            } else {
              ?>
              <div class="col-xs-12 alert alert-warning">No associated show</div>
              <?php
            }
            ?>

            <h4>Other artworks in this show:</h4>
            <?php 
            $art_posts=get_shows_art($showpost->ID); // gets array of associated art posts
          	foreach ( $art_posts as $artID ) {
              if($artID!=$post->ID){
            ?>
            <div class="col-xs-12 post_preview">
        		    <h4><?php echo get_the_title($artID); ?> </h4>
                <a href="<?php echo get_permalink($artID); ?>" class="post_preview_link link_overlay"><span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
            <?php
              }
        		}
            ?>
            <h6>Share this page on social media</h6>
            <p>
              <?php echo sharing_display(); ?> 
            </p>
            
            <h6>Get involved</h6>
            <div class="col-xs-12 post_preview">
        		    <h4>Come see this artwork</h4>
                <a href="http://northstreetcollective.org/contact/" class="post_preview_link link_overlay"><span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
            <div class="col-xs-12 post_preview">
        		    <h4>Donate to North Street Collective for art like this</h4>
                <a href="http://northstreetcollective.org/contact/" class="post_preview_link link_overlay"><span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
            
        </article>
      </div>
    </div>
  <?php 
    } 
    endwhile; 
  ?>
    <!-- <div class="page_controls">
      <div class="go_page_left btn btn-link"><span class="glyphicon glyphicon-arrow-left"></span> Previous</div>
      <div class="go_page_right btn btn-link"><span class="glyphicon glyphicon-fast-backward"></span> to the beginning</div>
    </div> -->
  </div>
  
</div><!-- .presenter_container -->
</div><!-- #art_presenter -->
<div id="art_presenter_controls" class="visible-xs">
  <div id="goleft" class="go_page_left"><span class="glyphicon glyphicon-chevron-left"></span></div>
  <div id="goright" class="go_page_right"><span class="glyphicon glyphicon-chevron-right"></span></div>
</div>

<?php } // this ends the parent post check-redirect logic ?>

<script>
var active_page_number=0;
var number_of_pages=<?php echo $pagenumber; ?>;

function gotopage(pagenumber, direction){
  if(pagenumber==undefined){
    if(direction=="next") {
      active_page_number = (active_page_number < number_of_pages ? active_page_number+1 : 0);
    } else if(direction=="prev"){
      active_page_number = (active_page_number>0 ? active_page_number-1 : 0);
    } 
  } else {
    active_page_number = (active_page_number<0 ? 0 : (active_page_number > number_of_pages ? number_of_pages : pagenumber) );
  }
  $('.art_page').removeClass("active");
  var active_page=$("#art_page_"+active_page_number);
  // alert("gotopage("+pagenumber+","+direction+") ("+active_page_number+"), active_page:"+active_page.attr("page_number"));
  active_page.addClass("active");
  var offsetx= ( active_page_number==0 ? 0 : ( active_page_number==number_of_pages ? $(document).width()-active_page.width() : ( $(document).width() - active_page.width() ) /2 ) );
  $("#art_presenter").scrollTo(active_page,1000,{ offset:-offsetx , easing:'easeOutExpo'});   
  // alert("active_page_number="+active_page_number);
}
function set_art_presenter_height(){
  var topnavoffset=$("header").offset();
  var available_vertical_space=$(window).height()-( topnavoffset.top + $("#main_navigation").outerHeight());
  $('#art_presenter').css({"height":available_vertical_space+"px"});
  // alert("set_art_presenter_height: "+$(window).height()+" - ("+topnavoffset.top+" + "+$("#main_navigation").outerHeight()+") = "+available_vertical_space);
}

$('.go_page_left').click(function(){
  // if($(this).parent().parent().hasClass("active")){
    gotopage(null,'prev');
    event.stopPropagation();
    // active_page_number = (active_page_number>0 ? active_page_number-1 : 0);
    // alert('active_page_number='+active_page_number);
  // }
});
$('.go_page_right').click(function(){
  // if($(this).parent().parent().hasClass("active")){
    // active_page_number = (active_page_number<number_of_pages ? active_page_number+1 : 0);
    gotopage(null,'next');
    event.stopPropagation();
  // }
});
$('.art_page').click(function(){
  // active_page_number=$(this).attr("page_number");
  gotopage(parseInt($(this).attr("page_number")));
});
$(".art_page").swiperight(function() {  
  event.stopPropagation();
   gotopage(null,'prev');
 });  
$(".art_page").swipeleft(function() {  
  event.stopPropagation();
  gotopage(null,'next');
});  

$(document).ready(function(){
  // $('#presenter_container').css({'width':<?php echo $pagenumber+1; ?>+"00%"});
  // var page_height=$(document).height()-($('#main_navigation').height + $('#main_navigation').offset().top);
  // $('#art_presenter').css({'height':page_height+'px'});
  gotopage();
  set_art_presenter_height();
});
// the following is handled in site.js
// $(window).resize(function() {
//   on_resize(false);
// });


</script>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer-art','parts/shared/html-footer' ) ); ?>