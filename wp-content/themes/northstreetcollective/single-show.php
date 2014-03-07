<?php
/**
 * The Template for displaying 'show' posts
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php
  $showslug=$post->post_name;
	if (has_post_thumbnail( $post->ID ) ){
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
    $imgurl=$image[0];
  } else $imgurl="";

  $art_posts=get_shows_art($post->ID); // gets array of associated art posts
?>
  <div class="row">
    <div id="top_image" class="col-md-12 content" style="position:relative; background-image:url(<?php echo $imgurl; ?>);">
      <div class="section_heading"><h1><?php the_title(); ?></h1></div>
      <div id="top_image_bottom" style="position:relative; margin-top:600px;"></div>
    </div><!-- #top_image -->
  </div><!-- .row -->
  <div class="row">
    <div id="show_blurb" class="col-md-8 col-md-push-2 lead content">
      <div class="section_heading"><h2>The Blurb</h2></div>
      <?php the_content(); ?>
    </div><!-- #show_blurb -->
  </div><!-- .row -->
<?php endwhile; ?>

  <div class="row">
    <div id="show_art" class="col-md-6 col-md-push-3 content">
      <div class="section_heading"><h2>Artwork</h2></div>
<?php
      if(!empty($art_posts)){
        $shows_artist_list=array(); // initialize shows artist list
      	foreach ( $art_posts as $artID ) {
      	  $art_post=get_post($artID);
      	  if($art_post) { 
?>
        		<div class="row show_art_piece ">
              <div class="col-xs-5 preview_image">
<?php
                if(has_post_thumbnail( $art_post->ID ) ){
                  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $art_post->ID ), 'thumbnail' ); 
                  $imgurl=$image[0];
?>
                  <a href="<?php echo get_permalink($art_post->ID); ?>" alt="goto art piece">
                    <div class="image" style="height:240px; background-image: url('<?php echo $imgurl; ?>')"></div>
                  </a>
            <?php 
              } else { 
            ?>
                  <!-- <div class="image headshot"><span class="glyphicon glyphicon-user"></span></div> -->
            <?php 
              }
              ?>
              </div>
              <div class="col-xs-7 ">
                <div class="text">
        		    <h4><?php echo $art_post->post_title; ?> </h4>
<?php 
             		// get art piece's associated artists, list them with Art and store their IDs for the list of artists below...
          	    $arts_artists=get_arts_artists($art_post->ID);
            		if(!empty($arts_artists)){
          	      $shows_artist_list=array_merge($shows_artist_list, $arts_artists); // combine artists from this art piece with shows artist list
              		echo '<h5 class="artist_list">by ';                  
            	    foreach($arts_artists as $artistID)
                  {
                    $artist=get_post($artistID);
            	      echo '<span class="artist_name">'. display_name_format( $artist->post_title) .'</span>';
            	    }
            	    echo '</h5>';
                }
                // echo '<p>'. strip_tags($art_post->post_content) .'</p>';
?>
                </div>
                <?php 
              		echo '<a href="' . get_permalink($art_post->ID) . '" class="post_preview_link btn btn-link btn-block btn-xs">View artwork <span class="glyphicon glyphicon-arrow-right"></span></a>';
                ?>
              </div>
            </div>
<?php
    		}
      } 
    }
    else 
    { 
?>
      	<div class="alert alert-danger">Art not found :(</div>
      <?php } wp_reset_postdata(); ?>
    </div><!-- #show_art -->
    <div id="show_artists" class="col-md-3 col-md-push-3 content">
      <div class="section_heading"><h2>Artists</h2></div>
      <?php
        // $artist_list should be an array filled with people post IDs
        if ( $shows_artist_list ) { 
        	foreach ( $shows_artist_list as $artist ) {
        	  $artist_post=get_post($artist);
        	  if($artist_post){
          		echo '<div class="show_artist ">';
              // echo get_preview_image($artist_post->ID);
          		echo '<a href="' . get_permalink($artist_post->ID) . '" class="btn btn-link btn-block btn-xs">'. display_name_format($artist_post->post_title) .'</a>';
          		echo '</div><!-- .show_artist -->';
        	  }
        	}
        } else { ?>
      	<div class="alert alert-danger">No artists found :(</div>
      <?php } ?>
    </div><!-- #show_artists -->
    <div id="show_events" class="col-md-3 col-md-pull-9 content">
      <div class="section_heading"><h2>Events</h2></div>
      <?php
        $args = array( 'post_status'=>'publish', 'post_type'=>array(TribeEvents::POSTTYPE), 'posts_per_page'=>0,
          //order by startdate from newest to oldest
          'meta_key'=>'_EventStartDate',
          'orderby'=>'_EventStartDate',
          'order'=>'DESC',
          //required in 3.x
          'eventDisplay'=>'custom',
          // query events by category
          'tax_query' => array(
              array(
                  'taxonomy' => 'show',
                  'field' => 'slug',
                  'terms' => $showslug,
                  'operator' => 'IN'
              ),
          )
        );
        $get_posts = null;
        $get_posts = new WP_Query();
        $get_posts->query($args);
        if($get_posts->have_posts()) : while($get_posts->have_posts()) : $get_posts->the_post(); 
      ?>
        <div class="event_preview">
          <div class="event_date"><?php echo tribe_events_event_schedule_details(); ?></div>
          <div <?php post_class(); ?>><h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5></div>
        </div>
        <?php endwhile; endif; wp_reset_query(); ?>    
    </div><!--#show_events -->
  </div><!-- .row -->
  <? $query = new WP_Query( array( 'post_type' => 'post', 'tax_query' => array ( array (
         'taxonomy' => 'show',
         'field' => 'slug',
         'terms' => $showslug,
         'operator' => 'IN'
      ) ) ) ); 
      if ( $query->have_posts() ) {
  ?>
  <div class="row">
    <div id="show_blog" class="col-md-8 col-md-push-2 content">
      <div class="section_heading"><h2>The Show Blog</h2></div>
        <?php
      	while ( $query->have_posts() ) {
      		$query->the_post();
      		echo '<div class="show_blog_post ">';
      		echo '<h4>' . get_the_title() . '</h4>';
      		echo get_preview_image();
      		the_excerpt();
      		echo '<a class="btn btn-link btn-block btn-xs post_preview_link" href="' . get_permalink($post->ID) . '">Read more <span class="glyphicon glyphicon-chevron-right"></span></a>';
      		echo '</div>';
      	} ?>
    </div><!-- #show_blog -->
  </div><!-- .row -->
  <?php } wp_reset_postdata(); ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
