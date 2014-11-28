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
<div class="container">
  <div class="row">
    <div class="section_heading show_heading"><h1><?php the_title(); ?></h1></div>

    <div id="carousel1" class="carousel left slide col-xs-12" data-interval="10000" data-ride="carousel">
      <?php
      $carousel_items='';
      $i=0;
  		if (has_post_thumbnail( $post->ID ) )
      {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
        $imgurl=$image[0];
        $carousel_items.='        
        <div class="carousel_background item active" style="background-image:url('. $imgurl .');">
          <div class="carousel-caption">
            <h1>'. get_the_title($post->ID) .'</h1>
          </div> 
          <div class="carousel-bottom">&nbsp;</div> 
        </div> ';
    	  $i++;
      } 
      // then get artwork in the show...
      $art_post_list=get_shows_art($post->ID);
      foreach($art_post_list as $art_post_ID){
        $art_post=get_post($art_post_ID);
    	  $i++;
        if (has_post_thumbnail( $post->ID ) ){
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $art_post_ID ), 'single-post-thumbnail' ); 
          $imgurl=$image[0];
          $carousel_items.='
            <div class="carousel_background item" style="background-image:url('. $imgurl .'); ">
              <div class="carousel-caption">
                <h1><a href="'. get_permalink($art_post->ID) .'">'. get_the_title($art_post->ID) .'</a></h1>
              </div>
              <div class="carousel-bottom">&nbsp;</div>
            </div>';            
        }
      }
      if(!empty($carousel_items)) echo '<div class="carousel-inner">'. $carousel_items .'</div>';
      else echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Content not found.</div>';
      if($i > 0) 
      { 
        $carousel_indicators='<div class="carousel_nav"> <ol class="nav carousel-indicators">'; //initiate the indicator variable so we can build this dynamically 
        for($k=0; $k<=$i-1; $k++){
          $carousel_indicators.='<li data-target="#carousel1" data-slide-to="'.$k.'" class="carousel-indicator';
          if($k==0) $carousel_indicators.=' active';
          $carousel_indicators.='"></li>';
        }
        $carousel_indicators.='</ol> </div>';
        echo $carousel_indicators;
      }
      wp_reset_postdata(); 
      ?>
      <!-- Controls -->
      <a class="left carousel-control" href="#carousel1" data-slide="prev">
        <span class="icon-chevron-left"></span>
      </a>
      <a class="right carousel-control" href="#carousel1" data-slide="next">
        <span class="icon-chevron-right"></span>
      </a>
    </div>

  </div><!-- .row -->
  <div class="row">
    <div id="show_blurb" class="col-sm-10 col-sm-offset-1 lead content">
      <?php the_content(); ?>
    </div><!-- #show_blurb -->
  </div><!-- .row -->
<?php endwhile; ?>
<div class="row">
    <div id="show_art" class="content col-xs-12 col-sm-9 col-md-10">
      <div class="section_heading"><h2>Artwork</h2></div>
<?php
      if(!empty($art_posts)){
        // $shows_artist_list=array(); // initialize shows artist list
        ?>
    		<div class="row art_grid">
        <?php
      	foreach ( $art_posts as $artID ) {
      	  $art_post=get_post($artID);
      	  if($art_post) { 
?>
              <div class="show_art_piece col-xs-12 col-md-6 col-lg-4">
                <div class="row post_preview">
                  <div class="post_preview_thumbnail col-xs-3">
<?php
                if(has_post_thumbnail( $art_post->ID ) ){
                  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $art_post->ID ), 'thumbnail' ); 
                  $imgurl=$image[0];
?>
                <div class="background_thumbnail" style="background-image: url('<?php echo $imgurl; ?>')"></div>
            <?php 
              } else { 
            ?>
                <div class="background_thumbnail"></div>
            <?php 
              }
              ?>
              </div>
              <div class="post_preview_content col-xs-9">
        		    <h4><?php echo $art_post->post_title; ?> </h4>
<?php 
             		// get art piece's associated artists, list them with Art and store their IDs for the list of artists below...
          	    $arts_artists=get_arts_artists($art_post->ID);
            		if(!empty($arts_artists)){
                  // $shows_artist_list=array_merge($shows_artist_list, $arts_artists); // combine artists from this art piece with shows artist list
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
              <a href="<?php echo get_permalink($art_post->ID); ?>" class="post_preview_link link_overlay btn btn-link btn-xs"><span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
          </div>
<?php
    		}
      }
  ?>
      </div>
  <?php 
    }
    else 
    { 
?>
      	<div class="alert alert-danger">Art not found :(</div>
      <?php } wp_reset_postdata(); ?>
    </div><!-- #show_art -->
    <div id="show_artists" class="col-xs-12 col-sm-3 col-md-2 content">
      <div class="section_heading"><h2>Artists</h2></div>
      <?php
        // $artist_list should be an array filled with people post IDs
        if ( $shows_artist_list=get_shows_artists($post->ID) ) { 
        	foreach ( $shows_artist_list as $artist ) {
        	  $artist_post=get_post($artist);
        	  if($artist_post){
          		echo '<div class="show_artist post_preview">';
              // echo get_preview_image($artist_post->ID);
          		echo display_name_format($artist_post->post_title);
          		echo '<a href="' . get_permalink($artist_post->ID) . '" class="post_preview_link link_overlay" alt="'. display_name_format($artist_post->post_title) .'"><span class="glyphicon glyphicon-chevron-right"></span></a>';
          		echo '</div><!-- .show_artist -->';
        	  }
        	}
        } else { ?>
      	<div class="alert alert-danger">No artists found :(</div>
      <?php } ?>
    </div><!-- #show_artists -->
  </div><!-- .row -->
  <div class="row">
    <div id="show_blog" class="col-xs-12 col-sm-6 content">
      <div class="section_heading"><h2>The Show Blog</h2></div>
        <?php
        $query = new WP_Query( array( 'post_type' => 'post', 'tax_query' => array ( array (
               'taxonomy' => 'show',
               'field' => 'slug',
               'terms' => $showslug,
               'operator' => 'IN'
            ) ) ) ); 
            if ( $query->have_posts() ) {
      	while ( $query->have_posts() ) {
      		$query->the_post();
      		echo '<div class="show_blog_post post_preview">';
      		echo '<h4>' . get_the_title() . '</h4>';
      		echo get_preview_image();
      		the_excerpt();
      		echo '<a class="post_preview_link link_overlay" href="' . get_permalink($post->ID) . '"><span class="glyphicon glyphicon-chevron-right"></span></a>';
      		echo '</div>';
      	}
      } else echo '<div class="alert">No blog posts found.</div>';
        ?>
    </div><!-- #show_blog -->
    <div id="show_events" class="col-xs-12 col-sm-6 content">
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
        if($get_posts->have_posts()) {
           while($get_posts->have_posts()) : $get_posts->the_post(); 
      ?>
        <div class="event_preview post_preview">
          <div class="event_date"><?php echo tribe_events_event_schedule_details(); ?></div>
          <div <?php post_class(); ?>><h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5></div>
          <a href="<?php echo get_permalink($post->ID); ?>" class="post_preview_link link_overlay"><span class="glyphicon glyphicon-chevron-right"></span></a>
        </div>
        <?php 
          endwhile; 
        } else echo '<div class="alert alert">No events found.</div>'; 
        wp_reset_query(); ?>    
    </div><!--#show_events -->
  </div><!-- .row -->
</div>
<div class="end_of_page dark_background">
  <div class="container">
    <div class="row">
      <div id="end_of_show" class="col-xs-12">
        <h3 class="section_heading">Browse Shows:</h3>
        <div class="row">
        <?php 
        $all_shows = get_posts( array( 'post_type' => 'show', 'posts_per_page' => '0', 'offset' => '0', 'order' => 'DESC', 'orderby' => 'date'));
        foreach($all_shows as $show){
        ?>
          <div class="col-xs-12">
            <div class="post_preview<?php if($show->ID == $post->ID) echo ' selected'; ?>">
            <h5 class="show_title">
              <?php echo $show->post_title; ?>
              <?php if($show->ID == $post->ID) { ?> <span> (You are here)</span> <?php } ?>
            </h5>
            <?php if($show->ID != $post->ID) { ?> <a href="<?php echo get_permalink($show->ID); ?>" alt="<?php echo $show->post_title; ?>" class="post_preview_link link_overlay"><span class="glyphicon glyphicon-chevron-right"></span></a> <?php } ?>
            </div>
          </div>
        <?php 
        }
        ?>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php wp_reset_postdata(); ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
